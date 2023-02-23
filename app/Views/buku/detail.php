<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col">
            <h1>DETAIL BUKU </h1>
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="/img/<?= $buku['sampul']; ?>" alt="sampul buku" width="150">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $buku['judul']; ?></h5>
                            <p class="card-text"><b>Pengarang: <?= $buku['pengarang']; ?></b></p>
                            <p class="card-text"><small class="text-muted">Penerbit: <?= $buku['penerbit']; ?></small></p>
                            <p class="card-text"><small class="text-muted">Tahun Terbit: <?= $buku['tahun_terbit']; ?></small></p>
                            <a href="/buku/ubah/<?= $buku['id_buku']; ?>" class="btn btn-warning">Ubah</a>
                            <form action="/buku/<?= $buku['id_buku'] ?>" method="post" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                            <br><br>
                            <a href="/buku">Kembali ke Daftar Buku</a>
                        </div>
                    </div>
                </div>
            </div>
            <?= $this->endSection() ?>
        </div>
    </div>
</div>