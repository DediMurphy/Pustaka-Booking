<div class="container-fluid">

    <?= $this->session->flashdata('pesan'); ?>
    <div class="row">
        <div class="col-lg-6">
            <form action="<?= base_url('buku/ubahKategori/' . $kategori['id_kategori']); ?>" method="post">
                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <input type="text" class="form-control" id="kategori" name="kategori" value="<?= $kategori['nama_kategori']; ?>">
                    <?= form_error('kategori', '<small class="text-danger">', '</small>'); ?>
                </div>
                <button type="submit" class="btn btn-primary">Ubah</button>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
