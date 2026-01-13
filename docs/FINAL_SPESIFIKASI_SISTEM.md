# FINAL SPESIFIKASI SISTEM: Sistem Pemesanan Restoran QR (RestoQR)

## 1. Ikhtisar Sistem
**Nama Sistem:** RestoQR
**Deskripsi:** Sistem pemesanan mandiri berbasis web yang memungkinkan pelanggan memindai kode QR di meja, melihat menu, memesan, dan membayar tanpa perantara pelayan.

### Fitur Utama (9 Core Use Cases):
1.  **Login User** (Admin, Kasir, Koki)
2.  **Manajemen Menu** (CRUD - Admin)
3.  **Manajemen Meja** (Generate QR - Admin)
4.  **Laporan Penjualan** (Admin)
5.  **Menu Digital** (Pelanggan - Scan QR)
6.  **Pemesanan Mandiri** (Pelanggan - Cart & Checkout)
7.  **Pembayaran Hybrid** (QRIS/Tunai)
8.  **Konfirmasi Pembayaran** (Kasir)
9.  **Manajemen Dapur Realtime** (Koki)

### Alur Pembayaran:
*   **QRIS (Self-Service)**: Pelanggan membayar via Midtrans Snap → Notifikasi otomatis ke sistem → Status: `paid`
*   **Tunai**: Pelanggan datang ke kasir → Kasir konfirmasi manual → Status: `paid`
*   **Auto-Cancel**: Jika pembayaran tidak selesai dalam waktu tertentu (20 menit), order otomatis `cancelled`

---

## 2. Arsitektur & Teknologi

### Technology Stack
*   **Backend**: Laravel 12
*   **Database**: MySQL
*   **Frontend**: Tailwind CSS + Blade Templates
*   **UI Library**: Flowbite (untuk komponen modern)
*   **Realtime**: Laravel Reverb + Echo (WebSockets)
*   **Payment Gateway**: Midtrans (Snap API)
*   **QR Generator**: `simplesoftwareio/simple-qrcode`

### Design System (Royal Blue Theme)

#### Color Palette
*   **Primary (Royal Blue)**:
    *   `blue-50`: #EFF6FF (Backgrounds)
    *   `blue-100`: #DBEAFE (Light accents)
    *   `blue-500`: #3B82F6 (Main primary color)
    *   `blue-600`: #2563EB (Hover states)
    *   `blue-700`: #1D4ED8 (Active states)
    *   `blue-900`: #1E3A8A (Dark text)

*   **Neutral Colors**:
    *   `gray-50`: #F9FAFB (Page backgrounds)
    *   `gray-100`: #F3F4F6 (Card backgrounds)
    *   `gray-500`: #6B7280 (Secondary text)
    *   `gray-700`: #374151 (Primary text)
    *   `gray-900`: #111827 (Headlines)

*   **Semantic Colors**:
    *   Success: `green-500` #10B981
    *   Warning: `amber-500` #F59E0B
    *   Danger: `red-500` #EF4444
    *   Info: `blue-500` #3B82F6

#### Typography
*   **Font Family**: Inter (Google Fonts) - Modern, clean, highly readable
*   **Headings**: Bold (700), gray-900
*   **Body**: Regular (400), gray-700
*   **Secondary**: Regular (400), gray-500

#### UI Components Style
*   **Buttons**: Rounded-lg, shadow-sm, smooth transitions
*   **Cards**: White background, border-gray-200, rounded-xl, shadow
*   **Forms**: Rounded-lg, focus:ring-blue-500, border-gray-300
*   **Tables**: Striped rows, hover effects, sticky headers
*   **Modals**: Backdrop blur, slide-in animation, rounded-2xl

### Arsitektur Realtime (Event-Driven)
Sistem menggunakan Websockets untuk notifikasi instan:
*   `OrderCreated`: Notifikasi ke Kasir saat pesanan masuk.
*   `OrderPaid`: Notifikasi ke Dapur saat pesanan lunas.
*   `OrderStatusUpdated`: Update status `proses` → `siap` ke Dashboard Koki.

---

## 3. Database Schema

> **Catatan**: Schema di bawah ini mengikuti Class Diagram yang Anda buat dengan beberapa **field tambahan** untuk mendukung fitur auto-cancellation dan capacity management.

### `User`
*   `id`: Integer (PK)
*   `name`: String
*   `email`: String (Unique)
*   `password`: String (Hashed)
*   `role`: Enum('admin', 'kasir', 'koki')
*   `created_at`, `updated_at`: Timestamp

### `Categori` (Category)
*   `id`: Integer (PK)
*   `name`: String
*   `icon`: String
*   `created_at`, `updated_at`: Timestamp

**Relasi**: `HasMany` Menu (1:Many)

### `Menu`
*   `id`: Integer (PK)
*   `categori_id`: Integer (FK to Categori)
*   `name`: String
*   `price`: String/Decimal
*   `image`: String (URL/Path)
*   `is_available`: Boolean
*   `created_at`, `updated_at`: Timestamp

**Relasi**: `BelongsTo` Categori (Many:1)

### `Table`
*   `id`: Integer (PK)
*   `number`: String (Unique)
*   `qr_url`: String (QR Code Path/URL)
*   **➕ `is_active`: Boolean** - Status aktif/nonaktif meja (TAMBAHAN)
*   `created_at`, `updated_at`: Timestamp

**Relasi**: `HasMany` Order (1:Many)

### `Order`
*   `id`: Integer (PK)
*   `table_id`: Integer (FK to Table)
*   `consumer_name`: String
*   `total_amount`: Decimal(10,2)
*   `snap_token`: String (Midtrans token)
*   `created_at`: Timestamp
*   `payment_method`: Enum('cash', 'qris')
*   `payment_status`: Enum('pending', 'paid', 'cancelled')
*   `Order_Status`: Enum('pending', 'proses', 'siap')
*   **➕ `payment_expires_at`: Timestamp** - Batas waktu pembayaran 20 menit (TAMBAHAN)
*   **➕ `cancelled_at`: Timestamp (Nullable)** - Waktu pembatalan otomatis (TAMBAHAN)
*   `updated_at`: Timestamp

**Relasi**: 
- `BelongsTo` Table (Many:1)
- `HasMany` Order Item (1:Many)

#### Status Transitions:

**Payment Status:**
1.  `pending` → `paid` (Setelah payment confirmed)
2.  `pending` → `cancelled` (Jika payment timeout 20 menit)

**Order Status:**
1.  `pending` → `proses` (Otomatis setelah payment_status = paid)
2.  `proses` → `siap` (Koki update manual - pesanan siap disajikan)

### `Order Item`
*   `id`: Integer (PK)
*   `order_id`: Integer (FK to Order)
*   `menu_id`: Integer (FK to Menu)
*   `quantity`: Integer
*   `price`: Decimal(10,2)
*   `note`: String (Catatan khusus per item)
*   `created_at`, `updated_at`: Timestamp

**Relasi**: 
- `BelongsTo` Order (Many:1)
- `BelongsTo` Menu (Many:1)

---

### 📋 Field Tambahan (Tidak Ada di Diagram Anda)

Berikut field yang **TIDAK ADA** di Class Diagram Anda namun diperlukan untuk fitur yang sudah kita diskusikan:

#### **Table:**
```diff
+ is_active: Boolean - Untuk enable/disable meja tanpa hapus data
```

#### **Order:**
```diff
+ payment_expires_at: Timestamp - Untuk auto-cancel setelah 20 menit
+ cancelled_at: Timestamp - Untuk tracking kapan order dibatalkan
```

#### **Order.payment_status:**
```diff
+ 'cancelled' - Tambahkan ke enum untuk payment timeout
```

> **Rekomendasi**: Update Class Diagram Anda dengan menambahkan 4 field di atas untuk mendukung semua requirement sistem.

---

### 🗂️ Tabel Opsional: `Payments` (Untuk Audit Trail)

> **Catatan**: Tabel ini **TIDAK ADA** di diagram Anda, namun **OPSIONAL** untuk keperluan laporan yang lebih detail.

Jika ingin tracking payment history terpisah dari Order:

*   `id`: Integer (PK)
*   `order_id`: Integer (FK to Order)
*   `amount`: Decimal(10,2)
*   `method`: Enum('cash', 'qris')
*   `status`: Enum('pending', 'success', 'failed')
*   `confirmed_by`: Integer (FK to User - untuk cash payment)
*   `confirmed_at`: Timestamp
*   `midtrans_transaction_id`: String
*   `snap_token`: String
*   `created_at`, `updated_at`: Timestamp

**Alternative**: Laporan penjualan bisa diambil langsung dari tabel `Order` tanpa perlu tabel `Payments` terpisah.

---

## 4. Business Rules

### Payment Timeout & Auto-Cancellation
*   Setiap order memiliki batas waktu pembayaran (default: 20 menit)
*   Jika `payment_expires_at` terlewati dan status masih `pending`, maka:
    *   Status berubah otomatis menjadi `cancelled`
    *   Field `cancelled_at` diisi dengan timestamp
    *   Event `OrderCancelled` di-trigger untuk cleanup

### Order Status Management
*   **Automatic**: `pending→cancelled` (timeout), `paid→proses` (payment confirmed)
*   **Manual by Koki**: `proses→siap` (pesanan selesai dan siap disajikan)
*   **Manual by Kasir**: `pending→paid` (untuk cash payment)

### Laporan Penjualan (Admin)
Laporan diambil dari tabel `payments` dengan filter:
*   Date range (Start date - End date)
*   Payment method (cash/qris/all)
*   Status (success/failed/all)
*   Export format: PDF, Excel

Data yang ditampilkan:
*   Total revenue per periode
*   Total transaksi per metode pembayaran
*   Menu terlaris (dari `order_items`)
*   Grafik penjualan harian/bulanan

---

## 5. Alur Implementasi (Step-by-Step)

1.  **Project Setup**: Install Laravel, Config ENV, Setup Database.
2.  **Frontend**: Setup Tailwind & Flowbite.
3.  **Migrations**: Eksekusi skema database (termasuk field tambahan).
4.  **Auth & Seeder**: Buat user default untuk setiap role.
5.  **Admin Features**: CRUD Menu & Meja (Generate QR).
6.  **Customer Features**: Halaman Menu Publik (Tanpa Login) → Cart → Checkout.
7.  **Payment**: 
    *   Integrasi Midtrans Snap untuk QRIS
    *   Form konfirmasi manual untuk Cash (Kasir)
    *   Payment timeout scheduler (Laravel Queue/Cron)
8.  **Realtime**: Setup Reverb, Buat Events, Pasang Listeners di Dashboard Kasir/Koki.
9.  **Reports**: Implementasi laporan penjualan dengan chart & export.
10. **Testing**: End-to-end testing semua alur pembayaran & status.
