<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPejabatkab extends Model
{
    protected $table = 't_ppk_bp';
    protected $primaryKey = 'id_ppk_bp';
    protected $allowedFields = ['nama_ppk', 'nip_ppk', 'nama_bp', 'nip_bp', 'nama_kabupaten'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama_ppk' => 'required|min_length[3]|max_length[100]',
        'nip_ppk' => 'numeric|required||min_length[17]|max_length[20]',
        'nama_bp' => 'required|min_length[3]|max_length[100]',
        'nip_bp' => 'numeric|required||min_length[17]|max_length[20]'
    ];

    protected $validationMessages = [
        'nama_ppk' => [
            'required' => 'Nama pejabat harus diisi.',
            'min_length' => 'Nama pejabat minimal 3 karakter.',
            'max_length' => 'Nama pejabat maksimal 100 karakter.'
        ],
        'nip_ppk' => [
            'required' => 'NIP pejabat harus diisi.',
            'min_length' => 'Nama pejabat minimal 3 karakter.',
            'max_length' => 'Nama pejabat maksimal 100 karakter.'
        ],
        'nama_bp' => [
            'required' => 'Nama pejabat harus diisi.',
            'min_length' => 'Nama pejabat minimal 3 karakter.',
            'max_length' => 'Nama pejabat maksimal 100 karakter.'
        ],
        'nip_bp' => [
            'required' => 'NIP pejabat harus diisi.',
            'min_length' => 'Nama pejabat minimal 3 karakter.',
            'max_length' => 'Nama pejabat maksimal 100 karakter.'
        ]
    ];
    public function getPejabatById($id)
    {
        return $this->find($id);
    }
    public function getAllPejabat()
    {
        return $this->findAll();
    }
    public function createPejabat($data)
    {
        return $this->insert($data);
    }
    public function updatePejabat($id, $data)
    {
        return $this->update($id, $data);
    }
    public function deletePejabat($id)
    {
        return $this->delete($id);
    }
    public function ppkbp()
    {
        $query =  $this->select('*')->first();
        return   $query;
    }
}
