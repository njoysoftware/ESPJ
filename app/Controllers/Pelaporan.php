<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;
use App\Models\ModelAkun;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPUnit\Framework\Constraint\IsNull;

class Pelaporan extends BaseController
{
    public function index()
    {
        // Check if the user is logged in
        if (!session()->has('user_id')) {
            // If not logged in, redirect to the login page
            return redirect()->to('/login');
        }
        return redirect()->to('/pelaporan/data'); // Redirect to dashboard or home page
    }
    public function data()
    {
        $judul_browser = 'Data BKU Kecamatan'; // Set the title for the browser tab
        $sub_judul = 'Data pelaporan'; // Set the subtitle for the page
        if (empty(session()->get('id_kecamatan')) || empty(session()->get('kecamatan'))) {
            session()->setFlashdata('error', 'Kecamatan tidak ditemukan');
        }
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

        $crud = new GroceryCrud();
        $crud->setTheme('flexigrid'); // Set the theme to datatables
        $crud->setTable('t_pembukuan');
        $crud->setRelation('id_kuitansi', 't_kuitansi', '{keterangan}'); // Set the relation for akun field
        if (session()->get('role') <> 'admin') {
            if (empty(session()->get('id_kecamatan')) || empty(session()->get('kecamatan'))) {
                session()->setFlashdata('error', 'Setting Kecamatan Dahulu');
                return redirect()->to('/home'); // Redirect to dashboard or home page
            }
            $crud->where('t_pembukuan.id_kecamatan', session()->get('id_kecamatan')); // Filter kuitansi by the current user's kecamatan
            //  $crud->unsetOperations();
            // $crud->unsetPrint();
        } else {
            $crud->setClone();
        }

        $crud->setSubject('Data BKU Kecamatan', 'Data BKU Kecamatan'); // Set the subject for the CRUD
        $crud->columns(['nomor', 'keterangan_bku', 'bulan', 'debet', 'kredit']);
        $crud->addFields(['bulan', 'debet', 'kredit', 'id_kuitansi', 'id_kecamatan', 'keterangan_bku',  'created_at',  'updated_at']);
        $crud->editFields(['bulan', 'debet', 'kredit', 'id_kuitansi', 'id_kecamatan', 'keterangan_bku', 'updated_at']);
        $crud->requiredFields(['bulan']); // Set the required fields for the form

        $crud->fieldType('debet', 'numeric');
        $crud->fieldType('kredit', 'numeric');
        $crud->fieldType('id_kecamatan', 'hidden');
        $crud->fieldType('keterangan_bku', 'text');
        //$crud->setTexteditor(['keterangan_bku']);


        $crud->fieldType('created_at', 'hidden', date('Y-m-d H:i:s')); // Set the create_at field to hidden
        $crud->fieldType('updated_at', 'hidden', date('Y-m-d H:i:s')); // Set the updated_at field to hidden
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
        $crud->displayAs('id_kecamatan', 'Kecamatan'); // Set the display name for the id_kecamatan field

        // Set validation rule for bruto field
        $crud->callbackColumn('nomor', function ($value, $row) {
            static $i = 0;
            $i++;
            return $i;
        });

        $crud->displayAs('id_kuitansi', 'Kuitansi');
        $crud->displayAs('keterangan_bku', 'Keterangan');
        $crud->setRead();
        $crud->callbackBeforeInsert(array($this, 'kecamatan_mana'));
        $crud->callbackBeforeUpdate(array($this, 'kecamatan_mana'));

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

        if (empty($post_array->data['keterangan_bku']) || !empty($post_array->data['id_kuitansi'])) {
            //mencari data kuitansi berdasarkan id
            $value = $post_array->data['id_kuitansi'];
            $modelKuitansi = model('App\Models\ModelKuitansi');
            $kuitansi = $modelKuitansi->getKuitansiById($value);
            if (!$kuitansi || empty($kuitansi)) {
                $post_array->data['keterangan_bku'] = '';
            }
            $post_array->data['keterangan_bku'] = $kuitansi['keterangan'];
            $post_array->data['kredit'] = $kuitansi['bruto'];
        }

        return $post_array;
    }
}
