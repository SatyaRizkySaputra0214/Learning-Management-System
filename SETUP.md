# SETUP GUIDE - LMS Bahasa

## Langkah-langkah Setup

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Setup Environment
```bash
copy .env.example .env
php artisan key:generate
```

### 3. Setup Database

**Opsi A: SQLite (Paling Mudah)**
```bash
# Buat file database SQLite
type null > database\database.sqlite

# Jalankan migrasi
php artisan migrate
```

**Opsi B: MySQL**
```bash
# Edit file .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lms_bahasa
DB_USERNAME=root
DB_PASSWORD=your_password

# Buat database di MySQL
# Kemudian jalankan migrasi
php artisan migrate
```

### 4. Seed Database (Data Awal)
```bash
php artisan db:seed
```

Ini akan membuat:
- 3 Kursus (English, Korean, Thai)
- 5 Skills (Reading, Writing, Listening, Speaking, Grammar)
- 1 Admin (username: admin, password: password)
- 2 Guru (username: guru1, guru2, password: password)
- 2 Murid (username: murid1, murid2, password: password)

### 5. Build Assets
```bash
npm run build
```

### 6. Jalankan Aplikasi
```bash
php artisan serve
```

Aplikasi berjalan di: **http://localhost:8000**

## Link Akses per Aktor

### Public
- **Login:** http://localhost:8000/login
- **Pendaftaran:** http://localhost:8000/register

### Admin
- **Dashboard:** http://localhost:8000/admin/dashboard
- **Verifikasi Pendaftaran:** http://localhost:8000/admin/registrations
- **Manajemen User:** http://localhost:8000/admin/users
- **Manajemen Kelas:** http://localhost:8000/admin/classes

**Login:** username: `admin` | password: `password`

### Guru
- **Dashboard:** http://localhost:8000/guru/dashboard
- **Kelas Saya:** http://localhost:8000/guru/classes

**Login:** username: `guru1` | password: `password`

### Murid
- **Dashboard:** http://localhost:8000/murid/dashboard
- **Sertifikat:** http://localhost:8000/murid/certificates

**Login:** username: `murid1` | password: `password`

## Alur Penggunaan

### 1. Pendaftaran Murid Baru
1. Buka http://localhost:8000/register
2. Isi formulir (nama, email, pilih kursus, upload bukti bayar)
3. Status pendaftaran: "Pending"

### 2. Verifikasi oleh Admin
1. Login sebagai admin
2. Buka menu "Verifikasi Pendaftaran"
3. Lihat detail dan bukti bayar
4. Verifikasi pendaftaran (Terima/Tolak)
5. Buat akun user (pilih role: murid/guru/admin)
6. Untuk murid: pilih kelas untuk dimasukkan

### 3. Guru Mengelola Kelas
1. Login sebagai guru
2. Buka "Kelas Saya"
3. Tambah pertemuan
4. Upload materi (video, PDF, dokumen)
5. Buat kuis dengan soal pilihan ganda
6. Buat tugas untuk murid

### 4. Murid Belajar
1. Login sebagai murid
2. Buka kelas
3. Lihat materi per pertemuan
4. Kerjakan kuis
5. Kumpul tugas

### 5. Guru Menilai
1. Buka tugas yang sudah dibuat
2. Lihat pengumpulan murid
3. Beri nilai dan feedback

### 6. Generate Sertifikat
1. Guru membuka kelas
2. Pilih murid
3. Generate sertifikat
4. Input nilai per skill (Reading, Writing, Listening, Speaking, Grammar)
5. Sistem generate sertifikat 2 layer

## Troubleshooting

### Error: "Class not found"
```bash
composer dump-autoload
```

### Error: "Key too long"
Di file `.env`, pastikan menggunakan SQLite atau set:
```
DB_CONNECTION=sqlite
```

### Error: "Vite manifest not found"
```bash
npm run build
```

### Error: "Permission denied" untuk storage
```bash
php artisan storage:link
```

## Tips Tambahan

### Membuat Kelas Baru (Admin)
1. Login sebagai admin
2. Buka "Manajemen Kelas" → "Tambah Kelas Baru"
3. Pilih kursus, guru pengampu, isi nama kelas dan periode

### Menambahkan Murid ke Kelas (Admin)
1. Saat membuat user dari registrasi yang sudah diverifikasi
2. Pilih role "murid"
3. Pilih kelas yang ingin dimasukkan

### Upload Materi (Guru)
- Video: gunakan link (YouTube, Google Drive, dll)
- PDF/Doc: upload file langsung (max 10MB)

### Membuat Kuis (Guru)
1. Pilih pertemuan
2. Buat kuis baru
3. Tambahkan soal satu per satu
4. Tentukan kunci jawaban dan poin

## File Penting

- **Routes:** `routes/web.php`
- **Controllers:** `app/Http/Controllers/`
- **Models:** `app/Models/`
- **Views:** `resources/views/`
- **Migrations:** `database/migrations/`
- **Seeders:** `database/seeders/`

## Kontak Support

Untuk pertanyaan lebih lanjut, silakan hubungi administrator sistem.
