<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // 1. Program Studi
        $this->db->table('program_studi')->insert([
            'kode_prodi' => 'IF',
            'nama_prodi' => 'Teknik Informatika',
            'fakultas'   => 'FTEIC',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $prodiIF = $this->db->insertID();

        $this->db->table('program_studi')->insert([
            'kode_prodi' => 'SI',
            'nama_prodi' => 'Sistem Informasi',
            'fakultas'   => 'FTEIC',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $prodiSI = $this->db->insertID();

        // 2. Users (Admin, 2 Dosen, 2 Mahasiswa)
        $this->db->table('users')->insert([
            'name'       => 'Admin SIAKAD',
            'email'      => 'admin@siakad.test',
            'password'   => password_hash('admin1234', PASSWORD_DEFAULT),
            'role'       => 'admin',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->db->table('users')->insert([
            'name'       => 'Fajar Baskoro, S.Kom., M.T.',
            'email'      => 'dosen@siakad.test',
            'password'   => password_hash('dosen1234', PASSWORD_DEFAULT),
            'role'       => 'dosen',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $userDosen1 = $this->db->insertID();

        $this->db->table('users')->insert([
            'name'       => 'Dr. Budi Santoso, S.Kom., M.T.',
            'email'      => 'dosen2@siakad.test',
            'password'   => password_hash('dosen1234', PASSWORD_DEFAULT),
            'role'       => 'dosen',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $userDosen2 = $this->db->insertID();

        $this->db->table('users')->insert([
            'name'       => 'Rennard Filbert Tanjaya',
            'email'      => 'rennard@siakad.test',
            'password'   => password_hash('mahasiswa1234', PASSWORD_DEFAULT),
            'role'       => 'mahasiswa',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $userMhs1 = $this->db->insertID();

        $this->db->table('users')->insert([
            'name'       => 'Willy Marcelius',
            'email'      => 'willy@siakad.test',
            'password'   => password_hash('mahasiswa1234', PASSWORD_DEFAULT),
            'role'       => 'mahasiswa',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $userMhs2 = $this->db->insertID();

        // 3. Dosen
        $this->db->table('dosen')->insert([
            'user_id'    => $userDosen1,
            'prodi_id'   => $prodiIF,
            'nip'        => '198504122010011001',
            'nama'       => 'Fajar Baskoro, S.Kom., M.T.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $dosen1 = $this->db->insertID();

        $this->db->table('dosen')->insert([
            'user_id'    => $userDosen2,
            'prodi_id'   => $prodiSI,
            'nip'        => '198811202014022003',
            'nama'       => 'Dr. Budi Santoso, S.Kom., M.T.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $dosen2 = $this->db->insertID();

        // 4. Mahasiswa
        $this->db->table('mahasiswa')->insert([
            'user_id'        => $userMhs1,
            'prodi_id'       => $prodiIF,
            'dosen_wali_id'  => $dosen1,
            'nrp'            => '5025241122',
            'nama'           => 'Rennard Filbert Tanjaya',
            'angkatan'       => 2024,
            'semester_aktif' => 5,
            'batas_sks'      => 24,
            'created_at'     => $now,
            'updated_at'     => $now,
        ]);
        $mhs1 = $this->db->insertID();

        $this->db->table('mahasiswa')->insert([
            'user_id'        => $userMhs2,
            'prodi_id'       => $prodiIF,
            'dosen_wali_id'  => $dosen1,
            'nrp'            => '5025241096',
            'nama'           => 'Willy Marcelius',
            'angkatan'       => 2024,
            'semester_aktif' => 3,
            'batas_sks'      => 24,
            'created_at'     => $now,
            'updated_at'     => $now,
        ]);
        $mhs2 = $this->db->insertID();

        // 5. Mata Kuliah
        $mkData = [
            ['prodi_id' => $prodiIF, 'kode_mk' => 'IF101', 'nama_mk' => 'Dasar Pemrograman', 'sks' => 4, 'semester' => 1],
            ['prodi_id' => $prodiIF, 'kode_mk' => 'IF202', 'nama_mk' => 'Struktur Data', 'sks' => 4, 'semester' => 2],
            ['prodi_id' => $prodiIF, 'kode_mk' => 'IF301', 'nama_mk' => 'Sistem Basis Data', 'sks' => 3, 'semester' => 3],
            ['prodi_id' => $prodiIF, 'kode_mk' => 'IF302', 'nama_mk' => 'Jaringan Komputer', 'sks' => 3, 'semester' => 3],
            ['prodi_id' => $prodiIF, 'kode_mk' => 'IF501', 'nama_mk' => 'Pemrograman Berbasis Kerangka Kerja', 'sks' => 3, 'semester' => 5],
        ];
        $mkIds = [];
        foreach ($mkData as $mk) {
            $mk['created_at'] = $now;
            $mk['updated_at'] = $now;
            $this->db->table('mata_kuliah')->insert($mk);
            $mkIds[] = $this->db->insertID();
        }

        // 6. Kelas
        $kelasData = [
            ['mata_kuliah_id' => $mkIds[0], 'dosen_id' => $dosen1, 'nama_kelas' => 'A', 'tahun_ajaran' => '2024/2025 Ganjil', 'jadwal' => 'Senin, 08:00 - 11:00', 'ruangan' => 'IF-101', 'kuota' => 40],
            ['mata_kuliah_id' => $mkIds[1], 'dosen_id' => $dosen1, 'nama_kelas' => 'A', 'tahun_ajaran' => '2024/2025 Genap', 'jadwal' => 'Selasa, 10:00 - 13:00', 'ruangan' => 'IF-102', 'kuota' => 40],
            ['mata_kuliah_id' => $mkIds[2], 'dosen_id' => $dosen2, 'nama_kelas' => 'B', 'tahun_ajaran' => '2026/2027 Ganjil', 'jadwal' => 'Kamis, 13:00 - 15:30', 'ruangan' => 'IF-104', 'kuota' => 35],
            ['mata_kuliah_id' => $mkIds[3], 'dosen_id' => $dosen1, 'nama_kelas' => 'C', 'tahun_ajaran' => '2026/2027 Ganjil', 'jadwal' => 'Jumat, 09:00 - 11:30', 'ruangan' => 'IF-108', 'kuota' => 30],
            ['mata_kuliah_id' => $mkIds[4], 'dosen_id' => $dosen1, 'nama_kelas' => 'D', 'tahun_ajaran' => '2026/2027 Ganjil', 'jadwal' => 'Rabu, 08:00 - 10:30', 'ruangan' => 'IF-105', 'kuota' => 35],
        ];
        $kelasIds = [];
        foreach ($kelasData as $k) {
            $k['created_at'] = $now;
            $k['updated_at'] = $now;
            $this->db->table('kelas')->insert($k);
            $kelasIds[] = $this->db->insertID();
        }

        // 7. Data Awal FRS & Nilai Semester Lalu untuk Rennard & Willy
        $this->db->table('frs_detail')->insertBatch([
            [
                'mahasiswa_id'   => $mhs1,
                'kelas_id'       => $kelasIds[0],
                'semester_ambil' => 1,
                'nilai_angka'    => 88.50,
                'nilai_huruf'    => 'A',
                'bobot'          => 4.00,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'mahasiswa_id'   => $mhs1,
                'kelas_id'       => $kelasIds[1],
                'semester_ambil' => 2,
                'nilai_angka'    => 81.00,
                'nilai_huruf'    => 'AB',
                'bobot'          => 3.50,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'mahasiswa_id'   => $mhs1,
                'kelas_id'       => $kelasIds[4],
                'semester_ambil' => 5,
                'nilai_angka'    => null,
                'nilai_huruf'    => null,
                'bobot'          => null,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'mahasiswa_id'   => $mhs2,
                'kelas_id'       => $kelasIds[4],
                'semester_ambil' => 3,
                'nilai_angka'    => null,
                'nilai_huruf'    => null,
                'bobot'          => null,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
        ]);
    }
}