<?php 
    require_once("function.php");
    if (empty($_SESSION["username"])) {
        return header("Location: " . basename("index.php"));
    }
    $id = $_GET["id"];
    $get_anak = get_anak($id)->fetch_assoc();
    
?>

<?= head("Edit Profile Anak"); ?>
<div class="container mt-3">
    <div class="row">
        <div class="col">
            <div class="card p-4">
                <div class="card-content">
                    <h4 class="text-center mb-3"><b>Edit Identitas Anak</b></h4>
                    <form action="function.php?func=edit-profile" method="POST">
                        <input type="hidden" name="id" id="id" value="<?= $get_anak["id"]; ?>">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" value="<?= $get_anak["nama"]; ?>" class="form-control" placeholder="E.g Budiman" name="nama" id="nama">
                                </div>

                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="orang-tua">Orang Tua</label>
                                    <input type="text" value="<?= $get_anak["orang_tua"]; ?>" class="form-control" placeholder="E.g Budiman" name="orang-tua" id="orang-tua">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <?php $tanggal_lahir = date_format(new DateTime($get_anak["tanggal_lahir"]), "Y-m-d"); ?>
                                    <label for="tanggal-lahir">Tanggal Lahir</label>
                                    <input type="date" value="<?= $tanggal_lahir; ?>" class="form-control" placeholder="E.g Budiman" name="tanggal-lahir" id="tanggal-lahir">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="gender">Jenis Kelamin</label>
                                    <select name="gender" id="gender" class="form-select">
                                        <option value="null" <?= empty($get_anak["gender"]) ? "selected" : ""; ?>>Pilih jenis kelamin anak...</option>
                                        <option value="Laki-laki" <?= $get_anak["gender"] == "Laki-laki" ? "selected" : ""; ?>>Laki-laki</option>
                                        <option value="Perempuan" <?= $get_anak["gender"] == "Perempuan" ? "selected" : ""; ?>>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" ><?= $get_anak["alamat"]; ?></textarea>
                        </div>
                        <button type="submit" name="Edit" class="btn btn-primary">Edit</button>
                        <a href="<?= basename("home.php"); ?>" class="btn btn-link">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= footer(); ?>