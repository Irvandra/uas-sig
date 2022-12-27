<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HubunganSDAKL extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_master_data' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'kode_wilayah' => [
                'type' => 'VARCHAR',
                'constraint' => 7
            ],
            'dampak_SDAKL' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'pengelolaan_SDAKL' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_master_data', 'master_data', 'id');
        $this->forge->createTable('hubungan_sdakl');
    }

    public function down()
    {
        $this->forge->dropTable('hubungan_sdakl');
    }
}
