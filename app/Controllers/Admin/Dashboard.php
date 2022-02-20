<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;
use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\TransaksiModel;

class Dashboard extends BaseController
{
    public function __construct()
    {
        // check if user is not logged in
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/auth'));
        }
    }

    public function Index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('/auth'));
        }
        $barang = new BarangModel();
        $user = new UserModel();
        $transaksi = new TransaksiModel();
        // Count data barang
        $data['barang'] = $barang->countAll();
        $data['user'] = $user->countAll();
        $data['transaksi'] = $transaksi->countAll();

        $data['stock'] =  $barang->cekStok()->getResult();


        return view('Admin/Dashboard', [
            'barang' => $data['barang'],
            'user' => $data['user'],
            'transaksi' => $data['transaksi'],
            'stock' => $data['stock']
        ]);
    }
}
