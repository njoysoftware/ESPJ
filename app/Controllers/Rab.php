<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;
use App\Models\ModelAkun;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Rab extends BaseController
{
    public function index()
    {
        // Check if the user is logged in
        if (!session()->has('user_id')) {
            // If not logged in, redirect to the login page
            return redirect()->to('/login');
        }
        return redirect()->to('/rab/datarab'); // Redirect to dashboard or home page
    }
    public function datarab()
    {
        $judul_browser = 'Data RAB Kecamatan'; // Set the title for the browser tab
        $sub_judul = 'Data Akun'; // Set the subtitle for the page
        // Load the Grocery CRUD library
        // $this->load->library('grocery_CRUD'); // Not needed in CodeIgniter 4

        // Check if the user is logged in
        if (!session()->has('user_id')) {
            // If not logged in, redirect to the login page
            return redirect()->to('/login');
        }
        /* if (session()->get('role') <> 'admin') {
            return redirect()->to('/home');
        } */
        if (empty(session()->get('id_kecamatan')) || empty(session()->get('kecamatan'))) {
            session()->setFlashdata('error', 'Kecamatan tidak ditemukan');
        }
        $crud = new GroceryCrud();
        $crud->setTheme('flexigrid'); // Set the theme to datatables
        $crud->setTable('t_rab');
        $crud->setRelation('id_akun', 't_akun', '{kementerian}.{program}.{kegiatan}.{output}.{komponen}.{sub_komponen}.{kode_akun}.{akun}.{detail}'); // Set the relation for akun field

        if (session()->get('role') <> 'admin') {
            if (empty(session()->get('id_kecamatan')) || empty(session()->get('kecamatan'))) {
                session()->setFlashdata('error', 'Setting Kecamatan Dahulu');
                return redirect()->to('/home'); // Redirect to dashboard or home page
            }

            $crud->where('id_kecamatan', session()->get('id_kecamatan')); // Filter kuitansi by the current user's kecamatan
            $crud->columns(['nomor', 'id_akun', 'jumlah', 'bulan', 'tahun_anggaran']);
            $crud->addFields(['id_kecamatan', 'id_akun', 'bulan', 'tahun_anggaran', 'jumlah',  'created_at', 'updated_at']);
            $crud->requiredFields(['id_akun', 'bulan', 'tahun_anggaran', 'jumlah']);
            $crud->editFields(['id_kecamatan', 'id_akun', 'bulan', 'tahun_anggaran', 'jumlah', 'updated_at']);
            $crud->fieldType('id_kecamatan', 'hidden');
        } else {

            $crud->setRelation('id_kecamatan', 't_kecamatan', 'nama_kecamatan');
            $crud->columns(['nomor', 'id_kecamatan', 'id_akun', 'bulan', 'tahun_anggaran', 'jumlah']);
            $crud->addFields(['id_kecamatan', 'id_akun', 'bulan', 'tahun_anggaran', 'jumlah',  'created_at', 'updated_at']);
            $crud->editFields(['id_kecamatan', 'id_akun', 'bulan', 'tahun_anggaran', 'jumlah', 'updated_at']);
            $crud->requiredFields(['id_kecamatan', 'id_akun', 'bulan', 'tahun_anggaran', 'jumlah']);
            $crud->displayAs('id_kecamatan', 'Kecamatan');
            $crud->setClone();
        }

        // $crud->setSubject('Data RAB Kecamatan', 'Data RAB Kecamatan'); // Set the subject for the CRUD

        $crud->fieldType('created_at', 'hidden'); // Set the create_at field to hidden
        $crud->fieldType('updated_at', 'hidden'); // Set the updated_at field to hidden
        $crud->fieldType(
            'bulan',
            'dropdown',
            array(
                'Januari' => 'Januari',
                'Februari' => 'Februari',
                'Maret' => 'Maret',
                'April' => 'April',
                'Mei' => 'Mei',
                'Juni' => 'Juni',
                'Juli' => 'Juli',
                'Agustus' => 'Agustus',
                'September' => 'September',
                'Oktober' => 'Oktober',
                'Nopember' => 'Nopember',
                'Desember' => 'Desember'
            )
        ); // Set the akun field type to dropdown

        $crud->setRule(
            'tahun_anggaran',
            'Tahun Anggaran',
            'required|numeric|greater_than[2000]|less_than_equal_to[' . date('Y') . ']'
        ); // Set validation rule for bruto field
        $crud->setSubject('Data RAB');
        $crud->callbackColumn('nomor', function ($value, $row) {
            static $i = 0;
            $i++;
            return $i;
        });

        $crud->callbackBeforeInsert(array($this, 'kecamatan_mana'));
        $crud->callbackAfterUpdate(array($this, 'kecamatan_mana'));
        //   $crud->displayAs('id_kecamatan', 'Kecamatan');
        $crud->displayAs('id_akun', 'Akun');
        $crud->displayAs('jumlah', 'Jumlah');
        $crud->setRead();

        $output = $crud->render();
        return view('grocery_view', (array)$output + [
            'judul' => $judul_browser,
            'sub_judul' => $sub_judul,
            'css_files' => $output->css_files,
            'js_files' => $output->js_files,

        ]);
    }


    public function kecamatan_mana($post_array)
    {

        $id_kecamatan   = session()->get('id_kecamatan'); // Get the kecamatan ID from the session
        // Set id_kecamatan to the current user's kecamatan if not already set
        $post_array->data['id_kecamatan'] =  $id_kecamatan;
        return $post_array;
    }
}
