<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KondisiLingkungan extends Migration
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
            'kualitas_air' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'kualitas_udara' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'keanekaragaman_hayati' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_master_data', 'master_data', 'id');
        $this->forge->createTable('kondisi_lingkungan');
    }

    public function down()
    {
        $this->forge->dropTable('kondisi_lingkungan');
    }
}
