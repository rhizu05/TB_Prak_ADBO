# Sequence Diagrams - RestoQR System

Dokumentasi Sequence Diagram yang diterjemahkan dari Activity Diagram yang telah disetujui.
Format: Mermaid JS.

---

## 1. Login User (Admin/Kasir/Koki)

```mermaid
sequenceDiagram
    participant User as Actor (Admin/Kasir/Koki)
    participant View as Login Page
    participant Controller as AuthController
    participant Model as User Model
    participant DB as Database

    User->>View: Buka Halaman Login
    View->>User: Tampilkan Form Login
    User->>View: Input Email & Password
    User->>View: Klik Tombol Login
    View->>Controller: submit(email, password)
    
    activate Controller
    Controller->>Model: where(email)->first()
    activate Model
    Model->>DB: Select * from users where email = ?
    activate DB
    DB-->>Model: User Data
    deactivate DB
    Model-->>Controller: User Object
    deactivate Model

    Controller->>Controller: Hash::check(password)
    
    alt Kredensial Valid
        Controller->>Controller: Auth::login(user)
        Controller->>Controller: Check Role (Admin/Kasir/Koki)
        Controller-->>View: Redirect to Dashboard
        View-->>User: Tampilkan Dashboard Sesuai Role
    else Kredensial Salah
        Controller-->>View: Return Error "Invalid Credential"
        View-->>User: Tampilkan Pesan Error
    end
    deactivate Controller
```

---

## 2. Mengelola Data Menu (Admin)

```mermaid
sequenceDiagram
    participant Admin
    participant View as Menu Index/Create/Edit View
    participant Controller as MenuController
    participant Model as Product Model
    participant DB as Database

    Admin->>View: Buka Manajemen Menu
    View->>Controller: index()
    Controller->>Model: all()
    Model->>DB: Select * from products where deleted_at is null
    DB-->>Model: List Products
    Model-->>Controller: List Products
    Controller-->>View: Tampilkan Daftar Menu

    alt Tambah Menu
        Admin->>View: Klik Tambah Menu
        View->>Admin: Form Tambah Menu
        Admin->>View: Input Data & Submit
        View->>Controller: store(request)
        activate Controller
        Controller->>Model: create(data)
        Model->>DB: Insert into products
        DB-->>Model: Success
        Model-->>Controller: Product Created
        Controller-->>View: Redirect with Success Notification
        deactivate Controller
    else Edit Menu
        Admin->>View: Klik Edit Menu
        View->>Controller: edit(id)
        Controller-->>View: Form Edit with Data
        Admin->>View: Update Data & Submit
        View->>Controller: update(request, id)
        activate Controller
        Controller->>Model: update(data)
        Model->>DB: Update products set...
        DB-->>Model: Success
        Model-->>Controller: Product Updated
        Controller-->>View: Redirect with Success Notification
        deactivate Controller
    else Hapus Menu (Soft Delete)
        Admin->>View: Klik Hapus Menu
        View->>Controller: destroy(id)
        activate Controller
        Controller->>Model: delete()
        Model->>DB: Update products set deleted_at = NOW()
        DB-->>Model: Success
        Model-->>Controller: Product Soft Deleted
        Controller-->>View: Redirect with Success Notification
        deactivate Controller
    end
```

---

## 3. Mengelola Data Meja (Admin)

```mermaid
sequenceDiagram
    participant Admin
    participant View as Table Index View
    participant Controller as TableController
    participant Service as QrCodeService
    participant Model as Table Model
    participant DB as Database

    Admin->>View: Buka Manajemen Meja
    View->>Admin: Form Tambah Meja
    Admin->>View: Input Nomor Meja & Generate
    View->>Controller: store(number)
    
    activate Controller
    Controller->>Service: generate(url)
    activate Service
    Service-->>Controller: QR Code Image/String
    deactivate Service
    
    Controller->>Model: create(number, qr_path, is_active=true)
    activate Model
    Model->>DB: Insert into tables
    activate DB
    DB-->>Model: Success
    deactivate DB
    Model-->>Controller: Table Created
    deactivate Model

    Controller-->>View: Show Table & QR Code
    View-->>Admin: Tampilkan QR Code & Notifikasi
    deactivate Controller
```

---

## 4. Melihat Laporan (Admin)

```mermaid
sequenceDiagram
    participant Admin
    participant View as Report View
    participant Controller as ReportController
    participant Model as Order/Payment Model
    participant DB as Database

    Admin->>View: Buka Halaman Laporan
    View->>Controller: index()
    Controller-->>View: Form Filter Tanggal

    Admin->>View: Filter Tanggal/Periode & Submit
    View->>Controller: filter(startDate, endDate)
    
    activate Controller
    Controller->>Model: whereBetween('created_at', [start, end])->get()
    activate Model
    Model->>DB: Select * from payments/orders...
    activate DB
    DB-->>Model: Transaction Data
    deactivate DB
    Model-->>Controller: Collection of Transactions
    deactivate Model

    Controller->>Controller: Calculate Total Revenue
    Controller-->>View: Render Chart & Table Data
    View-->>Admin: Tampilkan Grafik & Tabel Laporan
    deactivate Controller
```

---

## 5. Melihat Menu Digital (Pelanggan)

```mermaid
sequenceDiagram
    participant Pelanggan
    participant View as Public Menu View
    participant Controller as PublicMenuController
    participant ModelTable as Table Model
    participant ModelMenu as Product Model
    participant DB as Database

    Pelanggan->>View: Scan QR Code (Link: /menu/{number})
    View->>Controller: show(table_number)
    
    activate Controller
    Controller->>ModelTable: where('number', number)->first()
    activate ModelTable
    ModelTable->>DB: Select check
    DB-->>ModelTable: Table Data
    deactivate ModelTable

    alt Table Invalid / Inactive
        ModelTable-->>Controller: Null / Inactive
        Controller-->>View: Show 404 / Error Page
        View-->>Pelanggan: Tampilkan Pesan Error
    else Table Valid
        ModelTable-->>Controller: Table Object
        Controller->>ModelMenu: all() (grouped by category)
        activate ModelMenu
        ModelMenu->>DB: Select * from products where is_available=1
        DB-->>ModelMenu: Menu List
        deactivate ModelMenu
        
        Controller-->>View: Render Menu Page (with Table Info)
        View-->>Pelanggan: Tampilkan Daftar Menu & Kategori
    end
    deactivate Controller
```

---

## 6. Melakukan Pemesanan (Pelanggan)

```mermaid
sequenceDiagram
    participant Pelanggan
    participant View as Menu/Cart View
    participant Controller as OrderController
    participant Model as Order Model
    participant DB as Database

    Pelanggan->>View: Pilih Menu & Add to Cart
    View->>View: Update Local Cart (Session/Storage)
    Pelanggan->>View: Klik Checkout
    View->>View: Show Checkout Form
    Pelanggan->>View: Input Nama & Confirm Order
    View->>Controller: checkout(cartData, customerName, tableId)
    
    activate Controller
    Controller->>Model: create(status='pending', payment_status='unpaid'...)
    activate Model
    Model->>DB: Insert into orders
    Model->>DB: Insert into order_items
    DB-->>Model: Order ID
    deactivate Model
    Model-->>Controller: Order Object
    
    Controller-->>View: Redirect to Payment Page (Order ID)
    View-->>Pelanggan: Tampilkan Halaman Pembayaran
    deactivate Controller
```

---

## 7. Melakukan Pembayaran (Pelanggan)

```mermaid
sequenceDiagram
    participant Pelanggan
    participant View as Payment View
    participant Controller as PaymentController
    participant Service as Midtrans Service
    participant Model as Order Model
    participant DB as Database
    participant Webhook as PaymentGateway (Midtrans)

    Pelanggan->>View: Pilih Metode Pembayaran
    
    alt Bayar Tunai
        Pelanggan->>View: Klik Tunai
        View->>Controller: payCash(orderId)
        Controller->>Model: update(payment_method='cash', payment_status='unpaid')
        Controller-->>View: Show Instruction "Pay at Cashier"
        View-->>Pelanggan: Tampilkan Instruksi Bayar Kasir
    else Bayar QRIS
        Pelanggan->>View: Klik QRIS
        View->>Controller: payQris(orderId)
        
        activate Controller
        Controller->>Service: getSnapToken(order)
        activate Service
        Service->>Webhook: Request Token
        Webhook-->>Service: Snap Token
        deactivate Service
        
        Controller-->>View: Show Snap Popup / QR
        View-->>Pelanggan: Tampilkan QR Code Midtrans
        deactivate Controller
        
        Note right of Webhook: Pelanggan scan & bayar di HP Sendiri
        
        Webhook->>Controller: Webhook Handler (POST /payment-notify)
        activate Controller
        Controller->>Model: update(payment_status='paid')
        Model->>DB: Update orders...
        Controller->>Controller: Event(OrderPaid)
        deactivate Controller
        
        View-->>Pelanggan: Auto-refresh / Show Success
    end
```

---

## 8. Konfirmasi Pembayaran Tunai (Kasir)

```mermaid
sequenceDiagram
    participant Kasir
    participant View as Cashier Dashboard
    participant Controller as PaymentController
    participant Model as Order Model
    participant DB as Database
    participant Event as System Event

    Kasir->>View: Terima Uang & Cari Order
    View->>Controller: show(orderId)
    Controller-->>View: Order Details
    
    Kasir->>View: Klik "Confirm Payment"
    View->>Controller: confirmPayment(orderId)
    
    activate Controller
    Controller->>Model: find(orderId)
    Model->>DB: Select *
    DB-->>Model: Order Data
    
    Controller->>Model: update(payment_status='paid')
    activate Model
    Model->>DB: Update orders set payment_status='paid'
    DB-->>Model: Success
    deactivate Model
    
    Controller->>Event: dispatch(OrderPaid)
    Note right of Event: Realtime Notification to Kitchen
    
    Controller-->>View: Return Success Response
    View-->>Kasir: Update Status "Lunas" di Dashboard
    deactivate Controller
```

---

## 9. Update Status (Koki)

```mermaid
sequenceDiagram
    participant Koki
    participant View as Kitchen Dashboard
    participant Controller as KitchenController
    participant Model as Order Model
    participant DB as Database
    participant Event as System Event

    Note over View: Listening to OrderPaid Channel

    Koki->>View: Lihat Order Masuk (Status: Proses)
    Note right of Koki: Koki memasak pesanan...
    
    Koki->>View: Klik "Tandai Selesai"
    View->>Controller: updateStatus(orderId, 'siap')
    
    activate Controller
    Controller->>Model: update(order_status='siap')
    activate Model
    Model->>DB: Update orders set order_status='siap'
    DB-->>Model: Success
    deactivate Model
    
    Controller->>Event: dispatch(OrderStatusUpdated)
    Note right of Event: Notify Kasir/Waiter
    
    Controller-->>View: Return Success
    View-->>Koki: Status berubah jadi "Siap"
    deactivate Controller
```
