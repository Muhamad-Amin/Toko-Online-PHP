<?php 

    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "toko_online_php_tutorial";

    $connect = mysqli_connect($server, $username, $password, $database);

    if (mysqli_connect_errno()) {
        echo "failed to connect :". mysqli_connect_error();
        exit();
    }