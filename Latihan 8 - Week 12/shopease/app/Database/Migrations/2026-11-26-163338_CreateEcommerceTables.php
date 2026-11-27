<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEcommerceTables extends Migration
{
    public function up()
    {
        // 1. Tabel categories
        $this->forge->addField([
            'id_category' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 120, 'unique' => true],
            'icon'        => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'bi-box-seam'],
            'description' => ['type' => 'TEXT', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_category', true);
        $this->forge->createTable('categories', true);

        // 2. Tabel products
        $this->forge->addField([
            'id_product'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_category' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 180, 'unique' => true],
            'description' => ['type' => 'TEXT', 'null' => true],
            'specs'       => ['type' => 'TEXT', 'null' => true],
            'price'       => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'stock'       => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'badge'       => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'status'      => ['type' => 'ENUM', 'constraint' => ['tersedia', 'tidak_tersedia'], 'default' => 'tersedia'],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_product', true);
        $this->forge->addForeignKey('id_category', 'categories', 'id_category', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('products', true);

        // 3. Tabel product_images
        $this->forge->addField([
            'id_image'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_product' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'image'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'is_primary' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_image', true);
        $this->forge->addForeignKey('id_product', 'products', 'id_product', 'CASCADE', 'CASCADE');
        $this->forge->createTable('product_images', true);

        // 4. Tabel carts
        $this->forge->addField([
            'id_cart'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_user'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_cart', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('carts', true);

        // 5. Tabel cart_items
        $this->forge->addField([
            'id_cart_item' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_cart'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_product'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'quantity'     => ['type' => 'INT', 'constraint' => 11, 'default' => 1],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_cart_item', true);
        $this->forge->addUniqueKey(['id_cart', 'id_product']);
        $this->forge->addForeignKey('id_cart', 'carts', 'id_cart', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_product', 'products', 'id_product', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cart_items', true);

        // 6. Tabel orders
        $this->forge->addField([
            'id_order'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_user'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'order_number'     => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'recipient_name'   => ['type' => 'VARCHAR', 'constraint' => 100],
            'phone'            => ['type' => 'VARCHAR', 'constraint' => 25],
            'shipping_address' => ['type' => 'TEXT'],
            'notes'            => ['type' => 'TEXT', 'null' => true],
            'subtotal'         => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'shipping_cost'    => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'total'            => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'order_status'     => [
                'type'       => 'ENUM',
                'constraint' => ['pending_payment', 'waiting_verification', 'processing', 'shipped', 'completed', 'cancelled'],
                'default'    => 'pending_payment',
            ],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_order', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('orders', true);

        // 7. Tabel order_items (menyimpan snapshot nama & harga produk)
        $this->forge->addField([
            'id_order_item' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_order'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_product'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'product_name'  => ['type' => 'VARCHAR', 'constraint' => 150],
            'price'         => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'quantity'      => ['type' => 'INT', 'constraint' => 11],
            'subtotal'      => ['type' => 'DECIMAL', 'constraint' => '12,2'],
        ]);
        $this->forge->addKey('id_order_item', true);
        $this->forge->addForeignKey('id_order', 'orders', 'id_order', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_product', 'products', 'id_product', 'CASCADE', 'SET NULL');
        $this->forge->createTable('order_items', true);

        // 8. Tabel payments
        $this->forge->addField([
            'id_payment'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_order'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'method'         => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'Transfer Bank'],
            'amount'         => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'proof_file'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'payment_status' => [
                'type'       => 'ENUM',
                'constraint' => ['unpaid', 'submitted', 'verified', 'rejected'],
                'default'    => 'unpaid',
            ],
            'verified_by'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'verified_at'    => ['type' => 'DATETIME', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_payment', true);
        $this->forge->addForeignKey('id_order', 'orders', 'id_order', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('verified_by', 'users', 'id_user', 'CASCADE', 'SET NULL');
        $this->forge->createTable('payments', true);

        // 9. Tabel shipments
        $this->forge->addField([
            'id_shipment'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_order'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'courier'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'tracking_number' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'shipment_status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'shipped', 'delivered'],
                'default'    => 'pending',
            ],
            'shipped_at'      => ['type' => 'DATETIME', 'null' => true],
            'delivered_at'    => ['type' => 'DATETIME', 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_shipment', true);
        $this->forge->addForeignKey('id_order', 'orders', 'id_order', 'CASCADE', 'CASCADE');
        $this->forge->createTable('shipments', true);
    }

    public function down()
    {
        $this->forge->dropTable('shipments', true);
        $this->forge->dropTable('payments', true);
        $this->forge->dropTable('order_items', true);
        $this->forge->dropTable('orders', true);
        $this->forge->dropTable('cart_items', true);
        $this->forge->dropTable('carts', true);
        $this->forge->dropTable('product_images', true);
        $this->forge->dropTable('products', true);
        $this->forge->dropTable('categories', true);
    }
}