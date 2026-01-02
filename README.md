# Aplikasi Kasir Toko Pakaian (UAS)

Aplikasi Point of Sale (POS) berbasis Laravel untuk manajemen stok dan transaksi toko pakaian. Dibuat untuk memenuhi tugas UAS Pemrograman Web Lanjut.

**Identitas:**
- **Nama:** Muhammad Usman
- **NIM:** 411231141

## 🚀 Fitur Unggulan
1. **Multi-Role:** Login sebagai Admin (Kelola Produk) dan Kasir (Transaksi).
2. **Validasi Stok Cerdas:** Stok minimal 2 (sisa 1 untuk display tidak bisa dijual).
3. **Diskon Otomatis:** Diskon 10% jika belanja > Rp 100.000.
4. **Laporan Harian:** Dashboard Admin menampilkan omset real-time hari ini.
5. **Cetak Struk:** Fitur print nota belanja sederhana.

## 💻 Cara Instalasi 
1. Clone repo: `git clone https://github.com/mdusman1506/PWB-Toko-Pakaian.git`
2. `composer install`
3. Copy `.env.example` ke `.env` dan setting database.
4. `php artisan key:generate`
5. `php artisan migrate:fresh --seed` (Penting untuk data dummy)
6. `php artisan serve`

## 🔐 Akun Login
- **Admin:** `admin@toko.com` / `123456`
- **Kasir:** `kasir@toko.com` / `123456`
