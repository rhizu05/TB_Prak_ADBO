# Use Case Diagram - RestoQR

## Diagram Use Case Sistem

```mermaid
graph TB
    subgraph System["RestoQR System"]
        UC1["Login User"]
        UC2["Manajemen Menu<br/>(CRUD)"]
        UC3["Manajemen Meja<br/>(Generate QR)"]
        UC4["Laporan Penjualan"]
        UC5["Menu Digital<br/>(Scan QR)"]
        UC6["Pemesanan Mandiri<br/>(Cart & Checkout)"]
        UC7["Pembayaran Hybrid<br/>(QRIS/Tunai)"]
        UC8["Konfirmasi Pembayaran"]
        UC9["Manajemen Dapur<br/>Realtime"]
    end
    
    Admin["👨‍💼 Admin"]
    Kasir["💰 Kasir"]
    Koki["👨‍🍳 Koki"]
    Pelanggan["🧑‍🍽️ Pelanggan"]
    
    %% Admin connections
    Admin -->|login| UC1
    Admin -->|kelola| UC2
    Admin -->|kelola & generate QR| UC3
    Admin -->|lihat & export| UC4
    
    %% Kasir connections
    Kasir -->|login| UC1
    Kasir -->|konfirmasi tunai| UC8
    
    %% Koki connections
    Koki -->|login| UC1
    Koki -->|update status| UC9
    
    %% Pelanggan connections
    Pelanggan -->|scan & lihat| UC5
    Pelanggan -->|pesan| UC6
    Pelanggan -->|bayar| UC7
    
    %% Include relationships
    UC6 -.->|include| UC5
    UC7 -.->|include| UC6
    
    %% Extend relationships
    UC8 -.->|extend<br/>(jika tunai)| UC7
    
    style System fill:#EFF6FF,stroke:#3B82F6,stroke-width:3px
    style Admin fill:#DBEAFE,stroke:#2563EB,stroke-width:2px
    style Kasir fill:#DBEAFE,stroke:#2563EB,stroke-width:2px
    style Koki fill:#DBEAFE,stroke:#2563EB,stroke-width:2px
    style Pelanggan fill:#FEF3C7,stroke:#F59E0B,stroke-width:2px
    
    style UC1 fill:#FFF,stroke:#3B82F6,stroke-width:2px
    style UC2 fill:#FFF,stroke:#3B82F6,stroke-width:2px
    style UC3 fill:#FFF,stroke:#3B82F6,stroke-width:2px
    style UC4 fill:#FFF,stroke:#3B82F6,stroke-width:2px
    style UC5 fill:#FFF,stroke:#3B82F6,stroke-width:2px
    style UC6 fill:#FFF,stroke:#3B82F6,stroke-width:2px
    style UC7 fill:#FFF,stroke:#3B82F6,stroke-width:2px
    style UC8 fill:#FFF,stroke:#3B82F6,stroke-width:2px
    style UC9 fill:#FFF,stroke:#3B82F6,stroke-width:2px
```

---

## Deskripsi Aktor

### 👨‍💼 Admin
**Role**: Administrator sistem
**Akses**: Full access ke seluruh fitur manajemen

**Use Cases:**
1. Login User - Autentikasi ke sistem
2. Manajemen Menu - Create, Read, Update, Delete menu & kategori
3. Manajemen Meja - Manage tables & generate QR code
4. Laporan Penjualan - View, filter, export laporan

---

### 💰 Kasir
**Role**: Cashier/Front desk
**Akses**: Dashboard kasir untuk konfirmasi pembayaran tunai

**Use Cases:**
1. Login User - Autentikasi ke sistem
2. Konfirmasi Pembayaran - Konfirmasi pembayaran tunai dari pelanggan
   - Menerima notifikasi realtime untuk pesanan baru
   - Mengubah status order dari `pending` → `paid`

---

### 👨‍🍳 Koki
**Role**: Kitchen staff
**Akses**: Dashboard dapur untuk manajemen pesanan

**Use Cases:**
1. Login User - Autentikasi ke sistem
2. Manajemen Dapur Realtime - Kelola status pesanan
   - Menerima notifikasi realtime untuk pesanan lunas
   - Update status: `cooking` → `ready` → `completed`

---

### 🧑‍🍽️ Pelanggan
**Role**: Customer/Guest
**Akses**: Public access (tanpa login)

**Use Cases:**
1. Menu Digital - Scan QR code di meja, lihat menu
2. Pemesanan Mandiri - Tambah item ke cart, checkout
3. Pembayaran Hybrid - Pilih metode pembayaran (QRIS atau Tunai)

---

## Relasi Use Case

### 🔗 Include Relationships
Include menunjukkan use case yang **wajib** dilakukan sebagai bagian dari use case lain:

- **UC6 (Pemesanan Mandiri) include UC5 (Menu Digital)**
  - Untuk memesan, pelanggan harus lihat menu terlebih dahulu

- **UC7 (Pembayaran Hybrid) include UC6 (Pemesanan Mandiri)**
  - Untuk membayar, pelanggan harus checkout pesanan terlebih dahulu

### ➕ Extend Relationships
Extend menunjukkan use case yang **opsional** atau kondisional:

- **UC8 (Konfirmasi Pembayaran) extend UC7 (Pembayaran Hybrid)**
  - Konfirmasi kasir hanya terjadi jika pelanggan pilih metode **tunai**
  - Jika QRIS, tidak perlu konfirmasi manual (auto-verified oleh Midtrans)

---

## Skenario Alur Lengkap

### 📱 **Alur Pelanggan (Customer Journey)**

1. **Scan QR Code** di meja → UC5 (Menu Digital)
2. **Lihat Menu** → Pilih item
3. **Tambah ke Cart** → UC6 (Pemesanan Mandiri)
4. **Checkout** → Review order
5. **Pilih Pembayaran** → UC7 (Pembayaran Hybrid)
   - **Jika QRIS**: Bayar via Midtrans → Auto verified → Status: `paid`
   - **Jika Tunai**: Datang ke kasir → UC8 (Konfirmasi Pembayaran) → Status: `paid`

### 🔔 **Alur Kasir**

1. **Login** → UC1
2. **Terima Notifikasi** realtime untuk order baru (status: `pending`)
3. **Jika pembayaran tunai** → UC8 (Konfirmasi Pembayaran)
4. Update status `pending` → `paid`

### 👨‍🍳 **Alur Koki**

1. **Login** → UC1
2. **Terima Notifikasi** realtime untuk order lunas (status: `paid`)
3. **UC9 (Manajemen Dapur):**
   - Masak → Update status `cooking`
   - Selesai masak → Update status `ready`
   - Sudah disajikan → Update status `completed`

### 👨‍💼 **Alur Admin**

1. **Login** → UC1
2. **UC2** → Kelola menu & kategori (CRUD)
3. **UC3** → Kelola meja & generate QR code
4. **UC4** → Lihat laporan penjualan
   - Filter by date, payment method, status
   - Export to PDF/Excel

---

## Summary

| # | Use Case | Aktor | Include | Extend |
|---|----------|-------|---------|--------|
| 1 | Login User | Admin, Kasir, Koki | - | - |
| 2 | Manajemen Menu | Admin | - | - |
| 3 | Manajemen Meja | Admin | - | - |
| 4 | Laporan Penjualan | Admin | - | - |
| 5 | Menu Digital | Pelanggan | - | - |
| 6 | Pemesanan Mandiri | Pelanggan | UC5 | - |
| 7 | Pembayaran Hybrid | Pelanggan | UC6 | - |
| 8 | Konfirmasi Pembayaran | Kasir | - | UC7 (jika tunai) |
| 9 | Manajemen Dapur Realtime | Koki | - | - |

**Total**: 4 Aktor, 9 Use Cases, 2 Include, 1 Extend
