# 4.4.1 Pengujian Fungsional (Black Box Testing)

## Rencana Pengujian Sistem RestoQR

| No | Fitur/Use Case | Skenario Uji | Input | Output yang Diharapkan |
|----|----------------|--------------|-------|------------------------|
| 1 | Login | Login dengan kredensial valid | Email: admin@restoqr.com, Password: password | User berhasil login dan diarahkan ke dashboard sesuai role |
| 2 | Login | Login dengan kredensial tidak valid | Email: admin@restoqr.com, Password: salah | Muncul pesan error "Invalid credentials" |
| 3 | Melihat Menu Digital | Scan QR Code meja untuk akses menu | Scan QR Meja #1 | Halaman menu terbuka dengan header "Table #1" dan daftar produk |
| 4 | Melihat Menu Digital | Mencari menu dengan kata kunci | Kata kunci: "nasi" | Tampil produk yang mengandung kata "nasi" |
| 5 | Melakukan Pemesanan | Menambah item ke keranjang | Klik "Add" pada produk | Item berhasil ditambahkan, badge keranjang bertambah |
| 6 | Melakukan Pemesanan | Checkout dengan item valid | Nama: "Budi", Keranjang: 2 item | Pesanan berhasil dibuat, redirect ke halaman pembayaran |
| 7 | Melakukan Pemesanan | Checkout dengan keranjang kosong | Akses checkout tanpa item | Muncul pesan error "Cart is empty" |
| 8 | Melakukan Pembayaran (Tunai) | Pilih metode pembayaran Tunai | Pilih "Cash", klik "Pay Now" | Tampil halaman instruksi bayar ke kasir dengan nomor pesanan |
| 9 | Melakukan Pembayaran (QRIS) | Pilih metode pembayaran QRIS | Pilih "QRIS", klik "Pay Now" | Tampil halaman QR Code Midtrans untuk di-scan |
| 10 | Melakukan Pembayaran (QRIS) | Pembayaran QRIS berhasil | Scan QR dan bayar via simulator | Status pembayaran otomatis berubah menjadi "Paid" |
| 11 | Konfirmasi Pembayaran Tunai | Kasir konfirmasi pembayaran | Klik "Confirm Paid" pada order pending | Payment status berubah menjadi "Paid", order dikirim ke dapur |
| 12 | Konfirmasi Pembayaran Tunai | Melihat daftar pembayaran pending | Login sebagai Kasir | Tampil daftar pesanan dengan payment status "pending" |
| 13 | Update Status Pesanan | Koki menandai pesanan siap | Klik "Mark as Ready" pada KDS | Order status berubah dari "proses" menjadi "siap" |
| 14 | Update Status Pesanan | Melihat pesanan di Kitchen Display | Login sebagai Koki, buka KDS | Tampil kartu pesanan dengan detail item dan waktu tunggu |
| 15 | Melihat Laporan | Melihat laporan dengan filter periode | Pilih "7 Hari Terakhir" | Data laporan dan grafik sesuai periode yang dipilih |
| 16 | Melihat Laporan | Export laporan ke CSV | Klik tombol "Export CSV" | File CSV terdownload dengan data transaksi |

---

*Dokumen ini dibuat untuk keperluan pengujian fungsional sistem RestoQR.*
