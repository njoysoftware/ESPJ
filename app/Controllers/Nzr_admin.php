<?php

namespace App\Controllers;

class Nzr_admin extends BaseController
{
    public function index()
    {
        $modelKecamatan = model('App\Models\ModelKecamatan');
        // Check if the user is already logged in
        // Display the login form
        if (session()->get('logged_in')) {
            // If logged in, redirect to home or dashboard
            return redirect()->to('/nzr_admin/admin_home');
        }
        // If not logged in, show the login page
        $data = [
            'judul' => 'Login', // Set the title for the page
            'sub_judul' => 'Silakan masuk ke akun Anda', // Set the subtitle for the page
        ];
        // Return the login view with data
        return view('admin_login', $data);
    }
    public function admin_auth()
    {
        // Handle the login logic
        if ($this->request->getMethod('post')) {

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            // Validate input
            if (empty($username) || empty($password)) {
                session()->setFlashdata('error', 'Username and password harus diisi.');
                // Logic to log out the user, e.g., clearing session data
                session()->destroy();
                return redirect()->back()->withInput();
            }
            // Validate user credentials
            $modelUser = model('App\Models\ModelUser');
            $user = $modelUser->checkLoginAdmin($username, $password);
            $isadmin = $modelUser->isAdmin($username);
            if ($user) {

                if ($isadmin) {
                    // Set session data
                    session()->set('user_id', $user['id_user']);
                    session()->set('username', $user['username']);
                    session()->set('role', $user['role']);
                    session()->set('logged_in', true);

                    return redirect()->to('nzr_admin/admin_home'); // Redirect to dashboard or home page
                } else {
                    // Logic to log out the user, e.g., clearing session data
                    session()->destroy();
                    session()->setFlashdata('error', 'Invalid username or password.');

                    return redirect()->back()->withInput();
                }
            }
        }
    }

    public function admin_home()
    {
        if (session()->get('role') <> 'admin') {
            return redirect()->to('/nzr_admin');
        }
        // If logged in, load the home view
        // You can pass data to the view if needed
        $data = [
            'judul' => 'Dashboard', // Set the title for the page
            'sub_judul' => 'Welcome to the Dashboard', // Set the subtitle for
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            // Add other data as needed
        ];
        // return view('home', $data);
        // For simplicity, just return the home view    
        return view('admin', $this->identitas() + $data);
    }
    public function logout()
    {
        // Logic to log out the user, e.g., clearing session data
        session()->destroy();
        return redirect()->to('/nzr_admin');
    }
}
