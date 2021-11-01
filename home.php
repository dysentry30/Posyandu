<?php
require_once("function.php");
if (empty($_SESSION["username"])) {
    return header("Location: " . basename("index.php"));
}
if (!empty($_GET["search-name"])) {
    $get_data_by_name = get_anak_by_name($_GET["search-name"]);
} else {
    $list_anak = get_list_anak();
}
?>
<?= head("List Anak"); ?>
<div class="container">
    <div class="row mt-5">
        <div class="col">
            <h4><b>Daftar Anak</b></h4>
            <div class="row">
                <?php if (!empty($list_anak) || !empty($get_data_by_name)) : ?>
                    <div class="col-2">
                        <a href="<?= basename("daftar_anak.php"); ?>" class="btn btn-primary">Pendaftaran Anak</a>
                    </div>
                <?php endif; ?>
                <div class="col">
                    <form action="" method="GET">
                        <input type="text" class="form-control" placeholder="Cari nama..." id="search-name" name="search-name">
                    </form>
                </div>
            </div>
            <?php if (!empty($_SESSION["success"])) : ?>
                <div class="alert alert-success"><?= $_SESSION["success"]; ?></div>
                <?php unset($_SESSION["success"]); ?>
            <?php elseif (!empty($_SESSION["failed"])) : ?>
                <div class="alert alert-danger"><?= $_SESSION["failed"]; ?></div>
                <?php unset($_SESSION["failed"]); ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col">
            <?php if (!empty($list_anak)) : ?>
                <table class="table table-striped">
                    <thead>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Tanggal Lahir</th>
                        <th scope="col">Orang Tua</th>
                        <th scope="col">Jenis Kelamin</th>
                        <th scope="col">Umur</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Tanggal Dibuat</th>
                        <th scope="col">Aksi</th>
                    </thead>

                    <tbody>
                        <?php $no = 0; ?>
                        <?php foreach ($list_anak as $anak) : ?>
                            <tr>
                                <?php $tanggal_lahir = date_create($anak["tanggal_lahir"]); ?>
                                <?php $now = date_create("now") ?>
                                <?php $umur = $now->diff($tanggal_lahir)->y ?>
                                <?php $created_at = date_format(new DateTime($anak["created_at"]), "d F Y") ?>
                                <th class="align-middle" scope="row"><?= ++$no; ?></th>
                                <td class="align-middle"><?= $anak["nama"]; ?></td>
                                <td class="align-middle"><?= $tanggal_lahir->format("d F Y"); ?></td>
                                <td class="align-middle"><?= $anak["orang_tua"]; ?></td>
                                <td class="align-middle"><?= $anak["gender"]; ?></td>
                                <td class="align-middle"><?= $umur; ?></td>
                                <td class="align-middle" style="max-width:250px; word-wrap: break-word;"><?= $anak["alamat"]; ?></td>
                                <td class="align-middle"><?= $created_at; ?></td>
                                <td class="align-middle">
                                    <a href="edit-profile.php?id=<?= $anak["id"]; ?>" class="btn btn-primary mb-2">Edit Identitas Anak</a>
                                    <!-- <a href="vaksin.php?id=<?= $anak["id"]; ?>" class="btn btn-success">Get Vaksin</a> -->
                                    <a href="perkembangan_anak.php?id=<?= $anak["id"]; ?>" class="btn btn-warning mb-2">Lihat Perkembangan</a>
                                    <a href="perkembangan_anak.php?func=delete-anak&id=<?= $anak["id"]; ?>" class="btn btn-danger">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php elseif (!empty($get_data_by_name)) :  ?>
                <table class="table table-striped">
                    <thead>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Tanggal Lahir</th>
                        <th scope="col">Orang Tua</th>
                        <th scope="col">Jenis Kelamin</th>
                        <th scope="col">Umur</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Tanggal Dibuat</th>
                        <th scope="col">Aksi</th>
                    </thead>

                    <tbody>
                        <?php $no = 0; ?>
                        <?php foreach ($get_data_by_name as $anak) : ?>
                            <tr>
                                <?php $tanggal_lahir = date_create($anak["tanggal_lahir"]); ?>
                                <?php $now = date_create("now") ?>
                                <?php $umur = $now->diff($tanggal_lahir)->y ?>
                                <?php $created_at = date_format(new DateTime($anak["created_at"]), "d F Y") ?>
                                <th class="align-middle" scope="row"><?= ++$no; ?></th>
                                <td class="align-middle"><?= $anak["nama"]; ?></td>
                                <td class="align-middle"><?= $tanggal_lahir->format("d F Y"); ?></td>
                                <td class="align-middle"><?= $anak["orang_tua"]; ?></td>
                                <td class="align-middle"><?= $anak["gender"]; ?></td>
                                <td class="align-middle"><?= $umur; ?></td>
                                <td class="align-middle" style="max-width:250px; word-wrap: break-word;"><?= $anak["alamat"]; ?></td>
                                <td class="align-middle"><?= $created_at; ?></td>
                                <td class="align-middle">
                                    <a href="edit-profile.php?id=<?= $anak["id"]; ?>" class="btn btn-primary mb-2">Edit Identitas Anak</a>
                                    <!-- <a href="vaksin.php?id=<?= $anak["id"]; ?>" class="btn btn-success">Get Vaksin</a> -->
                                    <a href="perkembangan_anak.php?id=<?= $anak["id"]; ?>" class="btn btn-warning mb-2">Lihat Perkembangan</a>
                                    <a href="perkembangan_anak.php?func=delete-anak&id=<?= $anak["id"]; ?>" class="btn btn-danger">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="text-center">
                    <p><b>Data tidak ditemukan</b></p>
                    <p>Silahkan mendaftarkan anak ke posyandu melalui tombol dibawah ini ⬇</p>
                    <a href="<?= basename("daftar_anak.php"); ?>" class="btn btn-primary">Pendaftaran Anak</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= footer(); ?>