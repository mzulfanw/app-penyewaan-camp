<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterBarang extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('barang', [
            'slug VARCHAR(100)'
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('barang', 'slug');
    }
}
