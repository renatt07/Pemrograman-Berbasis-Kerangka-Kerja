<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table         = 'products';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'category_id',
        'sku',
        'name',
        'slug',
        'brand',
        'colorway',
        'court_type',
        'price',
        'stock',
        'sizes',
        'description',
        'image',
        'is_featured',
    ];

    public function getFiltered(?string $categorySlug = null, ?string $keyword = null, ?string $courtType = null, ?string $sort = null)
    {
        $builder = $this->select('products.*, categories.name as category_name, categories.slug as category_slug')
            ->join('categories', 'categories.id = products.category_id');

        if (! empty($categorySlug)) {
            $builder->where('categories.slug', $categorySlug);
        }

        if (! empty($courtType)) {
            $builder->where('products.court_type', $courtType);
        }

        if (! empty($keyword)) {
            $builder->groupStart()
                ->like('products.name', $keyword)
                ->orLike('products.brand', $keyword)
                ->orLike('products.colorway', $keyword)
                ->orLike('products.sku', $keyword)
                ->groupEnd();
        }

        match ($sort) {
            'price_asc'  => $builder->orderBy('products.price', 'ASC'),
            'price_desc' => $builder->orderBy('products.price', 'DESC'),
            default      => $builder->orderBy('products.is_featured', 'DESC')->orderBy('products.id', 'DESC'),
        };

        return $builder->findAll();
    }

    public function getBySlug(string $slug)
    {
        return $this->select('products.*, categories.name as category_name, categories.slug as category_slug')
            ->join('categories', 'categories.id = products.category_id')
            ->where('products.slug', $slug)
            ->first();
    }
}