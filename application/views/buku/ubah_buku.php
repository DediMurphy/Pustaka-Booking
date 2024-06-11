<!-- templates/header.php -->
<!DOCTYPE html>
<html>
<head>
    <title><?= $judul; ?></title>
    <!-- Load CSS and other head elements here -->
</head>
<body>
<!-- templates/sidebar.php -->
<!-- Load sidebar content here -->

<!-- templates/topbar.php -->
<!-- Load topbar content here -->

<!-- buku/ubah_buku.php -->
<div class="container">
    <h1><?= $judul; ?></h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $buku['id']; ?>">
        <input type="hidden" name="old_pict" value="<?= $buku['image']; ?>">
        <div class="form-group">
            <label for="judul_buku">Judul Buku</label>
            <input type="text" class="form-control" id="judul_buku" name="judul_buku" value="<?= $buku['judul_buku']; ?>">
            <?= form_error('judul_buku', '<small class="text-danger">', '</small>'); ?>
        </div>
        <div class="form-group">
            <label for="id_kategori">Kategori</label>
            <select class="form-control" id="id_kategori" name="id_kategori">
                <?php foreach ($kategori as $k): ?>
                    <option value="<?= $k['id_kategori']; ?>" <?= ($k['id_kategori'] == $buku['id_kategori']) ? 'selected' : ''; ?>><?= $k['nama_kategori']; ?></option>
                <?php endforeach; ?>
            </select>
            <?= form_error('id_kategori', '<small class="text-danger">', '</small>'); ?>
        </div>
        <div class="form-group">
            <label for="pengarang">Pengarang</label>
            <input type="text" class="form-control" id="pengarang" name="pengarang" value="<?= $buku['pengarang']; ?>">
            <?= form_error('pengarang', '<small class="text-danger">', '</small>'); ?>
        </div>
        <div class="form-group">
            <label for="penerbit">Penerbit</label>
            <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?= $buku['penerbit']; ?>">
            <?= form_error('penerbit', '<small class="text-danger">', '</small>'); ?>
        </div>
        <div class="form-group">
            <label for="tahun_terbit">Tahun Terbit</label>
            <input type="text" class="form-control" id="tahun_terbit" name="tahun_terbit" value="<?= $buku['tahun_terbit']; ?>">
            <?= form_error('tahun_terbit', '<small class="text-danger">', '</small>'); ?>
        </div>
        <div class="form-group">
            <label for="isbn">Nomor ISBN</label>
            <input type="text" class="form-control" id="isbn" name="isbn" value="<?= $buku['isbn']; ?>">
            <?= form_error('isbn', '<small class="text-danger">', '</small>'); ?>
        </div>
        <div class="form-group">
            <label for="stok">Stok</label>
            <input type="text" class="form-control" id="stok" name="stok" value="<?= $buku['stok']; ?>">
            <?= form_error('stok', '<small class="text-danger">', '</small>'); ?>
        </div>
        <div class="form-group">
            <label for="image">Gambar</label>
            <input type="file" class="form-control-file" id="image" name="image">
            <img src="<?= base_url('assets/img/upload/') . $buku['image']; ?>" alt="Gambar Buku" width="100">
        </div>
        <button type="submit" class="btn btn-primary">Ubah Data</button>
    </form>
</div>

<!-- templates/footer.php -->
<!-- Load footer content here -->
</body>
</html>
