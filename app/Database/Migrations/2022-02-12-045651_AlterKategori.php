<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterKategori extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('kategori', [
            'slug VARCHAR(100)'
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('kategori', 'slug');
    }
}
