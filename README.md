# 🟢 E-KAS RT - Sistem Pengelolaan Kas RT (Beta)

<p align="center">
  <img src="public/images/abikun.png" width="120" height="120" style="border-radius: 20px; box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3);" alt="Logo E-KAS RT">
</p>

<p align="center">
  <strong>E-KAS RT</strong> adalah platform pengelolaan keuangan kas Rukun Tetangga (RT) modern berbasis web yang dirancang dengan antarmuka <strong>Emerald Dark Glassmorphism</strong> yang futuristik, dinamis, dan sangat responsif. Aplikasi ini memudahkan pengurus RT (Admin & Bendahara) dalam mengelola data warga, mencatat iuran masuk, menyetujui transaksi pembayaran, mencatat pengeluaran secara terpusat, serta memberikan visualisasi data kas yang komprehensif bagi warga secara transparan.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10.x-red?style=for-the-badge&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.x-blue?style=for-the-badge&logo=tailwind-css" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/MySQL-8.0-orange?style=for-the-badge&logo=mysql" alt="MySQL">
  <img src="https://img.shields.io/badge/Beta-Development-yellow?style=for-the-badge" alt="Beta Status">
  <img src="https://img.shields.io/badge/Total_Warga-201_Orang-purple?style=for-the-badge&logo=auth0" alt="Total Warga">
</p>

---

## 📷 Tangkapan Layar (Screenshots Showcase)

Berikut adalah visualisasi antarmuka premium dari platform **E-KAS RT**:

### 1. Dashboard Utama & Analitik Kas Real-Time
Menampilkan total pemasukan, pengeluaran, saldo kas, serta grafik arus kas bulanan (Line Chart) dan perbandingan tahunan (Bar Chart) menggunakan Chart.js. Dilengkapi dengan tombol ekspor PDF & Word.
<p align="center">
  <img src="screenshots/dashboard.png" width="100%" alt="Dashboard E-KAS RT">
</p>

### 2. Database Warga Terperinci (Tampilan Desktop)
Pencatatan data identitas warga secara menyeluruh dengan kolom terstruktur rapi tanpa scroll menyamping.
<p align="center">
  <img src="screenshots/databasewarga.png" width="100%" alt="Database Warga RT">
</p>

### 3. Pengaturan Profil Mandiri
Formulir dinamis bagi warga dan admin untuk mengubah data pribadi, mengunggah foto profil, dan menyelaraskan status tempat tinggal secara langsung.
<p align="center">
  <img src="screenshots/setting-profil.png" width="100%" alt="Setting Profil">
</p>

### 4. Mading Informasi & Persetujuan Kas (Admin & Bendahara)
Panel terpusat untuk memposting pengumuman warga di mading informasi RT dan memvalidasi pembayaran iuran warga berdasarkan bukti transfer.
<p align="center">
  <img src="screenshots/mading.png" width="100%" alt="Mading & Persetujuan">
</p>

---

## ✨ Fitur-Fitur Utama

*   📈 **Dashboard Finansial Ekssekutif**: Ringkasan kas otomatis yang menyinkronkan data pemasukan dan pengeluaran secara real-time.
*   📊 **Grafik Cash Flow Interaktif**: Visualisasi arus kas dengan Chart.js yang dinamis untuk melihat tren pemasukan vs pengeluaran (Bulan & Tahun).
*   📱 **Laci Warga Interaktif (Responsive Mobile View)**: Desain khusus mobile di mana tabel database warga yang lebar secara otomatis disembunyikan dan digantikan oleh deretan kartu laci (*accordion drawers*) mewah.
    *   **Simulasi Hover**: Mengarahkan kursor ke kartu warga langsung melebarkan laci detail secara mulus.
    *   **Sentuhan Mobile (Tap)**: Mengetuk kartu warga membuka detail secara eksklusif dan otomatis menutup laci warga lainnya.
*   💬 **Widget Layanan Pelanggan WhatsApp (Beta Widget)**: Tombol WhatsApp terapung berdenyut di pojok bawah kanan yang menampilkan popover masukan/kritik/kendala fase Beta, dan langsung menghubungkan pengguna ke WhatsApp Admin dengan pesan otomatis.
*   📄 **Ekspor Laporan Cepat**: Cetak laporan rekap kas bulanan secara instan dalam format **PDF** dan **Microsoft Word**.
*   📢 **Mading Informasi RT**: Papan pengumuman warga interaktif yang dapat dikelola secara CRUD oleh admin/bendahara untuk mempublikasikan agenda RT (Lomba dan Kerja Bakti).
*   🔒 **Multi-Role Authentication**: Mendukung tiga peran pengguna dengan hak akses terproteksi: **Ketua RT (Admin)**, **Bendahara**, dan **Warga**.
*   🔔 **Sistem Validasi Pembayaran**: Warga dapat mengunggah bukti transfer, dan Admin/Bendahara memiliki wewenang untuk menyetujui (*Approve*) atau menolak (*Reject*) pembayaran tersebut.

---

## 🗺️ Blueprint & Alur Pembayaran Kas RT (POV Warga)

Bagian ini memaparkan alur lengkap bagaimana seorang **Warga** memantau status keuangannya, melakukan transfer, hingga mengonfirmasi pembayaran kas ke sistem **E-KAS RT** untuk kemudian divalidasi oleh pengurus RT.

### 👤 Sudut Pandang (POV) Warga

1. **Memantau Dompet Digital Mandiri (`/dompet`)**:
   Warga masuk ke sistem menggunakan akun mereka dan disuguhi halaman **"Dompet Saya"**. Di sini, warga dapat melihat visualisasi dinamis berupa kartu-kartu status iuran bulanan mereka di tahun berjalan. Tiap bulan diwakili oleh indikator warna yang mencerminkan status pembayaran:
   *   🔴 **Belum Bayar**: Terdapat tombol aksi untuk mengunggah bukti transfer iuran.
   *   🟡 **Menunggu**: Menandakan bukti pembayaran telah terunggah dan sedang dalam proses peninjauan oleh Admin/Bendahara.
   *   🟢 **Lunas**: Pembayaran terverifikasi dan secara otomatis menyinkronkan saldo kas RT.

2. **Prosedur Pembayaran Mandiri**:
   *   Warga melakukan transfer dana kas RT secara manual ke rekening pengurus RT yang disepakati (di luar aplikasi).
   *   Warga kembali ke aplikasi, membuka menu **"Dompet Saya"**, lalu mengeklik tombol bayar pada bulan yang tertunggak.
   *   Mengisi form konfirmasi dengan memasukkan nominal transfer dan mengunggah foto/dokumen digital **Bukti Transfer** (`bukti_transfer`).
   *   Sistem memberikan feedback instan berupa notifikasi sukses *SweetAlert2* bahwa bukti pembayaran telah terkirim dan status iuran bulan bersangkutan berubah menjadi **Menunggu**.

3. **Menerima Keputusan Pengurus**:
   *   Warga tidak perlu melakukan apa-apa lagi selain memantau halaman dompet mereka.
   *   Jika disetujui (Approved), status iuran bulan tersebut secara otomatis berubah menjadi **Lunas** (hijau emerald).
   *   Jika ditolak (Rejected) karena bukti tidak valid atau nominal tidak sesuai, status iuran akan kembali menjadi **Belum Bayar** (merah) sehingga warga dapat mengunggah ulang bukti transfer yang benar.

---

### 📷 Visualisasi Fitur & Alur Pembayaran Warga

Berikut adalah tampilan antarmuka premium dari sudut pandang warga saat melakukan pembayaran kas RT:

#### A. Halaman Dompet Saya (Warga View)
Menampilkan rangkuman total kontribusi, grafik kemajuan iuran tahunan, serta tabel riwayat transaksi kas pribadi secara terstruktur.
<p align="center">
  <img src="screenshots/dompet-warga.png" width="100%" alt="Halaman Dompet Warga">
</p>

#### B. Modal Pembayaran Kas (Metode QRIS & Bank Transfer)
Popup interaktif yang menampilkan nomor rekening tujuan transfer RT, integrasi QRIS, form pemilihan bulan kas, input nominal, dan unggah berkas bukti transfer.
<p align="center">
  <img src="screenshots/bayar-kas-modal.png" width="60%" style="border-radius: 20px; box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.2);" alt="Modal Pembayaran Kas Warga">
</p>

---

### 📊 Diagram Sequence Blueprint (Mermaid.js)

Berikut adalah diagram arsitektur interaksi sistem dari awal pembayaran oleh warga hingga persetujuan oleh Admin/Bendahara:

```mermaid
sequenceDiagram
    autonumber
    actor W as Warga (Citizen)
    participant APP as Sistem E-KAS RT (Web App)
    participant DB as Database (MySQL)
    actor A as Admin / Bendahara (Treasurer)

    Note over W: 1. Cek Tagihan & Transfer
    W->>APP: Login & Buka Menu "Dompet Saya"
    APP-->>W: Tampilan Status Iuran Bulanan (🔴 Belum Bayar)
    W->>W: Transfer Iuran secara Mandiri via Bank / E-Wallet

    Note over W: 2. Unggah Bukti Transaksi
    W->>APP: Form Pembayaran: Pilih Bulan, Isi Nominal, & Unggah Bukti Transfer
    APP->>DB: Query Simpan Transaksi (Status: 'menunggu')
    DB-->>APP: Sukses Menyimpan Data
    APP-->>W: SweetAlert "Bukti berhasil diupload! Menunggu persetujuan."
    Note over W: Status Berubah menjadi: 🟡 Menunggu

    Note over A: 3. Tinjauan & Validasi Pengurus
    A->>APP: Buka Dashboard Admin / Bendahara
    APP->>DB: Tarik Transaksi Status 'menunggu'
    DB-->>APP: Daftar Bukti Pembayaran Warga
    APP-->>A: Panel "Persetujuan Kas" (Tinjau Bukti Foto)
    
    alt Bukti Pembayaran Valid & Sesuai
        A->>APP: Klik "Setujui" (Approve)
        APP->>DB: Update Status -> 'lunas' & Tambah Saldo Kas RT
        DB-->>APP: Data Terbarui
        APP-->>A: SweetAlert "Pembayaran disetujui! Kas RT bertambah."
    else Bukti Pembayaran Tidak Valid / Salah Nominal
        A->>APP: Klik "Tolak" (Reject)
        APP->>DB: Update Status -> 'belum_bayar'
        DB-->>APP: Data Terbarui
        APP-->>A: SweetAlert "Pembayaran ditolak."
    end

    Note over W: 4. Hasil Verifikasi Real-Time
    W->>APP: Refresh Menu "Dompet Saya"
    APP->>DB: Ambil Status Iuran Terkini
    DB-->>APP: Data Status Iuran ('lunas' / 'belum_bayar')
    APP-->>W: Tampilan Status Iuran Berubah (🟢 Lunas / 🔴 Belum Bayar)
```

---

## 🛠️ Teknologi yang Digunakan

*   **Framework Utama**: [Laravel 10.x (PHP 8.x)](https://laravel.com)
*   **Desain UI & Styling**: [Tailwind CSS 3.x](https://tailwindcss.com), Custom Glassmorphic CSS
*   **Interaktivitas & Efek**: Javascript (ES6), [SweetAlert2](https://sweetalert2.github.io), [Chart.js](https://www.chartjs.org)
*   **Font & Ikon**: Google Fonts (Plus Jakarta Sans), FontAwesome v6
*   **Sistem Database**: MySQL

---

## 🔑 Akun Uji Coba Default (Seeders)

Jalankan Database Seeder untuk mendapatkan akun bawaan berikut guna melakukan pengujian fungsionalitas:

| Peran (Role) | Email Login | Password | Akses & Wewenang |
| :--- | :--- | :--- | :--- |
| **Ketua RT (Admin)** | `admin@kasrt.id` | `123123123` | CRUD Warga, CRUD Mading, Catat Pengeluaran, Laporan Kas, Laporan Cetak, Approval Pembayaran |
| **Bendahara** | `bendahara@kasrt.id` | `123123123` | CRUD Warga, CRUD Mading, Catat Pengeluaran, Laporan Kas, Laporan Cetak, Approval Pembayaran |
| **Warga** | `warga@kasrt.id` | `123123123` | Ubah Profil Mandiri, Kirim Bukti Transfer Iuran, Lihat Dompet & Riwayat Pembayaran Pribadi |

---

## 🚀 Panduan Menjalankan Aplikasi

Ikuti langkah-langkah di bawah ini untuk memasang dan menjalankan proyek **E-KAS RT** di lingkungan lokal Anda:

### Prasyarat (Prerequisites)
Pastikan Anda sudah menginstal:
*   PHP >= 8.1
*   Composer
*   Node.js & NPM
*   MySQL Server (via Laragon, XAMPP, atau MySQL native)

### Langkah 1: Kloning & Masuk ke Proyek
```bash
git clone <url-repositori-anda>
cd fabiannproject
```

### Langkah 2: Instalasi Dependensi PHP & Javascript
Instal seluruh library backend Laravel dan aset frontend:
```bash
# Instal dependensi composer (PHP)
composer install

# Instal dependensi NPM (JS/CSS)
npm install
```

### Langkah 3: Konfigurasi Environment (`.env`)
Salin file konfigurasi contoh dan buat key aplikasi:
```bash
cp .env.example .env
php artisan key:generate
```
Buka berkas `.env` yang baru dibuat di editor Anda, lalu sesuaikan koneksi database Anda (berikut adalah konfigurasi standar jika Anda menggunakan Laragon & HeidiSQL):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kas_rt
DB_USERNAME=root
DB_PASSWORD=
```

### Langkah 4: Migrasi & Seeding Database
Buat tabel database beserta akun bawaan (Ketua RT, Bendahara, dan Warga):
```bash
# Membuat skema tabel
php artisan migrate

# Mengisi data awal uji coba
php artisan db:seed --class=UserSeeder
```

### Langkah 5: Hubungkan Link Penyimpanan Media (Foto Profil)
Laravel memerlukan link simbolis agar berkas unggahan publik (seperti foto profil warga atau bukti transfer) dapat diakses dengan aman:
```bash
php artisan storage:link
```

### Langkah 6: Kompilasi Aset Frontend
Jalankan compiler Vite untuk memproses Tailwind CSS dan Javascript:
```bash
# Menjalankan Vite di mode development (Hot-reload)
npm run dev

# ATAU kompilasi final untuk mode production
npm run build
```

### Langkah 7: Jalankan Server Lokal
Jalankan server PHP artisan bawaan Laravel:
```bash
php artisan serve
```
Buka tautan [http://127.0.0.1:8000](http://127.0.0.1:8000) di browser Anda untuk masuk ke aplikasi.

---

## 📝 Catatan Tambahan (Pengembangan Beta)
Aplikasi saat ini dilengkapi dengan widget **Layanan Pelanggan WhatsApp (Beta)** di sudut bawah halaman. Nomor tujuan admin default diatur ke `0812345678`. Anda dapat mengubah nomor whatsapp admin sesungguhnya di bagian paling bawah berkas `resources/views/dashboard.blade.php` pada baris tautan `https://wa.me/62812345678`.
