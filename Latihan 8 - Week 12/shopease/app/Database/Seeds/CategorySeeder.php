<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $categories = [
            [
                'name'        => 'Mechanical Keyboard',
                'slug'        => 'mechanical-keyboard',
                'icon'        => 'bi-keyboard',
                'description' => 'Gasket mount custom, hot-swap, hingga Rapid Trigger Hall Effect.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Gaming Mouse',
                'slug'        => 'gaming-mouse',
                'icon'        => 'bi-mouse2',
                'description' => 'Bobot ultralight esports, sensor flagship, & polling rate 8000Hz.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Audio & Headset',
                'slug'        => 'audio-headset',
                'icon'        => 'bi-headset',
                'description' => 'Headset nirkabel low-latency & mikrofon kondensor jernih.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'Desk & Accessories',
                'slug'        => 'desk-accessories',
                'icon'        => 'bi-pc-display',
                'description' => 'Mousepad pro-grade Jepang dan monitor lightbar anti-silau.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        foreach ($categories as $cat) {
            $exists = $this->db->table('categories')->where('slug', $cat['slug'])->countAllResults();
            if ($exists === 0) {
                $this->db->table('categories')->insert($cat);
            }
        }
    }
}