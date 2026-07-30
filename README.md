# 🌐 SI Desa - Smart Village Ecosystem

<p align="center">
  <img src="public/logo.png" alt="SI Desa Logo" width="150">
</p>

<p align="center">
  <b>Sistem Informasi Desa Berbasis Web</b><br>
  Digitalisasi Pelayanan Publik Desa menggunakan Laravel
</p>

---

## 📖 Tentang Project

SI Desa (Smart Village Ecosystem) merupakan aplikasi berbasis web yang dirancang untuk mendukung digitalisasi pelayanan publik di lingkungan desa. Sistem ini menyediakan layanan administrasi secara online, pengelolaan pengaduan masyarakat, transparansi APBDes, publikasi berita desa, informasi UMKM, data kependudukan, serta fitur tracking permohonan layanan.

Project ini dikembangkan sebagai implementasi hasil **Kerja Praktik** pada **Dinas Komunikasi dan Informatika Kabupaten Tapanuli Tengah**.

---

## ✨ Fitur Utama

### 👥 Sistem Warga

- 🏠 Beranda
- 📄 Katalog Layanan
- 📝 Pengajuan Permohonan Layanan
- 📦 Tracking Status Permohonan
- 📢 Pengaduan Masyarakat
- 📰 Berita Desa
- 💰 Transparansi APBDes
- 👨‍👩‍👧 Data Kependudukan
- 🏪 Direktori UMKM

### 🔐 Sistem Admin

- Dashboard Monitoring
- Kelola Layanan
- Kelola Permohonan
- Kelola Tracking
- Kelola Pengaduan
- Kelola APBDes
- Kelola Berita
- Kelola Penduduk
- Kelola UMKM
- Statistik Dashboard

---

## 🛠️ Tech Stack

| Technology | Version |
|------------|---------|
| PHP | 8.2+ |
| Laravel | 12 |
| MySQL | 8.x |
| Tailwind CSS | Latest |
| JavaScript | ES6 |
| Chart.js | Latest |

---

## 📂 Struktur Folder

```
app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
```

---

## 🚀 Instalasi

### Clone Repository

```bash
git clone https://github.com/USERNAME/si_desa.git
```

Masuk ke folder project

```bash
cd si_desa
```

Install dependency

```bash
composer install
```

Install Node Module

```bash
npm install
```

Copy file environment

```bash
cp .env.example .env
```

Generate application key

```bash
php artisan key:generate
```

Atur konfigurasi database pada file `.env`

```env
DB_DATABASE=si_desa
DB_USERNAME=root
DB_PASSWORD=
```

Migrasi database

```bash
php artisan migrate
```

Jika menggunakan seeder

```bash
php artisan db:seed
```

Compile Asset

```bash
npm run dev
```

Jalankan server

```bash
php artisan serve
```

Buka browser

```
http://127.0.0.1:8000
```

---

## 📸 Screenshot

### Landing Page

> Tambahkan screenshot homepage

### Dashboard Admin

> Tambahkan screenshot dashboard

### Manajemen APBDes

> Tambahkan screenshot APBDes

### Tracking Layanan

> Tambahkan screenshot tracking

---

## 🧪 Pengujian

Metode pengujian yang digunakan adalah:

- Black Box Testing

Seluruh fitur utama berhasil dijalankan sesuai kebutuhan sistem.

---

## 📚 Dokumentasi Sistem

Sistem terdiri dari beberapa modul utama:

- Layanan Administrasi
- Tracking Permohonan
- Pengaduan Masyarakat
- APBDes
- Berita Desa
- Penduduk
- UMKM
- Dashboard Monitoring

---

## 👨‍💻 Author

**Nabil Abdillah Supardy**

Program Studi Sistem Informasi

Universitas Islam Negeri Imam Bonjol Padang

---

## 📄 License

Project ini dikembangkan untuk keperluan akademik (Kerja Praktik).

Copyright © 2026 Nabil Abdillah Supardy
