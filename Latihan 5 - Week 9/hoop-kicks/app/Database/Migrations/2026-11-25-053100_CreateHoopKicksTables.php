<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHoopKicksTables extends Migration
{
    public function up()
    {
        // 1. Tabel users
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
            'phone'      => ['type' => 'VARCHAR', 'constraint' => 25, 'null' => true],
            'address'    => ['type' => 'TEXT', 'null' => true],
            'password'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'role'       => ['type' => 'ENUM', 'constraint' => ['admin', 'customer'], 'default' => 'customer'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');

        // 2. Tabel categories
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 80],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
            'description' => ['type' => 'TEXT', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('categories');

        // 3. Tabel products
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'category_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'sku'         => ['type' => 'VARCHAR', 'constraint' => 40, 'unique' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 170, 'unique' => true],
            'brand'       => ['type' => 'VARCHAR', 'constraint' => 60],
            'colorway'    => ['type' => 'VARCHAR', 'constraint' => 100],
            'court_type'  => ['type' => 'ENUM', 'constraint' => ['Indoor', 'Outdoor', 'All-Court'], 'default' => 'All-Court'],
            'price'       => ['type' => 'INT', 'constraint' => 11],
            'stock'       => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'sizes'       => ['type' => 'VARCHAR', 'constraint' => 100, 'default' => '40,41,42,43,44,45'],
            'description' => ['type' => 'TEXT', 'null' => true],
            'image'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'is_featured' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('products');

        // 4. Tabel orders
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'order_code'       => ['type' => 'VARCHAR', 'constraint' => 40, 'unique' => true],
            'user_id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'recipient_name'   => ['type' => 'VARCHAR', 'constraint' => 100],
            'phone'            => ['type' => 'VARCHAR', 'constraint' => 25],
            'shipping_address' => ['type' => 'TEXT'],
            'payment_method'   => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'Transfer Bank'],
            'total_price'      => ['type' => 'INT', 'constraint' => 11],
            'status'           => ['type' => 'ENUM', 'constraint' => ['pending', 'paid', 'shipped', 'completed', 'cancelled'], 'default' => 'pending'],
            'notes'            => ['type' => 'TEXT', 'null' => true],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('orders');

        // 5. Tabel order_items
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'order_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'product_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'product_name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'shoe_size'    => ['type' => 'VARCHAR', 'constraint' => 10],
            'price'        => ['type' => 'INT', 'constraint' => 11],
            'quantity'     => ['type' => 'INT', 'constraint' => 11],
            'subtotal'     => ['type' => 'INT', 'constraint' => 11],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('order_items');
    }

    public function down()
    {
        $this->forge->dropTable('order_items', true);
        $this->forge->dropTable('orders', true);
        $this->forge->dropTable('products', true);
        $this->forge->dropTable('categories', true);
        $this->forge->dropTable('users', true);
    }
}