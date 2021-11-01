<?php 

    $con = new mysqli("localhost", "root", "", "posyandu");

    if($con->connect_errno) {
        echo "Failed to connect to Database because <b>".$con->connect_error."</b>";
        exit();
    }

?>