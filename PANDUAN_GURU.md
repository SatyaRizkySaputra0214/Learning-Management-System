# 🎯 PANDUAN GURU - LMS Bahasa

## 📍 Akses Halaman

**URL:** http://localhost:8000/guru/dashboard
**Login:** username: `guru1` | password: `password`

---

## 🗺️ Peta Halaman Guru

```
Dashboard Guru
    ↓
Kelas Saya
    ↓
Pilih Kelas
    ↓
┌─────────────────────────────────────────────┐
│ DETAIL KELAS                                │
├─────────────────────────────────────────────┤
│                                             │
│ ┌─────────────────────────────────────┐    │
│ │ DAFTAR PERTEMUAN                    │    │
│ │                                     │    │
│ │ ┌─────────────────────────────────┐ │    │
│ │ │ [1] Pertemuan 1                 │ │    │
│ │ │     0 Materi • 0 Kuis • 0 Tugas │ │    │
│ │ │ ─────────────────────────────── │ │    │
│ │ │ AKSI CEPAT:                     │ │    │
│ │ │ [📄 Upload Materi]              │ │    │
│ │ │ [📝 Buat Kuis]                  │ │    │
│ │ │ [📋 Buat Tugas]                 │ │    │
│ │ └─────────────────────────────────┘ │    │
│ │                                     │    │
│ │ ┌─────────────────────────────────┐ │    │
│ │ │ [2] Pertemuan 2                 │ │    │
│ │ │     1 Materi • 2 Kuis • 1 Tugas │ │    │
│ │ │ ─────────────────────────────── │ │    │
│ │ │ AKSI CEPAT:                     │ │    │
│ │ │ [📄 Upload Materi]              │ │    │
│ │ │ [📝 Buat Kuis]                  │ │    │
│ │ │ [📋 Buat Tugas]                 │ │    │
│ │ │ ─────────────────────────────── │ │    │
│ │ │ 📄 Materi:                      │ │    │
│ │ │   [Video Introduction ×]        │ │    │
│ │ │ 📝 Kuis:                        │ │    │
│ │ │   [Quiz 1 ✏️] [Quiz 2 ✏️]      │ │    │
│ │ │ 📋 Tugas:                       │ │    │
│ │ │   [Tugas 1 📊]                  │ │    │
│ │ └─────────────────────────────────┘ │    │
│ └─────────────────────────────────────┘    │
│                                             │
│ ┌─────────────────────┐                    │
│ │ INFO KELAS          │                    │
│ │ Guru: John Doe      │                    │
│ │ Periode: Jan 2026   │                    │
│ │ Status: Aktif       │                    │
│ └─────────────────────┘                    │
│                                             │
│ ┌─────────────────────┐                    │
│ │ DAFTAR MURID (5)    │                    │
│ │ [AR] Ahmad Rizki    │                    │
│ │ [SN] Siti Nurhaliza │                    │
│ │ ...                 │                    │
│ └─────────────────────┘                    │
└─────────────────────────────────────────────┘
```

---

## 📋 Langkah-langkah Lengkap

### 1️⃣ Buat Pertemuan Baru

```
┌──────────────────────────────────────┐
│ 1. Klik "Tambah Pertemuan"          │
│ 2. Isi urutan (misal: 1)            │
│ 3. Isi judul (misal: Introduction)  │
│ 4. Isi deskripsi (opsional)         │
│ 5. Klik "Simpan"                     │
└──────────────────────────────────────┘
```

### 2️⃣ Upload Materi

```
┌──────────────────────────────────────┐
│ 1. Klik "📄 Upload Materi"          │
│ 2. Pilih tipe:                       │
│    • Video → isi link YouTube        │
│    • PDF → upload file PDF           │
│    • Dokumen → upload file DOC       │
│ 3. Isi judul materi                  │
│ 4. Isi deskripsi (opsional)         │
│ 5. Klik "Simpan"                     │
└──────────────────────────────────────┘
```

### 3️⃣ Buat Kuis

```
┌──────────────────────────────────────┐
│ 1. Klik "📝 Buat Kuis"              │
│ 2. Pilih skill:                      │
│    • Reading                         │
│    • Writing                         │
│    • Listening                       │
│    • Speaking                        │
│    • Grammar                         │
│ 3. Isi judul kuis                    │
│ 4. Isi durasi (menit)               │
│ 5. Klik "Simpan"                     │
│ 6. Tambah soal:                      │
│    • Tulis soal                      │
│    • Isi opsi A, B, C, D            │
│    • Pilih kunci jawaban             │
│    • Klik "Tambah Soal"              │
│    • Ulangi sampai semua soal masuk │
│ 7. Klik "Edit" untuk edit kuis      │
└──────────────────────────────────────┘
```

### 4️⃣ Buat Tugas

```
┌──────────────────────────────────────┐
│ 1. Klik "📋 Buat Tugas"             │
│ 2. Pilih skill                       │
│ 3. Isi judul tugas                   │
│ 4. Isi deskripsi lengkap            │
│ 5. Set deadline (opsional)          │
│ 6. Klik "Simpan"                     │
└──────────────────────────────────────┘
```

### 5️⃣ Nilai Tugas

```
┌──────────────────────────────────────┐
│ 1. Klik nama tugas (icon 📊)        │
│ 2. Lihat daftar pengumpulan murid   │
│ 3. Untuk setiap murid:               │
│    • Klik "Lihat File Jawaban"      │
│    • Beri nilai (0-100)             │
│    • Isi feedback (opsional)        │
│    • Klik "Simpan Nilai"            │
│ 4. Ulangi untuk semua murid         │
└──────────────────────────────────────┘
```

### 6️⃣ Generate Sertifikat

```
┌──────────────────────────────────────┐
│ 1. Pastikan semua nilai sudah masuk │
│ 2. Buka kelas                        │
│ 3. Pilih murid yang akan diberi     │
│    sertifikat                        │
│ 4. Klik "Generate Sertifikat"       │
│ 5. Input nilai per skill:            │
│    • Reading                         │
│    • Writing                         │
│    • Listening                       │
│    • Speaking                        │
│    • Grammar                         │
│ 6. Sistem hitung rata-rata otomatis │
│ 7. Klik "Generate & Simpan"         │
│ 8. Sertifikat tersimpan & bisa      │
│    didownload murid                  │
└──────────────────────────────────────┘
```

---

## 🎨 Visual Flow

```
                    ┌─────────────────┐
                    │  KELAS SAYA     │
                    └────────┬────────┘
                             │
              ┌──────────────┴──────────────┐
              │                              │
     ┌────────▼────────┐          ┌────────▼────────┐
     │ TAMBAH PERTEMUAN│          │  LIHAT PERTEMUAN│
     └────────┬────────┘          └────────┬────────┘
              │                              │
    ┌─────────┼─────────┐          ┌────────┼────────┐
    │         │         │          │        │        │
    ▼         ▼         ▼          ▼        ▼        ▼
┌────────┐ ┌────────┐ ┌────────┐ ┌──────┐ ┌──────┐ ┌──────┐
│Upload  │ │ Buat   │ │ Buat   │ │ Edit │ │ Hapus│ │Lihat │
│Materi  │ │ Kuis   │ │ Tugas  │ │      │ │      │ │Detail│
└───┬────┘ └───┬────┘ └───┬────┘ └──────┘ └──────┘ └──────┘
    │          │          │
    │          │          │
    ▼          ▼          ▼
┌────────┐ ┌────────┐ ┌────────┐
│Materi  │ │Soal    │ │Deadline│
│Siap!   │ │Siap!   │ │Tugas   │
└────────┘ └────────┘ └────────┘
```

---

## ✅ Checklist Fitur Guru

### Manajemen Kelas
- [x] Lihat daftar kelas yang diampu
- [x] Lihat detail kelas
- [x] Lihat informasi kelas (guru, periode, status)
- [x] Lihat daftar murid

### Manajemen Pertemuan
- [x] Tambah pertemuan baru
- [x] Edit pertemuan
- [x] Hapus pertemuan
- [x] Urutan pertemuan otomatis

### Manajemen Materi
- [x] Upload materi video (link)
- [x] Upload materi PDF (file)
- [x] Upload materi dokumen (file)
- [x] Lihat daftar materi
- [x] Hapus materi

### Manajemen Kuis
- [x] Buat kuis baru
- [x] Pilih label skill
- [x] Set durasi kuis
- [x] Tambah soal pilihan ganda
- [x] Edit kuis
- [x] Hapus kuis
- [x] Hapus soal
- [x] Kunci jawaban otomatis

### Manajemen Tugas
- [x] Buat tugas baru
- [x] Pilih label skill
- [x] Set deadline
- [x] Lihat pengumpulan tugas
- [x] Beri nilai (0-100)
- [x] Beri feedback
- [x] Edit tugas
- [x] Hapus tugas

### Sertifikat
- [x] Generate sertifikat
- [x] Input nilai per skill
- [x] Rata-rata otomatis
- [x] Preview sertifikat 2 layer

---

## 🔥 Tips & Trik

### 1. Upload Materi
- **Video:** Gunakan link YouTube untuk menghemat storage
- **PDF:** Maksimal 10MB per file
- **Dokumen:** Format .doc atau .docx

### 2. Buat Kuis
- Buat minimal 5 soal per kuis
- Pilih skill yang sesuai dengan materi
- Set durasi yang cukup (15-30 menit)

### 3. Buat Tugas
- Berikan deskripsi yang jelas
- Set deadline yang reasonable
- Tentukan poin maksimal (default: 100)

### 4. Menilai
- Beri feedback yang membangun
- Nilai konsisten dengan rubrik
- Update nilai secara berkala

### 5. Sertifikat
- Pastikan semua nilai sudah masuk
- Cek rata-rata sebelum generate
- Preview sebelum publish

---

## 📞 Shortcut Keyboard

| Aksi | Shortcut |
|------|----------|
| Buka dashboard | `Alt + D` |
| Toggle sidebar | `Alt + S` |
| Toggle dark mode | `Alt + M` |

---

## ⚠️ Troubleshooting

### Error: "Tombol tidak berfungsi"
**Fix:** Refresh halaman (F5) atau clear cache browser

### Error: "File tidak bisa diupload"
**Fix:** Cek ukuran file (max 10MB) dan format file

### Error: "Kuis tidak tersimpan"
**Fix:** Pastikan minimal 1 soal sudah ditambahkan

### Error: "Nilai tidak bisa disimpan"
**Fix:** Pastikan nilai antara 0-100

---

**Selamat mengajar! 🎓**
