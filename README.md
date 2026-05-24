# LMS Bahasa - Learning Management System

Sistem Manajemen Pembelajaran untuk Kursus Bahasa Asing (English, Korean, Thai)

## 📋 Fitur Utama

### Admin (Super User)
- ✅ Verifikasi Pembayaran - Memeriksa bukti bayar dari form pendaftaran murid
- ✅ Manajemen Akun - Membuat akun Guru dan Murid secara manual (Sistem Tertutup)
- ✅ Penempatan Kelas (Enrollment) - Menentukan Guru pengampu dan Murid ke dalam kelas bahasa

### Guru (Instruktur)
- ✅ Manajemen Kelas - CRUD kelas yang diampu
- ✅ Manajemen Pertemuan - Mengatur urutan pertemuan
- ✅ Upload Materi - Video (Link/File), PDF, dan Dokumen
- ✅ Quiz Builder - Membuat kuis Pilihan Ganda dengan label kemampuan
- ✅ Manajemen Penugasan - Membuat slot tugas, koreksi manual, dan pemberian nilai
- ✅ Sertifikat & Rapor - Generate sertifikat otomatis dengan rincian nilai per elemen

### Murid (Peserta)
- ✅ Pendaftaran & Pembayaran - Form pendaftaran dan upload bukti transfer
- ✅ Akses Materi - Melihat dan mengunduh materi per pertemuan
- ✅ Pengerjaan Tugas & Kuis - Mengerjakan kuis PG dan mengumpulkan tugas
- ✅ Progress & Sertifikat - Melihat nilai dan mengunduh sertifikat

## 🚀 Instalasi

### Prasyarat
- PHP 8.2 atau lebih baru
- Composer
- Node.js & NPM
- MySQL atau SQLite

### Langkah Instalasi

1. **Clone repository**
```bash
git clone <repository-url>
cd starter-kit-main
```

2. **Install dependencies**
```bash
composer install
npm install
```

3. **Setup environment**
```bash
copy .env.example .env
php artisan key:generate
```

4. **Setup database**

   Untuk SQLite (lebih sederhana):
```bash
type null > database\database.sqlite
php artisan migrate
```

   Untuk MySQL:
```bash
# Edit .env dan sesuaikan DB_CONNECTION, DB_DATABASE, DB_USERNAME, DB_PASSWORD
php artisan migrate
```

5. **Seed database (Data Awal)**
```bash
php artisan db:seed
```

6. **Build assets**
```bash
npm run build
```

7. **Jalankan aplikasi**
```bash
php artisan serve
```

Aplikasi akan berjalan di: **http://localhost:8000**

## 👤 Akun Default (Setelah Seed)

### Admin
- **Username:** `admin`
- **Password:** `password`
- **Link:** http://localhost:8000/admin/dashboard

### Guru
- **Username:** `guru1`
- **Password:** `password`
- **Link:** http://localhost:8000/guru/dashboard

- **Username:** `guru2`
- **Password:** `password`

### Murid
- **Username:** `murid1`
- **Password:** `password`
- **Link:** http://localhost:8000/murid/dashboard

- **Username:** `murid2`
- **Password:** `password`

## 🔗 Link Akses per Aktor

### Public (Tanpa Login)
| Fitur | URL |
|-------|-----|
| Login | http://localhost:8000/login |
| Pendaftaran | http://localhost:8000/register |

### Admin
| Fitur | URL |
|-------|-----|
| Dashboard | http://localhost:8000/admin/dashboard |
| Verifikasi Pendaftaran | http://localhost:8000/admin/registrations |
| Manajemen User | http://localhost:8000/admin/users |
| Manajemen Kelas | http://localhost:8000/admin/classes |

### Guru
| Fitur | URL |
|-------|-----|
| Dashboard | http://localhost:8000/guru/dashboard |
| Kelas Saya | http://localhost:8000/guru/classes |
| Kelola Pertemuan | http://localhost:8000/guru/classes/{id} |
| Upload Materi | http://localhost:8000/guru/meetings/{id}/materials/create |
| Buat Kuis | http://localhost:8000/guru/meetings/{id}/quizzes/create |
| Buat Tugas | http://localhost:8000/guru/meetings/{id}/assignments/create |
| Nilai Tugas | http://localhost:8000/guru/assignments/{id}/submissions |
| Generate Sertifikat | http://localhost:8000/guru/classes/{id}/students/{id}/certificate/generate |

### Murid
| Fitur | URL |
|-------|-----|
| Dashboard | http://localhost:8000/murid/dashboard |
| Kelas Saya | http://localhost:8000/murid/classes/{id} |
| Lihat Pertemuan | http://localhost:8000/murid/meetings/{id} |
| Kerjakan Kuis | http://localhost:8000/murid/quizzes/{id}/take |
| Kumpul Tugas | http://localhost:8000/murid/assignments/{id}/submit |
| Sertifikat Saya | http://localhost:8000/murid/certificates |

## 📊 Struktur Database

### Tabel Utama
- `users` - Data pengguna (admin, guru, murid)
- `registrations` - Pendaftaran murid baru
- `courses` - Kursus bahasa (English, Korean, Thai)
- `classes` - Kelas pembelajaran
- `class_students` - Relasi murid ke kelas
- `skills` - Kemampuan (Reading, Writing, Listening, Speaking, Grammar)
- `meetings` - Pertemuan per kelas
- `materials` - Materi pembelajaran
- `quizzes` - Kuis
- `questions` - Soal kuis
- `assignments` - Tugas
- `quiz_scores` - Nilai kuis
- `assignment_submissions` - Pengumpulan tugas
- `certificates` - Sertifikat

## 🛠️ Teknologi yang Digunakan

- **Backend:** Laravel 12
- **Frontend:** Blade Templates + Tailwind CSS 4
- **JavaScript:** Alpine.js
- **Database:** MySQL / SQLite
- **Build Tool:** Vite

## 📝 Alur Penggunaan

### 1. Pendaftaran Murid Baru
```
Murid mengisi form → Upload bukti bayar → Status: "Menunggu Verifikasi"
```

### 2. Verifikasi oleh Admin
```
Admin cek bukti bayar → Verifikasi Berhasil → Admin buat akun → Admin masukkan ke kelas
```

### 3. Proses Belajar-Mengajar
```
Guru buat Pertemuan → Upload Materi → Buat Kuis/Tugas → Tentukan Label Skill
Murid login → Masuk Kelas → Belajar → Kerjakan Kuis → Upload Tugas
```

### 4. Penilaian
```
Guru nilai tugas manual → Nilai kuis otomatis → Tersimpan per Label Skill
```

### 5. Sertifikasi
```
Guru generate sertifikat → Sistem hitung rata-rata per skill → Cetak PDF 2 layer
```

## 🔐 Keamanan

- Password di-hash menggunakan bcrypt
- Middleware role-based access control
- CSRF protection
- File upload validation

## 📄 License

MIT License

## 👥 Developer

Dibuat dengan ❤️ untuk LMS Bahasa
