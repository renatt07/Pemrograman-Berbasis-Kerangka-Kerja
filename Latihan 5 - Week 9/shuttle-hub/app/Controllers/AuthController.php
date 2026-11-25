<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return session()->get('role') === 'admin'
                ? redirect()->to('/admin/dashboard')
                : redirect()->to('/');
        }

        return view('auth/login');
    }

    public function attemptLogin()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('email', $email)->first();

        if (! $user || ! password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau kata sandi salah.');
        }

        session()->set([
            'user_id'    => $user['id'],
            'name'       => $user['name'],
            'email'      => $user['email'],
            'role'       => $user['role'],
            'isLoggedIn' => true,
        ]);

        if ($user['role'] === 'admin') {
            return redirect()->to('/admin/dashboard')->with('success', 'Selamat datang kembali, ' . $user['name'] . '!');
        }

        return redirect()->to('/')->with('success', 'Login berhasil! Selamat datang, ' . $user['name'] . '.');
    }

    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        return view('auth/register');
    }

    public function attemptRegister()
    {
        $rules = [
            'name'             => 'required|min_length[3]|max_length[100]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'phone'            => 'required|min_length[9]|max_length[20]',
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
        ];

        $messages = [
            'email' => [
                'is_unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain.',
            ],
            'password_confirm' => [
                'matches' => 'Konfirmasi kata sandi tidak cocok.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->save([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'phone'    => $this->request->getPost('phone'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'customer',
        ]);

        return redirect()->to('/login')->with('success', 'Registrasi berhasil! Silakan login dengan akun baru Anda.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda berhasil keluar.');
    }
}