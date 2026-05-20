<?php

$host = "localhost";
$user = "root";
$password = "root";
$database = "dmrc_borewell";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

?>