<?php
require_once("function.php");
if (empty($_SESSION["username"])) {
    return header("Location: " . basename("index.php"));
}
?>

<?= head("Input Daftar Anak"); ?>
<div class="container mt-3">
    <div class="row">
        <div class="col">
            <div class="card p-4">
                <div class="card-content">
                    <h4 class="text-center mb-3"><b>Pendaftaran Anak</b></h4>
                    <form action="function.php?func=daftar-anak" method="POST">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" placeholder="E.g Budiman" name="nama" id="nama">
                                </div>

                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="orang-tua">Orang Tua</label>
                                    <input type="text" class="form-control" placeholder="E.g Budiman" name="orang-tua" id="orang-tua">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="tanggal-lahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control" placeholder="E.g Budiman" name="tanggal-lahir" id="tanggal-lahir">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="gender">Jenis Kelamin</label>
                                    <select name="gender" id="gender" class="form-select">
                                        <option value="null" selected>Pilih jenis kelamin anak...</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                        </div>
                        <button type="submit" name="daftar" class="btn btn-primary">Daftar</button>
                        <a href="<?= basename("home.php"); ?>" class="btn btn-link">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= footer(); ?>