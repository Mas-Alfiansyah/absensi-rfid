<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Absensi RFID - Laravel Project

Aplikasi sistem absensi berbasis RFID yang dikembangkan menggunakan framework Laravel. Proyek ini dirancang untuk mencatat kehadiran secara real-time dengan integrasi perangkat keras RFID.

## 🚀 Fitur Utama

-   **Monitoring Kehadiran:** Mencatat data tap kartu secara otomatis.
-   **Service Layer Architecture:** Logika bisnis dipisah ke dalam Services untuk kode yang lebih bersih.
-   **Export Data:** Mendukung ekspor laporan ke format Excel dan PDF.
-   **User Friendly Dashboard:** Tampilan data absensi yang mudah dipahami.

## 🛠️ Tech Stack

-   **Framework:** Laravel 12
-   **Database:** MySQL
-   **Dependencies:** - `maatwebsite/excel` (Export Excel)
    -   `barryvdh/laravel-dompdf` (Export PDF)

---

## ⚙️ Instalasi (Setup Awal)

Jika Anda baru saja mengkloning repositori ini, jalankan perintah berikut untuk menginstal dependensi:

```bash
composer install
cp .env.example .env
php artisan key:generate
composer require maatwebsite/excel
composer require barryvdh/laravel-dompdf
```
