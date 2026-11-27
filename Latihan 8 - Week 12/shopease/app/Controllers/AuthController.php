<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // Menampilkan halaman registrasi
    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return $this->redirectByRole(session()->get('role'));
        }

        return view('auth/register', [
            'title'      => 'Registrasi Akun — ShopEase Gaming Gear',
            'activeMenu' => 'register',
        ]);
    }

    // Memproses penyimpanan akun baru (default role: customer)
    public function store()
    {
        $rules = [
            'name' => [
                'rules'  => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required'   => 'Nama lengkap wajib diisi.',
                    'min_length' => 'Nama minimal 3 karakter.',
                    'max_length' => 'Nama maksimal 100 karakter.',
                ],
            ],
            'email' => [
                'rules'  => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required'    => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique'   => 'Email sudah terdaftar.',
                ],
            ],
            'phone' => [
                'rules'  => 'permit_empty|max_length[20]',
                'errors' => [
                    'max_length' => 'Nomor telepon maksimal 20 karakter.',
                ],
            ],
            'password' => [
                'rules'  => 'required|min_length[8]',
                'errors' => [
                    'required'   => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 8 karakter.',
                ],
            ],
            'password_confirm' => [
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password wajib diisi.',
                    'matches'  => 'Konfirmasi password tidak sama.',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->userModel->insert([
            'name'     => trim((string) $this->request->getPost('name')),
            'email'    => strtolower(trim((string) $this->request->getPost('email'))),
            'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'customer',
            'phone'    => trim((string) $this->request->getPost('phone')) ?: null,
            'address'  => trim((string) $this->request->getPost('address')) ?: null,
        ]);

        return redirect()->to('/login')
            ->with('success', 'Registrasi berhasil. Silakan login dengan akun baru Anda.');
    }

    // Menampilkan halaman login
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return $this->redirectByRole(session()->get('role'));
        }

        return view('auth/login', [
            'title'      => 'Login — ShopEase Gaming Gear',
            'activeMenu' => 'login',
        ]);
    }

    // Memproses autentikasi login
    public function authenticate()
    {
        $rules = [
            'email' => [
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required'    => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                ],
            ],
            'password' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Password wajib diisi.',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $email    = strtolower(trim((string) $this->request->getPost('email')));
        $password = (string) $this->request->getPost('password');

        $user = $this->userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email atau password salah.');
        }

        // Regenerasi session ID untuk mencegah session fixation
        session()->regenerate(true);

        session()->set([
            'isLoggedIn' => true,
            'user_id'    => $user['id_user'],
            'name'       => $user['name'],
            'email'      => $user['email'],
            'role'       => $user['role'],
        ]);

        return $this->redirectByRole($user['role'])
            ->with('success', 'Selamat datang kembali, ' . $user['name'] . '!');
    }

    // Mengakhiri session (Logout)
    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login')
            ->with('success', 'Anda berhasil logout.');
    }

    private function redirectByRole(?string $role)
    {
        switch ($role) {
            case 'admin':
                return redirect()->to('/admin');
            case 'operator':
                return redirect()->to('/operator');
            default:
                return redirect()->to('/');
        }
    }
}