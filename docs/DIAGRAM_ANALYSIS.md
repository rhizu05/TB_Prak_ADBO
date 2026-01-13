# Analisis Diagram RestoQR

## 📊 Diagram yang Telah Dibuat

### 1. Use Case Diagram
![Use Case Diagram](C:/Users/rhizu/.gemini/antigravity/brain/42cc80d6-a9b5-4baf-82e4-c0adf7799dd9/uploaded_image_0_1765944340347.png)

### 2. Class Diagram
![Class Diagram](C:/Users/rhizu/.gemini/antigravity/brain/42cc80d6-a9b5-4baf-82e4-c0adf7799dd9/uploaded_image_1_1765944340347.png)

---

## 📋 Analisis Use Case Diagram

### **Aktor (4)**
1. **Admin** - Administrator sistem
2. **Kasir** - Cashier untuk konfirmasi pembayaran
3. **Koki** - Kitchen staff untuk update status masakan
4. **Pelanggan** - Customer yang memesan

### **Use Cases dari Diagram**

#### Admin (3 Use Cases)
1. **Melihat Laporan** - View sales reports
2. **Mengelola Barcode Meja** - Manage table QR codes
3. **Mengelola Data Menu** - CRUD menu management

#### Kasir (2 Use Cases)
4. **Login** - Authentication
5. **Konfirmasi Pembayaran Tunai** - Confirm cash payment

#### Koki (2 Use Cases)
6. **Login** - Authentication (shared dengan Kasir & Admin)
7. **Update Status** - Update cooking status

#### Pelanggan (3 Use Cases)
8. **Melihat Menu** - View digital menu
9. **Melakukan Pemesanan** - Place order (cart & checkout)
10. **Melakukan Pembayaran** - Payment (QRIS/Cash)

### **Relasi Use Case**
- **<<include>>** antara "Melakukan Pemesanan" dan "Melihat Menu"
- **<<include>>** antara "Melakukan Pembayaran" dan "Melakukan Pemesanan"
- **<<extend>>** dari "Konfirmasi Pembayaran Tunai" ke "Melakukan Pembayaran"

---

## 🗄️ Analisis Class Diagram

### **Tables & Fields**

#### 1. **User**
```
+ id: Integer
+ name: String
+ email: String
+ password: String
+ role: Enum(Admin, kasir, koki)
```

#### 2. **Categori** (Category)
```
+ id: Integer
+ name: String
+ icon: String
+ method(type): type
```

#### 3. **Menu**
```
+ id: Integer
+ categori_id: String (FK to Categori)
+ name: String
+ price: String
+ image: String
+ is_available: Boolean
+ method(type): type
```
**Relasi**: `BelongsTo` Categori (1:Many)

#### 4. **Table**
```
+ id: Integer
+ number: String
+ qr_url: String
+ method(type): type
```
**Relasi**: `HasMany` Order (1:Many)

#### 5. **Order**
```
+ id: Integer
+ table_id: Integer (FK to Table)
+ consumer_name: String
+ total_amount: Decimal
+ snap_token: String
+ created_at: Date time
+ payment_method: Enum(Cash, QRIS)
+ payment_status: Enum(Pending, Paid)
+ Order_Status: Enum(Pending, Cooking, Ready, Completed)
```
**Relasi**: 
- `BelongsTo` Table (Many:1)
- `HasMany` Order Item (1:Many)

#### 6. **Order Item**
```
+ id: Integer
+ order_id: Integer (FK to Order)
+ menu_id: Integer (FK to Menu)
+ quantity: Integer
+ price: Decimal
+ note: String
+ method(type): type
```
**Relasi**: 
- `BelongsTo` Order (Many:1)
- `BelongsTo` Menu (Many:1)

---

## 🔍 Perbandingan dengan Spesifikasi Awal

### ✅ Yang Sudah Sesuai
1. **4 Aktor** - Admin, Kasir, Koki, Pelanggan ✓
2. **Login System** - Shared use case untuk staff ✓
3. **Payment Methods** - Cash & QRIS ✓
4. **Order Status Flow** - Pending → Cooking → Ready → Completed ✓
5. **Relasi Include/Extend** - Sesuai dengan business logic ✓
6. **Order Items** - Support note per item ✓

### ⚠️ Perbedaan yang Perlu Disesuaikan

#### Database Schema
| Field | Diagram | Spesifikasi Awal | Action |
|-------|---------|------------------|--------|
| **Table.capacity** | ❌ Tidak ada | ✅ Ada | **Tambahkan ke diagram** |
| **Table.is_active** | ❌ Tidak ada | ✅ Ada | **Tambahkan ke diagram** |
| **Order.payment_expires_at** | ❌ Tidak ada | ✅ Ada | **Tambahkan ke diagram** |
| **Order.cancelled_at** | ❌ Tidak ada | ✅ Ada | **Tambahkan ke diagram** |
| **Order.Order_Status** | ✅ Ada "Cancelled"? | ❌ Tidak ada | **Perlu klarifikasi** |
| **Payments Table** | ❌ Tidak ada | ✅ Ada (untuk laporan) | **Opsional - bisa dari Order** |

**Status Separation:**
- **Diagram**: `payment_status` (Pending/Paid) + `Order_Status` (Pending/Cooking/Ready/Completed)
- **Spesifikasi**: Single `status` field dengan semua state

> **Rekomendasi**: Ikuti diagram (2 field terpisah) karena lebih jelas memisahkan payment flow dan cooking flow

#### Use Case Count
- **Diagram**: Ada 10 use cases jika Login dihitung terpisah
- **Spesifikasi Awal**: 9 use cases

**Konversi ke 9 Use Cases:**
- Gabungkan 3 use case Login menjadi 1 use case "Login User" (shared)
- Total: 9 use cases ✓

---

## 📝 Rekomendasi Penyesuaian

### 1. **Update Class Diagram** (Tambahan Field)
Tambahkan ke diagram yang ada:

**Table:**
```diff
+ id: Integer
+ number: String
+ qr_url: String
++ capacity: Integer
++ is_active: Boolean
```

**Order:**
```diff
+ payment_status: Enum(Pending, Paid)
+ Order_Status: Enum(Pending, Cooking, Ready, Completed, Cancelled)
++ payment_expires_at: Timestamp
++ cancelled_at: Timestamp (Nullable)
```

### 2. **Use Case Consolidation** (9 Use Cases)
1. Login User (Admin, Kasir, Koki)
2. Mengelola Data Menu (Admin)
3. Mengelola Barcode Meja (Admin)
4. Melihat Laporan (Admin)
5. Melihat Menu (Pelanggan)
6. Melakukan Pemesanan (Pelanggan)
7. Melakukan Pembayaran (Pelanggan)
8. Konfirmasi Pembayaran Tunai (Kasir)
9. Update Status (Koki)

### 3. **Status Management**
Gunakan **2 field terpisah** seperti di diagram:

**payment_status:**
- `Pending` - Belum bayar
- `Paid` - Sudah bayar
- `Cancelled` - Payment timeout

**Order_Status:**
- `Pending` - Menunggu payment
- `Cooking` - Sedang dimasak
- `Ready` - Siap disajikan
- `Completed` - Sudah disajikan

---

## ✅ Final Alignment

**Diagram Anda sudah sangat bagus!** Hanya perlu penambahan beberapa field untuk:
- ✅ Table capacity management
- ✅ Payment timeout (20 menit)
- ✅ Auto-cancellation tracking

**Apakah Anda ingin saya:**
1. Update FINAL_SPESIFIKASI_SISTEM.md sesuai diagram Anda?
2. Buatkan versi Mermaid untuk kedua diagram?
3. Generate migration files sesuai Class Diagram?
