# 🚀 QUICK START - LMS Bahasa

## ⚡ Instalasi Cepat (5 Menit)

```bash
# 1. Install
composer install && npm install

# 2. Setup
copy .env.example .env
php artisan key:generate

# 3. Database (SQLite)
type null > database\database.sqlite
php artisan migrate --seed

# 4. Build
npm run build

# 5. Run
php artisan serve
```

**Buka:** http://localhost:8000

---

## 🔑 Login Info

### Admin
- **URL:** http://localhost:8000/login
- **Username:** `admin`
- **Password:** `password`

### Guru
- **Username:** `guru1` atau `guru2`
- **Password:** `password`

### Murid
- **Username:** `murid1` atau `murid2`
- **Password:** `password`

---

## 📋 Alur Cepat

### 1. Daftar Murid Baru
```
http://localhost:8000/register
→ Isi form
→ Upload bukti bayar
→ Tunggu verifikasi
```

### 2. Verifikasi (Admin)
```
Login sebagai admin
→ Verifikasi Pendaftaran
→ Pilih pendaftaran
→ Verifikasi (Terima)
→ Buat Akun (pilih role: murid)
→ Masukkan ke kelas
```

### 3. Kelola Kelas (Guru)
```
Login sebagai guru
→ Kelas Saya
→ Pilih kelas
→ Tambah Pertemuan
→ Upload Materi
→ Buat Kuis/Tugas
```

### 4. Belajar (Murid)
```
Login sebagai murid
→ Masuk Kelas
→ Lihat Materi
→ Kerjakan Kuis
→ Kumpul Tugas
```

---

## 🔗 Link Penting

| Fitur | URL |
|-------|-----|
| **Login** | http://localhost:8000/login |
| **Register** | http://localhost:8000/register |
| **Admin Dashboard** | http://localhost:8000/admin/dashboard |
| **Guru Dashboard** | http://localhost:8000/guru/dashboard |
| **Murid Dashboard** | http://localhost:8000/murid/dashboard |

---

## 🛠️ Commands

```bash
# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Create storage link
php artisan storage:link

# Run server
php artisan serve
```

---

## 📁 File Penting

- **Routes:** `routes/web.php`
- **Controllers:** `app/Http/Controllers/`
- **Views:** `resources/views/`
- **Models:** `app/Models/`

---

## ❓ Troubleshooting

**Error: "Class not found"**
```bash
composer dump-autoload
```

**Error: "Vite manifest not found"**
```bash
npm run build
```

**Error: "Database not found"**
```bash
type null > database\database.sqlite
php artisan migrate
```

---

## 📚 Dokumentasi Lengkap

- `README.md` - Dokumentasi utama
- `SETUP.md` - Panduan instalasi detail
- `LINKS.md` - Semua link akses
- `COMPLETED.md` - Yang sudah dibuat

---

**Happy Coding! 🎉**
