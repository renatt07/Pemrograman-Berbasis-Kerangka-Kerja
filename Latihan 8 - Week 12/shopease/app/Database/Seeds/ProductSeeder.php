<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // Ambil mapping slug => id_category
        $catRows = $this->db->table('categories')->get()->getResultArray();
        $catMap  = [];
        foreach ($catRows as $row) {
            $catMap[$row['slug']] = $row['id_category'];
        }

        $products = [
            [
                'category_slug' => 'mechanical-keyboard',
                'name'          => 'AULA F75 Tri-Mode Gasket',
                'slug'          => 'aula-f75-tri-mode-gasket',
                'price'         => 849000,
                'stock'         => 15,
                'badge'         => 'Best Seller',
                'status'        => 'tersedia',
                'image_base'    => 'aula-f75',
                'description'   => 'Keyboard mekanikal 75% (80 tombol) dengan leaf-spring gasket mount, 5 lapis peredam suara, keycap PBT double-shot, knob multifungsi metal, dan konektivitas tri-mode.',
                'specs'         => json_encode([
                    'Layout'       => '75% Compact (80 Keys + Metal Knob)',
                    'Switch'       => 'LEOBOG Reaper Linear (Hot-Swap 3/5-Pin)',
                    'Konektivitas' => '2.4GHz Wireless / Bluetooth / USB-C',
                    'Baterai'      => '4000 mAh',
                ]),
            ],
            [
                'category_slug' => 'gaming-mouse',
                'name'          => 'Pulsar Pro Series Susanto-X 2.0 Medium',
                'slug'          => 'pulsar-pro-series-susanto-x-2-0-medium',
                'price'         => 2750000,
                'stock'         => 10,
                'badge'         => 'Pro Choice',
                'status'        => 'tersedia',
                'image_base'    => 'pulsar-susanto-x-2',
                'description'   => 'Mouse esports edisi kolaborasi Pro Series seberat 51 gram dengan sensor flagship Pulsar XS-2 hingga 42.000 DPI dan dukungan polling rate 8000Hz untuk claw & relaxed claw grip.',
                'specs'         => json_encode([
                    'Sensor'       => 'Pulsar XS-2 (Up to 42.000 DPI)',
                    'Bobot'        => '51 gram (Medium)',
                    'Polling Rate' => 'Up to 8000Hz Wireless',
                    'Grip Style'   => 'Claw / Relaxed Claw',
                ]),
            ],
            [
                'category_slug' => 'audio-headset',
                'name'          => 'HyperX Cloud III Wireless',
                'slug'          => 'hyperx-cloud-iii-wireless',
                'price'         => 2499000,
                'stock'         => 9,
                'badge'         => 'New',
                'status'        => 'tersedia',
                'image_base'    => 'hyperx-cloud-3-wireless',
                'description'   => 'Headset gaming nirkabel 2.4GHz dengan daya tahan baterai hingga 120 jam, driver 53mm angled, dukungan DTS Headphone:X Spatial Audio, dan mikrofon 10mm yang bisa dilepas.',
                'specs'         => json_encode([
                    'Driver'       => '53mm Angled Neodymium',
                    'Konektivitas' => '2.4GHz Wireless Dongle USB-C',
                    'Daya Tahan'   => 'Hingga 120 Jam',
                    'Fitur Audio'  => 'DTS Headphone:X Spatial Audio',
                ]),
            ],
            [
                'category_slug' => 'mechanical-keyboard',
                'name'          => 'Wooting 60HE+ Rapid Trigger',
                'slug'          => 'wooting-60he-plus-rapid-trigger',
                'price'         => 4469000,
                'stock'         => 5,
                'badge'         => 'Esports',
                'status'        => 'tersedia',
                'image_base'    => 'wooting-60he-plus',
                'description'   => 'Keyboard kompetitif 60% dengan switch magnetik Hall Effect Lekker, fitur Rapid Trigger, aktuasi analog yang dapat dikustomisasi lewat Wootility, dan screw-in stabilizers.',
                'specs'         => json_encode([
                    'Layout'       => '60% ANSI Compact (61 Keys)',
                    'Switch'       => 'Lekker Linear60 Magnetic (Hall Effect)',
                    'Fitur Utama'  => 'Rapid Trigger & Adjustable Actuation',
                    'Konektivitas' => 'Wired USB-C (Detachable)',
                ]),
            ],
            [
                'category_slug' => 'desk-accessories',
                'name'          => 'Artisan Ninja FX Zero Soft XL',
                'slug'          => 'artisan-ninja-fx-zero-soft-xl',
                'price'         => 1347000,
                'stock'         => 14,
                'badge'         => 'Popular',
                'status'        => 'tersedia',
                'image_base'    => 'artisan-fx-zero-xl',
                'description'   => 'Mousepad esports buatan Jepang berukuran XL dengan permukaan polyester rajut yang seimbang antara glide halus dan stopping power presisi, serta alas anti-slip poron.',
                'specs'         => json_encode([
                    'Dimensi'   => '490 x 420 x 4 mm (XL)',
                    'Permukaan' => 'Circular Knitting Polyester (Balanced)',
                    'Hardness'  => 'Soft (Special Foamed Poron)',
                    'Alas'      => 'Anti-Slip Sucker Structure',
                ]),
            ],
            [
                'category_slug' => 'audio-headset',
                'name'          => 'HyperX QuadCast S RGB USB',
                'slug'          => 'hyperx-quadcast-s-rgb-usb',
                'price'         => 2550000,
                'stock'         => 12,
                'badge'         => 'Streamer',
                'status'        => 'tersedia',
                'image_base'    => 'hyperx-quadcast-s',
                'description'   => 'Mikrofon kondensor USB dengan pencahayaan RGB dinamis, empat pola kutub yang bisa dipilih, sensor tap-to-mute berindikator LED, pop filter internal, dan shock mount bawaan.',
                'specs'         => json_encode([
                    'Polar Pattern' => 'Cardioid, Stereo, Omni, Bi-directional',
                    'Kapsul'        => '3x 14mm Electret Condenser',
                    'Fitur'         => 'Tap-to-Mute LED + Gain Control Dial',
                    'Interface'     => 'USB-C & 3.5mm Headphone Monitor',
                ]),
            ],
            [
                'category_slug' => 'desk-accessories',
                'name'          => 'BenQ ScreenBar Pro LED',
                'slug'          => 'benq-screenbar-pro-led',
                'price'         => 3425000,
                'stock'         => 8,
                'badge'         => 'Setup Essential',
                'status'        => 'tersedia',
                'image_base'    => 'benq-screenbar-pro',
                'description'   => 'Lampu monitor LED dengan optik asimetris bebas pantulan layar, sensor gerak ultrasonik otomatis nyala/mati, auto-dimming, serta kompatibel dengan layar datar maupun melengkung.',
                'specs'         => json_encode([
                    'Optik'      => 'Asymmetric Anti-Glare Lighting',
                    'Suhu Warna' => '2700K – 6500K (CRI Ra > 95)',
                    'Sensor'     => 'Ultrasonic Motion & Ambient Light',
                    'Daya'       => 'USB-C + Patented Monitor Clamp',
                ]),
            ],
            [
                'category_slug' => 'gaming-mouse',
                'name'          => 'Logitech G PRO X SUPERLIGHT 2',
                'slug'          => 'logitech-g-pro-x-superlight-2',
                'price'         => 2358000,
                'stock'         => 0,
                'badge'         => 'Stok Habis',
                'status'        => 'tersedia',
                'image_base'    => 'logitech-gpx-superlight-2',
                'description'   => 'Mouse gaming nirkabel ikonik esports berbobot 60 gram dengan sensor HERO 2 hingga 44.000 DPI, switch hybrid optical-mechanical LIGHTFORCE, dan baterai hingga 95 jam.',
                'specs'         => json_encode([
                    'Sensor'  => 'HERO 2 (100 – 44.000 DPI)',
                    'Bobot'   => '60 gram',
                    'Switch'  => 'LIGHTFORCE Hybrid Optical-Mechanical',
                    'Baterai' => 'Hingga 95 Jam (USB-C)',
                ]),
            ],
            [
                'category_slug' => 'desk-accessories',
                'name'          => 'Elgato Stream Deck MK.2',
                'slug'          => 'elgato-stream-deck-mk-2',
                'price'         => 2499000,
                'stock'         => 7,
                'badge'         => 'Creator Pick',
                'status'        => 'tersedia',
                'image_base'    => 'elgato-stream-deck-mk2',
                'description'   => 'Kontroler meja dengan 15 tombol LCD yang dapat dikustomisasi untuk shortcut game, OBS, Discord, kontrol audio, hingga makro produktivitas, lengkap dengan stand miring 45° dan kabel USB-C lepas-pasang.',
                'specs'         => json_encode([
                    'Tombol'         => '15 Customizable LCD Keys',
                    'Konektivitas'   => 'USB-C to USB-A (Detachable)',
                    'Dimensi'        => '118 x 84 x 25 mm',
                    'Kompatibilitas' => 'Windows & macOS',
                ]),
            ],
            [
                'category_slug' => 'gaming-mouse',
                'name'          => 'Razer Viper V3 Pro Wireless',
                'slug'          => 'razer-viper-v3-pro-wireless',
                'price'         => 2599000,
                'stock'         => 11,
                'badge'         => 'Pro Flagship',
                'status'        => 'tersedia',
                'image_base'    => 'razer-viper-v3-pro',
                'description'   => 'Mouse gaming esports nirkabel ultra-ringan berbobot 54 gram dengan sensor optik Focus Pro 35K Gen-2, Optical Mouse Switches Gen-3, dan HyperPolling 8000Hz Wireless Dongle bawaan untuk respons kompetitif tanpa delay.',
                'specs'         => json_encode([
                    'Sensor'       => 'Razer Focus Pro 35K Optical Gen-2',
                    'Bobot'        => '54 gram (Symmetrical)',
                    'Polling Rate' => 'True 8000Hz Wireless (Dongle Included)',
                    'Baterai'      => 'Hingga 95 Jam (USB-C)',
                ]),
            ],
        ];

        foreach ($products as $item) {
            $exists = $this->db->table('products')->where('slug', $item['slug'])->countAllResults();
            if ($exists > 0) {
                continue;
            }

            $categoryId = $catMap[$item['category_slug']] ?? null;
            if (!$categoryId) {
                continue;
            }

            $imageBase = $item['image_base'];
            unset($item['category_slug'], $item['image_base']);

            $item['id_category'] = $categoryId;
            $item['created_at']  = $now;
            $item['updated_at']  = $now;

            $this->db->table('products')->insert($item);
            $productId = $this->db->insertID();

            // Deteksi otomatis file gambar di public/uploads/products/
            $foundFiles = [];
            foreach (['', '-2', '-3'] as $suffix) {
                foreach (['png', 'webp', 'jpg', 'jpeg'] as $ext) {
                    $fileName = $imageBase . $suffix . '.' . $ext;
                    if (is_file(FCPATH . 'uploads/products/' . $fileName)) {
                        $foundFiles[] = $fileName;
                        break;
                    }
                }
            }

            foreach ($foundFiles as $idx => $fileName) {
                $this->db->table('product_images')->insert([
                    'id_product' => $productId,
                    'image'      => $fileName,
                    'is_primary' => $idx === 0 ? 1 : 0,
                    'created_at' => $now,
                ]);
            }
        }
    }
}