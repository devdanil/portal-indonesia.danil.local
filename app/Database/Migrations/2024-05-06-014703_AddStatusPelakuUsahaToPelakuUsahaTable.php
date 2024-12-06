<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusPelakuUsahaToPelakuUsahaTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pelaku_usaha', [
            'status_pelaku_usaha' => [
                'type' => 'VARCHAR',
                'constraint' => 125, // Adjust constraint as needed
                'null' => true, // Set to true if the field can be NULL
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pelaku_usaha','status_pelaku_usaha');
    }
}
