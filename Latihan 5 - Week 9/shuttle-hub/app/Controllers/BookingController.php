<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\CourtModel;

class BookingController extends BaseController
{
    protected $courtModel;
    protected $bookingModel;

    public function __construct()
    {
        $this->courtModel   = new CourtModel();
        $this->bookingModel = new BookingModel();
    }

    public function create(int $courtId)
    {
        $court = $this->courtModel->find($courtId);
        if (! $court || $court['status'] !== 'available') {
            return redirect()->to('/')->with('error', 'Lapangan tidak ditemukan atau sedang maintenance.');
        }

        return view('bookings/create', [
            'title' => 'Booking ' . $court['name'],
            'court' => $court,
        ]);
    }

    public function store()
    {
        $rules = [
            'court_id'     => 'required|integer',
            'booking_date' => 'required|valid_date[Y-m-d]',
            'start_hour'   => 'required|integer|greater_than_equal_to[7]|less_than_equal_to[21]',
            'duration'     => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[4]',
        ];

        $proofFile = $this->request->getFile('payment_proof');
        if ($proofFile && $proofFile->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['payment_proof'] = 'uploaded[payment_proof]|max_size[payment_proof,2048]|is_image[payment_proof]|mime_in[payment_proof,image/jpg,image/jpeg,image/png,image/webp]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $courtId     = (int) $this->request->getPost('court_id');
        $bookingDate = $this->request->getPost('booking_date');
        $startHour   = (int) $this->request->getPost('start_hour');
        $duration    = (int) $this->request->getPost('duration');
        $endHour     = $startHour + $duration;

        if ($bookingDate < date('Y-m-d')) {
            return redirect()->back()->withInput()->with('error', 'Tanggal booking tidak boleh sebelum hari ini.');
        }

        if ($endHour > 22) {
            return redirect()->back()->withInput()->with('error', 'Jam operasional GOR sampai 22:00. Kurangi durasi atau pilih jam mulai lebih awal.');
        }

        $court = $this->courtModel->find($courtId);
        if (! $court || $court['status'] !== 'available') {
            return redirect()->to('/')->with('error', 'Lapangan tidak tersedia.');
        }

        $startTime = sprintf('%02d:00:00', $startHour);
        $endTime   = sprintf('%02d:00:00', $endHour);

        // Cek bentrok jadwal
        if ($this->bookingModel->isSlotBooked($courtId, $bookingDate, $startTime, $endTime)) {
            return redirect()->back()->withInput()->with('error', 'Jadwal pada jam tersebut sudah dibooking. Silakan pilih jam atau lapangan lain.');
        }

        // Proses upload bukti bayar (jika langsung diunggah)
        $proofName = null;
        if ($proofFile && $proofFile->isValid() && ! $proofFile->hasMoved()) {
            $uploadDir = FCPATH . 'uploads/payments';
            if (! is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $proofName = $proofFile->getRandomName();
            $proofFile->move($uploadDir, $proofName);
        }

        $totalPrice = $court['price_per_hour'] * $duration;

        $this->bookingModel->save([
            'user_id'       => session()->get('user_id'),
            'court_id'      => $courtId,
            'booking_date'  => $bookingDate,
            'start_time'    => $startTime,
            'end_time'      => $endTime,
            'duration'      => $duration,
            'total_price'   => $totalPrice,
            'payment_proof' => $proofName,
            'status'        => 'pending',
            'notes'         => $this->request->getPost('notes'),
        ]);

        return redirect()->to('/my-bookings')->with('success', 'Booking berhasil dibuat! Menunggu verifikasi admin.');
    }

    public function myBookings()
    {
        $userId = (int) session()->get('user_id');

        return view('bookings/my_bookings', [
            'title'    => 'Booking Saya',
            'bookings' => $this->bookingModel->getByUser($userId),
        ]);
    }

    public function uploadPayment(int $id)
    {
        $booking = $this->bookingModel->find($id);
        if (! $booking || (int) $booking['user_id'] !== (int) session()->get('user_id')) {
            return redirect()->to('/my-bookings')->with('error', 'Data booking tidak ditemukan.');
        }

        if ($booking['status'] !== 'pending') {
            return redirect()->to('/my-bookings')->with('error', 'Bukti pembayaran hanya bisa diunggah untuk booking berstatus Pending.');
        }

        $rules = [
            'payment_proof' => 'uploaded[payment_proof]|max_size[payment_proof,2048]|is_image[payment_proof]|mime_in[payment_proof,image/jpg,image/jpeg,image/png,image/webp]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to('/my-bookings')->with('errors', $this->validator->getErrors());
        }

        $proofFile = $this->request->getFile('payment_proof');
        $uploadDir = FCPATH . 'uploads/payments';
        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (! empty($booking['payment_proof']) && is_file($uploadDir . '/' . $booking['payment_proof'])) {
            unlink($uploadDir . '/' . $booking['payment_proof']);
        }

        $proofName = $proofFile->getRandomName();
        $proofFile->move($uploadDir, $proofName);

        $this->bookingModel->update($id, ['payment_proof' => $proofName]);

        return redirect()->to('/my-bookings')->with('success', 'Bukti pembayaran untuk booking #' . $id . ' berhasil diunggah.');
    }

    public function cancel(int $id)
    {
        $booking = $this->bookingModel->find($id);
        if (! $booking || (int) $booking['user_id'] !== (int) session()->get('user_id')) {
            return redirect()->to('/my-bookings')->with('error', 'Data booking tidak ditemukan.');
        }

        if ($booking['status'] !== 'pending') {
            return redirect()->to('/my-bookings')->with('error', 'Hanya booking berstatus Pending yang dapat dibatalkan.');
        }

        $this->bookingModel->update($id, ['status' => 'cancelled']);

        return redirect()->to('/my-bookings')->with('success', 'Booking #' . $id . ' berhasil dibatalkan.');
    }
}