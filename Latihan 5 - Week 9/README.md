# PBKK Pertemuan 9 — Framework CodeIgniter 4 (Latihan 1 & 2)

| Identitas | Keterangan |
| --- | --- |
| **Nama** | Rennard Filbert Tanjaya |
| **NRP** | 5025241122 |
| **Mata Kuliah** | Pemrograman Berbasis Kerangka Kerja (PBKK) |
| **Kelas** | D |
| **Framework** | CodeIgniter 4.7.6 (PHP 8.2+ & MySQL) |

---

## Ringkasan Proyek

Repository ini berisi implementasi tiga aplikasi web berbasis **CodeIgniter 4** dengan pola arsitektur **Model–View–Controller (MVC)** untuk menyelesaikan seluruh rangkaian **Latihan 1** dan **Latihan 2**. Setiap aplikasi berdiri secara independen dengan folder, database MySQL, `.env`, cookie session, port lokal, serta identitas desain visual yang berbeda agar mudah diuji secara bersamaan tanpa saling bentrok.

| Latihan | Nama Aplikasi | Domain | Folder | URL Lokal | Database MySQL |
| --- | --- | --- | --- | --- | --- |
| **Latihan 1** | **ShuttleHub** | Booking Lapangan Badminton | `shuttle-hub` | `http://localhost:8080` | `shuttlehub_db` |
| **Latihan 2.1** | **SIAKAD** | Sistem Informasi Akademik | `siakad` | `http://localhost:8081` | `siakad_db` |
| **Latihan 2.2** | **HoopKicks** | Toko Sepatu Basket | `hoop-kicks` | `http://localhost:8082` | `hoopkicks_db` |

---

## Daftar Isi

1. [Sekilas CodeIgniter 4 dan Pola MVC](#1-sekilas-codeigniter-4-dan-pola-mvc)
2. [Lingkungan Pengembangan](#2-lingkungan-pengembangan)
3. [Detail Aplikasi dan Kode Penting](#3-detail-aplikasi-dan-kode-penting)
   - [3.1 Latihan 1 — ShuttleHub](#31-latihan-1--shuttlehub)
   - [3.2 Latihan 2.1 — SIAKAD](#32-latihan-21--siakad)
   - [3.3 Latihan 2.2 — HoopKicks](#33-latihan-22--hoopkicks)
4. [Model Data dan Diagram ERD](#4-model-data-dan-diagram-erd)
5. [Langkah Instalasi dan Konfigurasi](#5-langkah-instalasi-dan-konfigurasi)
6. [Menjalankan Aplikasi dan Akun Demo](#6-menjalankan-aplikasi-dan-akun-demo)
7. [Dokumentasi Tampilan (Screenshot)](#7-dokumentasi-tampilan-screenshot)
8. [Kendala Teknis dan Penyelesaian](#8-kendala-teknis-dan-penyelesaian)
9. [Struktur Folder Repository](#9-struktur-folder-repository)
10. [Referensi](#10-referensi)

---

## 1. Sekilas CodeIgniter 4 dan Pola MVC

**CodeIgniter 4 (CI4)** adalah framework PHP ringan yang menerapkan pola **Model–View–Controller (MVC)** secara terstruktur dengan dukungan Composer, namespace PSR-4, *HTTP Filters*, *Query Builder*, *Database Migration & Seeder*, serta CLI `php spark`.

| Lapisan | Lokasi di CI4 | Tanggung Jawab Utama |
| --- | --- | --- |
| **Routes** | `app/Config/Routes.php` | Memetakan URL dan metode HTTP (`GET`/`POST`) ke Controller serta menempelkan Filter akses |
| **Filters** | `app/Filters/` | Middleware autentikasi (`AuthFilter`) dan pembatasan peran (`AdminFilter`, `RoleFilter`) di level server |
| **Controller** | `app/Controllers/` | Menerima request, memvalidasi input, menjalankan aturan bisnis, lalu mengembalikan View atau redirect |
| **Model** | `app/Models/` | Mengelola interaksi tabel MySQL, `$allowedFields`, relasi `JOIN`, dan perhitungan data |
| **View** | `app/Views/` | Merender HTML memakai *View Layouts* (`extend`, `section`, `renderSection`) tanpa query SQL |

### Penyesuaian dari Materi CodeIgniter 3 ke CodeIgniter 4

Sebagian panduan dasar kelas ditulis dengan sintaks CI3. Pada implementasi ini dilakukan penyesuaian ke standar CI4:
* Pemanggilan `$this->load->model()` dan `$this->load->view()` diganti dengan *namespace instantiation* (`new CourtModel()`) dan fungsi helper `view()`.
* Struktur direktori menggunakan `app/` dan `public/index.php` sebagai *document root*, bukan `application/`.
* Perlindungan rute berbasis login dan role ditangani terpusat melalui grup rute dan **HTTP Filters** (`app/Config/Filters.php`).
* Skema tabel dan data awal dibuat menggunakan **Migration** dan **DatabaseSeeder** sehingga mudah direproduksi ulang di mesin lain.

---

## 2. Lingkungan Pengembangan

| Komponen | Spesifikasi / Versi |
| --- | --- |
| **Sistem Operasi** | Windows 11 |
| **Server Lokal & Database** | XAMPP (Apache & MySQL / phpMyAdmin, port `3306`, driver `MySQLi`) |
| **PHP** | PHP 8.2+ (ekstensi `intl`, `mbstring`, `mysqli`, `fileinfo` aktif) |
| **Framework** | CodeIgniter `4.7.6` (`codeigniter4/appstarter`) |
| **Package Manager** | Composer |
| **Code Editor** | Visual Studio Code + ekstensi PHP Intelephense |
| **Frontend & UI** | Bootstrap 5.3.3, Bootstrap Icons 1.11.3, StartBootstrap SB Admin 7.0.7, Google Fonts, serta stylesheet kustom (`shuttlehub.css`, `siakad.css`, `hoopkicks.css`) |

---

## 3. Detail Aplikasi dan Kode Penting

### 3.1 Latihan 1 — ShuttleHub

**ShuttleHub** adalah aplikasi pemesanan lapangan badminton berbasis web dengan dua peran pengguna (**Admin** dan **Pelanggan**). Tampilan publik dan panel **SB Admin** dipoles menggunakan tema *Modern Badminton Arena* (palet *Deep Court Green* `#0A221F`, *BWF Emerald* `#0F766E`, aksen *Shuttle Lime* `#C6F135`, font *Outfit* + *JetBrains Mono*, serta logo *shuttlecock* SVG kustom).

#### Matriks Hak Akses & Fitur

| Fitur | Pengunjung | Pelanggan | Admin |
| --- | :---: | :---: | :---: |
| Katalog lapangan & filter tipe lantai (*Vinyl BWF*, *Parket Kayu*, dll.) | Ya | Ya | Ya |
| Registrasi & Login | Ya | Ya | Ya |
| Form booking, kalkulasi harga otomatis, & cek bentrok jadwal | Tidak | Ya | Ya |
| Upload bukti transfer (saat booking atau menyusul) & batal booking `pending` | Tidak | Ya | Ya |
| Panel SB Admin: Dashboard statistik & estimasi pendapatan | Tidak | Tidak | Ya |
| CRUD Lapangan + upload foto lapangan | Tidak | Tidak | Ya |
| Verifikasi bukti transfer & update status booking (`confirmed`/`completed`/`cancelled`) | Tidak | Tidak | Ya |

#### Potongan Kode Penting

**1. Pengelompokan Route dan Filter (`shuttle-hub/app/Config/Routes.php`)**

Rute pelanggan dilindungi filter `auth`, sedangkan seluruh panel administrasi dilindungi `admin` agar pengguna non-admin yang mengetik URL `/admin/...` langsung ditolak di server.

```php
// Area Pelanggan (dilindungi AuthFilter)
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('booking/(:num)', 'BookingController::create/$1');
    $routes->post('booking/store', 'BookingController::store');
    $routes->get('my-bookings', 'BookingController::myBookings');
    $routes->post('my-bookings/upload/(:num)', 'BookingController::uploadPayment/$1');
    $routes->post('my-bookings/cancel/(:num)', 'BookingController::cancel/$1');
});

// Area Admin (dilindungi AdminFilter)
$routes->group('admin', ['filter' => 'admin'], static function ($routes) {
    $routes->get('dashboard', 'Admin\DashboardController::index');
    $routes->get('courts', 'Admin\CourtController::index');
    $routes->post('courts/store', 'Admin\CourtController::store');
    $routes->post('courts/update/(:num)', 'Admin\CourtController::update/$1');
    $routes->post('courts/delete/(:num)', 'Admin\CourtController::delete/$1');
    $routes->get('bookings', 'Admin\BookingController::index');
    $routes->post('bookings/status/(:num)', 'Admin\BookingController::updateStatus/$1');
});
```

**2. Validasi Jam Operasional, Cek Bentrok Jadwal, dan Upload Bukti Bayar (`shuttle-hub/app/Controllers/BookingController.php`)**

Sistem mencegah pemesanan di luar jam operasional (`07:00–22:00`), menolak bentrok jadwal pada lapangan yang sama, dan menyimpan gambar bukti transfer menggunakan nama acak (`getRandomName()`).

```php
if ($endHour > 22) {
    return redirect()->back()->withInput()
        ->with('error', 'Jam operasional GOR sampai 22:00. Kurangi durasi atau pilih jam mulai lebih awal.');
}

// Cek bentrok jadwal di database
if ($this->bookingModel->isSlotBooked($courtId, $bookingDate, $startTime, $endTime)) {
    return redirect()->back()->withInput()
        ->with('error', 'Jadwal pada jam tersebut sudah dibooking. Silakan pilih jam atau lapangan lain.');
}

// Proses upload bukti bayar (validasi max 2MB & tipe image)
$proofName = null;
if ($proofFile && $proofFile->isValid() && ! $proofFile->hasMoved()) {
    $uploadDir = FCPATH . 'uploads/payments';
    if (! is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $proofName = $proofFile->getRandomName();
    $proofFile->move($uploadDir, $proofName);
}
```

---

### 3.2 Latihan 2.1 — SIAKAD

**SIAKAD** (Sistem Informasi Akademik Terpadu) mendukung tiga peran dalam satu portal (**Admin**, **Dosen**, dan **Mahasiswa**) dengan desain *Modern University Portal* (sidebar *Deep Oxford Navy* `#0B192C`, topbar putih modern, aksen *Royal Indigo* `#1D4ED8` & *Academic Gold* `#F59E0B`, serta halaman login *split-screen*).

#### Matriks Hak Akses & Fitur

| Fitur | Admin | Dosen | Mahasiswa |
| --- | :---: | :---: | :---: |
| Dashboard statistik & ringkasan akademik | Ya | Ya | Ya |
| CRUD Program Studi, Mata Kuliah, dan Kelas (termasuk kuota) | Ya | Tidak | Tidak |
| CRUD Dosen & Mahasiswa (otomatis membuat akun login + atur Dosen Wali) | Ya | Tidak | Tidak |
| Melihat kelas diampu & input nilai mahasiswa (konversi huruf & bobot otomatis) | Tidak | Ya | Tidak |
| Melihat daftar mahasiswa perwalian beserta SKS aktif & IPK | Tidak | Ya | Tidak |
| Melihat profil, isi/drop FRS (validasi batas SKS, kuota, & anti-duplikat) | Tidak | Tidak | Ya |
| Melihat Nilai/IPS per semester, IPK kumulatif, serta Cetak FRS & Transkrip | Tidak | Tidak | Ya |

#### Potongan Kode Penting

**1. Satu `RoleFilter` Dinamis untuk 3 Peran (`siakad/app/Filters/RoleFilter.php`)**

Filter membaca argumen role dari definisi rute (`role:admin`, `role:dosen`, `role:mahasiswa`) dan mengembalikan pengguna ke dashboard miliknya sendiri apabila mencoba mengakses area peran lain.

```php
$userRole = session()->get('role');
if (! empty($arguments) && ! in_array($userRole, $arguments, true)) {
    $target = match ($userRole) {
        'admin'     => '/admin/dashboard',
        'dosen'     => '/dosen/dashboard',
        'mahasiswa' => '/mahasiswa/dashboard',
        default     => '/login',
    };

    return redirect()->to($target)
        ->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk halaman tersebut.');
}
```

**2. Validasi Pengambilan FRS: Duplikat, Kuota Kelas, dan Batas SKS (`siakad/app/Controllers/Mahasiswa/FrsController.php`)**

```php
// 1. Cek apakah kelas sudah pernah diambil
$sudahAmbil = $this->frsModel->where('mahasiswa_id', $mhs['id'])
    ->where('kelas_id', $kelasId)->first();
if ($sudahAmbil) {
    return redirect()->to('/mahasiswa/frs')->with('error', 'Anda sudah mengambil kelas ini.');
}

// 2. Cek kuota kelas
if ((int) $kelas['terisi'] >= (int) $kelas['kuota']) {
    return redirect()->to('/mahasiswa/frs')->with('error', 'Kuota kelas sudah penuh.');
}

// 3. Cek batas SKS semester aktif
$sksAktif = $this->frsModel->getTotalSksSemester((int) $mhs['id'], (int) $mhs['semester_aktif']);
if (($sksAktif + (int) $kelas['sks']) > (int) $mhs['batas_sks']) {
    return redirect()->to('/mahasiswa/frs')
        ->with('error', 'Gagal mengambil kelas: total SKS melebihi batas maksimal (' . $mhs['batas_sks'] . ' SKS).');
}
```

**3. Konversi Nilai Otomatis dan Perhitungan IPK (`siakad/app/Models/FrsDetailModel.php`)**

| Rentang Nilai Angka | Nilai Huruf | Bobot Mutu |
| --- | :---: | :---: |
| $\ge 86$ | `A` | `4.00` |
| $76 - 85.99$ | `AB` | `3.50` |
| $66 - 75.99$ | `B` | `3.00` |
| $61 - 65.99$ | `BC` | `2.50` |
| $56 - 60.99$ | `C` | `2.00` |
| $41 - 55.99$ | `D` | `1.00` |
| $< 41$ | `E` | `0.00` |

```php
public static function konversiNilai(float $nilai): array
{
    return match (true) {
        $nilai >= 86 => ['huruf' => 'A',  'bobot' => 4.00],
        $nilai >= 76 => ['huruf' => 'AB', 'bobot' => 3.50],
        $nilai >= 66 => ['huruf' => 'B',  'bobot' => 3.00],
        $nilai >= 61 => ['huruf' => 'BC', 'bobot' => 2.50],
        $nilai >= 56 => ['huruf' => 'C',  'bobot' => 2.00],
        $nilai >= 41 => ['huruf' => 'D',  'bobot' => 1.00],
        default      => ['huruf' => 'E',  'bobot' => 0.00],
    };
}
```

---

### 3.3 Latihan 2.2 — HoopKicks

**HoopKicks** adalah toko online khusus sepatu basket dan *court gear* dengan gaya visual *Editorial Sneaker Boutique* (*Chalk Off-White* `#F5F4EF`, *Jet Black* `#0D0D0F`, aksen *Hardwood Vermilion* `#FF4500` & *Acid Lime* `#D9FF00`, sudut kotak tajam `0px`, tipografi *Barlow Condensed*, *Space Grotesk*, dan *JetBrains Mono*).

#### Matriks Hak Akses & Fitur

| Fitur | Pengunjung | Pelanggan | Admin |
| --- | :---: | :---: | :---: |
| Katalog sepatu, *Featured Heat*, pencarian (nama/brand/SKU), filter kategori & tipe lapangan (*Indoor/Outdoor/All-Court*), urut harga | Ya | Ya | Ya |
| Halaman detail sepatu + pemilih ukuran (`EU 40–46` / `M–XL`) & produk terkait | Ya | Ya | Ya |
| Keranjang belanja berbasis session (validasi harga & stok terbaru dari DB) | Ya | Ya | Ya |
| Checkout dalam transaksi database (otomatis potong stok & simpan snapshot item) | Tidak | Ya | Ya |
| Riwayat pesanan pelanggan (`/my-orders`) | Tidak | Ya | Ya |
| Panel Admin: Dashboard omzet & peringatan stok menipis ($\le 5$) | Tidak | Tidak | Ya |
| CRUD Kategori, CRUD Produk + upload foto sepatu, & update status pesanan (restock otomatis jika `cancelled`) | Tidak | Tidak | Ya |

#### Potongan Kode Penting

**1. Transaksi Checkout, Snapshot Item, dan Pengurangan Stok (`hoop-kicks/app/Controllers/OrderController.php`)**

Validasi stok dihitung secara agregat per produk (meski pelanggan membeli 2 ukuran berbeda dari sepatu yang sama). Penyimpanan pesanan, item, dan pemotongan stok dibungkus transaksi database.

```php
$db = \Config\Database::connect();
$db->transStart();

$orderCode = 'HK-' . date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));

$this->orderModel->insert([
    'order_code'       => $orderCode,
    'user_id'          => session()->get('user_id'),
    'recipient_name'   => trim($this->request->getPost('recipient_name')),
    'phone'            => trim($this->request->getPost('phone')),
    'shipping_address' => trim($this->request->getPost('shipping_address')),
    'payment_method'   => $this->request->getPost('payment_method'),
    'total_price'      => $totalPrice,
    'status'           => 'pending',
    'notes'            => trim((string) $this->request->getPost('notes')),
]);
$orderId = $this->orderModel->getInsertID();

foreach ($preparedItems as $item) {
    $item['order_id'] = $orderId;
    $this->orderItemModel->insert($item);
}

// Potong stok masing-masing produk
foreach ($neededByProduct as $pid => $qtyUsed) {
    $newStock = (int) $productCache[$pid]['stock'] - $qtyUsed;
    $this->productModel->update($pid, ['stock' => $newStock]);
}

$db->transComplete();
```

**2. Pengembalian Stok Otomatis saat Pesanan Dibatalkan (`hoop-kicks/app/Controllers/Admin/OrderController.php`)**

```php
if ($order['status'] === 'cancelled' && $newStatus !== 'cancelled') {
    return redirect()->to('/admin/orders')
        ->with('error', 'Pesanan yang sudah dibatalkan tidak dapat diaktifkan kembali.');
}

// Kembalikan stok otomatis tepat satu kali saat diubah menjadi cancelled
if ($order['status'] !== 'cancelled' && $newStatus === 'cancelled') {
    $items = $this->orderItemModel->where('order_id', $id)->findAll();
    foreach ($items as $item) {
        if (! empty($item['product_id'])) {
            $product = $this->productModel->find($item['product_id']);
            if ($product) {
                $this->productModel->update($product['id'], [
                    'stock' => (int) $product['stock'] + (int) $item['quantity'],
                ]);
            }
        }
    }
}
```

---

## 4. Model Data dan Diagram ERD

Seluruh tabel pada ketiga aplikasi dibuat melalui **CodeIgniter Migration** sehingga integritas *Primary Key*, *Unique Key*, dan *Foreign Key* terjaga langsung di MySQL.

### 4.1 ERD ShuttleHub (`shuttlehub_db`)

```mermaid
erDiagram
    users ||--o{ bookings : "membuat"
    courts ||--o{ bookings : "dipesan"

    users {
        int id PK
        varchar name
        varchar email UK
        varchar phone
        varchar password
        enum role "admin, customer"
    }
    courts {
        int id PK
        varchar name
        varchar floor_type
        int price_per_hour
        text description
        varchar image
        enum status "available, maintenance"
    }
    bookings {
        int id PK
        int user_id FK
        int court_id FK
        date booking_date
        time start_time
        time end_time
        int duration
        int total_price
        varchar payment_proof
        enum status "pending, confirmed, completed, cancelled"
        text notes
    }
```

### 4.2 ERD SIAKAD (`siakad_db`)

```mermaid
erDiagram
    users ||--o| dosen : "akun dosen"
    users ||--o| mahasiswa : "akun mahasiswa"
    program_studi ||--o{ dosen : "menaungi"
    program_studi ||--o{ mahasiswa : "menaungi"
    program_studi ||--o{ mata_kuliah : "memiliki"
    dosen ||--o{ mahasiswa : "dosen wali"
    dosen ||--o{ kelas : "mengampu"
    mata_kuliah ||--o{ kelas : "dibuka di"
    mahasiswa ||--o{ frs_detail : "mengambil"
    kelas ||--o{ frs_detail : "dipilih pada"

    users {
        int id PK
        varchar name
        varchar email UK
        varchar password
        enum role "admin, dosen, mahasiswa"
    }
    program_studi {
        int id PK
        varchar kode_prodi UK
        varchar nama_prodi
        varchar fakultas
    }
    dosen {
        int id PK
        int user_id FK,UK
        int prodi_id FK
        varchar nip UK
        varchar nama
    }
    mahasiswa {
        int id PK
        int user_id FK,UK
        int prodi_id FK
        int dosen_wali_id FK
        varchar nrp UK
        varchar nama
        int angkatan
        int semester_aktif
        int batas_sks
    }
    mata_kuliah {
        int id PK
        int prodi_id FK
        varchar kode_mk UK
        varchar nama_mk
        int sks
        int semester
    }
    kelas {
        int id PK
        int mata_kuliah_id FK
        int dosen_id FK
        varchar nama_kelas
        varchar tahun_ajaran
        varchar jadwal
        varchar ruangan
        int kuota
    }
    frs_detail {
        int id PK
        int mahasiswa_id FK
        int kelas_id FK
        int semester_ambil
        decimal nilai_angka
        varchar nilai_huruf
        decimal bobot
    }
```

> **Catatan Desain SIAKAD:** Kombinasi unik `(mahasiswa_id, kelas_id)` pada `frs_detail` mencegah mahasiswa mengambil kelas yang sama dua kali. Kolom `dosen_wali_id` menggunakan `ON DELETE SET NULL` agar data mahasiswa tetap aman apabila dosen wali dihapus.

### 4.3 ERD HoopKicks (`hoopkicks_db`)

```mermaid
erDiagram
    users ||--o{ orders : "melakukan"
    categories ||--o{ products : "mengelompokkan"
    orders ||--|{ order_items : "berisi"
    products ||--o{ order_items : "dipesan"

    users {
        int id PK
        varchar name
        varchar email UK
        varchar phone
        text address
        varchar password
        enum role "admin, customer"
    }
    categories {
        int id PK
        varchar name
        varchar slug UK
        text description
    }
    products {
        int id PK
        int category_id FK
        varchar sku UK
        varchar name
        varchar slug UK
        varchar brand
        varchar colorway
        enum court_type "Indoor, Outdoor, All-Court"
        int price
        int stock
        varchar sizes
        text description
        varchar image
        tinyint is_featured
    }
    orders {
        int id PK
        varchar order_code UK
        int user_id FK
        varchar recipient_name
        varchar phone
        text shipping_address
        varchar payment_method
        int total_price
        enum status "pending, paid, shipped, completed, cancelled"
        text notes
    }
    order_items {
        int id PK
        int order_id FK
        int product_id FK
        varchar product_name
        varchar shoe_size
        int price
        int quantity
        int subtotal
    }
```

> **Catatan Desain HoopKicks:** `order_items` menyimpan *snapshot* `product_name`, `shoe_size`, dan `price` saat transaksi, serta menggunakan `ON DELETE SET NULL` pada `product_id`. Dengan demikian perubahan harga atau penghapusan produk di katalog tidak akan merusak histori transaksi pelanggan.

---

## 5. Langkah Instalasi dan Konfigurasi

### 5.1 Prasyarat

1. Pastikan **XAMPP** (modul **Apache** dan **MySQL**), **PHP 8.2+**, dan **Composer** sudah terpasang.
2. Pastikan ekstensi `intl`, `mbstring`, `mysqli`, dan `fileinfo` aktif di `php.ini`.
3. Buka **phpMyAdmin** (`http://localhost/phpmyadmin`) lalu buat 3 database kosong:

```sql
CREATE DATABASE shuttlehub_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE siakad_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE hoopkicks_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5.2 Instalasi Dependency & Konfigurasi `.env`

Jika baru meng-clone repository (folder `vendor/` belum ada), jalankan `composer install` dan salin file `env` menjadi `.env` pada masing-masing folder proyek:

```powershell
# Ulangi untuk shuttle-hub, siakad, dan hoop-kicks
composer install
Copy-Item env .env
```

Sesuaikan konfigurasi `.env` di tiap folder agar port, database, dan nama cookie session tidak saling bertabrakan:

| Pengaturan `.env` | `shuttle-hub` | `siakad` | `hoop-kicks` |
| --- | --- | --- | --- |
| `CI_ENVIRONMENT` | `development` | `development` | `development` |
| `app.baseURL` | `'http://localhost:8080/'` | `'http://localhost:8081/'` | `'http://localhost:8082/'` |
| `app.indexPage` | `''` | `''` | `''` |
| `session.cookieName` | `'shuttlehub_session'` | `'siakad_session'` | `'hoopkicks_session'` |
| `database.default.database` | `shuttlehub_db` | `siakad_db` | `hoopkicks_db` |
| `database.default.username` | `root` | `root` | `root` |
| `database.default.password` | *(kosong untuk default XAMPP)* | *(kosong)* | *(kosong)* |
| `database.default.DBDriver` | `MySQLi` | `MySQLi` | `MySQLi` |

### 5.3 Menjalankan Migration dan Seeder

Jalankan perintah berikut di terminal pada masing-masing direktori (`shuttle-hub`, `siakad`, dan `hoop-kicks`):

```powershell
php spark migrate
php spark db:seed DatabaseSeeder
```

---

## 6. Menjalankan Aplikasi dan Akun Demo

Buka tiga terminal terpisah agar ketiga aplikasi dapat berjalan bersamaan:

```powershell
# Terminal 1 — ShuttleHub (http://localhost:8080)
cd shuttle-hub
php spark serve --port 8080

# Terminal 2 — SIAKAD (http://localhost:8081)
cd siakad
php spark serve --port 8081

# Terminal 3 — HoopKicks (http://localhost:8082)
cd hoop-kicks
php spark serve --port 8082
```

### Daftar Akun Demo (Hasil Seeder)

| Aplikasi | Role | Email | Kata Sandi | Keterangan |
| --- | --- | --- | --- | --- |
| **ShuttleHub** | Admin | `admin@shuttlehub.test` | `admin1234` | Panel SB Admin (Kelola Lapangan & Booking) |
| **ShuttleHub** | Pelanggan | `rennard@shuttlehub.test` | `rennard1234` | Booking lapangan & upload bukti transfer |
| **SIAKAD** | Admin | `admin@siakad.test` | `admin1234` | CRUD Prodi, Dosen, Mahasiswa, MK, Kelas |
| **SIAKAD** | Dosen 1 | `dosen@siakad.test` | `dosen1234` | Fajar Baskoro, S.Kom., M.T. (Pengampu PBKK & Dosen Wali) |
| **SIAKAD** | Dosen 2 | `dosen2@siakad.test` | `dosen1234` | Dr. Budi Santoso, S.Kom., M.T. |
| **SIAKAD** | Mahasiswa 1 | `rennard@siakad.test` | `mahasiswa1234` | Rennard Filbert Tanjaya (NRP `5025241122`, Smt 5) |
| **SIAKAD** | Mahasiswa 2 | `willy@siakad.test` | `mahasiswa1234` | Willy Marcelius (NRP `5025241096`, Smt 3) |
| **HoopKicks** | Admin | `admin@hoopkicks.test` | `admin1234` | Kelola Produk, Kategori, & Pesanan Masuk |
| **HoopKicks** | Pelanggan | `rennard@hoopkicks.test` | `rennard1234` | Keranjang, Checkout, & Riwayat Pesanan |

---

## 7. Dokumentasi Tampilan (Screenshot)

### 7.1 ShuttleHub (`http://localhost:8080`)

* **Form Login**
  ![Beranda ShuttleHub](Documentation/shuttlehub/01-login.png)
* **Form Register Akun**
  ![Beranda ShuttleHub](Documentation/shuttlehub/02-register.png)
* **Halaman Publik & Katalog Lapangan**
  ![Beranda ShuttleHub](Documentation/shuttlehub/03-home.png)
  ![Beranda ShuttleHub](Documentation/shuttlehub/04-home.png)
* **Form Booking & Upload Bukti Pembayaran**
  ![Form Booking ShuttleHub](Documentation/shuttlehub/05-booking-form.png)
* **Riwayat Booking Pelanggan (`Booking Saya`)**
  ![Booking Saya](Documentation/shuttlehub/06-my-bookings.png)
* **Panel SB Admin — Dashboard**
  ![Dashboard Admin ShuttleHub](Documentation/shuttlehub/07-admin-dashboard.png)
* **Panel SB Admin — Kelola Lapangan**
  ![Kelola Lapangan](Documentation/shuttlehub/08-admin-courts.png)
  ![Kelola Lapangan](Documentation/shuttlehub/09-admin-courts.png)
* **Panel SB Admin — Kelola Booking**
  ![Kelola Booking](Documentation/shuttlehub/10-admin-bookings.png)
  ![Kelola Booking](Documentation/shuttlehub/11-admin-bookings.png)

### 7.2 SIAKAD (`http://localhost:8081`)

* **Halaman Portal Login Split-Screen**
  ![Login SIAKAD](Documentation/siakad/01-login.png)
* **Panel Admin — Dashboard, Prodi, Dosen, Mahasiswa, Mata Kuliah, & Kelas**
  ![Dashboard Admin SIAKAD](Documentation/siakad/02-admin-dashboard.png)
  ![Kelola Mahasiswa](Documentation/siakad/03-admin-mahasiswa.png)
  ![Kelola Dosen](Documentation/siakad/04-admin-dosen.png)
  ![Kelola Program Studi](Documentation/siakad/05-admin-programstudi.png)
  ![Kelola Mata Kuliah](Documentation/siakad/06-admin-matkul.png)
  ![Kelola Kelas](Documentation/siakad/07-admin-kelas.png)
* **Panel Dosen — Kelas Diampu, Input Nilai, & Perwalian**
  ![Dashboard Dosen SIAKAD](Documentation/siakad/08-dosen-dashboard.png)
  ![Kelas Diampu Dosen](Documentation/siakad/09-dosen-kelas.png)
  ![Input Nilai Dosen](Documentation/siakad/10-dosen-nilai.png)
  ![Mahasiswa Perwalian](Documentation/siakad/11-dosen-perwalian.png)
* **Panel Mahasiswa — Profil, Pengisian FRS, Nilai/IPK, & Cetak Transkrip**
  ![Dashboard Mahasiswa](Documentation/siakad/12-mahasiswa-dashboard.png)
  ![Pengisian FRS](Documentation/siakad/13-mahasiswa-frs.png)
  ![Nilai dan IPK](Documentation/siakad/14-mahasiswa-nilai.png)
  ![Cetak Transkrip](Documentation/siakad/15-cetak-transkrip.png)
  ![Cetak FRS](Documentation/siakad/16-cetak-frs.png)

### 7.3 HoopKicks (`http://localhost:8082`)

* **Form Login**
  ![Beranda Hoopkicks](Documentation/hoopkicks/01-login.png)
* **Form Register Akun**
  ![Beranda Hoopkicks](Documentation/hoopkicks/02-register.png)
* **Storefront Editorial & Katalog Sepatu Basket**
  ![Beranda HoopKicks](Documentation/hoopkicks/03-storefront.png)
  ![Katalog & Filter HoopKicks](Documentation/hoopkicks/04-catalog.png)
* **Detail Sepatu (Pilih Size EU), Keranjang, Checkout, & Riwayat Pesanan**
  ![Detail Sepatu](Documentation/hoopkicks/05-product-detail.png)
  ![Keranjang Belanja](Documentation/hoopkicks/06-cart.png)
  ![Checkout](Documentation/hoopkicks/07-checkout.png)
  ![Pesanan saya](Documentation/hoopkicks/08-myorders.png)
* **Panel Admin — Dashboard, CRUD Produk + Foto, Kategori, & Update Status Pesanan**
  ![Dashboard Admin HoopKicks](Documentation/hoopkicks/09-admin-dashboard.png)
  ![Kelola Produk Sepatu](Documentation/hoopkicks/10-admin-kelola-sepatu.png)
  ![Edit Produk Sepatu](Documentation/hoopkicks/11-admin-edit-product.png)
  ![Kelola Pesanan Masuk](Documentation/hoopkicks/12-admin-kelola-order.png)
  ![Kelola Kategori](Documentation/hoopkicks/13-admin-kelola-kategori.png)
  ![Edit Kategori](Documentation/hoopkicks/14-admin-edit-kategori.png)

---

## 8. Kendala Teknis dan Penyelesaian

| Kendala yang Ditemui | Penyelesaian yang Diterapkan |
| --- | --- |
| **Bentrok sesi login saat 3 aplikasi dibuka bersamaan di `localhost`** | Membedakan `session.cookieName` pada file `.env` tiap proyek (`shuttlehub_session`, `siakad_session`, `hoopkicks_session`) sehingga sesi login tidak saling menimpa. |
| **Teks pada `<select>` menabrak ikon panah dropdown di CSS kustom** | Memisahkan aturan `.form-select` dan `.form-select-sm` dengan `padding-right: 2.6rem` dan mengatur ulang `background-position` agar ruang panah dropdown tetap lega. |

---

## 9. Struktur Folder Repository

```text
Latihan 5 - Week 9/
├── README.md
├── Documentation/
│   ├── shuttlehub/
│   ├── siakad/
│   └── hoopkicks/
├── shuttle-hub/                     # Latihan 1 — Booking Lapangan Badminton (Port 8080)
│   ├── app/
│   │   ├── Config/                  # Routes.php, Filters.php
│   │   ├── Controllers/             # Home, AuthController, BookingController, Admin/*
│   │   ├── Database/                # Migrations & DatabaseSeeder
│   │   ├── Filters/                 # AuthFilter, AdminFilter
│   │   ├── Models/                  # UserModel, CourtModel, BookingModel
│   │   └── Views/                   # layout/, auth/, bookings/, admin/
│   └── public/
│       ├── assets/shuttlehub.css
│       └── uploads/                 # courts/, payments/
├── siakad/                          # Latihan 2.1 — SIAKAD 3 Role (Port 8081)
│   ├── app/
│   │   ├── Controllers/             # AuthController, Admin/*, Dosen/*, Mahasiswa/*
│   │   ├── Database/                # CreateSiakadTables & DatabaseSeeder
│   │   ├── Filters/                 # RoleFilter
│   │   ├── Models/                  # 7 Model relasional akademik
│   │   └── Views/                   # layout/, auth/, admin/, dosen/, mahasiswa/
│   └── public/assets/siakad.css
└── hoop-kicks/                      # Latihan 2.2 — Basketball Footwear Store (Port 8082)
    ├── app/
    │   ├── Controllers/             # Shop, Cart, Order, Auth, Admin/*
    │   ├── Database/                # CreateHoopKicksTables & DatabaseSeeder
    │   ├── Filters/                 # AuthFilter, AdminFilter
    │   ├── Models/                  # User, Category, Product, Order, OrderItem
    │   └── Views/                   # layout/, auth/, shop/, admin/
    └── public/
        ├── assets/hoopkicks.css
        └── uploads/products/
```

---

## 10. Referensi

* [Dokumentasi Resmi CodeIgniter 4](https://codeigniter.com/user_guide/)
* [Bootstrap 5.3 Documentation](https://getbootstrap.com/docs/5.3/)
* [StartBootstrap SB Admin](https://startbootstrap.com/template/sb-admin)
* [Mermaid.js Entity Relationship Diagrams](https://mermaid.js.org/syntax/entityRelationshipDiagram.html)