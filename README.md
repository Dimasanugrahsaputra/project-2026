<h1 align="center">
📚 SISTEM INFORMASI PEMINJAMAN BUKU ONLINE
</h1>

<p align="center">
Website Perpustakaan Digital Berbasis Laravel 12, Filament 3, Livewire dan Docker
</p>

---

<p align="center">

![Laravel](https://img.shields.io/badge/Laravel-12-red)
![PHP](https://img.shields.io/badge/PHP-8.3-blue)
![Filament](https://img.shields.io/badge/Filament-v3-orange)
![Livewire](https://img.shields.io/badge/Livewire-v3-purple)
![MariaDB](https://img.shields.io/badge/MariaDB-10.11-blue)
![Docker](https://img.shields.io/badge/Docker-Container-blue)
![License](https://img.shields.io/badge/License-Academic-success)

</p>

---

# Tentang Project

Sistem Informasi Peminjaman Buku Online merupakan aplikasi perpustakaan berbasis website yang dikembangkan sebagai implementasi Capstone Project Program Studi Teknik Informatika Universitas Esa Unggul.

Aplikasi ini memungkinkan anggota melakukan pencarian buku, registrasi akun, login, pengajuan peminjaman buku secara online, menerima bukti peminjaman melalui email, serta melihat status peminjaman.

Administrator dapat mengelola seluruh data perpustakaan melalui Admin Panel Filament, mulai dari pengelolaan buku, kategori, rak buku, anggota, transaksi peminjaman, pengembalian hingga denda.

---

# Demo Website

Production

https://dmsangrhh.my.id

API Documentation

https://dmsangrhh.my.id/docs/api

GitHub Repository

https://github.com/Dimasanugrahsaputra/project-2026

---

# Fitur Sistem

## Visitor

- Melihat katalog buku
- Mencari buku
- Melihat detail buku
- Registrasi akun
- Login

---

## Anggota

- Login
- Forgot Password
- Reset Password melalui Email
- Mengajukan peminjaman buku
- Melihat status peminjaman
- Melihat riwayat transaksi
- Melihat informasi denda
- Logout

---

## Administrator

- Dashboard Admin
- CRUD Buku
- CRUD Kategori Buku
- CRUD Rak Buku
- CRUD Anggota
- CRUD User
- Persetujuan Pengajuan
- Penolakan Pengajuan
- Proses Pengambilan Buku
- Pengembalian Buku
- Manajemen Denda
- Monitoring Data Peminjaman

---

# Teknologi

| Komponen | Teknologi |
|------------|----------------|
| Backend | Laravel 12 |
| Frontend | Blade |
| Reactive UI | Livewire 3 |
| Admin Panel | Filament v3 |
| Database | MariaDB |
| Authentication | Laravel Authentication |
| Permission | Spatie Permission |
| API | Filament API Service |
| API Documentation | Scramble |
| Mail Service | Resend |
| Queue | Laravel Queue |
| Scheduler | Laravel Scheduler |
| Container | Docker Compose |
| Web Server | Nginx |
| Version Control | Git |

---

# Arsitektur

Browser

↓

Nginx

↓

Laravel 12

↓

MariaDB

↓

Storage

↓

Resend Email API

---

# Struktur Project

```
app/
bootstrap/
config/
database/
docker/
public/
resources/
routes/
storage/
tests/
```

---

# Flow Sistem

Visitor

↓

Registrasi

↓

Login

↓

Cari Buku

↓

Ajukan Peminjaman

↓

Admin Menyetujui

↓

Buku Dipinjam

↓

Email Bukti Peminjaman

↓

Pengembalian

↓

Perhitungan Denda

↓

Selesai

---

# Screenshot

## Landing Page

(Tambahkan Screenshot)

---

## Katalog Buku

(Tambahkan Screenshot)

---

## Detail Buku

(Tambahkan Screenshot)

---

## Login

(Tambahkan Screenshot)

---

## Registrasi

(Tambahkan Screenshot)

---

## Forgot Password

(Tambahkan Screenshot)

---

## Dashboard Admin

(Tambahkan Screenshot)

---

## Data Buku

(Tambahkan Screenshot)

---

## Pengajuan Peminjaman

(Tambahkan Screenshot)

---

## Pengembalian Buku

(Tambahkan Screenshot)

---

## Denda

(Tambahkan Screenshot)

---

# Instalasi

Clone Repository

```bash
git clone https://github.com/Dimasanugrahsaputra/project-2026.git
```

Masuk ke Folder

```bash
cd project-2026
```

Copy Environment

```bash
cp .env.example .env
```

Menjalankan Docker

```bash
docker compose up -d
```

Generate Key

```bash
php artisan key:generate
```

Migrasi Database

```bash
php artisan migrate --seed
```

Storage Link

```bash
php artisan storage:link
```

Jalankan Queue

```bash
php artisan queue:work
```

Jalankan Scheduler

```bash
php artisan schedule:work
```

---

# API

Login API

```
POST /api/auth/login
```

Logout

```
POST /api/auth/logout
```

Dokumentasi API

```
/docs/api
```

---

# Deployment

Server VPS Ubuntu

Docker Compose

Nginx Reverse Proxy

HTTPS (Let's Encrypt)

Domain

https://dmsangrhh.my.id

---

# Pengembang

Nama

Dimas Anugrah Saputra

NIM

20240801064

Program Studi

Teknik Informatika

Universitas Esa Unggul

---

# Capstone Project

Capstone Project

Universitas Esa Unggul

Program Studi Teknik Informatika

Tahun 2026

---

# License

Academic and Non Commercial Use Only

Copyright © 2026

Dimas Anugrah Saputra

All Rights Reserved.
