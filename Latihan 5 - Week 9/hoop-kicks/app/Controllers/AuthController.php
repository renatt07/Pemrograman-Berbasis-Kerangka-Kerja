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

        $user = $this->userModel->where('email', $this->request->getPost('email'))->first();

        if (! $user || ! password_verify($this->request->getPost('password'), $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau kata sandi salah.');
        }

        session()->set([
            'user_id'    => $user['id'],
            'name'       => $user['name'],
            'email'      => $user['email'],
            'phone'      => $user['phone'],
            'address'    => $user['address'],
            'role'       => $user['role'],
            'isLoggedIn' => true,
        ]);

        if ($user['role'] === 'admin') {
            return redirect()->to('/admin/dashboard')->with('success', 'Welcome back, Admin ' . $user['name'] . '.');
        }

        return redirect()->to('/')->with('success', 'Berhasil masuk! Selamat berburu sepatu di HoopKicks.');
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
            'phone'            => 'required|min_length[9]|max_length[25]',
            'address'          => 'required|min_length[5]',
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->save([
            'name'     => trim($this->request->getPost('name')),
            'email'    => trim($this->request->getPost('email')),
            'phone'    => trim($this->request->getPost('phone')),
            'address'  => trim($this->request->getPost('address')),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'customer',
        ]);

        return redirect()->to('/login')->with('success', 'Akun HoopKicks berhasil dibuat. Silakan login.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Anda berhasil keluar dari akun.');
    }
}