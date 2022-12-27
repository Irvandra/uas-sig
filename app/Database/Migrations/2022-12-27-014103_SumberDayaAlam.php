<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SumberDayaAlam extends Migration
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
            'jenis_sumber_daya' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'kondisi' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'ketersediaan' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_master_data', 'master_data', 'id');
        $this->forge->createTable('sumber_daya_alam');
    }

    public function down()
    {
        $this->forge->dropTable('sumber_daya_alam');
    }
}
