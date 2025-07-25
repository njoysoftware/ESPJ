<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;

class Setting extends BaseController
{
    public function index()
    {
        // Check if the user is logged in
        if (!session()->has('user_id')) {
            // If not logged in, redirect to the login page
            return redirect()->to('/login');
        }

        return redirect()->to('/setting/pejabat'); // Redirect to pejabat method
    }
    public function pejabat_kabupaten()
    {
        $judul_browser = 'Data PPK dan BPP'; // Set the title for the browser tab
        $sub_judul = 'Pejabat Kabupaten'; // Set the subtitle for the page
        // Load the Grocery CRUD library
        // $this->load->library('grocery_CRUD'); // Not needed in CodeIgniter 4

        // Check if the user is logged in
        if (!session()->has('user_id')) {
            // If not logged in, redirect to the login page
            return redirect()->to('/login');
        }

        $crud = new GroceryCrud();
        $crud->setTheme('flexigrid'); // Set the theme to datatables
        $crud->setTable('t_ppk_bp');
        $crud->setSubject('Pejabat Kabupaten', 'Pejabat Kabupaten'); // Set the
        $crud->setPrimaryKey('id_ppk_bp'); // Set the primary key for the table

        $crud->fieldType('nip_ppk', 'numeric'); // Set the create_at field to hidden
        $crud->fieldType('nip_bp', 'numeric'); // Set the create_at field to hidden

        $crud->fieldType('created_at', 'hidden', date('Y-m-d H:i:s')); // Set the create_at field to hidden
        $crud->fieldType('updated_at', 'hidden', date('Y-m-d H:i:s'));
        $crud->columns(['nama_ppk', 'nip_ppk', 'nama_bp', 'nip_bp']); // Set the columns to display in the list view
        $crud->editFields(['nama_ppk', 'nip_ppk', 'nama_bp', 'nip_bp', 'nama_kabupaten', 'updated_at']); // Set the fields to display in the edit form
        $crud->addFields(['nama_ppk', 'nip_ppk', 'nama_bp', 'nip_bp',  'nama_kabupaten', 'created_at', 'updated_at']); // Set the fields to display in the add form

        $crud->uniqueFields(['nama_ppk', 'nip_ppk', 'nama_bp', 'nip_bp']); // Set the unique fields for the form
        $crud->setRead();


        // Set the updated_at field to hidden
        $crud->requiredFields(['nama_ppk', 'nip_ppk', 'nama_bp', 'nip_bp']); // Set the required fields for the form

        $crud->displayAs('nama_ppk', 'Nama PPK'); // Set the display name for the ppk field
        $crud->displayAs('nama_bp', 'Nama BP/BPP'); // Set the display name for the spk field
        $crud->displayAs('nip_ppk', 'NIP PPK'); // Set the display name for the nip_spk field
        $crud->displayAs('nip_bp', 'NIP BP/BPP'); // Set the display name for the nip_spk field
        $crud->displayAs('nama_kabupaten', 'Kabupaten/Kota'); // Set the display name for the nip_spk field

        $crud->fieldType(
            'nama_kabupaten',
            'dropdown',
            array(
                'Bangkalan' => 'Bangkalan',
                'Banyuwangi' => 'Banyuwangi',
                'Batu' => 'Kota Batu',
                'Blitar' => 'Blitar',
                'Blitar (Kota)' => 'Kota Blitar',
                'Bojonegoro' => 'Bojonegoro',
                'Bondowoso' => 'Bondowoso',
                'Gresik' => 'Gresik',
                'Jember' => 'Jember',
                'Jombang' => 'Jombang',
                'Kediri' => 'Kediri',
                'Kediri (Kota)' => 'Kota Kediri',
                'Lamongan' => 'Lamongan',
                'Lumajang' => 'Lumajang',
                'Madiun' => 'Madiun',
                'Madiun (Kota)' => 'Kota Madiun',
                'Magetan' => 'Magetan',
                'Malang' => 'Malang',
                'Malang (Kota)' => 'Kota Malang',
                'Mojokerto' => 'Mojokerto',
                'Mojokerto (Kota)' => 'Kota Mojokerto',
                'Nganjuk' => 'Nganjuk',
                'Ngawi' => 'Ngawi',
                'Pacitan' => 'Pacitan',
                'Pamekasan' => 'Pamekasan',
                'Pasuruan' => 'Pasuruan',
                'Pasuruan (Kota)' => 'Kota Pasuruan',
                'Ponorogo' => 'Ponorogo',
                'Probolinggo' => 'Probolinggo',
                'Probolinggo (Kota)' => 'Kota Probolinggo',
                'Sampang' => 'Sampang',
                'Sidoarjo' => 'Sidoarjo',
                'Situbondo' => 'Situbondo',
                'Sumenep' => 'Sumenep',
                'Surabaya' => 'Kota Surabaya',
                'Trenggalek' => 'Trenggalek',
                'Tuban' => 'Tuban',
                'Tulungagung' => 'Tulungagung',
            )
        );
        $output = $crud->render();

        return view('grocery_view', (array)$output + [
            'judul' => $judul_browser,
            'sub_judul' => $sub_judul,
            'css_files' => $output->css_files,
            'js_files' => $output->js_files,
        ]);
    }
    public function pejabat()
    {
        $judul_browser = 'Data SPK'; // Set the title for the browser tab
        $sub_judul = 'Pejabat Kecamatan'; // Set the subtitle for the page
        $kecamatan  =   session()->get('kecamatan'); // Get the kecamatan from the session   

        // Load the Grocery CRUD library
        // $this->load->library('grocery_CRUD'); // Not needed in CodeIgniter 4

        // Check if the user is logged in
        if (!session()->has('user_id')) {
            // If not logged in, redirect to the login page
            return redirect()->to('/login');
        }

        $crud = new GroceryCrud();
        $crud->setTheme('flexigrid'); // Set the theme to datatables
        $crud->setTable('t_pejabat');
        $crud->setSubject('Pejabat', 'Pejabat'); // Set the
        $crud->setPrimaryKey('id_pejabat'); // Set the primary key for the table
        $crud->setRelation('id_kec', 't_kecamatan', '{nama_kecamatan}'); // Set the relation
        if (session()->get('role') <> 'admin') {
            if (empty(session()->get('id_kecamatan')) || empty(session()->get('kecamatan'))) {
                session()->setFlashdata('error', 'Setting Kecamatan Dahulu');
                return redirect()->to('/home'); // Redirect to dashboard or home page
            }
            $crud->where('t_pejabat.id_kec', session()->get('id_kecamatan')); // Filter users by the current user's kecamatan
        } else {
            $crud->setClone();
        }
        $crud->displayAs('id_kec', 'Kecamatan'); // Set the display name for the spk field
        $crud->displayAs('spk', 'Nama SPK'); // Set the display name for the spk field
        $crud->displayAs('nip_spk', 'NIP SPK'); // Set the display name for the nip_spk field

        $crud->columns(['id_kec', 'spk', 'nip_spk']); // Set the columns to display in the list view
        $crud->editFields(['id_kec',  'spk', 'nip_spk', 'updated_at']); // Set the fields to display in the edit form
        $crud->addFields(['id_kec',  'spk', 'nip_spk', 'created_at', 'updated_at']); // Set the fields to display in the add form
        $crud->fieldType('created_at', 'hidden', date('Y-m-d H:i:s')); // Set the create_at field to hidden
        $crud->fieldType('updated_at', 'hidden', date('Y-m-d H:i:s'));
        $crud->uniqueFields(['id_kec']); // Set the unique fields for the form
        $crud->setRead();



        $crud->fieldType(
            'id_kecamatan',
            'dropdown',
            array('id_kecamatan' => 'nama_kecamatan')
        ); // Set the nip_spk field type to text


        // Set the updated_at field to hidden
        $crud->requiredFields(['spk', 'nip_spk']); // Set the required fields for the form


        $output = $crud->render();

        return view('grocery_view', (array)$output + [
            'judul' => $judul_browser,
            'sub_judul' => $sub_judul,
            'css_files' => $output->css_files,
            'js_files' => $output->js_files,
        ]);
    }
    public function kecamatan()
    {
        $judul_browser = 'Data Kecamatan'; // Set the title for the browser tab
        $sub_judul = 'Kecamatan'; // Set the subtitle for the page

        // Load the Grocery CRUD library
        // $this->load->library('grocery_CRUD'); // Not needed in CodeIgniter 4

        // Check if the user is logged in
        if (!session()->has('user_id')) {
            // If not logged in, redirect to the login page
            return redirect()->to('/login');
        }

        $crud = new GroceryCrud();
        $crud->setTheme('flexigrid'); // Set the theme to datatables
        $crud->setTable('t_kecamatan');
        $crud->setSubject('Kecamatan', 'Kecamatan'); // Set the subject for the table
        $crud->setPrimaryKey('id_kecamatan'); // Set the primary key for the table
        if (session()->get('role') <> 'admin') {
            $crud->where('t_kecamatan.id_kecamatan', session()->get('id_kecamatan')); // Filter users by the current user's kecamatan
            //  $crud->unsetClone();
            //  $crud->unsetDelete();
            //  $crud->unsetEdit();
            // $crud->unsetAdd();
            $crud->unsetExport(); // Disable export functionality
            $crud->unsetPrint(); // Disable print functionality
        } else {
            $crud->setClone();
        }


        $crud->columns(['nama_kecamatan', 'kab_kecamatan', 'alamat_kecamatan', 'telp_kecamatan']); // Set the columns to display in the list view
        $crud->editFields(['nama_kecamatan', 'kab_kecamatan',  'alamat_kecamatan', 'telp_kecamatan', 'updated_at']); // Set the fields to display in the edit form
        $crud->addFields(['nama_kecamatan', 'kab_kecamatan',  'alamat_kecamatan', 'telp_kecamatan', 'created_at', 'updated_at']); // Set the fields to display in the add form

        $crud->fieldType('alamat_kecamatan', 'text');
        $crud->fieldType('telp_kecamatan', 'string');
        $crud->fieldType('created_at', 'hidden', date('Y-m-d H:i:s')); // Set the create_at field to hidden
        $crud->fieldType('updated_at', 'hidden', date('Y-m-d H:i:s')); // Set the updated_at field to hidden
        $crud->requiredFields(['nama_kecamatan', 'kab_kecamatan']); // Set the required fields for the form
        $crud->setRead();
        $crud->setTexteditor(['alamat_kecamatan']); // Set the keterangan field to use a text editor

        $crud->uniqueFields(['nama_kecamatan']); // Set the required fields for the form
        $crud->displayAs('kab_kecamatan', 'Kabupaten/Kota'); // Set the display name for the id_kecamatan field

        $crud->fieldType(
            'kab_kecamatan',
            'dropdown',
            array(
                'Bangkalan' => 'Bangkalan',
                'Banyuwangi' => 'Banyuwangi',
                'Batu' => 'Kota Batu',
                'Blitar' => 'Blitar',
                'Blitar (Kota)' => 'Kota Blitar',
                'Bojonegoro' => 'Bojonegoro',
                'Bondowoso' => 'Bondowoso',
                'Gresik' => 'Gresik',
                'Jember' => 'Jember',
                'Jombang' => 'Jombang',
                'Kediri' => 'Kediri',
                'Kediri (Kota)' => 'Kota Kediri',
                'Lamongan' => 'Lamongan',
                'Lumajang' => 'Lumajang',
                'Madiun' => 'Madiun',
                'Madiun (Kota)' => 'Kota Madiun',
                'Magetan' => 'Magetan',
                'Malang' => 'Malang',
                'Malang (Kota)' => 'Kota Malang',
                'Mojokerto' => 'Mojokerto',
                'Mojokerto (Kota)' => 'Kota Mojokerto',
                'Nganjuk' => 'Nganjuk',
                'Ngawi' => 'Ngawi',
                'Pacitan' => 'Pacitan',
                'Pamekasan' => 'Pamekasan',
                'Pasuruan' => 'Pasuruan',
                'Pasuruan (Kota)' => 'Kota Pasuruan',
                'Ponorogo' => 'Ponorogo',
                'Probolinggo' => 'Probolinggo',
                'Probolinggo (Kota)' => 'Kota Probolinggo',
                'Sampang' => 'Sampang',
                'Sidoarjo' => 'Sidoarjo',
                'Situbondo' => 'Situbondo',
                'Sumenep' => 'Sumenep',
                'Surabaya' => 'Kota Surabaya',
                'Trenggalek' => 'Trenggalek',
                'Tuban' => 'Tuban',
                'Tulungagung' => 'Tulungagung',
            )
        );

        $output = $crud->render();

        return view('grocery_view', (array)$output + [
            'judul' => $judul_browser,
            'sub_judul' => $sub_judul,
            'css_files' => $output->css_files,
            'js_files' => $output->js_files,
        ]);
    }
    public  function user()
    {
        $judul_browser = 'Data User Kecamatan'; // Set the title for the browser tab
        $sub_judul = 'Pengguna'; // Set the subtitle for the page
        $kecamatan  =   session()->get('kecamatan'); // Get the kecamatan from the session   
        // Load the Grocery CRUD library
        // $this->load->library('grocery_CRUD'); // Not needed in CodeIgniter 4

        // Check if the user is logged in
        if (!session()->has('user_id')) {
            // If not logged in, redirect to the login page
            return redirect()->to('/login');
        }

        $crud = new GroceryCrud();
        $crud->setTheme('flexigrid'); // Set the theme to datatables
        $crud->setTable('t_user');
        $crud->where('role !=', 'admin'); // Exclude admin users from the list
        if (session()->get('role') <> 'admin') {
            $crud->where('t_user.id_kecamatan', session()->get('id_kecamatan')); // Filter users by the current user's kecamatan            $crud->unsetAdd();
            //  $crud->unsetClone();
            //  $crud->unsetDelete();
            //  $crud->unsetEdit();
            // $crud->unsetAdd();
            $crud->unsetExport(); // Disable export functionality
            $crud->unsetPrint(); // Disable print functionality
        } else {
            $crud->setClone();
        }
        $crud->setRelation('id_kecamatan', 't_kecamatan', '{nama_kecamatan}'); // Set the relation for id_kecamatan field
        $crud->setSubject('Pengguna', 'Pengguna'); // Set the subject for the table
        $crud->setPrimaryKey('id_user'); // Set the primary key for the table

        $crud->columns(['id_kecamatan', 'username', 'role']); // Set the columns to display in the list view
        $crud->editFields(['username', 'id_kecamatan', 'password', 'role', 'updated_at']); // Set the fields to display in the edit form
        $crud->addFields(['username',  'id_kecamatan', 'password', 'role', 'updated_at']); // Set the fields to display in the edit form
        $crud->fieldType('role', 'hidden', 'user'); // Set the username field type to string
        $crud->fieldType('created_at', 'hidden', date('Y-m-d H:i:s')); // Set the create_at field to hidden
        $crud->fieldType('updated_at', 'hidden', date('Y-m-d H:i:s')); // Set the updated_at field to hidden
        $crud->requiredFields(['username', 'password', 'role']); // Set the required fields for the form
        $crud->uniqueFields(['username', 'id_kecamatan']);

        $crud->fieldType('password', 'password'); // Set the password field type to password

        $crud->fieldType(
            'Kecamatan',
            'dropdown',
            array('id_kecamatan' => 'nama_kecamatan')
        ); // Set the id_kecamatan field type to dropdown

        $crud->displayAs('id_kecamatan', 'Kecamatan'); // Set the display name for the id_kecamatan field


        $crud->callbackEditField('password', array(
            $this,
            'callback_edit_password'
        ));
        $crud->callbackAddField('password', array(
            $this,
            'callback_edit_password'
        ));
        $crud->callbackBeforeInsert(array($this, 'md5_password'));
        $crud->callbackBeforeUpdate(array($this, 'md5_password'));

        $output = $crud->render();

        return view('grocery_view', (array)$output + [
            'judul' => $judul_browser,
            'sub_judul' => $sub_judul,
            'css_files' => $output->css_files,
            'js_files' => $output->js_files,
        ]);
    }
    public function callback_edit_password($value)
    {
        // This function will be called when editing the password field
        // You can return a custom input field or any other HTML you want
        return '<input type="password" class="form-control" name="password" value="" />';
    }
    public function md5_password($post_array)
    {

        var_dump($post_array);

        $post_array->data['updated_at'] = date('Y-m-d H:i:s');
        if (session()->get('role') <> 'admin') {
            $post_array->data['role'] = 'user';
            $post_array->data['id_kecamatan'] = intval(session()->get('id_kecamatan'));
        }
        $password = $post_array->data['password'];
        $post_array->data['password'] = md5($password);

        return $post_array;
    }
}
