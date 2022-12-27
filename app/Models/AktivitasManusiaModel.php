<?php

namespace App\Models;

use CodeIgniter\Model;

class AktivitasManusiaModel extends Model
{
    protected $table = 'aktivitas_manusia';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'id_master_data','kode_wilayah', 'jenis_aktivitas','intensitas','dampak_potensial'
    ];
    protected $returnType = 'App\Entities\AktivitasManusia';
    protected $useTimestamps = false;
}
