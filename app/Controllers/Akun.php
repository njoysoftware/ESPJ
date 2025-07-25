<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;


class Akun extends BaseController
{
    public function index()
    {
        // Check if the user is logged in
        if (!session()->has('user_id')) {
            // If not logged in, redirect to the login page
            return redirect()->to('/login');
        }

        return redirect()->to('/akun/dataakun'); // Redirect to dashboard or home page
    }
    public function dataakun()
    {
        $judul_browser = 'Data Akun'; // Set the title for the browser tab
        $sub_judul = 'Data Akun'; // Set the subtitle for the page
        // Load the Grocery CRUD library
        // $this->load->library('grocery_CRUD'); // Not needed in CodeIgniter 4

        // Check if the user is logged in
        if (!session()->has('user_id')) {
            // If not logged in, redirect to the login page
            return redirect()->to('/login');
        }
        /*   if (session()->get('role') <> 'admin') {
            return redirect()->to('/home');
        } */

        $crud = new GroceryCrud();
        $crud->setTheme('flexigrid'); // Set the theme to datatables
        $crud->setTable('t_akun');
        $crud->setSubject('akun', 'Data Akun'); // Set the subject for the CRUD
        $crud->columns(['kementerian', 'program', 'kegiatan', 'output', 'komponen', 'sub_komponen', 'kode_akun', 'akun', 'detail',]);
        $crud->editFields(['kementerian', 'program', 'kegiatan', 'output', 'komponen', 'sub_komponen', 'kode_akun', 'akun', 'detail', 'updated_at']);
        $crud->addFields(['kementerian', 'program', 'kegiatan', 'output', 'komponen', 'sub_komponen', 'kode_akun', 'akun', 'detail',  'created_at', 'updated_at']);

        $crud->fieldType('created_at', 'hidden', date('Y-m-d H:i:s')); // Set the create_at field to hidden
        $crud->fieldType('updated_at', 'hidden', date('Y-m-d H:i:s')); // Set the updated_at field to hidden

        $crud->setRead();

        /*        if (session()->get('role') <> 'admin') {
            $crud->unsetAdd();
            $crud->unsetClone();
            $crud->unsetDelete();
            $crud->unsetEdit();
        } else {
            $crud->setClone();
        }
 */
        $output = $crud->render();
        return view('grocery_view', (array)$output + [
            'judul' => $judul_browser,
            'sub_judul' => $sub_judul,
            'css_files' => $output->css_files,
            'js_files' => $output->js_files,
        ]);
    }
    public function akunkecamatan() {}
}
