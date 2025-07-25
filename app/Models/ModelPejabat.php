<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPejabat extends Model
{
    protected $table = 't_pejabat';
    protected $primaryKey = 'id_pejabat';
    protected $allowedFields = ['spk', 'nip_spk', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'spk' => 'required|min_length[3]|max_length[100]',
        'nip_spk' => 'required||min_length[17]|max_length[20]'
    ];

    protected $validationMessages = [
        'spk' => [
            'required' => 'Nama pejabat harus diisi.',
            'min_length' => 'Nama pejabat minimal 3 karakter.',
            'max_length' => 'Nama pejabat maksimal 100 karakter.'
        ],
        'nip_spk' => [
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
    public function getPejabatByNip($nip)
    {
        return $this->where('nip', $nip)->first();
    }
    public function getPejabatByKecamatan($kecamatan)
    {
        return $this->where('id_kec', $kecamatan)->first();
    }
}
