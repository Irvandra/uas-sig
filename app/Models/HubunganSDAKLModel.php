<?php

namespace App\Models;

use CodeIgniter\Model;

class HubunganSDAKLModel extends Model
{
    protected $table = 'hubungan_sdakl';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'id_master_data','kode_wilayah','dampak_SDAKL','pengelolaan_SDAKL'
    ];
    protected $returnType = 'App\Entities\HubunganSDAKL';
    protected $useTimestamps = false;
}
