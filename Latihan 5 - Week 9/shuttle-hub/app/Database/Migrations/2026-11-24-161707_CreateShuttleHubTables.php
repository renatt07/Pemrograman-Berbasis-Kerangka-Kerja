<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateShuttleHubTables extends Migration
{
    public function up()
    {
        // 1. Tabel users
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
            'phone'      => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'password'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'role'       => ['type' => 'ENUM', 'constraint' => ['admin', 'customer'], 'default' => 'customer'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');

        // 2. Tabel courts (lapangan)
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'           => ['type' => 'VARCHAR', 'constraint' => 100],
            'floor_type'     => ['type' => 'VARCHAR', 'constraint' => 50],
            'price_per_hour' => ['type' => 'INT', 'constraint' => 11],
            'description'    => ['type' => 'TEXT', 'null' => true],
            'image'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status'         => ['type' => 'ENUM', 'constraint' => ['available', 'maintenance'], 'default' => 'available'],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('courts');

        // 3. Tabel bookings (pemesanan)
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'court_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'booking_date'  => ['type' => 'DATE'],
            'start_time'    => ['type' => 'TIME'],
            'end_time'      => ['type' => 'TIME'],
            'duration'      => ['type' => 'INT', 'constraint' => 2],
            'total_price'   => ['type' => 'INT', 'constraint' => 11],
            'payment_proof' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status'        => ['type' => 'ENUM', 'constraint' => ['pending', 'confirmed', 'completed', 'cancelled'], 'default' => 'pending'],
            'notes'         => ['type' => 'TEXT', 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('court_id', 'courts', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('bookings');
    }

    public function down()
    {
        $this->forge->dropTable('bookings', true);
        $this->forge->dropTable('courts', true);
        $this->forge->dropTable('users', true);
    }
}