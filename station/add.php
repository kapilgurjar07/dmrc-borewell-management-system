<?php

session_start();

if(!isset($_SESSION['user_id'])) {

    header("Location:../auth/login.php");

    exit();
}

include("../config/db.php");
?>

<?php

if(isset($_POST['submit'])) {

    $station_code = $_POST['station_code'];

    $station_name = $_POST['station_name'];

    $line_id = $_POST['line_id'];

    $latitude = $_POST['latitude'];

    $longitude = $_POST['longitude'];


    $query = "

    INSERT INTO station
    (
    station_code,
    station_name,
    line_id,
    latitude,
    longitude
    )

    VALUES
    (
    '$station_code',
    '$station_name',
    '$line_id',
    '$latitude',
    '$longitude'
    )

    ";


    $result = mysqli_query($conn, $query);


    if($result) {

        header("Location:list.php");

        exit();

    } else {

        echo mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Add Station</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>

body{
    background:#f4f6f9;
    font-family:Arial;
}

.form-container{

    background:white;
    padding:40px;
    border-radius:20px;
    box-shadow:0px 5px 15px rgba(0,0,0,0.1);
}

.page-title{

    font-weight:bold;
    color:#333;
}

.form-label{

    font-weight:600;
    color:#555;
}

.form-control,
.form-select{

    border-radius:10px;
    padding:12px;
}

.form-control:focus,
.form-select:focus{

    box-shadow:none;
    border-color:#0d6efd;
}

.btn-custom{

    padding:12px;
    border-radius:10px;
    font-weight:bold;
}

.info-box{

    background:#f8f9fa;
    border-left:5px solid #0d6efd;
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
}

</style>

</head>

<body>

<?php include("../includes/navbar.php"); ?>

<div class="container mt-5 mb-5">

<div class="row justify-content-center">

<div class="col-md-8">

<div class="form-container">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2 class="page-title">

Add Station

</h2>

<a
href="list.php"
class="btn btn-dark">

View Stations

</a>

</div>


<div class="info-box">

Enter station details carefully for proper borewell mapping.

</div>


<form method="POST">

<div class="row">

<!-- STATION CODE -->

<div class="col-md-6 mb-3">

<label class="form-label">

Station Code

</label>

<input
type="text"
name="station_code"
class="form-control"
placeholder="Enter Station Code"
required>

</div>


<!-- STATION NAME -->

<div class="col-md-6 mb-3">

<label class="form-label">

Station Name

</label>

<input
type="text"
name="station_name"
class="form-control"
placeholder="Enter Station Name"
required>

</div>


<!-- LINE -->

<div class="col-md-6 mb-3">

<label class="form-label">

Select Line

</label>

<select
name="line_id"
class="form-select"
required>

<option value="">

Select Line

</option>

<?php

$lineQuery = "SELECT * FROM line";

$lineResult = mysqli_query($conn, $lineQuery);

while($line = mysqli_fetch_assoc($lineResult)) {

?>

<option value="<?php echo $line['line_id']; ?>">

<?php echo $line['line_name']; ?>

</option>

<?php } ?>

</select>

</div>


<!-- LATITUDE -->

<div class="col-md-6 mb-3">

<label class="form-label">

Latitude

</label>

<input
type="text"
name="latitude"
class="form-control"
placeholder="Enter Latitude">

</div>


<!-- LONGITUDE -->

<div class="col-md-6 mb-3">

<label class="form-label">

Longitude

</label>

<input
type="text"
name="longitude"
class="form-control"
placeholder="Enter Longitude">

</div>

</div>


<!-- BUTTON -->

<div class="d-grid mt-3">

<button
type="submit"
name="submit"
class="btn btn-primary btn-custom">

Save Station

</button>

</div>

</form>

</div>

</div>

</div>

</div>

</body>
</html>