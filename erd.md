1) Entitas Inti
1. roles

Menyimpan jenis akses pengguna.

Atribut:

id (PK)
name
slug
created_at
updated_at

Contoh data:

admin
customer
2. users

Menyimpan semua pengguna sistem, baik admin maupun customer.

Atribut:

id (PK)
role_id (FK → roles.id)
name
email (unique)
password
phone nullable
address nullable
created_at
updated_at
3. categories

Menyimpan kategori jam tangan.

Atribut:

id (PK)
name
slug
description nullable
is_active
created_at
updated_at
deleted_at nullable
4. products

Menyimpan data produk jam tangan.

Atribut:

id (PK)
category_id (FK → categories.id)
name
brand
slug
description
price
stock
is_active
created_at
updated_at
deleted_at nullable
5. product_images

Menyimpan gambar produk.

Atribut:

id (PK)
product_id (FK → products.id)
image_path
is_primary
created_at
updated_at
6. carts

Menyimpan keranjang aktif milik customer.

Atribut:

id (PK)
user_id (FK → users.id, unique)
created_at
updated_at

Catatan: satu customer cukup satu cart aktif.

7. cart_items

Menyimpan item produk di dalam keranjang.

Atribut:

id (PK)
cart_id (FK → carts.id)
product_id (FK → products.id)
quantity
created_at
updated_at

Cart selalu membaca harga live dari relasi products.price. Snapshot harga tidak disimpan di keranjang.

8. orders

Menyimpan pesanan customer.

Atribut:

id (PK)
user_id (FK → users.id)
order_number (unique)
recipient_name
recipient_phone
shipping_address
subtotal
shipping_cost (Flat rate Rp20.000)
grand_total
status
notes nullable
created_at
updated_at

Status yang cocok:

pending
paid
processing
shipped
completed
cancelled
9. order_items

Menyimpan detail produk dalam pesanan.

Atribut:

id (PK)
order_id (FK → orders.id)
product_id (FK → products.id)
product_name_snapshot
product_price_snapshot
quantity
subtotal
created_at
updated_at

Snapshot wajib, supaya histori transaksi tidak rusak kalau produk diubah nanti.

10. order_tracking_logs

Menyimpan histori tracking pesanan.

Atribut:

id (PK)
order_id (FK → orders.id)
status
title
description
created_by (FK → users.id, biasanya admin)
created_at
updated_at

Ini tabel inti untuk fitur tracking timeline.

11. payments

Menyimpan data pembayaran manual atau simulasi pembayaran.

Atribut:

id (PK)
order_id (FK → orders.id, unique)
payment_method
payment_status
proof_image nullable
paid_at nullable
created_at
updated_at

Kalau kamu mau sistem lebih sederhana, tabel ini bisa digabung ke orders. Tapi secara desain, lebih rapi dipisah.

2) Relasi Antar Tabel

Relasi yang dipakai:

roles 1..* users
users 1..1 carts
carts 1..* cart_items
products 1..* cart_items
categories 1..* products
products 1..* product_images
users 1..* orders
orders 1..* order_items
products 1..* order_items
orders 1..* order_tracking_logs
users 1..* order_tracking_logs
orders 1..1 payments atau 1..0..1 kalau payment optional