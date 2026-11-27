<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id_product';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_category', 'name', 'slug', 'description',
        'specs', 'price', 'stock', 'badge', 'status',
    ];
    protected $useTimestamps    = true;

    public function attachImages(array $products): array
    {
        if (empty($products)) {
            return [];
        }

        $ids = array_column($products, 'id_product');
        $imageModel = new ProductImageModel();
        $rows = $imageModel->whereIn('id_product', $ids)
            ->orderBy('is_primary', 'DESC')
            ->orderBy('id_image', 'ASC')
            ->findAll();

        $grouped = [];
        foreach ($rows as $img) {
            $grouped[$img['id_product']][] = base_url('uploads/products/' . $img['image']);
        }

        foreach ($products as &$product) {
            $pid = $product['id_product'];
            if (!empty($grouped[$pid])) {
                $product['image_url'] = $grouped[$pid][0];
                $product['gallery']   = $grouped[$pid];
            } else {
                $fallback = 'https://placehold.co/600x450/111827/00e5ff?text=' . rawurlencode($product['name']);
                $product['image_url'] = $fallback;
                $product['gallery']   = [$fallback];
            }

            $decoded = json_decode((string) ($product['specs'] ?? ''), true);
            $product['specs_array'] = is_array($decoded) ? $decoded : [];
        }

        return $products;
    }
}