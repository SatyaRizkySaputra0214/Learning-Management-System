# 📚 LMS Bahasa - Link Akses dan Fitur

## 🔗 Quick Links

### URL Utama
- **Aplikasi:** http://localhost:8000
- **Login:** http://localhost:8000/login
- **Pendaftaran:** http://localhost:8000/register

---

## 👤 Akun Default

### Admin
| Field | Value |
|-------|-------|
| Username | `admin` |
| Password | `password` |
| Dashboard | http://localhost:8000/admin/dashboard |

### Guru 1
| Field | Value |
|-------|-------|
| Username | `guru1` |
| Password | `password` |
| Dashboard | http://localhost:8000/guru/dashboard |

### Guru 2
| Field | Value |
|-------|-------|
| Username | `guru2` |
| Password | `password` |
| Dashboard | http://localhost:8000/guru/dashboard |

### Murid 1
| Field | Value |
|-------|-------|
| Username | `murid1` |
| Password | `password` |
| Dashboard | http://localhost:8000/murid/dashboard |

### Murid 2
| Field | Value |
|-------|-------|
| Username | `murid2` |
| Password | `password` |
| Dashboard | http://localhost:8000/murid/dashboard |

---

## 📋 Fitur per Aktor

### 🟢 Public (Tanpa Login)

| Fitur | URL | Deskripsi |
|-------|-----|-----------|
| Login | http://localhost:8000/login | Form login untuk semua user |
| Pendaftaran | http://localhost:8000/register | Form pendaftaran murid baru |
| Sukses Daftar | http://localhost:8000/register/success | Halaman sukses pendaftaran |

---

### 🔴 Admin (Super User)

#### Dashboard & Overview
| Fitur | URL | Deskripsi |
|-------|-----|-----------|
| Dashboard | http://localhost:8000/admin/dashboard | Ringkasan sistem |

#### Verifikasi Pendaftaran
| Fitur | URL | Deskripsi |
|-------|-----|-----------|
| Daftar Pendaftaran | http://localhost:8000/admin/registrations | Lihat semua pendaftaran |
| Detail Pendaftaran | http://localhost:8000/admin/registrations/{id} | Lihat detail & bukti bayar |
| Verifikasi | (dari detail) | Terima/tolak pendaftaran |
| Buat User | http://localhost:8000/admin/registrations/{id}/create-user | Buat akun dari pendaftaran |

#### Manajemen User
| Fitur | URL | Deskripsi |
|-------|-----|-----------|
| Daftar User | http://localhost:8000/admin/users | Lihat semua user (guru, murid, admin) |

#### Manajemen Kelas
| Fitur | URL | Deskripsi |
|-------|-----|-----------|
| Daftar Kelas | http://localhost:8000/admin/classes | Lihat semua kelas |
| Tambah Kelas | http://localhost:8000/admin/classes/create | Buat kelas baru |
| Detail Kelas | http://localhost:8000/admin/classes/{id} | Lihat detail & tambah murid |
| Enroll Murid | (dari detail) | Masukkan murid ke kelas |

---

### 🟡 Guru (Instruktur)

#### Dashboard & Overview
| Fitur | URL | Deskripsi |
|-------|-----|-----------|
| Dashboard | http://localhost:8000/guru/dashboard | Ringkasan kelas yang diampu |
| Kelas Saya | http://localhost:8000/guru/classes | Daftar kelas yang diampu |

#### Manajemen Kelas
| Fitur | URL | Deskripsi |
|-------|-----|-----------|
| Detail Kelas | http://localhost:8000/guru/classes/{id} | Lihat detail kelas & pertemuan |

#### Manajemen Pertemuan
| Fitur | URL | Deskripsi |
|-------|-----|-----------|
| Tambah Pertemuan | http://localhost:8000/guru/classes/{classId}/meetings/create | Buat pertemuan baru |
| Edit Pertemuan | http://localhost:8000/guru/meetings/{id}/edit | Edit pertemuan |
| Hapus Pertemuan | (dari kelas) | Hapus pertemuan |

#### Manajemen Materi
| Fitur | URL | Deskripsi |
|-------|-----|-----------|
| Upload Materi | http://localhost:8000/guru/meetings/{meetingId}/materials/create | Upload video/PDF/dokumen |
| Hapus Materi | (dari kelas) | Hapus materi |

#### Quiz Builder
| Fitur | URL | Deskripsi |
|-------|-----|-----------|
| Buat Kuis | http://localhost:8000/guru/meetings/{meetingId}/quizzes/create | Buat kuis baru |
| Edit Kuis | http://localhost:8000/guru/quizzes/{id}/edit | Edit kuis & tambah soal |
| Tambah Soal | (dari edit kuis) | Tambah soal pilihan ganda |
| Hapus Kuis | (dari kelas) | Hapus kuis |
| Hapus Soal | (dari edit kuis) | Hapus soal |

#### Manajemen Tugas
| Fitur | URL | Deskripsi |
|-------|-----|-----------|
| Buat Tugas | http://localhost:8000/guru/meetings/{meetingId}/assignments/create | Buat tugas baru |
| Edit Tugas | http://localhost:8000/guru/assignments/{id}/edit | Edit tugas |
| Lihat Pengumpulan | http://localhost:8000/guru/assignments/{id}/submissions | Nilai tugas murid |
| Nilai Tugas | (dari submissions) | Beri nilai & feedback |
| Hapus Tugas | (dari kelas) | Hapus tugas |

#### Sertifikat
| Fitur | URL | Deskripsi |
|-------|-----|-----------|
| Generate Sertifikat | http://localhost:8000/guru/classes/{classId}/students/{studentId}/certificate/generate | Buat sertifikat untuk murid |

---

### 🟢 Murid (Peserta)

#### Dashboard & Overview
| Fitur | URL | Deskripsi |
|-------|-----|-----------|
| Dashboard | http://localhost:8000/murid/dashboard | Kelas yang diikuti |
| Kelas Saya | http://localhost:8000/murid/classes/{id} | Detail kelas & pertemuan |

#### Pembelajaran
| Fitur | URL | Deskripsi |
|-------|-----|-----------|
| Lihat Pertemuan | http://localhost:8000/murid/meetings/{id} | Materi, kuis, tugas |
| Download Materi | http://localhost:8000/murid/materials/{id}/download | Download/akses materi |

#### Kuis
| Fitur | URL | Deskripsi |
|-------|-----|-----------|
| Kerjakan Kuis | http://localhost:8000/murid/quizzes/{id}/take | Form kuis pilihan ganda |
| Hasil Kuis | http://localhost:8000/murid/quiz-scores/{id} | Lihat skor kuis |

#### Tugas
| Fitur | URL | Deskripsi |
|-------|-----|-----------|
| Kumpul Tugas | http://localhost:8000/murid/assignments/{id}/submit | Upload jawaban tugas |

#### Sertifikat
| Fitur | URL | Deskripsi |
|-------|-----|-----------|
| Sertifikat Saya | http://localhost:8000/murid/certificates | Daftar sertifikat |
| Download Sertifikat | http://localhost:8000/murid/certificates/{id}/download | Download sertifikat PDF |

---

## 🔄 Alur Kerja Lengkap

### 1. Pendaftaran → Verifikasi → Enrollment
```
Murid Daftar (http://localhost:8000/register)
    ↓
Admin Verifikasi (http://localhost:8000/admin/registrations)
    ↓
Admin Buat Akun (pilih role: murid)
    ↓
Admin Masukkan ke Kelas
    ↓
Murid Bisa Login
```

### 2. Guru Mengelola Kelas
```
Guru Login → Dashboard (http://localhost:8000/guru/dashboard)
    ↓
Pilih Kelas
    ↓
Tambah Pertemuan
    ↓
Upload Materi + Buat Kuis + Buat Tugas
```

### 3. Murid Belajar
```
Murid Login → Dashboard (http://localhost:8000/murid/dashboard)
    ↓
Masuk Kelas
    ↓
Lihat Materi → Download
    ↓
Kerjakan Kuis → Lihat Nilai
    ↓
Kumpul Tugas
```

### 4. Penilaian & Sertifikat
```
Guru Lihat Pengumpulan Tugas
    ↓
Beri Nilai & Feedback
    ↓
Generate Sertifikat untuk Murid
    ↓
Input Nilai per Skill
    ↓
Murid Download Sertifikat
```

---

## 🎯 Fitur Khusus

### Sertifikat 2 Layer
- **Layer 1 (Depan):** Nama murid, kursus, pernyataan kelulusan, tanda tangan
- **Layer 2 (Belakang):** Rincian nilai per elemen skill (Reading, Writing, Listening, Speaking, Grammar)

### Label Skill
Setiap kuis dan tugas dilabeli dengan skill:
- Reading
- Writing
- Listening
- Speaking
- Grammar

Nilai akhir adalah rata-rata dari semua elemen skill.

---

## 🛠️ Setup Pertama Kali

```bash
# 1. Install dependencies
composer install
npm install

# 2. Setup environment
copy .env.example .env
php artisan key:generate

# 3. Setup database (SQLite)
type null > database\database.sqlite
php artisan migrate

# 4. Seed data awal
php artisan db:seed

# 5. Build assets
npm run build

# 6. Run server
php artisan serve
```

---

## 📞 Support

Untuk bantuan lebih lanjut, silakan hubungi administrator sistem atau lihat dokumentasi lengkap di README.md
