Ringkasan Aplikasi LMS Kursus Bahasa Asing

1. Fitur Utama Berdasarkan Aktor

Admin (Super User)

Verifikasi Pembayaran: Memeriksa bukti bayar dari form pendaftaran murid.

Manajemen Akun: Membuat akun Guru dan Murid secara manual (Sistem Tertutup).

Penempatan Kelas (Enrollment): Menentukan Guru pengampu dan Murid ke dalam kelas bahasa yang spesifik (English, Korean, atau Thai).

Guru (Instruktur)

Manajemen Kelas: Melakukan CRUD (Create, Read, Update, Delete) pada kelas yang diampu.

Manajemen Pertemuan: Mengatur urutan pertemuan (Pertemuan 1, 2, dst).

Upload Materi: Mengunggah materi belajar dalam format Video (Link/File), PDF, dan Dokumen.

Quiz Builder: Membuat kuis Pilihan Ganda (PG) dengan label kemampuan tertentu.

Manajemen Penugasan: Membuat slot tugas (upload foto/dokumen), melakukan koreksi manual, dan memberikan nilai langsung.

Sertifikat & Rapor: Meng-generate sertifikat otomatis 2 layer (Depan: Kelulusan, Belakang: Rincian Nilai per Elemen).

Murid (Peserta)

Pendaftaran & Pembayaran: Mengisi formulir data diri dan mengunggah bukti transfer.

Akses Materi: Melihat dan mengunduh materi per pertemuan.

Pengerjaan Tugas & Kuis: Mengerjakan kuis PG dan mengumpulkan tugas sesuai instruksi guru.

Progress & Sertifikat: Melihat nilai tugas dan mengunduh sertifikat jika sudah diterbitkan oleh guru.

2. Alur Aplikasi (Workflow)

Tahap Pendaftaran: Murid mengisi form -> Upload bukti bayar -> Status: "Menunggu Verifikasi".

Tahap Verifikasi: Admin cek bukti bayar -> Verifikasi Berhasil -> Admin membuatkan akun login untuk Murid dan Guru -> Admin memasukkan mereka ke kelas terkait.

Tahap Belajar-Mengajar:

Guru membuat Pertemuan -> Upload Materi -> Buat Kuis/Tugas -> Menentukan Label Skill (Contoh: Listening untuk Kuis A, Writing untuk Tugas B).

Murid login -> Masuk ke Kelas -> Belajar Materi -> Kerjakan Kuis -> Upload Tugas.

Tahap Penilaian: Guru menilai tugas murid secara manual. Nilai kuis (PG) biasanya otomatis oleh sistem. Semua nilai tersimpan berdasarkan Label Skill.

Tahap Sertifikasi: Setelah semua pertemuan selesai, Guru menekan tombol "Generate Sertifikat". Sistem menghitung rata-rata nilai per label skill dan mencetaknya ke dalam file PDF 2 layer.

3. Skema Database (MySQL)

A. Tabel Pengguna & Akses

users: (id, username, password, role [admin/guru/murid], nama_lengkap, email, created_at)

registrations: (id, nama, email, kursus_pilihan [eng/kor/th], bukti_bayar_url, status [pending/verified], created_at)

B. Tabel Akademik & Kelas

courses: (id, nama_bahasa [English/Korean/Thai])

classes: (id, id_course, id_guru, nama_kelas, periode, status [aktif/selesai])

class_students: (id, id_class, id_student) -- Relasi Murid ke Kelas

skills: (id, nama_skill [Reading, Writing, Listening, Speaking, Grammar])

C. Tabel Konten & Aktivitas

meetings: (id, id_class, urutan_pertemuan, judul_pertemuan)

materials: (id, id_meeting, judul, tipe [video/pdf/doc], file_url)

quizzes: (id, id_meeting, id_skill, judul_kuis, durasi)

questions: (id, id_quiz, soal, opsi_a, opsi_b, opsi_c, opsi_d, kunci_jawaban)

assignments: (id, id_meeting, id_skill, judul_tugas, deskripsi, deadline)

D. Tabel Nilai & Sertifikasi

quiz_scores: (id, id_quiz, id_student, skor, created_at)

assignment_submissions: (id, id_assignment, id_student, file_url, nilai_guru, feedback, submitted_at)

certificates: (id, id_student, id_class, nomor_sertifikat, file_pdf_url, tgl_terbit)

4. Struktur Sertifikat (2 Layer)

Layer

Konten

Halaman 1 (Depan)

Nama Murid, Nama Kursus, Pernyataan Kelulusan, Tanda Tangan Pengelola, Tanggal.

Halaman 2 (Belakang)

Tabel Nilai: Element (Reading, Writing, Listening, Speaking), Nilai Angka, Predikat (A/B/C), Rata-rata Total.