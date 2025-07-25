<?php

namespace App\Models;

use CodeIgniter\Model;
use SQLite3;

class ModelAkun extends Model
{
    protected $table = 't_akun';
    protected $primaryKey = 'id_akun';
    protected $allowedFields = [
        'kementerian',
        'program',
        'kegiatan',
        'output',
        'komponen',
        'sub_komponen',
        'kode_akun',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getAkunById($id)
    {
        return $this->find($id);
    }

    public function getAllAkun()
    {
        return $this->findAll();
    }

    public function createAkun($data)
    {
        return $this->insert($data);
    }

    public function updateAkun($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteAkun($id)
    {
        return $this->delete($id);
    }
}
