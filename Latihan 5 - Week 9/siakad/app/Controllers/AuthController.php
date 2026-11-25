<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function index()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        return $this->redirectByRole(session()->get('role'));
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return $this->redirectByRole(session()->get('role'));
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

        $userModel = new UserModel();
        $user      = $userModel->where('email', $this->request->getPost('email'))->first();

        if (! $user || ! password_verify($this->request->getPost('password'), $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau kata sandi salah.');
        }

        session()->set([
            'user_id'    => $user['id'],
            'name'       => $user['name'],
            'email'      => $user['email'],
            'role'       => $user['role'],
            'isLoggedIn' => true,
        ]);

        return $this->redirectByRole($user['role'])
            ->with('success', 'Selamat datang, ' . $user['name'] . '!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah keluar dari SIAKAD.');
    }

    private function redirectByRole(?string $role)
    {
        return match ($role) {
            'admin'     => redirect()->to('/admin/dashboard'),
            'dosen'     => redirect()->to('/dosen/dashboard'),
            'mahasiswa' => redirect()->to('/mahasiswa/dashboard'),
            default     => redirect()->to('/login'),
        };
    }
}