<?php

namespace App\Libraries;

class DummyCatalog
{
    /**
     * Cek otomatis gambar lokal di public/uploads/products/ (.webp/.jpg/.jpeg/.png).
     * Jika belum ada, gunakan placeholder agar halaman tetap rapi.
     */
    private static function resolveImage(string $baseName, string $fallbackText, string $accentHex = '00e5ff'): string
    {
        foreach (['webp', 'jpg', 'jpeg', 'png'] as $ext) {
            $relativePath = 'uploads/products/' . $baseName . '.' . $ext;
            if (is_file(FCPATH . $relativePath)) {
                return base_url($relativePath);
            }
        }

        return 'https://placehold.co/600x450/111827/' . $accentHex . '?text=' . rawurlencode($fallbackText);
    }

    /**
     * Ambil foto utama + foto tambahan (-2, -3) jika tersedia di folder uploads.
     */
    private static function resolveGallery(string $baseName, string $fallbackText, string $accentHex = '00e5ff'): array
    {
        $images = [self::resolveImage($baseName, $fallbackText, $accentHex)];

        foreach ([2, 3] as $index) {
            foreach (['webp', 'jpg', 'jpeg', 'png'] as $ext) {
                $relativePath = 'uploads/products/' . $baseName . '-' . $index . '.' . $ext;
                if (is_file(FCPATH . $relativePath)) {
                    $images[] = base_url($relativePath);
                    break;
                }
            }
        }

        return $images;
    }

    public static function categories(): array
    {
        return [
            [
                'id'          => 1,
                'name'        => 'Mechanical Keyboard',
                'slug'        => 'mechanical-keyboard',
                'icon'        => 'bi-keyboard',
                'description' => 'Gasket mount custom, hot-swap, hingga Rapid Trigger Hall Effect.'
            ],
            [
                'id'          => 2,
                'name'        => 'Gaming Mouse',
                'slug'        => 'gaming-mouse',
                'icon'        => 'bi-mouse2',
                'description' => 'Bobot ultralight esports, sensor flagship, & polling rate 8000Hz.'
            ],
            [
                'id'          => 3,
                'name'        => 'Audio & Headset',
                'slug'        => 'audio-headset',
                'icon'        => 'bi-headset',
                'description' => 'Headset nirkabel low-latency & mikrofon kondensor jernih.'
            ],
            [
                'id'          => 4,
                'name'        => 'Desk & Accessories',
                'slug'        => 'desk-accessories',
                'icon'        => 'bi-pc-display',
                'description' => 'Mousepad pro-grade Jepang dan monitor lightbar anti-silau.'
            ],
        ];
    }

    public static function products(): array
    {
        return [
            [
                'id'            => 1,
                'category_id'   => 1,
                'category_name' => 'Mechanical Keyboard',
                'category_slug' => 'mechanical-keyboard',
                'name'          => 'AULA F75 Tri-Mode Gasket',
                'price'         => 849000,
                'stock'         => 15,
                'badge'         => 'Best Seller',
                'image'         => self::resolveImage('aula-f75', 'AULA F75 75%', '00e5ff'),
                'gallery'       => self::resolveGallery('aula-f75', 'AULA F75 75%', '00e5ff'),
                'description'   => 'Keyboard mekanikal 75% (80 tombol) dengan leaf-spring gasket mount, 5 lapis peredam suara, keycap PBT double-shot, knob multifungsi metal, dan konektivitas tri-mode.',
                'specs'         => [
                    'Layout'       => '75% Compact (80 Keys + Metal Knob)',
                    'Switch'       => 'LEOBOG Reaper Linear (Hot-Swap 3/5-Pin)',
                    'Konektivitas' => '2.4GHz Wireless / Bluetooth / USB-C',
                    'Baterai'      => '4000 mAh',
                ],
            ],
            [
                'id'            => 2,
                'category_id'   => 2,
                'category_name' => 'Gaming Mouse',
                'category_slug' => 'gaming-mouse',
                'name'          => 'Pulsar Pro Series Susanto-X 2.0 Medium',
                'price'         => 2750000,
                'stock'         => 10,
                'badge'         => 'Pro Choice',
                'image'         => self::resolveImage('pulsar-susanto-x-2', 'Pulsar Susanto-X 2.0', '818cf8'),
                'gallery'       => self::resolveGallery('pulsar-susanto-x-2', 'Pulsar Susanto-X 2.0', '818cf8'),
                'description'   => 'Mouse esports edisi kolaborasi Pro Series seberat 51 gram dengan sensor flagship Pulsar XS-2 hingga 42.000 DPI dan dukungan polling rate 8000Hz untuk claw & relaxed claw grip.',
                'specs'         => [
                    'Sensor'       => 'Pulsar XS-2 (Up to 42.000 DPI)',
                    'Bobot'        => '51 gram (Medium)',
                    'Polling Rate' => 'Up to 8000Hz Wireless',
                    'Grip Style'   => 'Claw / Relaxed Claw',
                ],
            ],
            [
                'id'            => 3,
                'category_id'   => 3,
                'category_name' => 'Audio & Headset',
                'category_slug' => 'audio-headset',
                'name'          => 'HyperX Cloud III Wireless',
                'price'         => 2499000,
                'stock'         => 9,
                'badge'         => 'New',
                'image'         => self::resolveImage('hyperx-cloud-3-wireless', 'HyperX Cloud III Wireless', '34d399'),
                'gallery'       => self::resolveGallery('hyperx-cloud-3-wireless', 'HyperX Cloud III Wireless', '34d399'),
                'description'   => 'Headset gaming nirkabel 2.4GHz dengan daya tahan baterai hingga 120 jam, driver 53mm angled, dukungan DTS Headphone:X Spatial Audio, dan mikrofon 10mm yang bisa dilepas.',
                'specs'         => [
                    'Driver'       => '53mm Angled Neodymium',
                    'Konektivitas' => '2.4GHz Wireless Dongle USB-C',
                    'Daya Tahan'   => 'Hingga 120 Jam',
                    'Fitur Audio'  => 'DTS Headphone:X Spatial Audio',
                ],
            ],
            [
                'id'            => 4,
                'category_id'   => 1,
                'category_name' => 'Mechanical Keyboard',
                'category_slug' => 'mechanical-keyboard',
                'name'          => 'Wooting 60HE+ Rapid Trigger',
                'price'         => 4469000,
                'stock'         => 5,
                'badge'         => 'Esports',
                'image'         => self::resolveImage('wooting-60he-plus', 'Wooting 60HE+', 'f43f5e'),
                'gallery'       => self::resolveGallery('wooting-60he-plus', 'Wooting 60HE+', 'f43f5e'),
                'description'   => 'Keyboard kompetitif 60% dengan switch magnetik Hall Effect Lekker, fitur Rapid Trigger, aktuasi analog yang dapat dikustomisasi lewat Wootility, dan screw-in stabilizers.',
                'specs'         => [
                    'Layout'       => '60% ANSI Compact (61 Keys)',
                    'Switch'       => 'Lekker Linear60 Magnetic (Hall Effect)',
                    'Fitur Utama'  => 'Rapid Trigger & Adjustable Actuation',
                    'Konektivitas' => 'Wired USB-C (Detachable)',
                ],
            ],
            [
                'id'            => 5,
                'category_id'   => 4,
                'category_name' => 'Desk & Accessories',
                'category_slug' => 'desk-accessories',
                'name'          => 'Artisan Ninja FX Zero Soft XL',
                'price'         => 1347000,
                'stock'         => 14,
                'badge'         => 'Popular',
                'image'         => self::resolveImage('artisan-fx-zero-xl', 'Artisan FX Zero XL', '38bdf8'),
                'gallery'       => self::resolveGallery('artisan-fx-zero-xl', 'Artisan FX Zero XL', '38bdf8'),
                'description'   => 'Mousepad esports buatan Jepang berukuran XL dengan permukaan polyester rajut yang seimbang antara glide halus dan stopping power presisi, serta alas anti-slip poron.',
                'specs'         => [
                    'Dimensi'    => '490 x 420 x 4 mm (XL)',
                    'Permukaan'  => 'Circular Knitting Polyester (Balanced)',
                    'Hardness'   => 'Soft (Special Foamed Poron)',
                    'Alas'       => 'Anti-Slip Sucker Structure',
                ],
            ],
            [
                'id'            => 6,
                'category_id'   => 3,
                'category_name' => 'Audio & Headset',
                'category_slug' => 'audio-headset',
                'name'          => 'HyperX QuadCast S RGB USB',
                'price'         => 2550000,
                'stock'         => 12,
                'badge'         => 'Streamer',
                'image'         => self::resolveImage('hyperx-quadcast-s', 'HyperX QuadCast S', 'a78bfa'),
                'gallery'       => self::resolveGallery('hyperx-quadcast-s', 'HyperX QuadCast S', 'a78bfa'),
                'description'   => 'Mikrofon kondensor USB dengan pencahayaan RGB dinamis, empat pola kutub yang bisa dipilih, sensor tap-to-mute berindikator LED, pop filter internal, dan shock mount bawaan.',
                'specs'         => [
                    'Polar Pattern' => 'Cardioid, Stereo, Omni, Bi-directional',
                    'Kapsul'        => '3x 14mm Electret Condenser',
                    'Fitur'         => 'Tap-to-Mute LED + Gain Control Dial',
                    'Interface'     => 'USB-C & 3.5mm Headphone Monitor',
                ],
            ],
            [
                'id'            => 7,
                'category_id'   => 4,
                'category_name' => 'Desk & Accessories',
                'category_slug' => 'desk-accessories',
                'name'          => 'BenQ ScreenBar Pro LED',
                'price'         => 3425000,
                'stock'         => 8,
                'badge'         => 'Setup Essential',
                'image'         => self::resolveImage('benq-screenbar-pro', 'BenQ ScreenBar Pro', 'fbbf24'),
                'gallery'       => self::resolveGallery('benq-screenbar-pro', 'BenQ ScreenBar Pro', 'fbbf24'),
                'description'   => 'Lampu monitor LED dengan optik asimetris bebas pantulan layar, sensor gerak ultrasonik otomatis nyala/mati, auto-dimming, serta kompatibel dengan layar datar maupun melengkung.',
                'specs'         => [
                    'Optik'      => 'Asymmetric Anti-Glare Lighting',
                    'Suhu Warna' => '2700K – 6500K (CRI Ra > 95)',
                    'Sensor'     => 'Ultrasonic Motion & Ambient Light',
                    'Daya'       => 'USB-C + Patented Monitor Clamp',
                ],
            ],
            [
                'id'            => 8,
                'category_id'   => 2,
                'category_name' => 'Gaming Mouse',
                'category_slug' => 'gaming-mouse',
                'name'          => 'Logitech G PRO X SUPERLIGHT 2',
                'price'         => 2358000,
                'stock'         => 0,
                'badge'         => 'Stok Habis',
                'image'         => self::resolveImage('logitech-gpx-superlight-2', 'Logitech GPX 2', '9ca3af'),
                'gallery'       => self::resolveGallery('logitech-gpx-superlight-2', 'Logitech GPX 2', '9ca3af'),
                'description'   => 'Mouse gaming nirkabel ikonik esports berbobot 60 gram dengan sensor HERO 2 hingga 44.000 DPI, switch hybrid optical-mechanical LIGHTFORCE, dan baterai hingga 95 jam.',
                'specs'         => [
                    'Sensor'       => 'HERO 2 (100 – 44.000 DPI)',
                    'Bobot'        => '60 gram',
                    'Switch'       => 'LIGHTFORCE Hybrid Optical-Mechanical',
                    'Baterai'      => 'Hingga 95 Jam (USB-C)',
                ],
            ],
        ];
    }

    public static function findProduct(int $id): ?array
    {
        foreach (self::products() as $product) {
            if ($product['id'] === $id) {
                return $product;
            }
        }

        return null;
    }
}