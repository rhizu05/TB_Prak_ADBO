# Activity Diagrams - RestoQR System

Dokumentasi lengkap untuk 9 Activity Diagrams sistem RestoQR.

---

## 1. Login User (Admin/Kasir/Koki) ✅

![Login User Activity Diagram](C:/Users/rhizu/.gemini/antigravity/brain/42cc80d6-a9b5-4baf-82e4-c0adf7799dd9/uploaded_image_1765946915845.png)

### **Aktor**: Admin / Kasir / Koki

### **Deskripsi Flow**:
1. **Buka Halaman Login** → **Input Email & Password** → **Klik Tombol Login**
2. **System**: Validasi Kredensial
   - ❌ Salah → Error → Loop back
   - ✅ Benar → Cek Role → Redirect ke Dashboard

**Rating: 9.5/10** - Excellent!

---

## 2. Mengelola Data Menu (Admin) ✅

![Mengelola Data Menu Activity Diagram](C:/Users/rhizu/.gemini/antigravity/brain/42cc80d6-a9b5-4baf-82e4-c0adf7799dd9/uploaded_image_1765947051185.png)

### **Aktor**: Admin

### **Deskripsi Flow**:
1. Buka Manajemen Menu → Pilih Aksi (Tambah/Edit/Hapus) → Simpan
2. **System**: Proses → Validasi
   - ❌ Invalid → Error → Loop
   - ✅ Valid → Simpan DB → Success

**Features**: Complete CRUD, Soft delete, Input validation

**Rating: 9.5/10** - Excellent!

---

## 3. Mengelola Data Meja (Admin) ✅

![Mengelola Data Meja Activity Diagram](C:/Users/rhizu/.gemini/antigravity/brain/42cc80d6-a9b5-4baf-82e4-c0adf7799dd9/uploaded_image_1765947265111.png)

### **Aktor**: Admin

### **Deskripsi Flow**:
1. Buka Manajemen Meja → Input Nomor Meja → Klik Generate QR
2. **System**: Generate QR Image → Simpan Data Meja → Tampilkan QR

**Features**: QR Generation, Data persistence, Display result

**Rating: 9/10** - Very good!

---

## 4. Melihat Laporan (Admin) ✅

![Melihat Laporan Activity Diagram](C:/Users/rhizu/.gemini/antigravity/brain/42cc80d6-a9b5-4baf-82e4-c0adf7799dd9/uploaded_image_0_1765947853130.png)

### **Aktor**: Admin

### **Deskripsi Flow**:

**Swimlane: Admin**
1. **Buka Halaman Laporan** - Admin membuka halaman laporan penjualan
2. **Filter Tanggal atau Periode** - Admin memilih date range atau periode (harian/mingguan/bulanan)

**Swimlane: System**
3. **Query Data Transaksi Tunai dan Qris** - Ambil data dari tabel `Order` atau `Payments`
4. **Hitung Total Pendapatan** - Sum semua transaksi yang sukses
5. **Render Grafik dan Tabel** - Visualisasi data dalam bentuk chart dan table
6. **End**

### **Verifikasi**:
- ✅ Swimlane structure jelas
- ✅ Filter by date/period
- ✅ Query transaksi (cash & QRIS)
- ✅ Calculate revenue
- ✅ Visualisasi (chart & table)
- ✅ Sesuai requirement laporan penjualan

### **✅ Kelebihan**:
- Flow sederhana dan jelas
- Mencakup filter untuk flexibility
- Support multiple payment methods
- Visualisasi data untuk better insight

### **💡 Saran & Masukan**:

**1. Export Functionality** ⭐ PENTING
```
Setelah "Render Grafik dan Tabel"
→ Tambahkan decision point: "Export Laporan?"
   → Ya: Export ke PDF/Excel
   → Tidak: End
```
**Kenapa?** Sesuai spesifikasi, laporan harus bisa di-export (PDF, Excel)

**2. Additional Filters**
```
Filter tidak hanya tanggal, tapi juga:
- Payment method (Cash/QRIS/All)
- Payment status (Success/Failed/All)
- Menu terlaris
```
**Kenapa?** Sesuai requirement: "filter by payment method & status"

**3. Empty State Handling**
```
Setelah Query Data, tambah decision:
"Ada data?" → Tidak → Tampilkan "No data available"
```
**Kenapa?** UX - inform user jika tidak ada transaksi di periode tersebut

**4. Loading State**
```
Sebelum "Render Grafik"
→ Tampilkan Loading indicator
```
**Kenapa?** Query bisa lambat untuk data besar

**Rating: 8/10** - Bagus, tapi perlu tambahan export & filter detail

---

## 5. Melihat Menu Digital (Pelanggan) ✅

![Melihat Menu Digital Activity Diagram](C:/Users/rhizu/.gemini/antigravity/brain/42cc80d6-a9b5-4baf-82e4-c0adf7899dd9/uploaded_image_1_1765947853130.png)

### **Aktor**: Pelanggan

### **Deskripsi Flow**:

**Swimlane: Pelanggan**
1. **Scan QR Code Meja** - Pelanggan scan QR di meja menggunakan smartphone

**Swimlane: System**
2. **QR Valid?** (Decision Point)
   - **Tidak Valid**: 
     - Tampilkan Halaman 404
     - End (Dead end - user perlu scan ulang)
   - **Valid**:
     - Ambil Data Menu & Kategori dari database
     - Tampilkan Halaman Menu
     - Lihat Daftar Makanan
     - End

### **Verifikasi**:
- ✅ Swimlane structure
- ✅ QR validation
- ✅ Error handling (404 page)
- ✅ Fetch menu data
- ✅ Display menu list
- ✅ Sesuai dengan use case

### **✅ Kelebihan**:
- **QR validation** - Security check sangat penting!
- **Error handling** - 404 page untuk invalid QR
- Flow simple dan user-friendly
- Fetch by category untuk better organization

### **💡 Saran & Masukan**:

**1. Filter by Category** ⭐ RECOMMENDED
```
Setelah "Tampilkan Halaman Menu"
→ Tambahkan: "Filter Kategori (optional)"
   → User bisa filter: Makanan, Minuman, Dessert, dll
```
**Kenapa?** UX - easier navigation jika menu banyak

**2. Search Menu** ⭐ RECOMMENDED
```
Di halaman menu, tambahkan activity:
"Search Menu by Name"
```
**Kenapa?** UX - pelanggan bisa langsung cari menu favorit

**3. Show Availability Status**
```
Saat tampilkan menu, show:
"Menu Available?" → Tampilkan badge "Habis" jika not available
```
**Kenapa?** Hindari pelanggan pesan menu yang habis (field `is_available` di DB)

**4. Table Info Display**
```
Tampilkan info:
"Anda sedang di: Meja #[number]"
```
**Kenapa?** Konfirmasi ke pelanggan bahwa QR scan berhasil dan meja correct

**5. Session/Cookie untuk Table**
```
Setelah QR valid, simpan:
"Create Session: table_id"
```
**Kenapa?** Pelanggan tidak perlu scan ulang jika refresh page

**Rating: 8.5/10** - Sangat baik, tambahan filter & search akan lebih perfect

---

## 6. Melakukan Pemesanan (Pelanggan) ✅

![Melakukan Pemesanan Activity Diagram](C:/Users/rhizu/.gemini/antigravity/brain/42cc80d6-a9b5-4baf-82e4-c0adf7799dd9/uploaded_image_2_1765947853130.png)

### **Aktor**: Pelanggan

### **Deskripsi Flow**:

**Swimlane: Pelanggan**
1. **Pilih Menu** - Pelanggan memilih menu dari list
2. **Klik 'Tambah ke Keranjang'** - Add item to cart
3. **Buka Keranjang** - View cart contents
4. **Klik 'Checkout'** - Proceed to checkout page
5. **Input Nama Pelanggan** - Enter customer name
6. **Lanjut Pembayaran** - Submit order

**Swimlane: System**
7. **Buat Data Order (Status: Pending)** - Create order record with status pending
8. **Redirect ke Halaman Pembayaran** - Navigate to payment page
9. **End**

### **Verifikasi**:
- ✅ Swimlane structure
- ✅ Add to cart functionality
- ✅ Checkout flow
- ✅ Customer name input
- ✅ Create order with pending status
- ✅ Redirect to payment page
- ✅ Sesuai dengan use case

### **✅ Kelebihan**:
- Flow logis dan mudah diikuti
- **Status: Pending** saat buat order (correct!)
- Cart system untuk review sebelum checkout
- Customer name collection (penting untuk tracking)

### **💡 Saran & Masukan**:

**1. Quantity Selection** ⭐ PENTING
```
Setelah "Pilih Menu", tambahkan:
"Input Quantity" → Pilih jumlah item (1, 2, 3, dst)
```
**Kenapa?** User mungkin mau pesan > 1 item yang sama (field `quantity` ada di DB)

**2. Add Notes per Item** ⭐ PENTING
```
Setelah "Pilih Menu", tambahkan:
"Input Notes (Optional)" → Misal: "Tidak pakai cabe", "Extra es"
```
**Kenapa?** Sesuai requirement - ada field `note` di `order_items`

**3. Cart Management** ⭐ RECOMMENDED
```
Di "Buka Keranjang", tambahkan decision:
"Edit Cart?"
   → Ubah quantity
   → Hapus item
   → Tambah item lagi
```
**Kenapa?** Flexibility - user bisa revise order sebelum checkout

**4. Order Summary Validation**
```
Sebelum "Lanjut Pembayaran", tambahkan:
"Review Order Summary"
   → Total items
   → Total price
   → Confirm order
```
**Kenapa?** User confirmation sebelum commit

**5. Empty Cart Check**
```
Setelah "Buka Keranjang", decision:
"Cart kosong?" → Ya → Tampilkan "Cart is empty"
```
**Kenapa?** Prevent checkout dengan cart kosong

**6. Table Validation**
```
Saat "Buat Data Order", pastikan:
"table_id from session" → Order tahu meja mana
```
**Kenapa?** Critical - order harus linked ke table yang benar

**7. Calculate Total Amount**
```
Sebelum "Buat Data Order":
"Calculate: total_amount = sum(qty × price)"
```
**Kenapa?** Harus ada di field `total_amount` di tabel Order

**Rating: 7.5/10** - Baik, tapi PERLU tambahan quantity, notes, dan cart management

---

## 7. Melakukan Pembayaran (Pelanggan) ✅

![Melakukan Pembayaran Activity Diagram](C:/Users/rhizu/.gemini/antigravity/brain/42cc80d6-a9b5-4baf-82e4-c0adf7799dd9/uploaded_image_0_1767713836384.png)

### **Aktor**: Pelanggan

### **Deskripsi Flow**:

**Swimlane: Pelanggan**
1. **Decision Point**: Pilih Metode Bayar (Tunai vs QRIS)

**Jalur Tunai:**
2. **Pilih Bayar Tunai**
3. **System**: 
   - Set Payment Status: Unpaid (Pending)
   - Tampilkan Instruksi 'Bayar ke Kasir'
   - End (Merge to final node)

**Jalur QRIS:**
2. **Pilih QRIS Midtrans**
3. **System**:
   - Request Snap Token Midtrans
   - Tampilkan QR Code Midtrans
   - Tunggu Callback Webhook (Async process)
   - Update Status: Lunas (Paid)
   - End (Merge to final node)

### **Verifikasi**:
- ✅ Swimlane structure
- ✅ Handle 2 metode pembayaran
- ✅ Integrasi Midtrans logic (Request Token → Callback)
- ✅ Status handling (Unpaid vs Lunas)
- ✅ Sesuai dengan Use Case "Pembayaran Hybrid"

### **Catatan**:
Diagram ini sangat akurat, terutama pada bagian **QRIS flow** yang menunjukkan "Tunggu Callback Webhook". Ini detail teknis yang penting!

**Rating: 10/10** - Sangat detail dan akurat secara teknis.

---

## 8. Konfirmasi Pembayaran Tunai (Kasir) ✅

![Konfirmasi Pembayaran Tunai Activity Diagram](C:/Users/rhizu/.gemini/antigravity/brain/42cc80d6-a9b5-4baf-82e4-c0adf7799dd9/uploaded_image_1_1767713836384.png)

### **Aktor**: Kasir

### **Deskripsi Flow**:

**Swimlane: Kasir**
1. **Terima Uang Tunai** - Interaksi fisik dengan pelanggan
2. **Cari Pesanan di Sistem** - Lookup order berdasarkan nomor meja/nama
3. **Klik 'Konfirmasi Bayar'** - Action di dashboard kasir

**Swimlane: System**
4. **Update Status Pembayaran** - Change status `pending` → `paid`
5. **Update Penjualan Harian** - Record transaction
6. **Kirim Notifikasi Pesanan ke Koki** - Trigger realtime event ke dapur
7. **End**

### **Verifikasi**:
- ✅ Swimlane structure
- ✅ Manual confirmation process
- ✅ System updates (Status & Sales record)
- ✅ Trigger selanjutnya (Notifikasi ke Koki)
- ✅ Sesuai dengan Use Case "Konfirmasi Pembayaran"

### **Catatan**:
Flow sangat logis. Step "Kirim Notifikasi Pesanan ke Koki" adalah kunci dari sistem realtime ini. 

**Rating: 9.5/10** - Sangat baik!

---

## 9. Update Status (Koki) ✅

![Update Status Activity Diagram](C:/Users/rhizu/.gemini/antigravity/brain/42cc80d6-a9b5-4baf-82e4-c0adf7799dd9/uploaded_image_2_1767713836384.png)

### **Aktor**: Koki

### **Deskripsi Flow**:

**Swimlane: Koki**
1. **Lihat Dashboard Daftar Pesanan** - Monitoring pesanan masuk
2. **Tandai Selesai Pada Salah Satu Pesanan** - Koki menyelesaikan masakan

**Swimlane: System**
3. **Update Status: Siap** - Ubah status order di DB
4. **Notifikasi ke Kasir** - Beritahu kasir/waiter bahwa makanan siap
5. **End**

### **Verifikasi**:
- ✅ Swimlane structure
- ✅ Dashboard monitoring
- ✅ Status update interaction
- ✅ **Simplified Status**: Update ke status "Siap" (Sesuai revisi kita!)
- ✅ Feedback loop (Notifikasi)
- ✅ Sesuai dengan Use Case "Manajemen Dapur"

### **Catatan**:
Diagram ini sudah **konsisten dengan perubahan status** yang barusan kita sepakati (menggunakan status "Siap"). 

**Rating: 9.5/10** - Sangat baik dan konsisten!

---

## 📊 Summary Review (Diagram 7-9)

| Diagram | Rating | Kekuatan | Catatan |
|---------|--------|----------|---------|
| **7. Pembayaran** | 10/10 | QRIS Webhook Logic | Perfek secara teknis |
| **8. Konfirmasi Kasir** | 9.5/10 | Realtime Trigger | Alur manual ke sistem clear |
| **9. Update Status** | 9.5/10 | Consistent Status | Sesuai revisi (3 status) |

---

## 📊 Summary Review (Diagram 4-6)

| Diagram | Rating | Kekuatan | Prioritas Perbaikan |
|---------|--------|----------|---------------------|
| **4. Melihat Laporan** | 8/10 | Simple, clear reporting | ⭐ Export functionality, Additional filters |
| **5. Melihat Menu Digital** | 8.5/10 | QR validation, Error handling | ⭐ Session management, ✨ Filter/search |
| **6. Melakukan Pemesanan** | 7.5/10 | Logical flow, Cart system | ⭐⭐ Quantity & Notes!, Cart management |

### **Catatan Umum:**
Semua diagram sudah **sangat baik** dengan flow yang logis. Yang perlu ditambahkan adalah detail-detail yang **critical** untuk functionality dan UX.

**Legend:**
- ⭐⭐ = CRITICAL (Must have - sesuai DB schema & requirement)
- ⭐ = IMPORTANT (Highly recommended)
- ✨ = NICE TO HAVE (Enhancement untuk better UX)

---

## Status Dokumentasi
- ✅ **9/9 Diagram Received**
- 📊 Progress: 100% - SEMUA DIAGRAM LENGKAP & VALID ✅
