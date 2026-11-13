# Galeri Seni (PHP OOP + MySQL)

## Pasang
1. Taruh folder ini di `htdocs/` (XAMPP) atau `public_html/`.
2. Jalankan `database.sql` di phpMyAdmin.
3. Sesuaikan `config/config.php` (user, password, admin_key).
4. Buka `http://localhost/galeri-php/`.

Butuh PHP 8.0+ dan ekstensi PDO MySQL.

## Struktur
- index.php          tampilan galeri
- api.php            pintu masuk API (JSON)
- bootstrap.php      autoloader + memuat config
- config/config.php  pengaturan database & kata sandi admin
- src/Database.php           koneksi PDO + pembuatan tabel
- src/Karya.php              entitas + validasi
- src/KaryaRepository.php    CRUD ke database
- src/KaryaController.php    menangani permintaan API
- src/Response.php          respons JSON
- src/NotFoundException.php
