# PRODUCT REQUIREMENTS DOCUMENT (PRD)

## 1. Informasi Proyek

### Nama Produk
Watch Store

### Versi
1.1 (MVP + Order Tracking)

### Platform
Web Application

### Teknologi
- Laravel 12
- PostgreSQL
- Blade Template
- Bootstrap 5
- Authentication Laravel

---

## 2. Latar Belakang

Perkembangan e-commerce membuat pelanggan lebih mudah dalam melakukan pembelian produk secara online. Namun, masih banyak toko jam tangan yang belum memiliki sistem penjualan berbasis web yang terintegrasi dengan pengelolaan pesanan dan tracking status pesanan.

Sistem Watch Store dibangun untuk memfasilitasi proses penjualan jam tangan secara online mulai dari pengelolaan produk, keranjang belanja, checkout, hingga tracking perjalanan pesanan oleh customer. Admin juga dapat mengelola produk, kategori, stok, dan status pesanan secara terpusat.

---

## 3. Tujuan Sistem

Tujuan utama sistem adalah:

- Menyediakan katalog produk jam tangan secara online.
- Memudahkan customer melakukan pembelian produk.
- Membantu admin mengelola produk, stok, dan pesanan.
- Menyediakan tracking status pesanan yang transparan kepada customer.
- Menyimpan data transaksi dan riwayat tracking secara terstruktur di database.

---

## 4. Scope Project

### Included Scope

#### Customer
- Registrasi akun
- Login dan logout
- Melihat katalog produk
- Melihat detail produk
- Menambahkan produk ke keranjang
- Mengelola keranjang
- Checkout pesanan
- Melihat riwayat pesanan
- Melihat status pesanan
- Melihat tracking timeline pesanan

#### Admin
- Login dan logout
- Dashboard Admin
- CRUD kategori
- CRUD produk
- Upload gambar produk
- Mengelola stok produk
- Mengelola data pesanan
- Mengubah status pesanan
- Menambahkan catatan tracking pesanan
- Melihat data customer

### Excluded Scope
- Payment Gateway otomatis
- Voucher dan promo
- Wishlist
- Review dan rating
- Multi gudang
- Multi cabang
- Mobile application
- Integrasi kurir otomatis
- Live chat
- Return/refund otomatis

---

## 5. Aktor Sistem

### Admin
Hak akses:
- Mengelola kategori
- Mengelola produk
- Mengelola stok
- Mengelola pesanan
- Mengubah status pesanan
- Menambahkan tracking pesanan
- Melihat data customer

### Customer
Hak akses:
- Registrasi akun
- Login
- Melihat produk
- Membeli produk
- Melihat riwayat pesanan
- Melihat tracking pesanan milik sendiri

---

## 6. Kebutuhan Fungsional

### 6.1 Modul Authentication

#### Register
Customer dapat membuat akun baru menggunakan nama, email, dan password.

#### Login
Admin dan customer dapat masuk ke sistem menggunakan email dan password.

#### Logout
Pengguna dapat keluar dari sistem.

---

### 6.2 Modul Kategori

Admin dapat:
- Menambah kategori
- Mengubah kategori
- Menghapus kategori
- Melihat daftar kategori

---

### 6.3 Modul Produk

Admin dapat:
- Menambah produk
- Mengubah produk
- Menghapus produk
- Mengelola stok produk
- Mengunggah gambar produk

Customer dapat:
- Melihat produk
- Melihat detail produk
- Mencari produk

Data produk minimal:
- Nama produk
- Kategori
- Merek
- Deskripsi
- Harga
- Stok
- Gambar
- Status aktif

---

### 6.4 Modul Keranjang

Customer dapat:
- Menambahkan produk ke keranjang
- Mengubah jumlah item
- Menghapus item
- Melihat total harga

---

### 6.5 Modul Checkout

Customer dapat:
- Mengisi data penerima
- Mengisi alamat pengiriman
- Membuat pesanan

Sistem akan:
- Menghitung subtotal transaksi
- Membuat pesanan dengan status `pending_shipping_cost`
- Membuat nomor pesanan
- Menyimpan detail transaksi
- Membuat tracking awal pesanan

---

### 6.6 Modul Pesanan

Customer dapat:
- Melihat daftar pesanan
- Melihat detail pesanan
- Melihat status pesanan

Admin dapat:
- Melihat seluruh pesanan
- Melihat detail pesanan
- Mengubah status pesanan

---

### 6.7 Modul Tracking Pesanan

Customer dapat:
- Melihat timeline perjalanan pesanan
- Melihat tanggal perubahan status
- Melihat catatan tracking dari admin

Admin dapat:
- Menambahkan catatan tracking pesanan
- Mengubah status pesanan
- Melihat histori tracking seluruh pesanan

---

### 6.8 Modul Dashboard Admin

Dashboard menampilkan:
- Total produk
- Total customer
- Total pesanan
- Total penjualan
- Pesanan terbaru
- Tracking terbaru

---

## 7. Business Rules

### User

BR-01  
Setiap email hanya dapat digunakan oleh satu akun.

BR-02  
Customer wajib login sebelum checkout.

BR-03  
Admin tidak diperbolehkan melakukan checkout sebagai customer.

---

### Produk

BR-04  
Produk harus memiliki kategori.

BR-05  
Harga produk harus lebih dari 0.

BR-06  
Stok produk tidak boleh bernilai negatif.

BR-07  
Produk dengan stok 0 tetap dapat ditampilkan, tetapi tidak dapat dibeli.

BR-07B  
Produk dan Kategori yang dihapus menggunakan mekanisme Soft Deletes untuk menjaga integritas histori transaksi. Data riwayat transaksi lama harus tetap dapat mengakses referensi produk dan kategori ini.

---

### Keranjang

BR-08  
Customer hanya dapat menambahkan produk yang tersedia.

BR-09  
Jumlah item pada keranjang tidak boleh melebihi stok yang tersedia.

BR-10  
Keranjang hanya dimiliki oleh satu customer.

BR-10B  
Cart tidak menyimpan snapshot harga, tetapi selalu membaca harga terbaru dari master produk.

---

### Pesanan

BR-11  
Satu pesanan hanya dimiliki oleh satu customer.

BR-12  
Satu pesanan dapat memiliki banyak item produk.

BR-13  
Snapshot harga produk hanya dibuat dan disimpan pada transaksi saat checkout (tabel order_items).

BR-14  
Perubahan harga produk tidak boleh mempengaruhi transaksi yang sudah checkout.

BR-15  
Nomor pesanan harus unik.

BR-16  
Pesanan memiliki status:
- Pending
- Paid
- Processing
- Shipped
- Completed
- Cancelled

BR-17  
Status pesanan hanya dapat diubah oleh admin.

BR-18  
Pesanan dengan status Completed tidak dapat diubah kembali.

BR-19  
Pesanan dengan status Cancelled tidak dapat diubah kembali.

BR-19B  
Ongkos kirim ditentukan secara manual oleh Admin setelah pesanan dibuat. Saat checkout, pesanan memiliki status "pending_shipping_cost". Setelah Admin menginput ongkos kirim, status berubah menjadi "pending_payment" (Grand total = subtotal + shipping_cost).

---

### Tracking Pesanan

BR-20  
Setiap perubahan status pesanan wajib menghasilkan data tracking baru.

BR-21  
Riwayat tracking tidak boleh dihapus.

BR-22  
Customer hanya dapat melihat tracking miliknya sendiri.

BR-23  
Admin dapat melihat seluruh tracking pesanan.

BR-24  
Setiap data tracking harus memiliki tanggal dan waktu pencatatan.

BR-25  
Urutan tracking harus mengikuti kronologi waktu.

BR-26  
Tracking awal otomatis dibuat saat pesanan berhasil dibuat.

BR-27  
Data histori transaksi (Orders, OrderItems, Payments, OrderTrackingLogs) tidak boleh menggunakan soft delete dan tidak boleh dihapus secara fisik. Relasi historis tidak boleh menggunakan cascade delete.

---

## 8. Alur Bisnis Utama

### Pembelian dan Tracking Pesanan

1. Customer melakukan login.
2. Customer melihat katalog produk.
3. Customer memilih produk.
4. Customer menambahkan produk ke keranjang.
5. Customer melakukan checkout.
6. Sistem membuat pesanan.
7. Sistem membuat tracking awal dengan status "Pesanan Dibuat".
8. Admin memverifikasi pesanan.
9. Admin memperbarui status pesanan.
10. Sistem membuat data tracking baru.
11. Customer melihat perkembangan pesanan melalui timeline tracking.
12. Pesanan selesai setelah status menjadi Completed.

---

## 9. Non Functional Requirements

### Security
- Password harus terenkripsi.
- Validasi seluruh input pengguna.
- Role Based Access Control.
- Customer hanya bisa mengakses data miliknya sendiri.

### Performance
- Waktu respon maksimal 3 detik untuk operasi normal.
- Pagination untuk data produk, pesanan, dan tracking.

### Compatibility
- Google Chrome
- Microsoft Edge
- Mozilla Firefox

### Usability
- Responsive Design
- Mobile Friendly
- Navigasi mudah digunakan
- Informasi status dan tracking mudah dipahami

---

## 10. Asumsi

- Sistem hanya berbasis web.
- Pembayaran dilakukan secara manual atau simulasi pembayaran.
- Pengiriman dikelola di luar sistem atau dicatat secara manual oleh admin.
- Satu customer dapat memiliki banyak pesanan.
- Produk yang dijual hanya jam tangan.
- Admin bertanggung jawab terhadap pengelolaan produk, pesanan, dan tracking.
- Tracking pesanan bersifat internal, bukan integrasi kurir otomatis.

---

## 11. Prioritas Fitur

### High Priority
- Login
- Register
- Kategori
- Produk
- Keranjang
- Checkout
- Pesanan
- Tracking Pesanan
- Dashboard Admin

### Medium Priority
- Search Produk
- Filter Produk
- Catatan tracking oleh admin

### Low Priority
- Laporan penjualan
- Export data
- Notifikasi otomatis

---

## 12. Risiko Proyek

- Perubahan kebutuhan setelah database dibuat.
- Kesalahan desain relasi database.
- Pengelolaan stok yang tidak konsisten.
- Validasi transaksi yang kurang lengkap.
- Tracking pesanan tidak tersusun kronologis.
- Perubahan status pesanan tanpa pencatatan tracking.

---

## 13. Success Criteria

Sistem dianggap berhasil apabila:

- Customer dapat melakukan pembelian produk.
- Customer dapat melihat status dan tracking pesanan.
- Admin dapat mengelola produk dan pesanan.
- Setiap perubahan status pesanan tercatat di tracking.
- Seluruh transaksi tersimpan di PostgreSQL.
- Sistem berjalan stabil pada Laravel 12.
- Tracking pesanan dapat ditampilkan dalam bentuk timeline yang jelas.

---

## 14. Catatan Implementasi

Fitur tracking pesanan direkomendasikan menggunakan tabel terpisah, misalnya:
- orders
- order_items
- order_tracking_logs

Dengan struktur ini, histori perubahan status tetap tersimpan rapi dan tidak bercampur dengan data utama pesanan.