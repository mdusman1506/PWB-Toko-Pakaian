# Aplikasi Kasir Toko Pakaian (UAS)

Project ini adalah aplikasi Point of Sale (POS) berbasis web untuk manajemen toko pakaian, dilengkapi dengan fitur multi-role (Admin & Kasir), manajemen stok, dan laporan penjualan harian.

**Identitas Mahasiswa:**
- **Nama:** [NAMA LENGKAP KAMU]
- **NIM:** [NIM KAMU]
- **Kelas:** [KELAS KAMU]
- **Mata Kuliah:** Pemrograman Web Lanjut

---

## 🚀 Fitur Utama

### 1. Role Admin
- **Dashboard:** Melihat ringkasan omset harian, total produk, dan produk terlaris hari ini.
- **Manajemen Produk (CRUD):** Tambah, Edit, Hapus produk.
- **Validasi Stok:** Stok minimal 2 (wajib menyisakan 1 untuk display).
- **Akses Kasir:** Admin bisa berpindah ke halaman kasir untuk membantu transaksi.

### 2. Role Kasir
- **Transaksi Penjualan:** UI Kasir yang responsif dengan keranjang belanja (Cart).
- **Validasi Pembelian:** Tidak bisa membeli barang "Display Only" (stok sisa 1).
- **Diskon Otomatis:** Diskon 10% jika belanja di atas Rp 100.000 atau beli lebih dari 3 items.
- **Cetak Struk:** Fitur cetak nota belanja sederhana.
- **Riwayat Transaksi:** Melihat history transaksi pribadi.

---

## 🛠️ Teknologi yang Digunakan
- **Framework:** Laravel 9/10
- **Database:** MySQL
- **Frontend:** Bootstrap 5 (Blade Template)
- **Tools:** VS Code, XAMPP/Laragon

---

## 💻 Cara Instalasi (Untuk Dosen/Penguji)

Jika ingin menjalankan project ini di komputer lokal, silakan ikuti langkah berikut:

1. **Clone Repository**
   ```bash
   git clone [https://github.com/](https://github.com/)[USERNAME-GITHUB-KAMU]/uas-toko-pakaian.git
