<?php
require_once("function.php");
if (empty($_SESSION["username"])) {
    return header("Location: " . basename("index.php"));
}
$id = $_GET["id"];
$data_proggress = get_health_progress_anak($id);
$anak = get_anak($id)->fetch_assoc();
$get_injected_vaksin = get_vaksin_list_data($id, 1);
$get_not_injected_vaksin = get_vaksin_list_data($id, 0);
?>

<?= head("Health Report for " . $anak["nama"]); ?>
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        overflow: hidden;
    }

    tbody {
        display: block;
        height: 50px;
        overflow: auto;
    }

    thead,
    tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
        /* even columns width , fix width of table too*/
    }

    thead {
        width: calc(100% - 1em)
            /* scrollbar is average 1em/16px width, remove it from thead width */
    }

    table {
        width: 400px;
    }
</style>
<div class="container mt-2">
    <div class="row">
        <?php if ($data_proggress->num_rows > 0) : ?>
            <div class="col-6">
                <h2><b>Perkembangan Anak</b></h2>
                <?php if (!empty($_SESSION["success"]) || !empty($_SESSION["failed"])) : ?>
                    <div id="myModal" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><b>Sukses</b></h5>
                                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php if (!empty($_SESSION["success"])) : ?>
                                        <div class="alert alert-success">
                                            <p><?= $_SESSION["success"]; ?></p>
                                        </div>
                                        <?php unset($_SESSION["success"]) ?>
                                    <?php elseif (!empty($_SESSION["failed"])) : ?>
                                        <div class="alert alert-danger">
                                            <p><?= $_SESSION["failed"]; ?></p>
                                        </div>
                                        <?php unset($_SESSION["failed"]) ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input id="showModal" type="hidden" data-bs-toggle="modal" data-bs-target="#myModal">

                    <script>
                        const showModalBtn = document.getElementById("showModal");
                        setTimeout(() => {
                            showModalBtn.click();
                        }, 100);
                    </script>
                <?php endif; ?>
                <div class="card mt-6 shadow">
                    <div class="card-body">
                        <?php $tanggal_lahir = date_create($anak["tanggal_lahir"]) ?>
                        <?php $now = date_create("now") ?>
                        <h3 class="card-title"><b><?= $anak["nama"]; ?></b></h3>
                        <p class="card-subtitle text-muted">Tanggal Lahir: <b><?= $tanggal_lahir->format("d F Y") ?></b></p>
                        <p class="card-subtitle text-muted">Umur: <b><?= $now->diff($tanggal_lahir)->y; ?> Tahun, <?= $now->diff($tanggal_lahir)->m; ?> Bulan, <?= $now->diff($tanggal_lahir)->d; ?> Hari</b></p>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card mt-5">
                    <div class="card-body shadow">
                        <h3 class="card-title"><b>Perkembangan Fisik Anak</b></h3>
                        <canvas id="chart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-6" style="position: relative;top:-200px">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title"><b>Perkembangan Imunisasi & Fisik</b></h3>
                        <div class="row mb-3">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="physical-tab" data-bs-toggle="tab" href="#physical" role="tab" aria-controls="physical" aria-selected="true">Perkembangan Fisik</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="list-vaksin-tab" data-bs-toggle="tab" href="#list-vaksin" role="tab" aria-controls="list-vaksin" aria-selected="false">Riwayat Imunisasi</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Data Imunisasi</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="myTabs">
                            <div class="tab-pane fade show active" id="physical" role="tabpanel" aria-labelledby="physical-tab">
                                <?php if ($data_proggress->num_rows > 0) : ?>
                                    <table class="table table-striped table-sm">
                                        <thead style="text-align: center;">
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Tinggi Badan (cm)</th>
                                            <th>Berat Badan (kg)</th>
                                            <th>Umur</th>
                                            <th>Aksi</th>
                                        </thead>
                                        <tbody style="display: block;height: 196px !important; overflow-y: scroll;">
                                            <?php $no = 0; ?>
                                            <?php foreach ($data_proggress as $progress) : ?>
                                                <tr style="text-align: center;">
                                                    <th class="align-middle"><?= ++$no; ?></th>
                                                    <td class="align-middle" style="max-width:196px; word-wrap: break-word;"><?= $progress["nama"]; ?></td>
                                                    <td class="align-middle"><?= $progress["tinggi_badan"]; ?></td>
                                                    <td class="align-middle"><?= $progress["berat_badan"]; ?></td>
                                                    <td class="align-middle"><?= $progress["umur"]; ?></td> 
                                                    <td class="align-middle">
                                                        <a href="<?= basename("function.php?func=delete-data&id=" . $progress["id"]) . "&child_id=" . $progress["child_id"]; ?>" class="btn btn-danger">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else : ?>
                                    <div class="text-center">
                                        <p><b>Data Tidak Ditemukan</b></p>
                                        <p>Silahkan tekan tombol <b>Buat Perkembangan Fisik</b> disebelah kanan untuk menambahkan proses perkembangan anak</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="tab-pane fade" id="list-vaksin" role="tabpanel" aria-labelledby="list-vaksin-tab">
                                <?php if ($get_injected_vaksin->num_rows > 0) : ?>
                                    <table class="table table-striped table-sm;">
                                        <thead style="text-align: center;">
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th style="max-width:160px;">Nama Imunisasi</th>
                                            <th style="max-width:196px;">Disuntik pada tanggal</th>
                                            <th>Aksi</th>
                                        </thead>
                                        <tbody style="overflow-y: scroll;height: 196px !important;">
                                            <?php $no = 0; ?>
                                            <?php foreach ($get_injected_vaksin as $injected) : ?>
                                                <?php $injected_at = date_format(date_create($injected["injected_at"]), "d F Y"); ?>
                                                <tr style="text-align: center;">
                                                    <th class="align-middle"><?= ++$no; ?></th>
                                                    <td class="align-middle" style=""><?= $injected["nama"]; ?></td>
                                                    <td class="align-middle"><?= $injected["nama_vaksin"]; ?></td>
                                                    <td class="align-middle"><?= $injected_at; ?></td>
                                                    <td class="align-middle">
                                                        <a href="<?= basename("function.php?func=delete-vaksin&id=" . $injected["id"]) . "&child_id=" . $injected["child_id"]; ?>" class="btn btn-danger">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else : ?>
                                    <div class="text-center">
                                        <p><b>Data Tidak Ditemukan</b></p>
                                        <p>Silahkan cek pada kolom <b>Data Imunisasi</b> dan tekan tombol <b>Sudah disuntik</b> jika vaksin sudah disuntikan ke anak.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                <?php if ($get_not_injected_vaksin->num_rows > 0) : ?>

                                    <table class="table table-striped table-sm">
                                        <thead style="text-align: center;">
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Nama Imunisasi</th>
                                            <th>Tanggal disuntik</th>
                                            <th>Aksi</th>
                                        </thead>
                                        <tbody style="display: block;overflow-y: scroll;height:196px;">
                                            <?php $no = 0; ?>
                                            <?php foreach ($get_not_injected_vaksin as $injecting) : ?>
                                                <?php $injecting_on = date_format(date_create($injecting["injected_at"]), "d F Y"); ?>
                                                <tr style="text-align: center;margin: 10px 0;">
                                                    <th class="align-middle"><?= ++$no; ?></th>
                                                    <td class="align-middle" style="max-width:196px; word-wrap: break-word;"><?= $injecting["nama"]; ?></td>
                                                    <td class="align-middle"><?= $injecting["nama_vaksin"]; ?></td>
                                                    <td class="align-middle"><?= $injecting_on; ?></td>
                                                    <td class="align-middle" style="text-align: start;">
                                                        <a href="<?= basename("function.php?func=sudah-vaksin&child_id=" . $injecting["child_id"] . "&id=" . $injecting["id"]); ?>" class="btn btn-success btn-sm">Sudah disuntik</a>
                                                        <a href="<?= basename("update-vaksin.php?id=" . $injecting["id"]); ?>" class="btn btn-warning btn-sm mt-2">Edit Imunisasi</a>
                                                        <!-- <a href="<?= basename("function.php?func=delete-vaksin&id=" . $injecting["id"]) . "&child_id=" . $injected["child_id"]; ?>" class="btn btn-danger">Delete</a> -->
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else : ?>
                                    <div class="text-center">
                                        <p><b>Data Tidak Ditemukan</b></p>
                                        <p>Silahkan tekan tombol dibawah ini untuk membuat data vaksin baru</p>
                                        <a href="<?= basename("new_vaksin.php?id=" . $id); ?>" class="btn btn-primary mb-4">Buat Data Imunisasi Baru</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 mt-4">
                <a href="<?= basename("add_progress.php?id=$id"); ?>" class="btn btn-primary btn-block">Buat Perkembangan Fisik</a>
                <a href="<?= basename("new_vaksin.php?id=" . $id); ?>" class="btn btn-warning">Buat Data Imunisasi Baru</a>
                <!-- <a href="<?= basename("vaksin.php?id=$id"); ?>" class="btn btn-success btn-block">Get Imunisasi</a> -->
                <a href="<?= basename("home.php"); ?>" class="btn btn-link btn-block">Kembali</a>
            </div>
    </div>
<?php else : ?>
    <div class="col">
        <h2><b>Health Report</b></h2>
        <div class="text-center">
            <p><b>Data Tidak Ditemukan</b></p>
            <p>Silahkan pilih salah satu tombol dibawah ini</p>
            <a href="<?= basename("add_progress.php?id=$id"); ?>" class="btn btn-primary btn-block">Buat Data Perkembangan Fisik</a>
            <!-- <a href="<?= basename("vaksin.php?id=$id"); ?>" class="btn btn-success btn-block">Get Imunisasi</a> -->
            <a href="<?= basename("home.php"); ?>" class="btn btn-link btn-block">Kembali</a>
        </div>
    </div>
<?php endif ?>
</div>
<?= footer(); ?>
<script>
    window.addEventListener("DOMContentLoaded", async () => {
        const id = "<?= $id; ?>";
        let tinggi_badan = [];
        let berat_badan = [];
        let created_at = [];
        await fetch(`function.php?func=get-perkembangan&id=${id}`)
            .then(resolve => resolve.json())
            .then(result => {
                const ctx = document.getElementById("chart").getContext("2d");
                result.forEach(data => {
                    tinggi_badan.push(data.tinggi_badan);
                    berat_badan.push(data.berat_badan);
                    created_at.push(data.created_at);
                });
                let chart = new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: created_at.map(value => {
                            const months = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
                            let date = new Date(value);
                            return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`
                        }),
                        datasets: [{
                            label: "Tinggi Badan (Cm)",
                            borderColor: "#0069D9",
                            backgroundColor: "transparent",
                            data: tinggi_badan
                        }, {
                            label: "Berat Badan (Kg)",
                            borderColor: "#218838",
                            backgroundColor: "transparent",
                            data: berat_badan
                        }]
                    },
                    options: {}
                })
            });
    })
</script>