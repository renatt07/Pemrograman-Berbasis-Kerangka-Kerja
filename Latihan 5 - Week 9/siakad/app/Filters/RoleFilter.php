<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = session()->get('role');
        if (! empty($arguments) && ! in_array($userRole, $arguments, true)) {
            $target = match ($userRole) {
                'admin'     => '/admin/dashboard',
                'dosen'     => '/dosen/dashboard',
                'mahasiswa' => '/mahasiswa/dashboard',
                default     => '/login',
            };

            return redirect()->to($target)->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk halaman tersebut.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu aksi setelah request
    }
}