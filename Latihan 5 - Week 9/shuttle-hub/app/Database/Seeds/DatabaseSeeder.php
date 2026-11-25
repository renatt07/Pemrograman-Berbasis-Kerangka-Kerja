<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // Akun Demo (Admin & Pelanggan)
        $this->db->table('users')->insertBatch([
            [
                'name'       => 'Admin ShuttleHub',
                'email'      => 'admin@shuttlehub.test',
                'phone'      => '081234567890',
                'password'   => password_hash('admin1234', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => 'Rennard Filbert',
                'email'      => 'rennard@shuttlehub.test',
                'phone'      => '085678901234',
                'password'   => password_hash('rennard1234', PASSWORD_DEFAULT),
                'role'       => 'customer',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // Data Awal Lapangan Badminton
        $this->db->table('courts')->insertBatch([
            [
                'name'           => 'Court 1 - Aero Pro',
                'floor_type'     => 'Karpet Vinyl BWF',
                'price_per_hour' => 75000,
                'description'    => 'Lapangan standar turnamen dengan karpet vinyl anti-slip, pencahayaan LED bebas silau, dan ruang tunggu AC.',
                'image'          => null,
                'status'         => 'available',
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'name'           => 'Court 2 - Smash Zone',
                'floor_type'     => 'Karpet Vinyl BWF',
                'price_per_hour' => 75000,
                'description'    => 'Lapangan vinyl premium cocok untuk latihan rutin maupun sparing kompetitif.',
                'image'          => null,
                'status'         => 'available',
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'name'           => 'Court 3 - Classic Wood',
                'floor_type'     => 'Parket Kayu',
                'price_per_hour' => 60000,
                'description'    => 'Lantai parket kayu empuk yang nyaman untuk lutut dengan sirkulasi udara maksimal.',
                'image'          => null,
                'status'         => 'available',
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'name'           => 'Court 4 - Rally Reguler',
                'floor_type'     => 'Semen Halus / Standar',
                'price_per_hour' => 45000,
                'description'    => 'Pilihan ekonomis untuk main santai bareng teman kampus atau komunitas.',
                'image'          => null,
                'status'         => 'available',
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
        ]);
    }
}