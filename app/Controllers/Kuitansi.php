<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;
use Nggit\PHPTerbilang\Terbilang;


class Kuitansi extends BaseController
{
    public function index()
    {
        // Check if the user is logged in
        if (!session()->has('user_id')) {
            // If not logged in, redirect to the login page
            return redirect()->to('/login');
        }

        return redirect()->to('/kuitansi/data'); // Redirect to dashboard or home page
    }
    public function data()
    {
        // Check if the user is logged in
        if (!session()->has('user_id')) {
            // If not logged in, redirect to the login page
            return redirect()->to('/login');
        }
        $judul_browser = 'Data Kuitansi'; // Set the title for the browser tab
        $sub_judul = 'Data Kuitansi';
        $kecamatan  =   session()->get('kecamatan'); // Get the kecamatan from the session   
        if (empty(session()->get('id_kecamatan')) || empty(session()->get('kecamatan'))) {
            $kecamatan = 'Kecamatan .....';
        } else {
            $kecamatan = 'Kecamatan ' . $kecamatan;
        }
        // Set the subtitle for the page
        // Load the Grocery CRUD library
        // $this->load->library('grocery_CRUD'); // Not needed in CodeIgniter 4


        $crud = new GroceryCrud();

        $crud->setTheme('flexigrid'); // Set the theme to datatables
        $crud->setTable('t_kuitansi');
        $crud->setRelation('akun', 't_akun', '{kementerian}.{program}.{kegiatan}.{output}.{komponen}.{sub_komponen}.{kode_akun}.{detail}'); // Set the relation for akun field
        if (session()->get('role') <> 'admin') {
            if (empty(session()->get('id_kecamatan')) || empty(session()->get('kecamatan'))) {
                session()->setFlashdata('error', 'Setting Kecamatan Dahulu');
                return redirect()->to('/home'); // Redirect to dashboard or home page
            }
            $crud->where('id_kecamatan', session()->get('id_kecamatan')); // Filter kuitansi by the current user's kecamatan
            $crud->setPrimaryKey('id_kuitansi'); // Set the primary key for the table
            $crud->columns(['nomor', 'nama_penerima', 'keterangan', 'bruto', 'ppn', 'pph', 'netto', 'tanggal']); // Set the columns to display in the list view
            $crud->editFields(['nomor', 'tahun_anggaran', 'nama_toko', 'nama_penerima', 'akun', 'id_kecamatan', 'keterangan', 'bruto', 'ppn', 'pph', 'netto', 'tanggal', 'updated_at']); // Set the fields to display in the edit form
            $crud->addFields(['nomor', 'tahun_anggaran', 'nama_toko', 'nama_penerima', 'akun', 'id_kecamatan', 'keterangan', 'bruto', 'ppn', 'pph', 'netto', 'tanggal', 'created_at', 'updated_at']); // Set the fields to display in the add form
            $crud->fieldType('id_kecamatan', 'hidden'); // Set the id_kecamatan field to hidden

        } else {
            $crud->columns(['nomor', 'nama_penerima', 'keterangan', 'bruto', 'ppn', 'pph', 'netto', 'tanggal']); // Set the columns to display in the list view
            $crud->editFields(['nomor', 'tahun_anggaran', 'nama_toko', 'nama_penerima', 'akun', 'keterangan', 'bruto', 'ppn', 'pph', 'netto', 'tanggal', 'updated_at']); // Set the fields to display in the edit form
            $crud->addFields(['nomor', 'tahun_anggaran', 'nama_toko', 'nama_penerima', 'akun',  'keterangan', 'bruto', 'ppn', 'pph', 'netto', 'tanggal', 'created_at', 'updated_at']); // Set the fields to display in the add form
            $crud->setClone();
        }
        $crud->requiredFields(['nomor', 'tahun_anggaran', 'nama_toko', 'bruto', 'akun', 'nama_penerima', 'keterangan',  'tanggal']); // Set the required fields for the form
        $crud->fieldType('nomor', 'string'); // Set the nomor field type to string
        $crud->fieldType('nama_toko', 'text'); // Set the nama_toko field type to string
        $crud->fieldType('tahun_anggaran', 'numeric'); // Set the keterangan field type to text
        $crud->fieldType('keterangan', 'text'); // Set the keterangan field type to text
        $crud->fieldType('tanggal', 'date'); // Set the keterangan field type to text
        $crud->fieldType('nama_penerima', 'text'); // Set the nama_penerima field type to text
        $crud->fieldType('bruto', 'int'); // Set the bruto field type to numeric
        $crud->fieldType('ppn', 'float', 0); // Set the ppn field type to numeric with default value 0
        $crud->fieldType('pph', 'float', 0); // Set the pph field type to numeric with default value 0
        $crud->fieldType('netto', 'float'); //
        // $crud->setTexteditor(['keterangan', 'bruto']); // Set the keterangan field to use a text editor
        $crud->fieldType('created_at', 'hidden', date('Y-m-d H:i:s')); // Set the create_at field to hidden
        $crud->fieldType('updated_at', 'hidden', date('Y-m-d H:i:s')); // Set the updated_at field to hidden
        $crud->fieldType('netto', 'hidden'); // Set the netto field to hidden

        $crud->displayAs('nama_toko', 'Nama Usaha/Sebagai'); // Set the display name for the akun field
        $crud->displayAs('nama_penerima', 'Nama Penerima'); // Set the display name for the nama_penerima field
        $crud->displayAs('akun', 'Akun'); // Set the display name for
        $crud->displayAs('bruto', 'Jumlah Bruto'); // Set the display name for the bruto field
        $crud->displayAs('ppn', 'PPN'); // Set the display name
        $crud->displayAs('pph', 'PPh'); // Set the display name for the pph field
        $crud->displayAs('netto', 'Jumlah Netto'); // Set the display name
        $crud->displayAs('tanggal', 'Tanggal'); // Set the display name for the
        $crud->displayAs('keterangan', 'Keterangan'); // Set the display name for the keterangan field
        $crud->displayAs('tahun_anggaran', 'Tahun Anggaran'); // Set


        // code for open-source edition

        $crud->setActionButton("<i class='fa fa-print' name='printer'>cetak</i>", 'btn btn-default', function ($value, $row) {
            return '/kuitansi/cetak/' . $row->id_kuitansi;
        }, true);
        $crud->setRead();
        $crud->setClone();
        $crud->setSubject('Kuitansi', 'Data Kuitansi'); // Set the subject for the CRUD
        $crud->setRule(
            'tahun_anggaran',
            'Tahun Anggaran',
            'required|numeric|greater_than[2000]|less_than_equal_to[' . date('Y') . ']'
        ); // Set validation rule for bruto field

        $crud->callbackBeforeInsert(array($this, 'pajak_netto'));
        $crud->callbackBeforeUpdate(array($this, 'pajak_netto'));
        $output['judul_browser'] = $judul_browser;
        $output = $crud->render();


        return view('grocery_view', (array)$output + [
            'judul' => $judul_browser,
            'sub_judul' => $sub_judul,
            'kecamatan' => $kecamatan,
            'css_files' => $output->css_files,
            'js_files' => $output->js_files,
        ]);
        // return $this->_groceryOutput($output);
    }


    public function callback_edit_password($value, $primary_key)
    {
        // This function will be called when editing the password field
        // You can return a custom input field or any other HTML you want
        return '<input type="password" class="form-control" name="password" value="" />';
    }
    public function pajak_netto($post_array)
    {
        $bruto = $post_array->data['bruto'];
        $pph = $post_array->data['pph'];
        $ppn = $post_array->data['ppn'];
        $id_kecamatan   = session()->get('id_kecamatan'); // Get the kecamatan ID from the session

        if (empty($pph)) {
            $pph = 0;
        }
        if (empty($ppn)) {
            $ppn = 0;
        }


        $netto = $bruto - $ppn - $pph; // Calculate netto as bruto minus the percentage of bruto
        $post_array->data['netto'] = $netto;
        $post_array->data['id_kecamatan'] = $id_kecamatan; // Ensure id_kecamatan is set in the post array


        return $post_array;
    }
    public function cetak($value)
    {
        // Check if the user is logged in
        if (!session()->has('user_id')) {
            // If not logged in, redirect to the login page
            return redirect()->to('/login');
        }

        //mencari data kuitansi berdasarkan id
        $modelKuitansi = model('App\Models\ModelKuitansi');
        $kuitansi = $modelKuitansi->getKuitansiById($value);

        if (!$kuitansi || empty($kuitansi)) {
            // If no kuitansi found, redirect to the kuitansi data page with an error message
            return redirect()->to('/kuitansi/data')->with('error', 'Kuitansi tidak ditemukan.');
        }

        $judul_browser = 'KW-' . $kuitansi['id_kuitansi']; // Set the title for the browser tab

        //Apakah Admin
        if (session()->get('role') <> 'admin') {
            //mencari data kecamatan berdasarkan id_kecamatan
            $session_kecamatan  =   session()->get('id_kecamatan'); // Get the kecamatan from the session   
            $id_kecamatan = $kuitansi['id_kecamatan']; // Get the kecamatan from the kuitansi data
            if ($session_kecamatan <> $id_kecamatan) {

                return redirect()->to('/kuitansi/data')->with('error', 'Kuitansi tidak ditemukan.');
            }
            $modelKecamatan = model('App\Models\ModelKecamatan');
            $getkecamatan = $modelKecamatan->getKecamatanById($id_kecamatan); // Get the kecamatan name from the model
            if ($getkecamatan) {
                $kecamatan = $getkecamatan['nama_kecamatan']; // Extract the name from the kecamatan data
            } else {
                $kecamatan = ''; // If no kecamatan found, set it to an empty string
            }

            if (empty($kecamatan)) {
                $kecamatan = 'Kecamatan .....';
            } else {
                $kecamatan = 'Kecamatan ' . $kecamatan;
            }
            //mencari data pejabat berdasarkan id_kecamatan
            $modelPejabat = model('App\Models\ModelPejabat');
            $pejabat = $modelPejabat->getPejabatByKecamatan($kuitansi['id_kecamatan']);
            if ($pejabat) {
                $kuitansi['pejabat'] = $pejabat['spk'];
                $kuitansi['nip_pejabat'] = $pejabat['nip_spk'];
            } else {
                $kuitansi['pejabat'] = 'Belum ada pejabat yang ditetapkan';
                $kuitansi['nip_pejabat'] = '';
            }
        } else {
            $kecamatan = 'Kecamatan .................';
            $kuitansi['pejabat'] = '..............................';
            $kuitansi['nip_pejabat'] = '..............................';
        }


        $terbilang = new Terbilang(); // Initialize the Terbilang library for number to words conversion
        $terbilang->parse(); // Convert numbers to words


        $modelppkbp = model('App\Models\ModelPejabatKab');
        $ppkbp = $modelppkbp->ppkbp();
        if ($ppkbp) {
            $ppk = $ppkbp['nama_ppk'];
            $nip_ppk = $ppkbp['nip_ppk'];
            $bp = $ppkbp['nama_bp'];
            $nip_bp = $ppkbp['nip_bp'];
            $nama_kabupaten = $ppkbp['nama_kabupaten'];
        } else {
            $ppk = '............................';
            $nip_ppk = '............................';
            $bp = '............................';
            $nip_bp = '............................';
            $nama_kabupaten = '............................';
        }

        //mencari data akun berdasarkan id_akun
        $id_akun = $kuitansi['akun'];
        $modelAkun = model('App\Models\ModelAkun');
        $akun = $modelAkun->getAkunById($id_akun);
        if ($akun) {
            $kuitansi['akun'] = $akun['kementerian'] . '.' .
                $akun['program'] . '.' .
                $akun['kegiatan'] . '.' .
                $akun['output'] . '.' .
                $akun['komponen'] . '.' .
                $akun['sub_komponen'] . '.' .
                $akun['kode_akun'];
        } else {
            $kuitansi['akun'] = 'Akun tidak ditemukan';
        }


        if (!$kuitansi) {
            return redirect()->to('/kuitansi/data')->with('error', 'Kuitansi tidak ditemukan.');
        } else {
            // Convert the amounts to words

            $kuitansi['bruto'] = (float)$kuitansi['bruto'];
            $kuitansi['ppn'] = (float)$kuitansi['ppn'];
            $kuitansi['pph'] = (float)$kuitansi['pph'];
            $kuitansi['netto'] = (float)$kuitansi['netto'];
            $bruto_terbilang = $terbilang->parse($kuitansi['bruto'])->getResult();
            $ppn_terbilang = $terbilang->parse($kuitansi['ppn'])->getResult();
            $pph_terbilang = $terbilang->parse($kuitansi['pph'])->getResult();
            $netto_terbilang = $terbilang->parse($kuitansi['netto'])->getResult();

            $data = [
                'judul_browser' => $judul_browser,
                'kuitansi' => $kuitansi,
                'bruto_terbilang' => $bruto_terbilang,
                'ppn_terbilang' => $ppn_terbilang,
                'pph_terbilang' => $pph_terbilang,
                'netto_terbilang' =>   $netto_terbilang,
                'kecamatan' => $kecamatan,
                'judul' => 'Kuitansi',
                'sub_judul' => 'Cetak Kuitansi',
                'nama_ppk' => $ppk,
                'nip_ppk' => $nip_ppk,
                'nama_bp' => $bp,
                'nip_bp' => $nip_bp,
                'nama_kabupaten' => $nama_kabupaten,
            ];
            return view('cetak_kuitansi', $data); // Assuming you have a view named 'cetak_kuitansi'
        }
    }


    private function _groceryOutput($output = null)
    {

        return view(
            'grocery_view',
            (array)$output
        );
    }
}
