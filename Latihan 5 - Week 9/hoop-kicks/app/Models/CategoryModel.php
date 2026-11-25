<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table         = 'categories';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = ['name', 'slug', 'description'];

    public function getAllWithProductCount()
    {
        return $this->select('categories.*, (SELECT COUNT(*) FROM products WHERE products.category_id = categories.id) as product_count', false)
            ->orderBy('categories.name', 'ASC')
            ->findAll();
    }
}