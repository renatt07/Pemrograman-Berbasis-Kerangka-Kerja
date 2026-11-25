<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSiakadTables extends Migration
{
    public function up()
    {
        // 1. Tabel users
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
            'password'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'role'       => ['type' => 'ENUM', 'constraint' => ['admin', 'dosen', 'mahasiswa'], 'default' => 'mahasiswa'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');

        // 2. Tabel program_studi
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kode_prodi' => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'nama_prodi' => ['type' => 'VARCHAR', 'constraint' => 100],
            'fakultas'   => ['type' => 'VARCHAR', 'constraint' => 100],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('program_studi');

        // 3. Tabel dosen
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'unique' => true],
            'prodi_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nip'        => ['type' => 'VARCHAR', 'constraint' => 30, 'unique' => true],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('prodi_id', 'program_studi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('dosen');

        // 4. Tabel mahasiswa
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'unique' => true],
            'prodi_id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'dosen_wali_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'nrp'            => ['type' => 'VARCHAR', 'constraint' => 30, 'unique' => true],
            'nama'           => ['type' => 'VARCHAR', 'constraint' => 100],
            'angkatan'       => ['type' => 'INT', 'constraint' => 4, 'default' => 2024],
            'semester_aktif' => ['type' => 'INT', 'constraint' => 2, 'default' => 3],
            'batas_sks'      => ['type' => 'INT', 'constraint' => 2, 'default' => 24],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('prodi_id', 'program_studi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('dosen_wali_id', 'dosen', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('mahasiswa');

        // 5. Tabel mata_kuliah
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'prodi_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'kode_mk'    => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'nama_mk'    => ['type' => 'VARCHAR', 'constraint' => 120],
            'sks'        => ['type' => 'INT', 'constraint' => 2],
            'semester'   => ['type' => 'INT', 'constraint' => 2],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('prodi_id', 'program_studi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('mata_kuliah');

        // 6. Tabel kelas
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'mata_kuliah_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'dosen_id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nama_kelas'     => ['type' => 'VARCHAR', 'constraint' => 20],
            'tahun_ajaran'   => ['type' => 'VARCHAR', 'constraint' => 30],
            'jadwal'         => ['type' => 'VARCHAR', 'constraint' => 80],
            'ruangan'        => ['type' => 'VARCHAR', 'constraint' => 50],
            'kuota'          => ['type' => 'INT', 'constraint' => 3, 'default' => 40],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('mata_kuliah_id', 'mata_kuliah', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('dosen_id', 'dosen', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kelas');

        // 7. Tabel frs_detail (relasi mahasiswa <-> kelas + nilai)
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'mahasiswa_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'kelas_id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'semester_ambil' => ['type' => 'INT', 'constraint' => 2],
            'nilai_angka'    => ['type' => 'DECIMAL', 'constraint' => '5,2', 'null' => true],
            'nilai_huruf'    => ['type' => 'VARCHAR', 'constraint' => 2, 'null' => true],
            'bobot'          => ['type' => 'DECIMAL', 'constraint' => '3,2', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['mahasiswa_id', 'kelas_id']);
        $this->forge->addForeignKey('mahasiswa_id', 'mahasiswa', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kelas_id', 'kelas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('frs_detail');
    }

    public function down()
    {
        $this->forge->dropTable('frs_detail', true);
        $this->forge->dropTable('kelas', true);
        $this->forge->dropTable('mata_kuliah', true);
        $this->forge->dropTable('mahasiswa', true);
        $this->forge->dropTable('dosen', true);
        $this->forge->dropTable('program_studi', true);
        $this->forge->dropTable('users', true);
    }
}