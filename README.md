# Sistem Manajemen Pembelajaran (LMS) Sekolah Bahasa

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-646CFF?style=for-the-badge&logo=vite&logoColor=white)

Sistem ini adalah platform **Learning Management System (LMS)** yang dirancang khusus untuk manajemen sekolah bahasa. Aplikasi ini memfasilitasi interaksi antara admin, guru, dan murid dalam proses belajar mengajar, mulai dari pendaftaran online hingga penerbitan sertifikat.

Proyek ini dibangun menggunakan **Laravel 12**, **TailwindCSS 4**, dan **Alpine.js**, memberikan pengalaman pengguna yang modern, cepat, dan responsif.

---

## 2. Latar Belakang dan Tujuan

### Permasalahan
Banyak sekolah bahasa masih menggunakan cara manual dalam mengelola pendaftaran murid, pembagian materi, pelaksanaan kuis, dan pemantauan perkembangan siswa. Hal ini sering menyebabkan ketidakteraturan data dan sulitnya pelaporan nilai.

### Tujuan
Membangun platform digital yang terintegrasi untuk mengotomatisasi proses administrasi dan akademik di sekolah bahasa.

### Manfaat
- **Bagi Admin:** Mempermudah verifikasi pendaftaran dan manajemen pengguna/kelas.
- **Bagi Guru:** Efisiensi dalam memberikan materi, tugas, kuis, dan absensi.
- **Bagi Murid:** Kemudahan akses materi dan pemantauan progres belajar secara real-time.

---

## 3. Fitur Utama

### 🔐 Autentikasi & Multi-Role
- Sistem login dengan 3 level akses: **Admin**, **Guru**, dan **Murid**.
- Manajemen profil dan preferensi tema (Light/Dark mode).

### 🏛️ Dashboard Admin
- **Manajemen Pendaftaran:** Verifikasi calon murid baru berdasarkan tingkat bahasa.
- **Manajemen Pengguna:** Kontrol penuh atas data Guru, Murid, dan Admin.
- **Manajemen Kelas:** Pembuatan kelas dan proses *enrollment* siswa ke kelas.
- **Monitoring:** Memantau detail perkembangan siswa di setiap kelas.

### 👨‍🏫 Fitur Guru
- **Manajemen Pertemuan:** Membuat jadwal pertemuan di setiap kelas.
- **Materi & Pengumuman:** Unggah materi pembelajaran dan broadcast pengumuman.
- **Kuis & Tugas:** Pembuatan kuis interaktif dan penugasan dengan sistem pengumpulan file.
- **E-Certificate:** Menghasilkan sertifikat bagi siswa yang telah menyelesaikan kursus.
- **Rekap Nilai:** Laporan nilai lengkap yang dapat diekspor ke format Excel.
- **Absensi:** Pencatatan kehadiran siswa di setiap pertemuan.

### 🎓 Fitur Murid
- **Akses Kelas:** Melihat kelas yang diikuti dan daftar pertemuan.
- **Pengerjaan Kuis:** Mengikuti kuis online dengan batasan waktu/deadline.
- **Submit Tugas:** Mengunggah hasil tugas langsung melalui platform.
- **Unduh Materi & Sertifikat:** Akses mudah ke semua sumber daya belajar dan sertifikat digital.

---

## 4. Teknologi yang Digunakan

- **Backend:** [Laravel 12.x](https://laravel.com/) (PHP 8.2+)
- **Frontend:** [Blade Templates](https://laravel.com/docs/12.x/blade), [TailwindCSS 4](https://tailwindcss.com/), [Alpine.js](https://alpinejs.dev/)
- **Build Tool:** [Vite](https://vitejs.dev/)
- **Database:** MySQL / SQLite
- **Package Tambahan:**
  - `maatwebsite/excel` (Export Laporan)
  - `blade-ui-kit/blade-icons` (Ikonografi)
  - `owenvoke/blade-fontawesome` (FontAwesome integration)

---

## 5. Arsitektur Sistem

Aplikasi ini menggunakan pola arsitektur **MVC (Model-View-Controller)** standar Laravel:
- **Models:** Mengelola logika data dan relasi antar tabel (Users, Classes, Quizzes, dll).
- **Views:** Menggunakan Blade engine dengan komponen TailwindCSS untuk UI yang konsisten.
- **Controllers:** Menangani logika bisnis untuk masing-masing role (AdminController, GuruController, MuridController).
- **Middleware:** `RoleMiddleware` digunakan untuk memastikan keamanan akses berdasarkan role pengguna.

---

## 6. Instalasi dan Menjalankan Proyek

Pastikan Anda sudah menginstal **PHP >= 8.2**, **Composer**, dan **Node.js** di sistem Anda.

### Langkah-langkah:

1. **Clone Repository**
   ```bash
   git clone https://github.com/username/nama-repo.git
   cd nama-repo
   ```

2. **Install Dependency**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Lalu sesuaikan konfigurasi database di file `.env`.

4. **Generate App Key**
   ```bash
   php artisan key:generate
   ```

5. **Migrasi dan Seeder**
   Jalankan migrasi database beserta data awal (opsional):
   ```bash
   php artisan migrate --seed
   ```

6. **Jalankan Aplikasi**
   Gunakan perintah berikut untuk menjalankan server development dan Vite secara bersamaan:
   ```bash
   npm run dev
   ```
   Aplikasi akan berjalan di `http://localhost:8000`.

---

## 7. Penggunaan Sistem

### Login Default (Jika menggunakan Seeder)
- **Admin:** `admin@example.com` / `password`
- **Guru:** `guru@example.com` / `password`
- **Murid:** `murid@example.com` / `password`

### Alur Kerja Umum:
1. **Calon Murid** melakukan registrasi melalui halaman `/register`.
2. **Admin** memverifikasi pendaftaran dan membuatkan akun user.
3. **Admin** memasukkan murid ke dalam kelas yang sesuai.
4. **Guru** mengisi materi, kuis, dan tugas di dalam kelas tersebut.
5. **Murid** mengakses materi dan mengerjakan tugas/kuis.
6. **Guru** memberikan penilaian dan sertifikat di akhir kursus.

---

## 8. API Documentation (Placeholder)

Saat ini sistem fokus pada aplikasi web berbasis Blade. Namun, beberapa endpoint internal yang tersedia antara lain:

- `POST /api/login` – Autentikasi pengguna.
- `GET /murid/quizzes/{quiz}/deadline` – Mengecek batas waktu kuis.
- `POST /murid/notifications/{announcement}/read` – Menandai pengumuman telah dibaca.

---

## Lisensi
Proyek ini dilisensikan di bawah [MIT License](LICENSE).
