<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $users = [
            [
                'name'       => 'Admin ShopEase',
                'email'      => 'admin@shopease.com',
                'password'   => password_hash('admin1234', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'phone'      => '081200000001',
                'address'    => 'Jl. Ikan Hiu No. 88, Surabaya',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => 'Operator Gudang',
                'email'      => 'operator@shopease.com',
                'password'   => password_hash('operator1234', PASSWORD_DEFAULT),
                'role'       => 'operator',
                'phone'      => '081200000002',
                'address'    => 'Gudang ShopEase, Surabaya',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => 'Rennard Filbert',
                'email'      => 'rennard@shopease.com',
                'password'   => password_hash('customer1234', PASSWORD_DEFAULT),
                'role'       => 'customer',
                'phone'      => '081234567890',
                'address'    => 'Sukolilo, Surabaya, Jawa Timur',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => 'Willy Marcelius',
                'email'      => 'willy@shopease.com',
                'password'   => password_hash('customer1234', PASSWORD_DEFAULT),
                'role'       => 'customer',
                'phone'      => '081298765432',
                'address'    => 'Gubeng, Surabaya, Jawa Timur',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Cek email dulu agar aman jika seeder dijalankan ulang
        foreach ($users as $user) {
            $exists = $this->db->table('users')
                ->where('email', $user['email'])
                ->countAllResults();

            if ($exists === 0) {
                $this->db->table('users')->insert($user);
            }
        }
    }
}