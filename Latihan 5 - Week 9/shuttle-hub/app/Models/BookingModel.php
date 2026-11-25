<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table            = 'bookings';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'user_id',
        'court_id',
        'booking_date',
        'start_time',
        'end_time',
        'duration',
        'total_price',
        'payment_proof',
        'status',
        'notes',
    ];

    // Ambil semua booking beserta nama user & nama lapangan (untuk Admin)
    public function getAllWithDetails()
    {
        return $this->select('bookings.*, users.name as customer_name, users.phone as customer_phone, courts.name as court_name, courts.floor_type')
            ->join('users', 'users.id = bookings.user_id')
            ->join('courts', 'courts.id = bookings.court_id')
            ->orderBy('bookings.created_at', 'DESC')
            ->findAll();
    }

    // Ambil riwayat booking milik 1 pelanggan tertentu
    public function getByUser(int $userId)
    {
        return $this->select('bookings.*, courts.name as court_name, courts.floor_type, courts.image as court_image')
            ->join('courts', 'courts.id = bookings.court_id')
            ->where('bookings.user_id', $userId)
            ->orderBy('bookings.created_at', 'DESC')
            ->findAll();
    }

    // Cek bentrok jadwal di lapangan & tanggal yang sama
    public function isSlotBooked(int $courtId, string $date, string $startTime, string $endTime): bool
    {
        return $this->where('court_id', $courtId)
            ->where('booking_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('start_time <', $endTime)
            ->where('end_time >', $startTime)
            ->countAllResults() > 0;
    }
}