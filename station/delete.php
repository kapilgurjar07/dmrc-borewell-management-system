<?php

include("../config/db.php");

$id = $_GET['id'];

$query = "DELETE FROM station WHERE station_id = '$id'";

$result = mysqli_query($conn, $query);

if($result) {

    header("Location:list.php");

} else {

    echo "Delete Failed";
}
?>