# Latihan 1 — Pemrograman Berbasis Kerangka Kerja (PBKK)

| Detail | Keterangan |
| --- | --- |
| **Nama Lengkap** | Rennard Filbert Tanjaya |
| **NRP** | 5025241122 |
| **Mata Kuliah** | Pemrograman Berbasis Kerangka Kerja |
| **Kelas** | D |

---

## 1. Aplikasi Konsol: Hello World

Program CLI dasar yang hanya menampilkan teks "Hello, World!" di terminal untuk memastikan environment .NET telah terkonfigurasi dengan benar di sistem.

### Build & Run

1. Inisialisasi proyek console:

```bash
dotnet new console -n HelloWorld
```

2. Masuk ke direktori dan jalankan:

```bash
cd HelloWorld
dotnet run
```

### Dokumentasi
<img width="839" height="214" alt="image" src="https://github.com/user-attachments/assets/976c9411-8b14-4330-a2b6-08894e0cfc37" />

---

## 2. Sistem Registrasi & Manajemen Mahasiswa (Desktop GUI)

Aplikasi desktop berbasis **C# Windows Forms** untuk mengelola data mahasiswa secara terstruktur. Menggunakan tata letak horizontal (*Top-to-Bottom*) agar area pengisian data dan visualisasi tabel tetap bersih.

### Build & Run

1. Inisialisasi proyek winforms:

```bash
dotnet new winforms -n SistemDataMahasiswa
```

2. Masuk ke folder proyek dan jalankan:

```bash
cd SistemDataMahasiswa
dotnet run
```

### Fitur Utama

- **Manajemen Data (CRUD)** — Mendukung operasi penambahan, pembaruan (edit), dan penghapusan data secara interaktif.
- **Mode Edit** — Memilih baris tabel dan menekan tombol edit akan mengunci kolom NRP dan mengalihkan fungsi tombol ke pembaruan data.
- **Validasi Data**
  - Seluruh field (NRP, Nama Lengkap, Program Studi, IPK) wajib terisi.
  - Mencegah duplikasi data dengan memeriksa keunikan NRP.
  - Membatasi nilai IPK secara ketat hanya pada rentang `0.00` hingga `4.00`.
- **Reset Input** — Mengosongkan form input dan mengembalikan mode aplikasi ke kondisi awal dengan satu klik.

### Dokumentasi

#### Tampilan Awal Form & Tabel
<img width="1107" height="741" alt="image" src="https://github.com/user-attachments/assets/5ec7903f-3678-439d-8a94-365afc08f663" />

#### Penambahan Data Berhasil
<img width="1107" height="741" alt="image" src="https://github.com/user-attachments/assets/7cefc052-31a1-4945-befd-d70d442f1e17" />

#### Mode Edit Data (NRP Terkunci)
<img width="1107" height="741" alt="image" src="https://github.com/user-attachments/assets/2af6ea46-d2d8-41f2-a511-1133b06f3e57" />

#### Pencarian Data (Tampil Pop-up)
<img width="1102" height="739" alt="image" src="https://github.com/user-attachments/assets/d91cf8eb-f582-4646-a6b9-97f2a0c9d2c1" />

#### Pencarian Data Tidak Ditemukan
<img width="1105" height="738" alt="image" src="https://github.com/user-attachments/assets/5fca2d04-6c33-4cb3-a88b-c464076341bf" />

#### Hapus Data
<img width="1104" height="740" alt="image" src="https://github.com/user-attachments/assets/9363b4df-fc48-49d4-9774-1711b42d61b0" />

#### Penanganan Validasi & Peringatan Error
- Kolom Nama, NRP, Program Studi, dan IPK harus terisi semua
<img width="1103" height="737" alt="image" src="https://github.com/user-attachments/assets/3c47b3db-e96e-4b6e-8d50-297bd592ec69" />

- NRP harus unik
<img width="1105" height="738" alt="image" src="https://github.com/user-attachments/assets/af4bf222-e965-4031-bd60-217864f7f245" />

- IPK diantara 0-4
<img width="1103" height="738" alt="image" src="https://github.com/user-attachments/assets/56625f55-b5fc-4513-ad8e-26d20f9cc3b9" />

### Struktur Project

| File | Fungsi |
| --- | --- |
| `Mahasiswa.cs` | *Data Model* yang mendefinisikan entitas objek (NRP, NamaLengkap, ProgramStudi, IPK). |
| `MahasiswaService.cs` | *Business Logic* yang mengelola koleksi data (*In-Memory List*), validasi duplikasi, dan pencarian. |
| `Form1.cs` | *User Interface* yang menangani rendering GUI, skema warna serta *event handler*. |
| `Program.cs` | *Entry point* untuk mengeksekusi dan menjalankan form utama aplikasi. |
