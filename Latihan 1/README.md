# Dokumentasi Tugas 1 — Pemrograman Berbasis Kerangka Kerja (PBKK)

## Informasi Praktikan

| Detail | Keterangan |
| --- | --- |
| **Nama Lengkap** | Rennard Filbert Tanjaya |
| **NRP** | 5025241122 |
| **Mata Kuliah** | Pemrograman Berbasis Kerangka Kerja |
| **Kelas** | D |

---

## 1. Aplikasi Konsol: Hello World

Program CLI dasar untuk memastikan environment .NET telah terkonfigurasi dengan benar di sistem.

### Build & Run

Inisialisasi proyek console:

```bash
dotnet new console -n ProgramHelloWorld
```

Masuk ke direktori dan jalankan:

```bash
cd ProgramHelloWorld
dotnet run
```

### Dokumentasi



---

## 2. Sistem Registrasi & Manajemen Mahasiswa (Desktop GUI)

Aplikasi desktop berbasis **C# Windows Forms** untuk mengelola data mahasiswa secara terstruktur. Menggunakan tema **Navy & Amber** dengan tata letak horizontal (*Top-to-Bottom*) agar area pengisian data dan visualisasi tabel tetap bersih serta ergonomis.

### Build & Run

Inisialisasi proyek winforms:

```bash
dotnet new winforms -n SistemAkademik
```

Masuk ke folder proyek dan jalankan:

```bash
cd SistemAkademik
dotnet run
```

### Fitur Utama

- **Manajemen Data (CRUD)** — Mendukung operasi penambahan, pembaruan (edit), dan penghapusan data secara interaktif.
- **Pencarian via Dialog Pop-up** — Menampilkan rincian pencarian mahasiswa melalui jendela *message box* tanpa memangkas tampilan tabel utama.
- **Mode Edit Dinamis** — Memilih baris tabel dan menekan tombol edit akan mengunci kolom NRP dan mengalihkan fungsi tombol ke pembaruan data.
- **Validasi Menyeluruh**
  - Seluruh field (NRP, Nama Lengkap, Program Studi, IPK) wajib terisi.
  - Mencegah duplikasi data dengan memeriksa keunikan NRP.
  - Membatasi nilai IPK secara ketat hanya pada rentang `0.00` hingga `4.00`.
- **Batal / Reset Cepat** — Mengosongkan form input dan mengembalikan mode aplikasi ke kondisi awal dengan satu klik.

### Tampilan Aplikasi

#### Tampilan Awal Form & Tabel



#### Penambahan Data Berhasil



#### Mode Edit Data (NRP Terkunci)



#### Pencarian Data (Tampil Pop-up)



#### Penanganan Validasi & Peringatan Error



### Struktur Berkas

| File | Fungsi |
| --- | --- |
| `Mahasiswa.cs` | *Data Model* yang mendefinisikan entitas objek (NRP, NamaLengkap, ProgramStudi, IPK). |
| `MahasiswaService.cs` | *Business Logic* yang mengelola koleksi data (*In-Memory List*), validasi duplikasi, dan pencarian. |
| `Form1.cs` | *User Interface* yang menangani rendering GUI, skema warna Navy & Amber, serta *event handler*. |
| `Program.cs` | *Entry point* untuk mengeksekusi dan menjalankan form utama aplikasi. |
