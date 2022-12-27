<?php

namespace App\Models;

use CodeIgniter\Model;

class SumberDayaAlamModel extends Model
{
    protected $table = 'sumber_daya_alam';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'id_master_data', 'kode_wilayah', 'jenis_sumber_daya', 'kondisi', 'ketersediaan'
    ];
    protected $returnType = 'App\Entities\SumberDayaAlam';
    protected $useTimestamps = false;
}
