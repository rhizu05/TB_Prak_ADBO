## 🎯 Ringkasan

Diagram class yang Anda buat sudah **sangat bagus dan lengkap**! Namun ada beberapa field tambahan yang diperlukan untuk mendukung fitur-fitur yang telah kita diskusikan:

1. ✅ Payment timeout (20 menit)
2. ✅ Auto-cancellation mechanism
3. ✅ Table activation/deactivation

---

## ➕ Field yang Perlu Ditambahkan

### 1. **Table** - Tambahkan 1 Field

```diff
Table
+ id: Integer
+ number: String
+ qr_url: String
++ is_active: Boolean
+ method(type): type
```

#### **is_active: Boolean**
- **Fungsi**: Enable/disable meja tanpa perlu hapus data
- **Use Case**: Jika meja rusak atau sedang maintenance, bisa di-nonaktifkan sementara
- **Default**: `true`

---

### 2. **Order** - Tambahkan 2 Field + Update Enum

```diff
Order
+ id: Integer
+ table_id: Integer
+ consumer_name: String
+ total_amount: Decimal
+ snap_token: String
+ created_at: Date time
+ payment_method: Enum(Cash, QRIS)
- payment_status: Enum(Pending, Paid)
+ payment_status: Enum(Pending, Paid, Cancelled)
+ Order_Status: Enum(Pending, Cooking, Ready, Completed)
++ payment_expires_at: Timestamp
++ cancelled_at: Timestamp (Nullable)
```

#### **payment_expires_at: Timestamp**
- **Fungsi**: Menyimpan deadline pembayaran (created_at + 20 menit)
- **Use Case**: System scheduler cek field ini untuk auto-cancel order yang expired
- **Format**: `2025-12-17 11:30:00`

#### **cancelled_at: Timestamp (Nullable)**
- **Fungsi**: Tracking kapan order dibatalkan (manual atau auto)
- **Use Case**: Untuk laporan dan analisis kenapa order dibatalkan
- **Nullable**: `NULL` jika belum di-cancel

#### **payment_status: Enum** - Tambahkan 'Cancelled'
- **Current**: `Enum(Pending, Paid)`
- **Update to**: `Enum(Pending, Paid, Cancelled)`
- **Fungsi**: Status 'Cancelled' untuk order yang timeout atau dibatalkan

---

## 📊 Visualisasi Update

### **Before (Diagram Current):**

```
┌──────────────────────────┐
│ Table                    │
├──────────────────────────┤
│ + id: Integer            │
│ + number: String         │
│ + qr_url: String         │
│ + method(type): type     │
└──────────────────────────┘

┌──────────────────────────────────────────────┐
│ Order                                        │
├──────────────────────────────────────────────┤
│ + payment_status: Enum(Pending, Paid)        │
│ + Order_Status: Enum(Pending, Cooking, ...)  │
└──────────────────────────────────────────────┘
```

### **After (Dengan Field Tambahan):**

```
┌──────────────────────────┐
│ Table                    │
├──────────────────────────┤
│ + id: Integer            │
│ + number: String         │
│ + qr_url: String         │
│ ✨ + is_active: Boolean  │  ← NEW
│ + method(type): type     │
└──────────────────────────┘

┌────────────────────────────────────────────────────┐
│ Order                                              │
├────────────────────────────────────────────────────┤
│ + payment_status: Enum(Pending, Paid, Cancelled)   │  ← UPDATED
│ + Order_Status: Enum(Pending, Cooking, ...)        │
│ ✨ + payment_expires_at: Timestamp                 │  ← NEW
│ ✨ + cancelled_at: Timestamp (Nullable)            │  ← NEW
└────────────────────────────────────────────────────┘
```

---

## 🔄 Business Logic untuk Field Baru

### **1. is_active (Table)**

**Alur:**
```
Admin → Manajemen Meja → Set Capacity
- Meja 1: capacity = 2 (untuk couple)
- Meja 2: capacity = 4 (untuk keluarga kecil)
- Meja 3: capacity = 8 (untuk rombongan)
```

**Use Case:**
- Informasi untuk customer berapa orang muat di meja
- Bisa untuk optimasi penempatan customer (future feature)

---

### **2. payment_expires_at (Order)**

**Alur:**
```
1. Customer checkout → created_at = 2025-12-17 11:00:00
2. System auto set → payment_expires_at = 2025-12-17 11:20:00
3. Laravel Scheduler cek setiap menit
4. Jika NOW() > payment_expires_at DAN payment_status = 'pending'
   → Update payment_status = 'cancelled'
   → Set cancelled_at = NOW()
```

**Laravel Command:**
```php
// app/Console/Commands/CancelExpiredOrders.php
Order::where('payment_status', 'pending')
     ->where('payment_expires_at', '<', now())
     ->update([
         'payment_status' => 'cancelled',
         'cancelled_at' => now()
     ]);
```

---

### **3. cancelled_at (Order)**

**Alur:**
```
Scenario 1: Auto-cancel
- payment_expires_at terlewati
- System set cancelled_at = now()

Scenario 2: Manual cancel (future feature)
- Customer/Admin cancel pesanan
- System set cancelled_at = now()
```

**Use Case:**
- Tracking & analytics: Berapa banyak order yang cancelled?
- Laporan: Grafik order cancelled per hari/minggu
- Audit: Siapa yang cancel dan kapan

---

## ✅ Checklist Update Diagram

Untuk melengkapi Class Diagram Anda:

- [ ] **Table**: Tambahkan field `is_active` (Boolean)
- [ ] **Order**: Tambahkan field `payment_expires_at` (Timestamp)
- [ ] **Order**: Tambahkan field `cancelled_at` (Timestamp, Nullable)
- [ ] **Order**: Update `payment_status` enum → tambahkan `'Cancelled'`

---

## 📝 Catatan Tambahan

### **Tabel Payments (OPSIONAL)**

Di diagram Anda **TIDAK ADA** tabel `Payments`. Ini **OK dan VALID**!

**Alternatif 1 (Tanpa tabel Payments):**
- Laporan penjualan diambil langsung dari tabel `Order`
- Filter by: `payment_status = 'paid'` dan `payment_method`
- Simple dan cukup untuk kebanyakan use case

**Alternatif 2 (Dengan tabel Payments):**
- Tracking lebih detail untuk setiap payment attempt
- Support multiple payment attempts per order
- Lebih kompleks tapi lebih comprehensive untuk audit

**Rekomendasi saya**: Mulai **TANPA** tabel Payments (ikuti diagram Anda), bisa ditambahkan nanti jika perlu.

---

## 🎯 Summary

**Yang Perlu Ditambahkan:**
1. ✅ Table.is_active (Boolean)
2. ✅ Order.payment_expires_at (Timestamp)
3. ✅ Order.cancelled_at (Timestamp)
4. ✅ Order.payment_status → tambah 'Cancelled'

**Total**: **4 perubahan kecil** untuk melengkapi diagram Anda!

Diagram Anda sudah 96% sempurna, tinggal tambahkan 4 field di atas untuk mendukung fitur auto-cancellation dan table management. 🚀
