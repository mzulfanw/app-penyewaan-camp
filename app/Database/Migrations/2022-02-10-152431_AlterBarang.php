<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterBarang extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('barang', [
            'kategori_id VARCHAR(10)'
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('barang', 'kategori_id');
    }
}
