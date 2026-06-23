# Website Sistem Jam (Watch Store System)

Website Sistem Jam adalah sebuah aplikasi web e-commerce yang dibangun menggunakan framework **Laravel**. Aplikasi ini memungkinkan pengguna untuk melihat katalog produk jam tangan, menambahkan ke keranjang belanja (cart), dan melakukan pemesanan (checkout). Terdapat juga fitur Admin untuk mengelola produk, kategori, dan pesanan.

## Persyaratan Sistem

Pastikan sistem Anda memenuhi persyaratan berikut sebelum melakukan instalasi:

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL / MariaDB

## Cara Clone dan Instalasi

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek ini di komputer lokal Anda:

### 1. Clone Repositori

Buka terminal atau command prompt, lalu jalankan perintah berikut untuk melakukan clone:

```bash
git clone https://github.com/MIKELIZER/website-sistem-jam.git
cd website-sistem-jam
```

### 2. Install Dependensi PHP (Composer)

Jalankan perintah berikut untuk menginstal semua library PHP yang dibutuhkan:

```bash
composer install
```

### 3. Install Dependensi JavaScript (NPM)

Jalankan perintah berikut untuk menginstal dan melakukan kompilasi aset frontend:

```bash
npm install
npm run build
```
*(Gunakan `npm run dev` jika Anda ingin menjalankan Vite dev server saat pengembangan).*

### 4. Konfigurasi Environment File (.env)

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```
*(Jika Anda menggunakan Windows Command Prompt, gunakan `copy .env.example .env`)*

Buka file `.env` di text editor Anda dan sesuaikan konfigurasi database. Contoh:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_jam
DB_USERNAME=root
DB_PASSWORD=
```
*Pastikan Anda sudah membuat database kosong dengan nama yang sesuai di MySQL (misal: `sistem_jam`).*

### 5. Generate Application Key

Jalankan perintah ini untuk membuat application key yang unik:

```bash
php artisan key:generate
```

### 6. Jalankan Migrasi dan Seeder Database

Perintah ini akan membuat struktur tabel di database Anda dan mengisinya dengan data dummy (opsional, jika seeder tersedia):

```bash
php artisan migrate:fresh --seed
```

### 7. Link Storage (Untuk Gambar/File)

Agar gambar produk yang di-upload dapat diakses melalui browser, jalankan:

```bash
php artisan storage:link
```

### 8. Jalankan Local Development Server

Terakhir, jalankan server bawaan Laravel:

```bash
php artisan serve
```

Aplikasi sekarang dapat diakses melalui browser di alamat: `http://localhost:8000`

---
**Catatan Tambahan**:
- Anda mungkin perlu login menggunakan akun yang dibuat oleh seeder atau melakukan pendaftaran (Register) terlebih dahulu.
