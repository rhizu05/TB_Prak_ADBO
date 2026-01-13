# Dapoer Katendjo 🍽️

System Management Restoran & Point of Sales (POS) yang dibangun menggunakan Laravel. Project ini ditujukan untuk Tugas Besar Praktikum Analisis Desain Berorientasi Objek (ADBO).

## 🚀 Fitur Utama

### 👑 Admin
- **Dashboard**: Ringkasan statistik restoran.
- **Manajemen Produk**: Tambah, edit, dan hapus menu makanan/minuman.
- **Manajemen Kategori**: Kelola kategori menu.
- **Manajemen Meja**: Atur nomor meja dan QR Code.
- **Laporan**: Melihat dan export laporan penjualan.

### 💰 Kasir
- **Dashboard Kasir**: Monitoring pesanan masuk.
- **Pembayaran**: Memproses pembayaran pesanan (Tunai & QRIS).
- **Riwayat Transaksi**: Melihat status pembayaran.

### 👨‍🍳 Koki (Kitchen)
- **Kitchen Display System (KDS)**: Tampilan real-time pesanan yang masuk ke dapur.
- **Status Pesanan**: Mengupdate status pesanan menjadi "Ready" atau "Served".

### 📱 Pelanggan (Customer)
- **Self Order**: Pemesanan mandiri melalui scan QR Code di meja.
- **Menu Digital**: Melihat daftar menu dan kategori.
- **Cart & Checkout**: Memilih item dan melakukan checkout.
- **Tracking Order**: Memantau status pesanan secara real-time.
- **Pembayaran Online**: Integrasi dengan Midtrans (QRIS).

## 🛠️ Tech Stack

- **Framework**: Laravel 11/12
- **Language**: PHP 8.2+
- **Frontend**: Blade Templates, TailwindCSS (via Vite)
- **Database**: MySQL / MariaDB
- **Payment Gateway**: Midtrans
- **Other**: Simple QR Code

## 📦 Instalasi

Ikuti langkah-langkah berikut untuk menjalankan project di local machine:

1. **Clone Repository**
   ```bash
   git clone https://github.com/rhizu05/TB_Prak_ADBO.git
   cd TB_Prak_ADBO
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Setup Environment**
   Duplicate file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database Anda.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi Database**
   Pastikan Anda telah membuat database di MySQL, lalu atur di `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_anda
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Konfigurasi Midtrans (Opsional)**
   Tambahkan Server Key dan Client Key Midtrans di `.env` jika ingin menggunakan fitur pembayaran online.
   ```env
   MIDTRANS_SERVER_KEY=your-server-key
   MIDTRANS_CLIENT_KEY=your-client-key
   MIDTRANS_IS_PRODUCTION=false
   ```

6. **Migrasi & Seeding**
   ```bash
   php artisan migrate --seed
   ```

7. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```
   Akses aplikasi di `http://localhost:8000`.

## 🔑 Akun Demo (Seeder)

Jika menggunakan `db:seed`, berikut adalah akun default yang dapat digunakan:

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@example.com | password |
| **Kasir** | kasir@example.com | password |
| **Koki** | koki@example.com | password |

## 👥 Kontributor

- **[Nama Anda]** - *Developer*
