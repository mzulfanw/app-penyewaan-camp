<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\BarangModel;


class Home extends BaseController
{
    protected $barang;
    public function __construct()
    {
        $this->barang = new BarangModel();

        helper(['form', 'number']);
    }


    public function index()
    {
        $data = [
            'barang' => $this->barang->getBarangandKategori()->getResult(),
            'cart' => \Config\Services::cart()
        ];
        // dd($data);
        return view('welcome_message', $data);
    }


    public function detail($kategori, $slug)
    {
        $data = [
            'detail' => $this->barang->getSlugandKategori($kategori, $slug)->getRow(),
            'cart' => \Config\Services::cart()
        ];
        // dd($data);
        return view('detail', $data);
    }

    public function findBarang()
    {
        $cari = $this->request->getGet('search');
        $data = [
            'data' => $this->barang->searchByKategori($cari)->getResult(),
            'cart' => \Config\Services::cart()
        ];
        return view('Search',  $data);
    }


    // Shopping cart

    public function cek()
    {
        $cart = \Config\Services::cart();
        $response = $cart->contents();
        $data = json_encode($response);
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    public function add()
    {
        $cart = \Config\Services::cart();
        $cart->insert(array(
            'id' => $this->request->getPost('id'),
            'price' => $this->request->getPost('price'),
            'name' => $this->request->getPost('name'),
            'qty' => 1,
            'options' => array(
                'gambar' => $this->request->getPost('gambar'),
                'kategori' => $this->request->getPost('kategori')
            )
        ));
        session()->setFlashdata('pesan', 'Barang berhasil ditambahkan ke keranjang');
        return redirect()->back();
    }

    public function clear()
    {
        $cart = \Config\Services::cart();
        $cart->destroy();
        return redirect()->back();
    }

    public function cart()
    {
        $data = [
            'title' => 'Keranjang',
            'cart' => \Config\Services::cart(),
        ];

        return view('cart', $data);
    }


    public function update()
    {
        $cart = \Config\Services::cart();
        $i = 1;
        foreach ($cart->contents() as $value) {
            $cart->update(array(
                'rowid' => $value['rowid'],
                'qty' => $this->request->getPost('qty' . $i++)
            ));
        }
        session()->setFlashdata('pesan', 'Berhasil menambahkan quantity');
        return redirect()->to(base_url('home/cart'));
    }


    public function delete($rowid)
    {
        $cart = \Config\Services::cart();
        $cart->remove($rowid);
        session()->setFlashdata('pesan', 'Barang berhasil dihapus dari keranjang');
        return redirect()->to(base_url('home/cart'));
    }


    public function checkout()
    {
        $data = [
            'title' => 'Checkout',
            'cart' => \Config\Services::cart(),
        ];

        return view('cekout', $data);
    }

    public function finish()
    {
        if (!$this->validate([
            'potoktp' => [
                'rules' => 'uploaded[potoktp]|mime_in[potoktp,image/jpg,image/jpeg,image/gif,image/png]|max_size[potoktp,2048]',
                'errors' => [
                    'uploaded' => 'Harus Ada File yang diupload',
                    'mime_in' => 'File Extention Harus Berupa jpg,jpeg,gif,png',
                    'max_size' => 'Ukuran File Maksimal 2 MB'
                ]
            ],
            'pototf' => [
                'rules' => 'uploaded[pototf]|mime_in[pototf,image/jpg,image/jpeg,image/gif,image/png]|max_size[pototf,2048]',
                'errors' => [
                    'uploaded' => 'Harus Ada File yang diupload',
                    'mime_in' => 'File Extention Harus Berupa jpg,jpeg,gif,png',
                    'max_size' => 'Ukuran File Maksimal 2 MB'
                ]
            ],

        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }
        $transaksi = new TransaksiModel();
        $dataktp = $this->request->getFile('potoktp');
        $datatf = $this->request->getFile('pototf');
        $namaktp = $dataktp->getRandomName();
        $namatf = $datatf->getRandomName();
        $jumlah = $this->request->getPost('jumlah');
        $barang_id = $this->request->getPost('barang_id');
        $transaksi->insert([
            "barang_id" => $barang_id,
            "user_id" => $this->request->getPost('user_id'),
            "jumlah" => $this->request->getPost('jumlah'),
            "total_harga" => $this->request->getPost('total_harga'),
            "tanggal" => date('Y-m-d H:i:s'),
            "status" => "Sudah di Bayar",
            "payment_method" => $this->request->getPost('payment_method'),
            "potoktp" => $namaktp,
            "pototf" => $namatf,
        ]);
        $dataktp->move('./admin/assets/img/transaksi/ktp/', $namaktp);
        $datatf->move('./admin/assets/img/transaksi/tf/', $namatf);
        $cart = \Config\Services::cart();
        $cart->destroy();


        // mengurangi stok barang yang ada di table barang dengan cara melooping dan kurangi stok barang tersebut
        $barang = new BarangModel();
        // call all data $barang
        $data = $barang->findAll();
        foreach ($data as $value) {
            // take all stok from $value
            $stok = $value['stok'];
            // take all id from $value
            $id = $value['id'];
            // if id from $value is equal to id from $barang_id
            if ($id == $barang_id) {
                // then stok from $value minus stok from $barang_id
                $stok = $stok - $jumlah;
                // update stok from $value
                $barang->update(['id' => $id], ['stok' => $stok]);
            }
        }

        session()->setFlashdata('pesan', 'Sukses, Silahkan menunggu Admin untuk mengkonfirmasi pembayaran');
        return redirect()->to(base_url('/'));
    }
}
