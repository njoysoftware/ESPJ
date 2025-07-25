<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Libraries\GroceryCrud;
use App\Models\ModelRab;
use App\Models\ModelAkun;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class UploadController extends BaseController
{
    public function index()
    {
        // Check if the user is logged in
        if (!session()->has('user_id')) {
            // If not logged in, redirect to the login page
            return redirect()->to('/login');
        }
        $modelAkun = model('App\Models\ModelAkun');
        $data = [
            'judul' => 'Upload RAB Kecamatan', // Set the title for the page
            'sub_judul' => 'Gunakan File Xls atau Xls', // Set the subtitle for
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'id_kecamatan' => session()->get('id_kecamatan'),
            // Add other data as needed
        ];
        $data['akun'] = $modelAkun->getAllAkun();

        return view('upload_form', $data);
    }

    public function uploadrab()
    {
        // Check if the user is logged in
        if (!session()->has('user_id')) {
            // If not logged in, redirect to the login page
            return redirect()->to('/login');
        }
        $modelRab = model('App\Models\ModelRab');
        $file = $this->request->getFile('upload_file');
        $bulan = $this->request->getPost('bulan');
        $id_kec = session()->get('id_kecamatan');
        // $file->move(FCPATH . 'upload');
        // $filePath = FCPATH . 'upload/' . $file->getFilename();
        $ext = $file->getExtension();

        if ($ext == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } elseif ($ext == 'xlsx') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        } else {
            // If not logged in, redirect to the login page
            session()->setFlashdata('message', 'Gunakan File Excel');
            return redirect()->to('/upload_rab');
        }

        //  $objPHPExcel = new Spreadsheet();
        $objPHPExcel = $reader->load($file);
        $sheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $numrow = 1;
        // Example: Only take the first data row (after header)
        foreach ($sheet as $idx => $data) {
            if ($idx == 1) {
                continue;
            }
            $kecamatan = $id_kec;
            $akun = $data['C'];
            $ta = $data['E'];
            $jumlah = $data['F'];
            $simpandata = [
                'id_kecamatan' => $kecamatan,
                'id_akun' => $akun,
                'bulan' => $bulan,
                'tahun_anggaran' => $ta,
                'jumlah' => $jumlah
            ];
            $insert_data =   $modelRab->Exportexcel($simpandata);
        }
        $numrow++;
        if ($insert_data) {

            session()->setFlashdata('message', 'Berhasil berhasil hore');
            //  var_dump($simpandata);
            //  
            // break; // Only first data row
        } else {
            session()->setFlashdata('message', 'Gagal Export ');
        }
        return redirect()->to('/UploadController');
    }
}
