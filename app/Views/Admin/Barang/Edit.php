<?= $this->extend('Admin\Layouts\header')  ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Update Data Barang</h3>
        </div>
        <div class="card-body">
            <?php if (!empty(session()->getFlashdata('error'))) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4>Periksa Kembali</h4>
                    </hr />
                    <?php echo session()->getFlashdata('error'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            <form action="<?= base_url("/admin/barang/update/" . $barang['id']) ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nama Barang *</label>
                    <input type="text" class="form-control" name="nama_barang" placeholder="Masukan Nama Barang" value="<?= $barang['nama_barang']; ?>">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Harga *</label>
                    <input type="number" class="form-control" name="harga" placeholder="Masukan Harga" value="<?= $barang['harga']; ?>">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Stok *</label>
                    <input type="number" class="form-control" name="stok" placeholder="Masukan Stok" value="<?= $barang['stok']; ?>">
                </div>
                <div class="mb-3">
                    <label for="berkas" class="form-label">Gambar *</label>
                    <input type="file" class="form-control" id="berkas" name="gambar">
                </div>
                <select class="form-select" name="kategori_id" aria-label="Default select example">
                    <option selected>-- Pilih Kategori --</option>
                    <?php foreach ($kategori as $k) : ?>
                        <option value="<?= $k['id'] ?>" selected><?= $k['nama_kategori'] ?></option>

                    <?php endforeach; ?>
                </select>
                <div class="mb-3">
                    <label for="" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="keterangan" name="deskripsi" rows="3"><?= $barang['deskripsi'] ?></textarea>
                </div>
                <div class="mb-3">
                    <input type="submit" class="btn btn-primary btn-sm" value="Simpan">
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>