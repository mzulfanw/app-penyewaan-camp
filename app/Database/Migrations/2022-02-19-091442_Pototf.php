<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pototf extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('transaksi', [
            'pototf VARCHAR(100)'
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('transaksi', 'pototf');
    }
}
