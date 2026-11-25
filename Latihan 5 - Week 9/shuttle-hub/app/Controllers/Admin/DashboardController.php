<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\CourtModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $courtModel   = new CourtModel();
        $bookingModel = new BookingModel();
        $userModel    = new UserModel();

        $revenueRow = $bookingModel->selectSum('total_price')
            ->whereIn('status', ['confirmed', 'completed'])
            ->first();

        $allBookings = $bookingModel->getAllWithDetails();

        $data = [
            'title'          => 'Dashboard',
            'totalCourts'    => $courtModel->countAll(),
            'totalBookings'  => $bookingModel->countAll(),
            'pendingCount'   => $bookingModel->where('status', 'pending')->countAllResults(),
            'totalCustomers' => $userModel->where('role', 'customer')->countAllResults(),
            'totalRevenue'   => (int) ($revenueRow['total_price'] ?? 0),
            'recentBookings' => array_slice($allBookings, 0, 5),
        ];

        return view('admin/dashboard', $data);
    }
}