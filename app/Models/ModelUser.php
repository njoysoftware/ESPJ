<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUser extends Model
{
    protected $table = 't_user';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['username', 'password', 'role'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
        'password' => 'required|min_length[3]',
        'role' => 'required|in_list[admin,user]'
    ];
    protected $validationMessages = [
        'username' => [
            'required' => 'Username is required.',
            'min_length' => 'Username must be at least 3 characters long.',
            'max_length' => 'Username cannot exceed 20 characters.',
            'is_unique' => 'This username is already taken.'
        ],
        'password' => [
            'required' => 'Password is required.',
            'min_length' => 'Password must be at least 3 characters long.'
        ],
        'role' => [

            'in_list' => 'Role must be either admin or user.'
        ]
    ];
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
    public function getUserByKecamatan($id_kecamatan)
    {
        return $this->where('id_kecamatan', $id_kecamatan)->first();
    }
    public function createUser($data)
    {
        return $this->insert($data);
    }
    public function updateUser($id, $data)
    {
        return $this->update($id, $data);
    }
    public function deleteUser($id)
    {
        return $this->delete($id);
    }
    public function getAllUsers()
    {
        return $this->findAll();
    }
    public function getUserById($id)
    {
        return $this->find($id);
    }
    public function checkLogin($username, $password)
    {
        $user = $this->getUserByUsername($username);

        /*         if ($user && md5($password) == $user['password'] &&  $id_kecamatan == $user['id_kecamatan']) {
            return $user;
        } */
        if ($user && md5($password) == $user['password']) {
            return $user;
        }
        return false;
    }
    public function checkLoginAdmin($username, $password)
    {
        $user = $this->getUserByUsername($username);

        if ($user && md5($password) == $user['password']) {
            if ($this->isAdmin($username)) {
                return $user;
            }
        }
        return false;
    }
    public function changePassword($id, $newPassword)
    {
        $data = [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return $this->update($id, $data);
    }
    public function getUserRole($username)
    {
        $user = $this->getUserByUsername($username);
        return $user ? $user['role'] : null;
    }
    public function isAdmin($username)
    {
        $role = $this->getUserRole($username);
        return $role === 'admin';
    }
    public function isUser($username)
    {
        $role = $this->getUserRole($username);
        return $role === 'user';
    }
    public function getUserCount()
    {
        return $this->countAll();
    }
    public function getUserList($limit = 10, $offset = 0)
    {
        return $this->findAll($limit, $offset);
    }
    public function searchUsers($keyword)
    {
        return $this->like('username', $keyword)->findAll();
    }
    public function getUserByRole($role)
    {
        return $this->where('role', $role)->findAll();
    }
}
