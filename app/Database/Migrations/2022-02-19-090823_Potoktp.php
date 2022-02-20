<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Potoktp extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('transaksi', [
            'potoktp VARCHAR(100)'
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('transaksi', 'potoktp');
    }
}
