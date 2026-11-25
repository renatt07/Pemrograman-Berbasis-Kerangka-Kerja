<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingModel;

class BookingController extends BaseController
{
    protected $bookingModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
    }

    public function index()
    {
        return view('admin/bookings/index', [
            'title'    => 'Kelola Booking',
            'bookings' => $this->bookingModel->getAllWithDetails(),
        ]);
    }

    public function updateStatus(int $id)
    {
        $booking = $this->bookingModel->find($id);
        if (! $booking) {
            return redirect()->to('/admin/bookings')->with('error', 'Data booking tidak ditemukan.');
        }

        $status = $this->request->getPost('status');
        if (! in_array($status, ['pending', 'confirmed', 'completed', 'cancelled'], true)) {
            return redirect()->to('/admin/bookings')->with('error', 'Status tidak valid.');
        }

        $this->bookingModel->update($id, ['status' => $status]);

        return redirect()->to('/admin/bookings')->with('success', 'Status booking #' . $id . ' diperbarui menjadi ' . strtoupper($status) . '.');
    }
}