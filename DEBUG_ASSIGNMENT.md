# 🐛 DEBUG: Guru Tidak Bisa Tambah Penugasan

## ✅ Yang Sudah Dicek

### 1. Routes
```
✅ GET  guru/meetings/{meeting}/assignments/create
✅ POST guru/meetings/{meeting}/assignments
```

### 2. Controller
```php
✅ Import Assignment model
✅ Method createAssignment() ada
✅ Method storeAssignment() ada
✅ Validasi benar
```

### 3. View
```
✅ guru/assignments/create.blade.php ada
✅ Form action benar
✅ Route di tombol benar
```

### 4. Database
```
✅ Tabel assignments ada
✅ Test script berhasil buat assignment
```

---

## 🔍 Kemungkinan Masalah

### 1. Error 500 saat submit form
**Penyebab:** Validasi gagal atau error server

**Solusi:**
- Cek error di console browser (F12)
- Cek Laravel log: `storage/logs/laravel.log`

### 2. Tombol tidak merespon
**Penyebab:** JavaScript error atau link rusak

**Solusi:**
- Klik kanan → "Inspect" pada tombol
- Cek apakah href berisi URL yang benar

### 3. Redirect tanpa pesan sukses
**Penyebab:** Session tidak tersimpan

**Solusi:**
- Clear cache: `php artisan cache:clear`
- Logout → Login ulang

---

## 🛠️ Langkah Debugging

### Step 1: Test Manual via Browser

1. Login sebagai guru: `guru1` / `password`
2. Buka: http://localhost:8000/guru/classes/{id}
3. Klik "📋 Buat Tugas"
4. **Apa yang terjadi?**
   - [ ] Halaman terbuka → Isi form → Submit
   - [ ] Error 404 → Route tidak ditemukan
   - [ ] Error 500 → Server error
   - [ ] Tidak ada reaksi → JavaScript error

### Step 2: Cek Browser Console

Tekan F12 → Tab "Console"

Cari error merah:
```
[Error] ...
```

### Step 3: Cek Laravel Log

```bash
tail -f storage/logs/laravel.log
```

Atau buka file `storage/logs/laravel.log` dan cari error terbaru.

### Step 4: Test dengan Data Minimal

Form sudah terisi:
- Label Skill: Reading
- Judul: Test Assignment
- Deskripsi: Test
- Deadline: (kosong)
- Poin: 100

Klik "Buat Tugas" → Apa yang terjadi?

---

## ✅ Test Script Berhasil

Script `test_assignment.php` berhasil membuat assignment:
```
✓ Tugas berhasil dibuat!
  ID: 1
  Judul: Test Assignment - Write Introduction
```

Ini membuktikan:
- ✅ Database table OK
- ✅ Model Assignment OK
- ✅ Relasi OK

**Masalah kemungkinan di VIEW atau FORM submission.**

---

## 🔧 Solusi Cepat

### Opsi 1: Clear Semua Cache
```bash
cd C:\Users\Satya\Documents\starter-kit-main
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Opsi 2: Restart Server
```bash
# Stop server (Ctrl+C)
# Start ulang
php artisan serve
```

### Opsi 3: Hard Refresh Browser
```
Windows: Ctrl + Shift + R
Mac: Cmd + Shift + R
```

---

## 📝 Form yang Benar

Pastikan form terisi seperti ini:

```
┌─────────────────────────────────────┐
│ Label Skill:  [Reading ▼]          │ ← WAJIB
│ Judul Tugas:  [Test Assignment]    │ ← WAJIB
│ Deskripsi:    [Write something...] │ ← WAJIB
│ Deadline:     [2026-03-01 23:59]   │ ← Opsional
│ Poin Max:     [100]                │ ← Opsional
│                                     │
│ [Buat Tugas] [Batal]                │
└─────────────────────────────────────┘
```

---

## 🎯 URL Test

Test akses langsung:

1. **Test Form:**
   ```
   http://localhost:8000/guru/meetings/1/assignments/create
   ```
   Harus muncul form "Buat Tugas Baru"

2. **Test Kelas:**
   ```
   http://localhost:8000/guru/classes/1
   ```
   Harus ada tombol "📋 Buat Tugas"

3. **Test Daftar Tugas:**
   ```
   http://localhost:8000/guru/assignments/1/submissions
   ```
   Harus muncul halaman penilaian

---

## 📞 Laporan Error

Jika masih error, kirimkan:

1. **Screenshot error** (F12 Console)
2. **URL yang diakses**
3. **Tombol yang diklik**
4. **Pesan error lengkap** dari `storage/logs/laravel.log`

---

## ✅ Checklist Debugging

- [ ] Login berhasil
- [ ] Bisa buka kelas
- [ ] Tombol "Buat Tugas" ada
- [ ] Klik tombol → form terbuka
- [ ] Isi form → semua field terisi
- [ ] Klik "Buat Tugas" → submit
- [ ] Redirect kembali ke kelas
- [ ] Tugas muncul di daftar

---

**Jika semua checklist ✅ tapi masih tidak bisa, kirim screenshot error!**
