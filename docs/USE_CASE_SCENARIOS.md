# Skenario Use Case - Sistem RestoQR

---

## 1. Use Case: Melihat Menu

| Komponen | Deskripsi |
|----------|-----------|
| **Use Case** | Melihat Menu |
| **Aktor** | Pelanggan (Customer) |
| **Tipe** | Primary |
| **Tujuan** | Pelanggan dapat melihat daftar menu makanan dan minuman yang tersedia |
| **Deskripsi** | Pelanggan memindai QR Code di meja untuk mengakses halaman menu digital yang menampilkan produk berdasarkan kategori |

**Skenario Utama:**

| No | Aktor | Sistem |
|----|-------|--------|
| 1 | Pelanggan memindai QR Code pada meja | - |
| 2 | - | Sistem menampilkan halaman menu dengan nomor meja |
| 3 | - | Sistem menampilkan daftar kategori dan produk yang tersedia |
| 4 | Pelanggan memilih kategori tertentu | - |
| 5 | - | Sistem menampilkan produk sesuai kategori yang dipilih |
| 6 | Pelanggan melihat detail produk (nama, harga, deskripsi) | - |

---

## 2. Use Case: Menambah ke Keranjang

| Komponen | Deskripsi |
|----------|-----------|
| **Use Case** | Menambah ke Keranjang |
| **Aktor** | Pelanggan (Customer) |
| **Tipe** | Primary |
| **Tujuan** | Pelanggan dapat menambahkan item menu ke dalam keranjang belanja |
| **Deskripsi** | Pelanggan memilih produk dari menu dan menambahkannya ke keranjang dengan jumlah yang diinginkan |

**Skenario Utama:**

| No | Aktor | Sistem |
|----|-------|--------|
| 1 | Pelanggan memilih produk dari daftar menu | - |
| 2 | Pelanggan menentukan jumlah produk yang diinginkan | - |
| 3 | Pelanggan menekan tombol "Add to Cart" | - |
| 4 | - | Sistem menyimpan item ke dalam session keranjang |
| 5 | - | Sistem menampilkan notifikasi "Berhasil ditambahkan" |
| 6 | - | Sistem memperbarui badge jumlah item di ikon keranjang |

---

## 3. Use Case: Melihat Keranjang

| Komponen | Deskripsi |
|----------|-----------|
| **Use Case** | Melihat Keranjang |
| **Aktor** | Pelanggan (Customer) |
| **Tipe** | Primary |
| **Tujuan** | Pelanggan dapat melihat daftar item yang telah ditambahkan ke keranjang |
| **Deskripsi** | Pelanggan mengakses halaman keranjang untuk mereview pesanan sebelum checkout |

**Skenario Utama:**

| No | Aktor | Sistem |
|----|-------|--------|
| 1 | Pelanggan menekan ikon keranjang di header | - |
| 2 | - | Sistem menampilkan halaman keranjang |
| 3 | - | Sistem menampilkan daftar item (nama, qty, harga, subtotal) |
| 4 | - | Sistem menghitung dan menampilkan total harga |
| 5 | Pelanggan dapat mengubah jumlah atau menghapus item | - |
| 6 | - | Sistem memperbarui total harga secara otomatis |

---

## 4. Use Case: Melakukan Checkout

| Komponen | Deskripsi |
|----------|-----------|
| **Use Case** | Melakukan Checkout |
| **Aktor** | Pelanggan (Customer) |
| **Tipe** | Primary |
| **Tujuan** | Pelanggan dapat membuat pesanan dari item di keranjang |
| **Deskripsi** | Pelanggan mengonfirmasi pesanan dan memasukkan nama (opsional) untuk membuat order baru |

**Skenario Utama:**

| No | Aktor | Sistem |
|----|-------|--------|
| 1 | Pelanggan menekan tombol "Place Order" di halaman keranjang | - |
| 2 | Pelanggan mengisi nama (opsional) | - |
| 3 | Pelanggan menekan tombol konfirmasi | - |
| 4 | - | Sistem membuat record Order baru di database |
| 5 | - | Sistem membuat record OrderItem untuk setiap produk |
| 6 | - | Sistem mengosongkan session keranjang |
| 7 | - | Sistem mengarahkan ke halaman status pesanan |

---

## 5. Use Case: Melakukan Pembayaran

| Komponen | Deskripsi |
|----------|-----------|
| **Use Case** | Melakukan Pembayaran |
| **Aktor** | Pelanggan (Customer) |
| **Tipe** | Primary |
| **Tujuan** | Pelanggan dapat memilih metode pembayaran dan menyelesaikan transaksi |
| **Deskripsi** | Pelanggan memilih metode pembayaran (Cash/QRIS) untuk menyelesaikan pesanan |

**Skenario Utama:**

| No | Aktor | Sistem |
|----|-------|--------|
| 1 | Pelanggan menekan tombol "Proceed to Payment" di halaman status | - |
| 2 | - | Sistem menampilkan halaman pemilihan metode pembayaran |
| 3 | - | Sistem menampilkan total yang harus dibayar |
| 4 | Pelanggan memilih metode pembayaran (Cash atau QRIS) | - |
| 5 | Pelanggan menekan tombol "Pay Now" | - |
| 6 | - | Sistem membuat record Payment dengan status pending |
| 7 | - | Sistem menampilkan instruksi pembayaran |

---

## 6. Use Case: Mengelola Kategori

| Komponen | Deskripsi |
|----------|-----------|
| **Use Case** | Mengelola Kategori |
| **Aktor** | Admin |
| **Tipe** | Primary |
| **Tujuan** | Admin dapat menambah, mengubah, dan menghapus kategori menu |
| **Deskripsi** | Admin mengelola kategori produk (makanan/minuman) melalui dashboard admin |

**Skenario Utama:**

| No | Aktor | Sistem |
|----|-------|--------|
| 1 | Admin login ke sistem | - |
| 2 | - | Sistem memvalidasi kredensial dan mengarahkan ke dashboard |
| 3 | Admin memilih menu "Categories" di sidebar | - |
| 4 | - | Sistem menampilkan daftar kategori yang ada |
| 5 | Admin menekan tombol "Add Category" | - |
| 6 | - | Sistem menampilkan form tambah kategori |
| 7 | Admin mengisi nama dan tipe kategori (food/drink) | - |
| 8 | Admin menekan tombol "Save" | - |
| 9 | - | Sistem menyimpan kategori baru ke database |
| 10 | - | Sistem menampilkan pesan sukses |

---

## 7. Use Case: Mengelola Produk

| Komponen | Deskripsi |
|----------|-----------|
| **Use Case** | Mengelola Produk |
| **Aktor** | Admin |
| **Tipe** | Primary |
| **Tujuan** | Admin dapat menambah, mengubah, dan menghapus produk menu |
| **Deskripsi** | Admin mengelola data produk termasuk nama, harga, deskripsi, gambar, dan ketersediaan |

**Skenario Utama:**

| No | Aktor | Sistem |
|----|-------|--------|
| 1 | Admin memilih menu "Products" di sidebar | - |
| 2 | - | Sistem menampilkan daftar produk dengan pagination |
| 3 | Admin menekan tombol "Add Product" | - |
| 4 | - | Sistem menampilkan form tambah produk |
| 5 | Admin mengisi data produk (nama, kategori, harga, deskripsi) | - |
| 6 | Admin mengunggah gambar produk | - |
| 7 | Admin menekan tombol "Save" | - |
| 8 | - | Sistem menyimpan gambar ke storage |
| 9 | - | Sistem menyimpan data produk ke database |
| 10 | - | Sistem menampilkan pesan sukses dan kembali ke daftar |

---

## 8. Use Case: Mengonfirmasi Pembayaran

| Komponen | Deskripsi |
|----------|-----------|
| **Use Case** | Mengonfirmasi Pembayaran |
| **Aktor** | Kasir |
| **Tipe** | Primary |
| **Tujuan** | Kasir dapat mengonfirmasi pembayaran yang diterima dari pelanggan |
| **Deskripsi** | Kasir memverifikasi pembayaran (cash/QRIS) dan mengubah status pesanan menjadi "cooking" |

**Skenario Utama:**

| No | Aktor | Sistem |
|----|-------|--------|
| 1 | Kasir login ke sistem | - |
| 2 | - | Sistem menampilkan dashboard kasir |
| 3 | - | Sistem menampilkan daftar pesanan dengan pembayaran pending |
| 4 | Kasir menerima pembayaran dari pelanggan | - |
| 5 | Kasir menekan tombol "Confirm Paid" pada pesanan terkait | - |
| 6 | - | Sistem mengubah payment_status menjadi "paid" |
| 7 | - | Sistem mengubah order_status menjadi "cooking" |
| 8 | - | Sistem menampilkan pesan konfirmasi sukses |
| 9 | - | Sistem menghapus pesanan dari daftar pending |

---

## 9. Use Case: Menandai Pesanan Siap

| Komponen | Deskripsi |
|----------|-----------|
| **Use Case** | Menandai Pesanan Siap |
| **Aktor** | Koki |
| **Tipe** | Primary |
| **Tujuan** | Koki dapat menandai pesanan yang sudah selesai dimasak |
| **Deskripsi** | Koki melihat pesanan di Kitchen Display System dan menandai pesanan sebagai "ready" setelah selesai dimasak |

**Skenario Utama:**

| No | Aktor | Sistem |
|----|-------|--------|
| 1 | Koki login ke sistem | - |
| 2 | - | Sistem menampilkan dashboard koki |
| 3 | Koki memilih menu "Kitchen Display" di sidebar | - |
| 4 | - | Sistem menampilkan daftar pesanan dengan status "cooking" |
| 5 | - | Sistem menampilkan detail item dan waktu tunggu setiap pesanan |
| 6 | Koki menyiapkan pesanan sesuai urutan | - |
| 7 | Koki menekan tombol "Mark as Ready" pada pesanan yang selesai | - |
| 8 | - | Sistem mengubah order_status menjadi "ready" |
| 9 | - | Sistem menghapus pesanan dari tampilan KDS |
| 10 | - | Sistem auto-refresh untuk memuat pesanan baru |
