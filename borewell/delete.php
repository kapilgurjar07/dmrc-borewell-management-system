<?php

session_start();

if(!isset($_SESSION['user_id'])) {

    header("Location:../auth/login.php");

    exit();
}

include("../config/db.php");

$id = $_GET['id'];

$query = "

DELETE FROM borewell

WHERE borewell_id = '$id'

";

$result = mysqli_query($conn, $query);

if($result) {

    header("Location:list.php");

} else {

    echo mysqli_error($conn);
}
?>