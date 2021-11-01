<?php
require_once("function.php");
if (empty($_SESSION["username"])) {
    return header("Location: " . basename("index.php"));
}
$id = $_GET["id"];
$list_vaksin_anak = get_vaksin_list_data($id, 0);
?>

<?= head("List Vaksin"); ?>
<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h5><b>List Vaksin</b></h5>
            <?php if (!empty($_SESSION["success"])) : ?>
                <div class="alert alert-success">
                    <?= $_SESSION["success"]; ?>
                    <?php unset($_SESSION["success"]) ?>
                </div>
            <?php elseif (!empty($_SESSION["failed"])) : ?>
                <div class="alert alert-danger">
                    <?= $_SESSION["failed"]; ?>
                    <?php unset($_SESSION["failed"]) ?>
                </div>
            <?php endif; ?>
            <?php if ($list_vaksin_anak->num_rows > 0) : ?>
                <a href="<?= basename("new_vaksin.php?id=" . $id); ?>" class="btn btn-primary mb-4">Buat Data Vaksin Baru</a>
                <table class="table table-striped">
                    <thead>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Vaksin Name</th>
                        <th scope="col">Sudah Disuntikkan</th>
                        <th scope="col">Injection Time</th>
                        <th scope="col">Created Time</th>
                        <th scope="col">Actions</th>
                    </thead>

                    <tbody>
                        <?php $no = 0; ?>
                        <?php foreach ($list_vaksin_anak as $vaksin) : ?>
                            <?php $injection_time_formatted = date_format(new DateTime($vaksin["injected_at"]), "d F Y"); ?>
                            <?php $created_at_formatted = date_format(new DateTime($vaksin["created_at"]), "d F Y"); ?>
                            <?php $is_injected = ($vaksin["is_injected"] == "0" ? "Belum" : "Sudah")?>
                            <tr>
                                <th class="align-middle" scope="row"><?= ++$no; ?></th>
                                <td class="align-middle"><?= $vaksin["nama"]; ?></td>
                                <td class="align-middle"><?= $vaksin["nama_vaksin"]; ?></td>
                                <td class="align-middle"><?= $is_injected; ?></td>
                                <td class="align-middle"><?= $injection_time_formatted; ?></td>
                                <td class="align-middle"><?= $created_at_formatted; ?></td>
                                <td class="align-middle">
                                    <!-- <a href="<?= basename("function.php?func=delete-vaksin&child_id=". $vaksin["child_id"] . "&id=" . $vaksin["id"]); ?>" class="btn btn-danger">Delete</a> -->
                                    <a href="<?= basename("function.php?func=sudah-vaksin&id=" . $vaksin["id"]); ?>" class="btn btn-success">Already Being Injected?</a>
                                    <a href="<?= basename("update-vaksin.php?id=" . $vaksin["id"]); ?>" class="btn btn-warning">Edit Vaksin</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            <?php else : ?>
                <div class="text-center">
                    <p><b>Data Tidak Ditemukan</b></p>
                    <p>Silahkan klik tombol dibawah ini untuk membuat data vaksin</p>
                    <a href="<?= basename("new_vaksin.php?id=" . $id); ?>" class="btn btn-primary mb-4">Buat Data Vaksin Baru</a>
                </div>
            <?php endif; ?>
            <p>*Note: Tekan tombol <b>Sudah disuntik?</b> jika imunisasi sudah disuntikkan ke anak</p>
        </div>
    </div>
</div>
<?= footer(); ?>