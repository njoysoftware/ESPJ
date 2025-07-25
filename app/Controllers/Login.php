<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {
        $modelKecamatan = model('App\Models\ModelKecamatan');
        // Check if the user is already logged in
        // Display the login form
        if (session()->get('logged_in')) {
            // If logged in, redirect to home or dashboard
            return redirect()->to('/home');
        }
        // If not logged in, show the login page
        $data = [
            'judul' => 'Login', // Set the title for the page
            'sub_judul' => 'Silakan masuk ke akun Anda'
        ];
        // Return the login view with data
        return view('login', $data);
    }
    public function auth()
    {
        // Handle the login logic
        if ($this->request->getMethod('post')) {

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            //  $id_kecamatan = $this->request->getPost('kecamatan');

            // Validate input
            if (empty($username) || empty($password)) {
                session()->setFlashdata('error', 'Username and password harus diisi.');
                return redirect()->back()->withInput();
            }

            // Validate user credentials
            $modelUser = model('App\Models\ModelUser');
            $modelKecamatan = model('App\Models\ModelKecamatan');
            $user = $modelUser->checkLogin($username, $password);
            if ($user) {
                $isadmin = $modelUser->isAdmin($username);
                if ($isadmin) {
                    session()->setFlashdata('error', 'Invalid username or password.');
                    return redirect()->back()->withInput();
                }
                $kecamatan = $modelKecamatan->getKecamatan($user['id_kecamatan']);
                if ($kecamatan) {
                    // Check if kecamatan exists
                    session()->set('id_kecamatan', $kecamatan['id_kecamatan']);
                    session()->set('kecamatan', $kecamatan['nama_kecamatan']);
                    session()->set('kab_kecamatan', $kecamatan['kab_kecamatan']);
                } else {
                    session()->set('id_kecamatan', null);
                    session()->set('kecamatan', null);
                    session()->set('kab_kecamatan', null);
                }
                // Set session data
                session()->set('user_id', $user['id_user']);
                session()->set('username', $user['username']);
                session()->set('role', $user['role']);
                session()->set('logged_in', true);

                return redirect()->to('/home'); // Redirect to dashboard or home page
            } else {
                session()->setFlashdata('error', 'Invalid username or password or kecamatan.');
                return redirect()->back()->withInput();
            }
        }
    }

    public function logout()
    {
        // Logic to log out the user, e.g., clearing session data
        session()->destroy();
        cookies()->clear();
        return redirect()->to('/login');
    }
}
