<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKecamatan extends Model
{
    protected $table = 't_kecamatan';
    protected $primaryKey = 'id_kecamatan';
    protected $allowedFields = ['nama_kecamatan', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    public function getKecamatan($id_kecamatan)
    {
        if ($id_kecamatan === null || $id_kecamatan === '') {
            return $this->findAll();
        }
        return $this->where(['id_kecamatan' => $id_kecamatan])->first();
    }

    public function getAllKecamatan()
    {
        return $this->findAll();
    }
    public function getKecamatanbyName($nama_kecamatan)
    {
        return $this->where(['nama_kecamatan' => $nama_kecamatan])->first();
    }
    public function getKecamatanById($id_kecamatan)
    {
        return $this->where(['id_kecamatan' => $id_kecamatan])->first();
    }
}
