# TASK.md
# Project: Watch Store
# Tech Stack: Laravel 12 + PostgreSQL + Bootstrap 5

---

## 1. Project Initialization

### 1.1 Setup Environment
- [ ] Buat project Laravel 12
- [ ] Konfigurasi PostgreSQL di `.env`
- [ ] Setup koneksi database dan test koneksi
- [ ] Install package autentikasi yang dibutuhkan
- [ ] Setup Bootstrap 5
- [ ] Buat struktur folder dasar untuk Admin dan Customer
- [ ] Buat layout utama:
  - [ ] Admin Layout
  - [x] Halaman Katalog untuk Customer Layout

### 1.2 Base Configuration
- [ ] Set timezone aplikasi
- [ ] Set locale aplikasi
- [ ] Konfigurasi storage untuk upload gambar
- [ ] Konfigurasi route dasar
- [ ] Konfigurasi middleware role

---

## 2. Authentication & Role Management

### 2.1 Roles Table
- [ ] Buat migration tabel `roles`
- [ ] Buat model `Role`
- [ ] Seed data role:
  - [ ] admin
  - [ ] customer

### 2.2 Users Table
- [ ] Buat migration tabel `users`
- [ ] Tambahkan `role_id` pada users
- [ ] Tambahkan field tambahan:
  - [ ] phone
  - [ ] address
- [ ] Buat model `User`
- [ ] Hubungkan relasi `User belongsTo Role`

### 2.3 Auth Flow
- [ ] Buat halaman register customer
- [ ] Buat halaman login
- [ ] Buat logout
- [ ] Atur redirect berdasarkan role
- [ ] Buat middleware akses admin
- [ ] Buat middleware akses customer

### 2.4 Authorization Rules
- [ ] Pastikan admin tidak masuk ke halaman customer
- [ ] Pastikan customer tidak masuk ke halaman admin
- [ ] Batasi akses data berdasarkan pemilik data

---

## 3. Master Data: Categories

### 3.1 Database
- [ ] Buat migration tabel `categories` (tambahkan softDeletes)
- [ ] Buat model `Category` (gunakan trait SoftDeletes)

### 3.2 Admin CRUD Category
- [ ] Buat halaman daftar kategori
- [ ] Buat form tambah kategori
- [ ] Buat form edit kategori
- [ ] Buat proses simpan kategori
- [ ] Buat proses update kategori
- [ ] Buat proses hapus kategori
- [ ] Tambahkan validasi:
  - [ ] nama wajib
  - [ ] slug unik
  - [ ] status aktif

### 3.3 Seeder
- [ ] Buat seed kategori awal
- [ ] Isi contoh kategori jam tangan

---

## 4. Master Data: Products

### 4.1 Database
- [ ] Buat migration tabel `products` (tambahkan softDeletes)
- [ ] Tambahkan foreign key `category_id`
- [ ] Buat model `Product` (gunakan trait SoftDeletes)
- [ ] Hubungkan relasi:
  - [ ] Product belongsTo Category
  - [ ] Category hasMany Product

### 4.2 Admin CRUD Product
- [ ] Buat halaman daftar produk
- [ ] Buat form tambah produk
- [ ] Buat form edit produk
- [ ] Buat proses simpan produk
- [ ] Buat proses update produk
- [ ] Buat proses hapus produk
- [ ] Tambahkan validasi:
  - [ ] nama wajib
  - [ ] kategori wajib
  - [ ] brand wajib
  - [ ] harga wajib dan > 0
  - [ ] stok wajib dan >= 0
  - [ ] status aktif

### 4.3 Product Search & Filter
- [ ] Tambahkan pencarian produk
- [ ] Tambahkan filter kategori
- [ ] Tambahkan filter status aktif
- [ ] Tambahkan pagination

### 4.4 Product Status
- [ ] Buat fitur aktif/nonaktif produk
- [ ] Pastikan produk stok 0 tetap tampil tetapi tidak bisa dibeli

---

## 5. Product Images

### 5.1 Database
- [ ] Buat migration tabel `product_images`
- [ ] Buat model `ProductImage`
- [ ] Hubungkan relasi:
  - [ ] Product hasMany ProductImage
  - [ ] ProductImage belongsTo Product

### 5.2 Upload Gambar
- [ ] Buat upload gambar produk
- [ ] Simpan path gambar ke database
- [ ] Buat penanda gambar utama (`is_primary`)
- [ ] Batasi format file yang diizinkan
- [ ] Batasi ukuran file gambar
- [ ] Buat fitur hapus gambar

---

## 6. Cart System

### 6.1 Database
- [ ] Buat migration tabel `carts`
- [ ] Buat migration tabel `cart_items`
- [ ] Buat model `Cart`
- [ ] Buat model `CartItem`
- [ ] Hubungkan relasi:
  - [ ] User hasOne Cart
  - [ ] Cart hasMany CartItem
  - [ ] CartItem belongsTo Product

### 6.2 Cart Features
- [x] Buat logic cart aktif per customer
- [x] Buat tombol ubah quantity item
- [x] Buat hapus item dari keranjang
- [x] Buat perhitungan subtotal
- [x] Buat perhitungan total keranjang

### 6.3 Cart Validation
- [x] Cek stok sebelum item ditambahkan
- [x] Cek quantity tidak melebihi stok
- [x] Pastikan Cart tidak menyimpan snapshot harga (selalu baca dari master produk)

---

## 7. Order / Checkout System

### 7.1 Database
- [x] Buat migration tabel `orders`
- [x] Buat migration tabel `order_items`
- [x] Buat model `Order`
- [x] Buat model `OrderItem`
- [x] Hubungkan relasi:
  - [x] User hasMany Order
  - [x] Order hasMany OrderItem
  - [x] OrderItem belongsTo Product
- [x] Pastikan relasi yang terkait histori transaksi (Orders, OrderItems) tidak menggunakan cascade delete

### 7.2 Checkout Flow
- [x] Buat halaman checkout
- [x] Buat form data penerima
- [x] Buat form alamat pengiriman
- [x] Buat proses membuat order dari cart
- [x] Buat proses membuat order items
- [x] Buat nomor pesanan unik
- [x] Simpan subtotal
- [x] Simpan manual shipping cost Admin
- [x] Simpan grand total

### 7.3 Order Validation
- [x] Pastikan customer login sebelum checkout
- [x] Pastikan cart tidak kosong
- [x] Pastikan stok cukup
- [x] Simpan snapshot nama produk
- [x] Simpan snapshot harga produk
- [x] Kurangi stok setelah order dibuat atau saat status diproses, pilih satu dan konsisten

### 7.4 Order Status
- [x] Buat status pesanan
- [x] Buat tampilan status pesanan di customer
- [x] Buat tampilan status pesanan di admin

---

## 8. Order Tracking

### 8.1 Database
- [x] Buat migration tabel `order_tracking_logs`
- [x] Buat model `OrderTrackingLog`
- [x] Hubungkan relasi:
  - [x] Order hasMany OrderTrackingLog
  - [x] OrderTrackingLog belongsTo Order
  - [x] OrderTrackingLog belongsTo User sebagai pembuat tracking
- [x] Pastikan relasi histori tidak menggunakan cascade delete

### 8.2 Tracking Timeline
- [x] Buat tracking awal otomatis saat order dibuat
- [x] Buat fitur tambah tracking baru oleh admin
- [x] Simpan status tracking
- [x] Simpan judul tracking
- [x] Simpan deskripsi tracking
- [x] Simpan waktu tracking

### 8.3 Customer Tracking View
- [x] Buat halaman detail order dengan timeline tracking
- [x] Tampilkan urutan tracking berdasarkan waktu
- [x] Tampilkan status terbaru
- [x] Tampilkan catatan tracking

### 8.4 Tracking Rules
- [x] Setiap perubahan status menghasilkan tracking baru
- [x] Tracking tidak bisa dihapus
- [x] Customer hanya melihat tracking miliknya sendiri
- [x] Admin melihat semua tracking pesanan

---

## 9. Payments

### 9.1 Database
- [x] Buat migration tabel `payments`
- [x] Buat model `Payment`
- [x] Hubungkan relasi:
  - [x] Order hasOne Payment
  - [x] Payment belongsTo Order
- [x] Pastikan relasi histori tidak menggunakan cascade delete

### 9.2 Payment Features
- [x] Buat pilihan metode pembayaran
- [x] Buat status pembayaran
- [x] Buat upload bukti pembayaran jika manual
- [x] Buat tampilan pembayaran pada detail order
- [x] Buat validasi satu order hanya memiliki satu payment

### 9.3 Payment Flow
- [x] Buat payment record saat checkout atau setelah checkout
- [x] Buat status pembayaran:
  - [x] pending
  - [x] verified
  - [x] rejected
- [x] Sinkronkan payment dengan status order

---

## 10. Admin Dashboard

### 10.1 Dashboard Metrics
- [x] Tampilkan total produk
- [x] Tampilkan total customer
- [x] Tampilkan total pesanan
- [x] Tampilkan total penjualan
- [x] Tampilkan pesanan terbaru
- [x] Tampilkan tracking terbaru

### 10.2 Dashboard UI
- [x] Buat card statistik
- [x] Buat tabel pesanan terbaru
- [ ] Buat chart sederhana jika diperlukan

---

## 11. Customer Pages

### 11.1 Home / Catalog
- [x] Buat halaman utama customer
- [x] Tampilkan produk unggulan
- [x] Tampilkan daftar produk
- [x] Tampilkan kategori produk
- [x] Tampilkan detail produk

### 11.2 Order History
- [x] Buat halaman riwayat pesanan
- [x] Tampilkan daftar order customer
- [x] Tampilkan detail order
- [x] Tampilkan status order
- [x] Tampilkan tracking timeline

### 11.3 Profile
- [x] Buat halaman profil customer
- [x] Buat update data profil
- [x] Buat update nomor telepon
- [x] Buat update alamat

---

## 12. Admin Pages

### 12.1 Management Pages
- [ ] Buat halaman admin kategori
- [ ] Buat halaman admin produk
- [ ] Buat halaman admin pesanan
- [ ] Buat halaman admin tracking
- [ ] Buat halaman admin customer

### 12.2 Admin Actions
- [ ] Admin dapat ubah status order
- [ ] Admin dapat tambah tracking
- [ ] Admin dapat lihat detail order
- [ ] Admin dapat lihat detail customer

---

## 13. Validation & Error Handling

- [ ] Buat validasi form untuk semua input
- [ ] Buat pesan error yang jelas
- [ ] Buat notifikasi sukses
- [ ] Buat notifikasi gagal
- [ ] Pastikan redirect sesuai kondisi
- [ ] Pastikan data invalid tidak tersimpan

---

## 14. Database Seeding

- [ ] Seed role admin dan customer
- [ ] Seed user admin awal
- [ ] Seed kategori awal
- [ ] Seed produk contoh
- [ ] Seed gambar produk contoh
- [ ] Seed data order contoh jika diperlukan

---

## 15. Testing

### 15.1 Feature Testing
- [ ] Test register
- [ ] Test login
- [ ] Test role access
- [ ] Test CRUD kategori
- [ ] Test CRUD produk
- [ ] Test upload gambar
- [ ] Test cart
- [ ] Test checkout
- [ ] Test order tracking
- [ ] Test admin update status
- [ ] Test payment flow

### 15.2 Validation Testing
- [ ] Test stok tidak boleh minus
- [ ] Test quantity cart melebihi stok
- [ ] Test order tanpa login
- [ ] Test akses halaman admin oleh customer
- [ ] Test akses order milik user lain

---

## 16. UI / UX Polishing

- [ ] Buat tampilan responsif
- [ ] Buat sidebar admin
- [ ] Buat navbar customer
- [ ] Buat card produk yang rapi
- [ ] Buat badge status order
- [ ] Buat timeline tracking yang jelas
- [ ] Buat desain konsisten antara admin dan customer

---

## 17. Documentation

- [ ] Tulis README proyek
- [ ] Dokumentasikan setup environment
- [ ] Dokumentasikan struktur database
- [ ] Dokumentasikan alur role admin dan customer
- [ ] Dokumentasikan alur checkout dan tracking

---

## 18. Final Review

- [ ] Cek semua relasi database
- [ ] Cek foreign key migration
- [ ] Cek route dan middleware
- [ ] Cek konsistensi status order
- [ ] Cek tracking timeline
- [ ] Cek tampilan mobile
- [ ] Cek bug utama
- [ ] Siapkan demo proyek