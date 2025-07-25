<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Check if the user is logged in
        if (!session()->has('user_id')) {
            // If not logged in, redirect to the login page
            return redirect()->to('/login');
        }
        if (session()->get('role') === 'admin') {
            return redirect()->to('/Nzr_admin');
        }
        // If logged in, load the home view
        // You can pass data to the view if needed
        $data = [
            'judul' => 'Dashboard', // Set the title for the page
            'sub_judul' => 'Welcome to the Dashboard', // Set the subtitle for
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'id_kecamatan' => session()->get('id_kecamatan'),
            // Add other data as needed
        ];
        if (empty(session()->get('id_kecamatan')) || empty(session()->get('kecamatan'))) {
            session()->setFlashdata('error', 'Kecamatan tidak ditemukan');
        }
        // return view('home', $data);
        // For simplicity, just return the home view    
        return view('home', $this->identitas() + $data);
    }
}
