<?php

namespace App\Models;

use CodeIgniter\Model;

class KondisiLingkunganModel extends Model
{
    protected $table = 'kondisi_lingkungan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'id_master_data','kode_wilayah','kualitas_air','kualitas_udara','keanekaragaman_hayati'
    ];
    protected $returnType = 'App\Entities\KondisiLingkungan';
    protected $useTimestamps = false;
}
