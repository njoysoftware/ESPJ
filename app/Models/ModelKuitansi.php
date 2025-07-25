<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKuitansi extends Model
{
    protected $table = 't_kuitansi';
    protected $primaryKey = 'id_kuitansi';
    protected $allowedFields = ['nomor', 'nama_toko', 'nama_penerima', 'keterangan', 'bruto', 'pajak', 'netto', 'tanggal'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getKuitansiById($id)
    {
        return $this->where('id_kuitansi', $id)->first();
    }

    public function getAllKuitansi()
    {
        return $this->findAll();
    }
    public function deleteKuitansi($id)
    {
        return $this->delete($id);
    }
    public function createKuitansi($data)
    {
        return $this->insert($data);
    }
    public function updateKuitansi($id, $data)
    {
        return $this->update($id, $data);
    }
}
