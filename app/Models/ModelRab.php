<?php

namespace App\Models;

use CodeIgniter\Model;
use LDAP\Result;

class ModelRab extends Model
{
    protected $table            = 't_rab';
    protected $primaryKey       = 'id_rab';
    protected $allowedFields    = ['id_rab', 'id_kecamatan', 'id_akun', 'bulan', 'tahun_anggaran', 'jumlah'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function Exportexcel($data)
    {
        return $this->insert($data);
    }
    public function uploadExcel($data)
    {
        return  $this->insert($data);
    }
    public function getAllRab()
    {
        return $this->findAll();
    }
    public function getKecamatanAkun()
    {
        $this->join('t_kecamatan', 't_kecamatan.id_kecamatan = t_rab.id_kecamatan', 'LEFT');
        $this->join('t_akun', 't_akun.id_akun = t_rab.id_akun', 'LEFT');
        $this->select('t_kecamatan.id_kecamatan');
        $this->select('t_kecamatan.nama_kecamatan');
        $this->select('t_akun.*');
        $this->select('t_rab.*');
        $this->orderBy('t_rab.id_rab');
        return $this->findAll();
    }
    public function getRabWhere($kecamatan, $bulan, $ta)
    {
        $this->where('id_kecamatan', $kecamatan);
        $this->where('bulan', $bulan);
        $this->where('tahun_anggaran', $ta);
        $this->findAll();
        $results = $this->get()->getResult();
        return $results;
    }
    public function getSumJumlah($kecamatan)
    {

        $query =  $this->selectSum('jumlah')->where('id_kecamatan', $kecamatan)->first();
        return   $query;
    }
    public function getRow($kecamatan)
    {

        $query =  $this->select('jumlah')->where('id_kecamatan', $kecamatan)->findAll();
        return   $query;
    }
}
