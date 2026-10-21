# Booking Kampus

## 1. Deskripsi dan Ruang Lingkup Fitur

### Deskripsi

Booking Kampus adalah aplikasi desktop Windows dengan Rich UI. Aplikasi ini dibangun dengan WPF, C#, dan XAML di atas .NET 8, memakai database SQL Server lewat ADO.NET, dan menerapkan arsitektur MVVM. Aplikasi dipakai untuk mengajukan pemakaian ruangan kampus beserta fasilitasnya, memeriksa jadwal, dan memproses persetujuan oleh administrator. Penggunanya ada dua peran yaitu Mahasiswa (pemohon) dan Administrator.

### Ruang Lingkup

- **Autentikasi dan hak akses:** login/logout dengan username dan kata sandi (di-hash dengan BCrypt), pemeriksaan akun aktif, dan pembatasan akses berdasarkan peran.
- **Dashboard:** statistik booking menunggu, ruangan aktif, fasilitas aktif, dan booking disetujui bulan ini, ditambah daftar booking disetujui hari ini.
- **Data master:** pencarian dan pengelolaan ruangan (kode, lokasi, kapasitas, status, fasilitas terkait) serta fasilitas (nama, deskripsi, status).
- **Booking:** pengajuan dengan tanggal, jam mulai dan selesai, keperluan, dan fasilitas opsional. Ada juga tampilan jadwal ruangan per tanggal, daftar "Booking Saya" beserta catatan administrator, dan pembatalan booking.
- **Pencegahan bentrok:** pengajuan ditolak jika waktunya beririsan dengan booking berstatus Menunggu atau Disetujui di ruangan dan tanggal yang sama.
- **Persetujuan (admin):** antrean booking menunggu, lalu setujui atau tolak. Penolakan wajib disertai alasan minimal 3 karakter.
- **Validasi dan penanganan error:** tanggal tidak boleh lampau, jam operasional 07.00–21.00, keperluan 5–200 karakter, serta state loading, empty state, dan pesan error tanpa crash.
- **Di luar rilis awal:** pengelolaan akun oleh admin (Should) dan notifikasi status booking (Could).

## 2. Latar Belakang dan Manfaat

### Latar Belakang

Selama ini permintaan ruangan dilakukan lewat komunikasi manual sehingga sulit dilacak dan mudah terlewat. Pemohon juga tidak punya informasi jadwal sebelum memilih waktu, dan beberapa orang bisa meminta ruangan dan waktu yang sama sehingga terjadi bentrok. Administrator tidak punya antrean yang rapi beserta rincian kebutuhan dan fasilitas. Data kapasitas, lokasi, status, dan fasilitas ruangan pun belum dikelola secara konsisten.

### Manfaat

- **Bagi mahasiswa:** pengajuan lebih mudah, jadwal bisa dilihat sebelum memilih slot, dan status serta catatan keputusan bisa dipantau langsung.
- **Bagi administrator:** semua pengajuan terkumpul di satu antrean dengan rincian lengkap. Keputusan lebih cepat dan terdokumentasi, dan data ruangan serta fasilitas terkelola konsisten.
- **Bagi kampus:** pemakaian ruangan lebih tertib karena bentrok dicegah otomatis, data booking tersimpan terpusat, dan integritas data terjaga lewat constraint database dan otorisasi berlapis.
