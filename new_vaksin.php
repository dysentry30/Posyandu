<?php
require_once("function.php");
if (empty($_SESSION["username"])) {
    return header("Location: " . basename("index.php"));
}
$id = $_GET["id"];
$anak = get_anak($id)->fetch_assoc();
?>

<?= head("Input Data Imunisasi"); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card p-4 mt-4">
                <h5 class="card-title text-center"><b>Buat Data Imunisasi</b></h5>
                <div class="card-content">
                    <form action="function.php?func=insert-vaksin" method="POST">
                        <div class="form-group mb-3">
                            <input type="hidden" name="id" id="id" value="<?= $id; ?>">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" value="<?= $anak["nama"]; ?>" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="vaksin-name">Nama Imunisasi</label>
                            <select class="form-select <?= (!empty($_SESSION["failed-vaksin"]) ? "is-invalid" : ""); ?>" name="vaksin-name" id="vaksin-name">
                                <option value="null" selected>Pilih Imunisasi..</option>
                                <option value="Tetanus">Tetanus</option>
                                <option value="Tuberkulosis">Tuberkulosis</option>
                                <option value="Difteri Pertusis Tetanus">Difteri Pertusis Tetanus</option>
                                <option value="Polio">Polio</option>
                                <option value="Campak">Campak</option>
                                <option value="Hepatitis B">Hepatitis B</option>
                            </select>
                            <?php if(!empty($_SESSION["failed-vaksin"])): ?>
                            <div class="invalid-feedback">
                                <?= $_SESSION["failed-vaksin"]; ?>
                                <?php unset($_SESSION["failed-vaksin"]); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group mb-3">
                            <label for="injection-time">Disuntik pada tanggal</label>
                            <input type="date" name="injection-time" id="injection-time" class="form-control <?= (!empty($_SESSION["failed-injection-time"]) ? "is-invalid" : ""); ?>">
                            <?php if(!empty($_SESSION["failed-injection-time"])): ?>
                            <div class="invalid-feedback">
                                <?= $_SESSION["failed-injection-time"]; ?>
                            </div>
                            <?php unset($_SESSION["failed-injection-time"]) ?>
                            <?php endif; ?>
                        </div>
                        <input type="submit" name="new-vaksin" id="new-vaksin" class="btn btn-primary" value="Buat Data Imunisasi">
                        <a href="<?= basename("perkembangan_anak.php?id=" . $anak["id"]); ?>" class="btn btn-link">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= footer(); ?>