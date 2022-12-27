<?php

namespace App\Models;

use CodeIgniter\Model;

class HubunganSDAAMModel extends Model
{
    protected $table = 'hubungan_sdaam';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'id_master_data', 'kode_wilayah', 'dampak_SDAAM', 'pengelolaan_SDAAM'
    ];
    protected $returnType = 'App\Entities\SumberDayaAlam';
    protected $useTimestamps = false;
}
