<?php
session_start();
require_once("mysql.php");
date_default_timezone_set("Asia/Jakarta");

if (isset($_POST["loginBtn"])) {
    if ($_POST["username"] == "admin" && $_POST["password"] == "admin") {
        $_SESSION["username"] = "admin";
        return header("Location: " . basename("home.php"));
    } else {
        $_SESSION["gagal"] = "Gagal Login";
        return header("Location: " . basename("index.php"));
    }
}

// TODO Function To Execute
if (isset($_GET["func"])) {
    if ($_GET["func"] == "logout") {
        return logout();
    } elseif ($_GET["func"] == "daftar-anak") {
        daftar_anak();
    } elseif ($_GET["func"] == "edit-profile") {
        edit_profile();
    } elseif ($_GET["func"] == "insert-vaksin") {
        insert_vaksin();
    } elseif ($_GET["func"] == "insert-perkembangan") {
        insert_perkembangan();
    } elseif ($_GET["func"] == "get-perkembangan") {
        $dataArr = [];
        $data = get_health_progress_anak($_GET["id"]);
        foreach ($data as $d) {
            array_push($dataArr, $d);
        }
        return print_r(json_encode($dataArr));
    } elseif ($_GET["func"] == "delete-data") {
        delete_data_progress($_GET["id"]);
    } elseif ($_GET["func"] == "delete-anak") {
        delete_data_anak($_GET["id"]);
    } elseif ($_GET["func"] == "delete-vaksin") {
        delete_data_vaksin($_GET["id"], $_GET["child_id"]);
    } elseif ($_GET["func"] == "update-vaksin") {
        update_data_vaksin($_POST["id"]);
    } elseif ($_GET["func"] == "sudah-vaksin") {
        update_injected_data_vaksin($_GET["id"], $_GET["child_id"]);
    }
}
// ! END
function head($title)
{
    echo '<!DOCTYPE html>
        <html lang="en">
        
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . ($title == "" ? "Login Administration" : $title) . '</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        
        </head>
        
        <body>
            <header class="container">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand" href="' . basename("home.php") . '"><b>Posyandu</b></a>
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item ml-5">
                            ' . (empty($_SESSION["username"]) ? '<a href="index.php" class="nav-link">Masuk</a>' : '<a href="function.php?func=logout" class="nav-link">Keluar</a>') . '
                        </li>
                    </ul>
                </nav>
            </header>
        ';
}

function footer()
{
    echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        </body>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
        <script>
            const checkBoxPassword = document.querySelector("#seePassword");
            const inputPassword    = document.querySelector("#password");
            checkBoxPassword.addEventListener("change", e => {
                if(e.target.checked) {
                    inputPassword.setAttribute("type", "text");
                } else {
                    inputPassword.setAttribute("type", "password");
                }
            })
        </script>
        </html>';
}

function get_anak_by_name($name) {
    global $con;
    $query = "SELECT * FROM list_anak WHERE nama LIKE '%$name%'";
    $result = $con->query($query);
    if($result->num_rows > 0) {
        return $result;
    }
    return null;
}

function logout()
{
    session_destroy();
    return header("Location: " . basename("index.php"));
}

// TODO Function for Executing database

function get_list_anak()
{
    global $con;
    $query = "SELECT * FROM list_anak;";
    $result = $con->query($query);
    return $result;
}

function get_anak($id)
{
    global $con;
    $query = "SELECT * FROM list_anak WHERE id=$id;";
    $result = $con->query($query);
    if($result->num_rows > 0) {
        return $result;
    }
    return null;
}

function get_vaksin_list_data($id, $is_injected)
{
    global $con;
    if($is_injected == 1) {
        $query = "SELECT * FROM vaksin WHERE child_id=$id AND `is_injected`=$is_injected ORDER BY vaksin.created_at DESC";
    } else {
        $query = "SELECT * FROM vaksin WHERE child_id=$id AND `is_injected`=$is_injected ORDER BY vaksin.injected_at ASC";
    }
    $result = $con->query($query);
    return $result;
}

function get_vaksin_single_data($id)
{
    global $con;
    $query = "SELECT * FROM vaksin WHERE id=$id";
    $result = $con->query($query);
    return $result;
}

function get_health_progress_anak($id)
{
    global $con;
    $query = "SELECT * FROM perkembangan_anak WHERE child_id=$id";
    $result = $con->query($query);
    return $result;
}

function update_data_vaksin()
{
    global $con;
    $id = $_POST["id"];
    $vaksin_name = $_POST["vaksin-name"];
    $injection_at = date_format(new DateTime($_POST["injection-time"]), "Y-m-d H:i:s");

    $query = "UPDATE vaksin SET `nama_vaksin`='$vaksin_name', `injected_at`='$injection_at' WHERE id=$id";
    if ($con->query($query)) {
        $_SESSION["success"] = "Data Berhasil Diperbaharui";
        header("Location: " . basename("perkembangan_anak.php?id=" . $_POST["child_id"]));
    } else {
        $_SESSION["failed"] = "Data Gagal Diperbaharui";
        header("Location: " . basename("perkembangan_anak.php?id=" . $_POST["child_id"]));
    }
}

function update_injected_data_vaksin($id, $child_id)
{
    global $con;
    $query = "UPDATE vaksin SET `is_injected`=1 WHERE id=$id AND child_id=$child_id;";
    if ($con->query($query)) {
        $_SESSION["success"] = "Vaksin Sudah Disuntikkan";
        header("Location: " . basename("perkembangan_anak.php?id=" . $child_id));
    } else {
        $_SESSION["failed"] = "Vaksin Belom Disuntikkan";
        header("Location: " . basename("perkembangan_anak.php?id=" . $child_id));
    }
}

function delete_data_progress($id)
{
    global $con;
    $query = "DELETE FROM perkembangan_anak WHERE id=$id;";
    if ($con->query($query)) {
        $_SESSION["success"] = "Data Berhasil Dihapus";
        header("Location: " . basename("perkembangan_anak.php?id=" . $_GET["child_id"]));
    } else {
        $_SESSION["failed"] = "Data Gagal Dihapus";
        header("Location: " . basename("perkembangan_anak.php?id=" . $_GET["child_id"]));
    }
}

function delete_data_vaksin($id, $child_id)
{
    global $con;
    $query = "DELETE FROM vaksin WHERE id=$id";
    if ($con->query($query)) {
        $_SESSION["success"] = "Data Vaksin Berhasil Dihapus";
        header("Location: " . basename("perkembangan_anak.php?id=" . $child_id));
    } else {
        $_SESSION["failed"] = "Data Vaksin Gagal Dihapus";
        header("Location: " . basename("perkembangan_anak.php?id=" . $child_id));
    }
}

function delete_data_anak($id)
{
    global $con;
    $query = "DELETE FROM list_anak WHERE id=$id;";
    if ($con->query($query)) {
        $query = "DELETE FROM perkembangan_anak WHERE child_id=$id";
        if ($con->query($query)) {
            $query = "DELETE FROM vaksin WHERE child_id=$id";
            if ($con->query($query)) {
                $_SESSION["success"] = "Data Berhasil Dihapus";
                header("Location: " . basename("home.php"));
            } else {
                $_SESSION["failed"] = "Data Gagal Dihapus";
                header("Location: " . basename("home.php"));
            }
        } else {
            $_SESSION["failed"] = "Data Gagal Dihapus";
            header("Location: " . basename("home.php"));
        }
    } else {
        $_SESSION["failed"] = "Data Gagal Dihapus";
        header("Location: " . basename("home.php"));
    }
}

function daftar_anak()
{
    global $con;
    if (isset($_POST["daftar"])) {
        $id = rand(10000, 99999);
        $nama = $_POST["nama"];
        $orang_tua = $_POST["orang-tua"];
        $gender = $_POST["gender"];
        $alamat = $_POST["alamat"];
        $tanggal_lahir = date_create($_POST["tanggal-lahir"]);
        $now = date_create("now");
        $umur = $now->diff($tanggal_lahir)->y;
        $tanggal_lahir_formatted = $tanggal_lahir->format("Y-m-d H:i:s");
        $query = "INSERT INTO list_anak(id, nama, tanggal_lahir, orang_tua, gender, alamat, umur) VALUES($id, '$nama', '$tanggal_lahir_formatted', '$orang_tua', '$gender', '$alamat', $umur)";
        if ($con->query($query)) {
            $_SESSION["success"] = "Data Berhasil Ditambahkan";
            header("Location: " . basename("home.php"));
        } else {
            $_SESSION["failed"] = "Data Gagal Ditambahkan";
            header("Location: " . basename("home.php"));
        }
    }
}

function edit_profile()
{
    global $con;
    $id = $_POST["id"];
    $nama = $_POST["nama"];
    $orang_tua = $_POST["orang-tua"];
    $gender = $_POST["gender"];
    $alamat = $_POST["alamat"];
    $tanggal_lahir = date_format(new DateTime($_POST["tanggal-lahir"]), "Y-m-d H:i:s");

    $query = "UPDATE `list_anak` SET `nama`='$nama', `orang_tua`='$orang_tua', `gender`='$gender', `alamat`='$alamat', `tanggal_lahir`='$tanggal_lahir' WHERE `id`=$id;";
    if ($con->query($query)) {
        $_SESSION["success"] = "Data Berhasil Diupdate";
        header("Location: " . basename("home.php"));
    } else {
        $_SESSION["failed"] = $con->error;
        header("Location: " . basename("home.php"));
    }
}
// TODO NEXT: Deleting Data Anak and deleting data vaksin

function insert_vaksin()
{
    global $con;
    $id = $_POST["id"];
    $nama = $_POST["nama"];
    $now = new DateTime("now");
    if ($_POST["vaksin-name"] != "null") {
        $vaksin_name = $_POST["vaksin-name"];
    } else {
        $_SESSION["failed-vaksin"] = "Pilih Salah Satu Vaksin";
        return header("Location: " . basename("new_vaksin.php?id=" . $id));
    }
    if (!empty($_POST["injection-time"])) {
        $injection_time = new DateTime($_POST["injection-time"]);
        if ($injection_time > $now) {
            $injection_time_formatted = $injection_time->format("Y-m-d H:i:s");
            $query = "INSERT INTO vaksin(child_id, nama, nama_vaksin, injected_at, is_injected) VALUES($id, '$nama', '$vaksin_name', '$injection_time_formatted', 0);";
            if ($con->query($query)) {
                $_SESSION["success"] = "Data Vaksin Berhasil Ditambahkan";
                header("Location: " . basename("perkembangan_anak.php?id=" . $id));
            } else {
                $_SESSION["failed"] = "Data Vaksin Gagal Ditambahkan";
                header("Location: " . basename("perkembangan_anak.php?id=" . $id));
            }
        } else {
            $_SESSION["failed-injection-time"] = "Injection Time Harus Lebih Besar Dari Waktu Sekarang";
            header("Location: " . basename("new_vaksin.php?id=" . $id));
        }
    } else {
        $_SESSION["failed-injection-time"] = "Isikan Baris Ini";
        header("Location: " . basename("new_vaksin.php?id=" . $id));
    }
}

function insert_perkembangan()
{
    $id = $_POST["id"];
    $nama = $_POST["nama"];
    $tinggi_badan = (int) $_POST["tinggi-badan"];
    $berat_badan = (int) $_POST["berat-badan"];
    $umur = date_create($_POST["tanggal-lahir"]);
    $now = date_create("now");
    $umur =  $now->diff($umur)->y;

    if (empty($tinggi_badan)) {
        $_SESSION["failed-height"] = "Silahkan isi tinggi badan anak";
        $_SESSION["berat_badan"] = "$berat_badan";
        return header("Location: " . basename("add_progress.php?id=$id"));
    } elseif (empty($berat_badan)) {
        $_SESSION["failed-weight"] = "Silahkan isi berat badan anak";
        $_SESSION["tinggi_badan"] = "$tinggi_badan";
        return header("Location: " . basename("add_progress.php?id=$id"));
    }

    global $con;
    $query = "INSERT INTO perkembangan_anak(child_id, nama, tinggi_badan, berat_badan, umur) VALUES($id, '$nama', $tinggi_badan, $berat_badan, $umur);";
    if ($con->query($query)) {
        $_SESSION["success"] = "Data Berhasil Ditambahkan";
        header("Location: " . basename("perkembangan_anak.php?id=" . $id));
    } else {
        $_SESSION["failed"] = $con->error;
        header("Location: " . basename("perkembangan_anak.php?id=" . $id));
    }
}


    // ! END

    // TODO Functions for executing queries

    // ! END
