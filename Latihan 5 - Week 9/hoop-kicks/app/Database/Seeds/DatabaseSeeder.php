<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // 1. Akun Demo
        $this->db->table('users')->insertBatch([
            [
                'name'       => 'Admin HoopKicks',
                'email'      => 'admin@hoopkicks.test',
                'phone'      => '081234567890',
                'address'    => 'Jl. Tunjungan No. 88, Surabaya',
                'password'   => password_hash('admin1234', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => 'Rennard Filbert',
                'email'      => 'rennard@hoopkicks.test',
                'phone'      => '085678901234',
                'address'    => 'Jl. Diponegoro No. 45, Surabaya',
                'password'   => password_hash('rennard1234', PASSWORD_DEFAULT),
                'role'       => 'customer',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // 2. Kategori Produk
        $categories = [
            ['name' => 'Signature Series', 'slug' => 'signature-series', 'description' => 'Rilisan eksklusif lini signature bintang NBA dengan teknologi cushioning terbaik.'],
            ['name' => 'Guard / Low-Top',  'slug' => 'guard-low-top',    'description' => 'Sepatu ringan berpotongan rendah dengan traksi tajam untuk kecepatan dan shifty moves.'],
            ['name' => 'Outdoor Beast',    'slug' => 'outdoor-beast',    'description' => 'Outsole karet tebal tahan gesekan aspal dan semen lapangan outdoor.'],
            ['name' => 'Court Gear',       'slug' => 'court-gear',       'description' => 'Kaos kaki performa, tas sepatu, dan perlengkapan pendukung latihan.'],
        ];
        $catIds = [];
        foreach ($categories as $cat) {
            $cat['created_at'] = $now;
            $cat['updated_at'] = $now;
            $this->db->table('categories')->insert($cat);
            $catIds[$cat['slug']] = $this->db->insertID();
        }

        // 3. Produk Sepatu Basket & Gear
        $this->db->table('products')->insertBatch([
            [
                'category_id' => $catIds['signature-series'],
                'sku'         => 'NK-KB6-GRN',
                'name'        => 'Nike Kobe 6 Protro',
                'slug'        => 'nike-kobe-6-protro-reverse-grinch',
                'brand'       => 'Nike',
                'colorway'    => 'Bright Crimson / Electric Green',
                'court_type'  => 'Indoor',
                'price'       => 3499000,
                'stock'       => 6,
                'sizes'       => '41,42,43,44,45',
                'description' => 'Siluet rendah legendaris dengan tekstur sisik ular, unit Air Zoom Turbo responsif di forefoot, dan traksi tajam untuk permainan tempo cepat.',
                'image'       => null,
                'is_featured' => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'category_id' => $catIds['signature-series'],
                'sku'         => 'AD-AE1-WTL',
                'name'        => 'Adidas Anthony Edwards 1 Low',
                'slug'        => 'adidas-ae-1-low-mx-charcoal',
                'brand'       => 'Adidas',
                'colorway'    => 'MX Charcoal / Signal Orange',
                'court_type'  => 'All-Court',
                'price'       => 2100000,
                'stock'       => 12,
                'sizes'       => '40,41,42,43,44,45,46',
                'description' => 'Cage TPU sarang lebah futuristik dengan kombinasi bantalan JET BOOST dan Lightstrike untuk ledakan langkah pertama yang stabil.',
                'image'       => null,
                'is_featured' => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'category_id' => $catIds['guard-low-top'],
                'sku'         => 'LN-WOW10-LOW',
                'name'        => 'Li-Ning Way of Wade 10 Low',
                'slug'        => 'li-ning-way-of-wade-10-low-mint',
                'brand'       => 'Li-Ning',
                'colorway'    => 'Ice Mint / Carbon Black',
                'court_type'  => 'Indoor',
                'price'       => 2899000,
                'stock'       => 8,
                'sizes'       => '40,41,42,43,44',
                'description' => 'Full-length BOOM midsole dipadukan plat karbon penuh untuk pantulan vertikal maksimal dan penguncian tumit super rapat.',
                'image'       => null,
                'is_featured' => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'category_id' => $catIds['guard-low-top'],
                'sku'         => 'NK-BK1-MRG',
                'name'        => 'Nike Book 1 EP',
                'slug'        => 'nike-book-1-ep-mirage',
                'brand'       => 'Nike',
                'colorway'    => 'Mirage Ashen Slate / Clay',
                'court_type'  => 'All-Court',
                'price'       => 2199000,
                'stock'       => 14,
                'sizes'       => '40,41,42,43,44,45',
                'description' => 'Desain clean bergaya lifestyle namun dibekali Cushlon 2.0, Air Zoom di tumit, dan outsole XDR untuk cengkeraman konsisten.',
                'image'       => null,
                'is_featured' => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'category_id' => $catIds['signature-series'],
                'sku'         => 'UA-CUR11-FIR',
                'name'        => 'Under Armour Curry 11',
                'slug'        => 'under-armour-curry-11-future-curry',
                'brand'       => 'Under Armour',
                'colorway'    => 'Jet Black / Cobalt / Orange',
                'court_type'  => 'Indoor',
                'price'       => 2499000,
                'stock'       => 9,
                'sizes'       => '41,42,43,44,45',
                'description' => 'Teknologi UA Flow tanpa karet konvensional yang sangat ringan dan menempel ekstrem di lantai kayu maupun vinyl.',
                'image'       => null,
                'is_featured' => 0,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'category_id' => $catIds['outdoor-beast'],
                'sku'         => 'LN-FOF-11',
                'name'        => 'Li-Ning Fission 9 Outdoor',
                'slug'        => 'li-ning-fission-9-outdoor-concrete',
                'brand'       => 'Li-Ning',
                'colorway'    => 'Concrete Grey / Acid Orange',
                'court_type'  => 'Outdoor',
                'price'       => 1450000,
                'stock'       => 18,
                'sizes'       => '40,41,42,43,44,45,46',
                'description' => 'Dirancang khusus untuk lapangan outdoor dengan karet TUFF OS super awet, upper mesh breathable, dan shank anti-torsi.',
                'image'       => null,
                'is_featured' => 0,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'category_id' => $catIds['outdoor-beast'],
                'sku'         => 'JD-LUKA3-EP',
                'name'        => 'Jordan Luka 3 PF',
                'slug'        => 'jordan-luka-3-pf-midnight-racer',
                'brand'       => 'Jordan',
                'colorway'    => 'Midnight Racer / Barely Grape',
                'court_type'  => 'Outdoor',
                'price'       => 1999000,
                'stock'       => 11,
                'sizes'       => '41,42,43,44,45',
                'description' => 'IsoPlate samping yang lebar untuk menopang gerakan step-back keras serta outsole versi PF yang lebih tangguh di lapangan semen.',
                'image'       => null,
                'is_featured' => 0,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'category_id' => $catIds['court-gear'],
                'sku'         => 'HK-ELITE-SCK',
                'name'        => 'Nike Elite Crew Basketball Socks',
                'slug'        => 'nike-elite-crew-basketball-socks-black',
                'brand'       => 'Nike',
                'colorway'    => 'Triple Black / Volt Stitch',
                'court_type'  => 'All-Court',
                'price'       => 249000,
                'stock'       => 30,
                'sizes'       => 'M,L,XL',
                'description' => 'Kaos kaki basket dengan bantalan tebal di area tumit dan bola kaki serta arch band ketat anti-selip.',
                'image'       => null,
                'is_featured' => 0,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ]);
    }
}