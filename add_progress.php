<?php
require_once("function.php");
if (empty($_SESSION["username"])) {
    return header("Location: " . basename("index.php"));
}
$id = $_GET["id"];
$anak = get_anak($id)->fetch_assoc();
?>

<?= head("Input Data Progress"); ?>
<div class="container">
    <div class="row">
        <div class="col-6" style="position: absolute;top: 50%; left: 50%; transform:translate(-50%, -50%);">
            <div class="card shadow p-4 mt-4 ">
                <h5 class="card-title text-center"><b>Buat Data Perkembangan Fisik</b></h5>
                <?php if (!empty($_SESSION["success"])) : ?>
                    <div class="alert alert-success" role="alert">
                        <?= $_SESSION["success"]; ?>
                        <?php unset($_SESSION["success"]); ?>
                    </div>
                <?php elseif (!empty($_SESSION["failed"])) : ?>
                    <div class="alert alert-failed" role="alert">
                        <?= $_SESSION["failed"]; ?>
                        <?php unset($_SESSION["failed"]); ?>
                    </div>
                <?php endif; ?>
                <div class="card-content">
                    <form action="function.php?func=insert-perkembangan" method="POST">
                        <div class="form-group mb-2">
                            <input type="hidden" name="id" id="id" value="<?= $id; ?>">
                            <?php $tanggal_lahir = date_format(new DateTime($anak["tanggal_lahir"]), "Y-m-d"); ?>
                            <input type="hidden" name="tanggal-lahir" id="tanggal-lahir" value="<?= $tanggal_lahir; ?>">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" value="<?= $anak["nama"]; ?>" readonly>
                        </div>
                        <div class="form-group mb-2">
                            <label for="tinggi-badan">Tinggi Badan</label>
                            <div class="input-group">
                                <?php $tinggi_badan_session = (!empty($_SESSION["tinggi_badan"]) ? $_SESSION["tinggi_badan"] : ""); ?>
                                <input type="text" value="<?= $tinggi_badan_session; ?>" name="tinggi-badan" id="tinggi-badan" class="form-control <?= (!empty($_SESSION["failed-height"]) ? "is-invalid" : ""); ?>" aria-describedby="basic-addon2">
                                <?php unset($_SESSION["tinggi_badan"]); ?>
                                <span class="input-group-text" id="basic-addon2">Cm</span>
                                <?php if (!empty($_SESSION["failed-height"])) : ?>
                                    <div class="invalid-feedback">
                                        <?= $_SESSION["failed-height"]; ?>
                                        <?php unset($_SESSION["failed-height"]); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                        <div class="form-group mb-2">
                            <label for="berat-badan">Berat Badan</label>
                            <div class="input-group">
                                <?php $berat_badan_session = (!empty($_SESSION["berat_badan"]) ? $_SESSION["berat_badan"] : ""); ?>
                                <input type="text" value="<?= $berat_badan_session; ?>" name="berat-badan" id="berat-badan" class="form-control <?= (!empty($_SESSION["failed-weight"]) ? "is-invalid" : ""); ?>">
                                <?php unset($_SESSION["berat_badan"]); ?>
                                <span class="input-group-text" id="basic-addon2">Kg</span>
                                <?php if (!empty($_SESSION["failed-weight"])) : ?>
                                    <div class="invalid-feedback">
                                        <?= $_SESSION["failed-weight"]; ?>
                                    </div>
                                    <?php unset($_SESSION["failed-weight"]) ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <input type="submit" name="new-data" id="new-data" class="btn btn-primary" value="Tambah Data">
                        <a href="<?= basename("perkembangan_anak.php?id=" . $anak["id"]); ?>" class="btn btn-link">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= footer(); ?>