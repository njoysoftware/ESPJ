<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;
use PhpOffice\PhpSpreadsheet\Reader\Xls\MD5;


class User extends BaseController
{
    public function index()
    {
        // Check if the user is logged in
        if (!session()->has('user_id')) {
            // If not logged in, redirect to the login page
            return redirect()->to('/login');
        }
        if (session()->get('role') <> 'admin') {
            return redirect()->to('/nzr_admin');
        }
        return redirect()->to('/user/datauser'); // Redirect to dashboard or home page
    }
    public function datauser()
    {
        $judul_browser = 'Data User'; // Set the title for the browser tab
        $sub_judul = 'Data User'; // Set the subtitle for the page
        // Load the Grocery CRUD library
        // $this->load->library('grocery_CRUD'); // Not needed in CodeIgniter 4

        // Check if the user is logged in
        if (!session()->has('user_id')) {
            // If not logged in, redirect to the login page
            return redirect()->to('/login');
        }
        if (session()->get('role') <> 'admin') {
            return redirect()->to('/nzr_admin');
        }
        $crud = new GroceryCrud();

        $crud->setTheme('flexigrid'); // Set the theme to datatables
        $crud->setTable('t_user');
        $crud->where('role =', 'admin');
        $crud->setPrimaryKey('id_user'); // Set the primary key for the table

        $crud->columns(['username', 'password', 'role']); // Set the columns to display in the list view
        $crud->editFields(['username', 'password', 'role', 'updated_at']); // Set the relation for the role field
        $crud->addFields(['username', 'password', 'role', 'created_at', 'updated_at']); // Set the fields to display in the add form
        $crud->fieldType('password', 'password'); // Set the password field type to password
        $crud->fieldType('created_at', 'hidden', date('Y-m-d H:i:s')); // Set the create_at field to hidden
        $crud->fieldType('updated_at', 'hidden', date('Y-m-d H:i:s')); // Set the updated_at field to hidden
        $crud->requiredFields(['username', 'password', 'role']); // Set the required fields for the form

        // Dropdown 
        $crud->fieldType(
            'role',
            'dropdown',
            array('user' => 'user', 'admin' => 'admin')
        );
        $crud->displayAs('role', 'role');

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

        $crud->setSubject('User', 'Users'); // Set the subject for the CRUD

        $crud->setRead();
        if (session()->get('role') <> 'admin') {
            $crud->unsetAdd();
            $crud->unsetClone();
            $crud->unsetDelete();
            $crud->unsetEdit();
        } else {
            $crud->setClone();
        }


        $output = $crud->render();

        return view('grocery_view', (array)$output + [
            'judul' => $judul_browser,
            'sub_judul' => $sub_judul,
            'css_files' => $output->css_files,
            'js_files' => $output->js_files,
        ]);
        // return $this->_groceryOutput($output);
    }


    public function callback_edit_password($value)
    {
        // This function will be called when editing the password field
        // You can return a custom input field or any other HTML you want
        return '<input type="password" class="form-control" name="password" value="" />';
    }
    public function md5_password($post_array)
    {

        // $post_array->data['updated_at'] = date('Y-m-d H:i:s');
        $password = $post_array->data['password'];
        $post_array->data['password'] = md5($password);

        return $post_array;
    }
    private function _groceryOutput($output = null)
    {

        return view(
            'grocery_view',
            (array)$output
        );
    }
}
