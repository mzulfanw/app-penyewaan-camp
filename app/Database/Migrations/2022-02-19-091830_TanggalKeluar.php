<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TanggalKeluar extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('transaksi', [
            'tanggal_keluar DATE'
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('transaksi', 'tanggal_keluar');
    }
}
