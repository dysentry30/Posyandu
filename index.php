<?php
require_once("function.php");
if (!empty($_SESSION["username"])) {
    return header("Location: " . basename("home.php"));
}
?>
<?= head("Login Administration"); ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-5" style="position:absolute;top:50%;left:50%;transform:translate(-50%, -50%);">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center"><b>Masuk Sistem Posyandu</b></h5>
                    <?php if (!empty($_SESSION["gagal"])) : ?>
                        <div class="alert alert-danger"><?= $_SESSION["gagal"]; ?></div>
                        <?php unset($_SESSION["gagal"]); ?>
                    <?php endif; ?>
                    <form action="function.php" method="POST">
                        <div class="form-group mt-3 mb-3">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Kata Sandi</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="seePassword">
                                <label for="seePassword" class="form-check-label">Lihat kata sandi</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" id="loginBtn" value="Masuk" name="loginBtn">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= footer(); ?>