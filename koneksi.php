<?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "latihan_api";

    $conn = mysqli_connect($server, $username, $password, $database);
    if(!$conn){
        die("Koneksi gagal");
    }
?>