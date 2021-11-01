<?php
require_once("function.php");
if (empty($_SESSION["username"])) {
    return header("Location: " . basename("index.php"));
}
$id = $_GET["id"];
$vaksin_data = get_vaksin_single_data($id)->fetch_assoc();
print_r($vaksin_data);
?>

<?= head("Input Data Vaksin"); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card p-4 mt-4">
                <h5 class="card-title text-center"><b>Perbarui Data Imunisasi</b></h5>
                <div class="card-content">
                    <form action="function.php?func=update-vaksin" method="POST">
                        <div class="form-group mb-3">
                            <input type="hidden" name="id" id="id" value="<?= $vaksin_data["id"]; ?>">
                            <input type="hidden" name="child_id" id="child_id" value="<?= $vaksin_data["child_id"]; ?>">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" value="<?= $vaksin_data["nama"]; ?>" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="vaksin-name">Nama Imunisasi</label>
                            <select class="form-select <?= (!empty($_SESSION["failed-vaksin"]) ? "is-invalid" : ""); ?>" name="vaksin-name" id="vaksin-name">
                                <option value="null" <?= ($vaksin_data["nama_vaksin"] == null ? "selected" : ""); ?> >Choose vaksin</option>
                                <option value="Tetanus" <?= ($vaksin_data["nama_vaksin"] == "Tetanus" ? "selected" : ""); ?>>Tetanus</option>
                                <option value="Tuberkulosis" <?= ($vaksin_data["nama_vaksin"] == "Tuberkulosis" ? "selected" : ""); ?>>Tuberkulosis</option>
                                <option value="Difteri Pertusis Tetanus" <?= ($vaksin_data["nama_vaksin"] == "Difteri Pertusis Tetanus" ? "selected" : ""); ?>>Difteri Pertusis Tetanus</option>
                                <option value="Polio" <?= ($vaksin_data["nama_vaksin"] == "Polio" ? "selected" : ""); ?>>Polio</option>
                                <option value="Campak" <?= ($vaksin_data["nama_vaksin"] == "Campak" ? "selected" : ""); ?>>Campak</option>
                                <option value="Hepatitis B" <?= ($vaksin_data["nama_vaksin"] == "Hepatitis B" ? "selected" : ""); ?>>Hepatitis B</option>
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
                            <?php $injection_at = date_format(new DateTime($vaksin_data["injected_at"]), "Y-m-d") ?>
                            <input type="date" value="<?= $injection_at; ?>" name="injection-time" id="injection-time" class="form-control <?= (!empty($_SESSION["failed-injection-time"]) ? "is-invalid" : ""); ?>">
                            <?php if(!empty($_SESSION["failed-injection-time"])): ?>
                            <div class="invalid-feedback">
                                <?= $_SESSION["failed-injection-time"]; ?>
                            </div>
                            <?php unset($_SESSION["failed-injection-time"]) ?>
                            <?php endif; ?>
                        </div>
                        <input type="submit" name="update-vaksin" id="update-vaksin" class="btn btn-primary" value="Perbarui Data Imunisasi">
                        <a href="<?= basename("perkembangan_anak.php?id=" . $vaksin_data["child_id"]); ?>" class="btn btn-link">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= footer(); ?>