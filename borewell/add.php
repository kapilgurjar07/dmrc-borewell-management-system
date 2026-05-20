<?php

session_start();

if(!isset($_SESSION['user_id'])) {

    header("Location:../auth/login.php");

    exit();
}

include("../config/db.php");
?>

<?php

include("../config/db.php");

if(isset($_POST['submit'])) {

    $station           = $_POST['station'];
    $num_of_borewells  = $_POST['num_of_borewells'];
    $capacity          = $_POST['capacity'];
    $range_area        = $_POST['range_area'];
    $distance          = $_POST['distance'];
    $diameter          = $_POST['diameter'];
    $depth             = $_POST['depth'];
    $approval_date     = $_POST['approval_date'];
    $validity_years    = $_POST['validity_years'];
    $created_by        = $_POST['created_by'];
    $latitude          = $_POST['latitude'];
    $longitude         = $_POST['longitude'];

    // AUTO BOREWELL CODE

    $stationQuery = "SELECT station_code
                     FROM station
                     WHERE station_id = '$station'";

    $stationResult = mysqli_query($conn, $stationQuery);

    $stationRow = mysqli_fetch_assoc($stationResult);

    $stationCode = $stationRow['station_code'];

    // FIND LAST CODE

    $codeQuery = "SELECT borewell_code
                  FROM borewell
                  WHERE station = '$station'
                  ORDER BY borewell_id DESC
                  LIMIT 1";

    $codeResult = mysqli_query($conn, $codeQuery);

    $nextNumber = 1;

    if(mysqli_num_rows($codeResult) > 0) {

        $codeRow = mysqli_fetch_assoc($codeResult);

        $lastCode = $codeRow['borewell_code'];

        $parts = explode('-', $lastCode);

        $number = end($parts);

        $nextNumber = intval($number) + 1;
    }

    $borewell_code = $stationCode . "-BW-" .
                     str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

    // EXPIRY DATE

    $expiry_date = date(
        'Y-m-d',
        strtotime($approval_date . " +$validity_years years")
    );

    // PHOTO UPLOAD

    $photo = $_FILES['photo']['name'];

    $tmpName = $_FILES['photo']['tmp_name'];

    move_uploaded_file(
        $tmpName,
        "../uploads/" . $photo
    );

    // INSERT QUERY

    $query = "INSERT INTO borewell (

        station,
        borewell_code,
        num_of_borewells,
        capacity,
        range_area,
        distance,
        diameter,
        depth,
        approval_date,
        validity_years,
        expiry_date,
        photo,
        created_by,
        latitude,
        longitude

    )

    VALUES (

        '$station',
        '$borewell_code',
        '$num_of_borewells',
        '$capacity',
        '$range_area',
        '$distance',
        '$diameter',
        '$depth',
        '$approval_date',
        '$validity_years',
        '$expiry_date',
        '$photo',
        '$created_by',
        '$latitude',
        '$longitude'
    )";

    $result = mysqli_query($conn, $query);

    if($result) {

        echo "Borewell Added Successfully";

    } else {

        echo "Error";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Add Borewell</title>

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

.upload-box{

    border:2px dashed #ccc;
    padding:20px;
    border-radius:15px;
    text-align:center;
    background:#fafafa;
}

.upload-box:hover{

    border-color:#0d6efd;
    background:#f0f7ff;
    transition:0.3s;
}

</style>

</head>

<body>

<?php include("../includes/navbar.php"); ?>

<div class="container mt-5 mb-5">

<div class="row justify-content-center">

<div class="col-md-10">

<div class="form-container">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2 class="page-title">

Add Borewell

</h2>

<a
href="list.php"
class="btn btn-dark">

View Borewells

</a>

</div>


<form method="POST" enctype="multipart/form-data">

<div class="row">

<!-- STATION -->

<div class="col-md-6 mb-3">

<label class="form-label">

Select Station

</label>

<select
name="station"
class="form-select"
required>

<option value="">

Select Station

</option>

<?php

$stationQuery = "SELECT * FROM station";

$stationResult = mysqli_query($conn, $stationQuery);

while($stationRow = mysqli_fetch_assoc($stationResult)) {

?>

<option value="<?php echo $stationRow['station_id']; ?>">

<?php echo $stationRow['station_name']; ?>

</option>

<?php } ?>

</select>

</div>


<!-- NUMBER -->

<div class="col-md-6 mb-3">

<label class="form-label">

Number of Borewells

</label>

<input
type="number"
name="num_of_borewells"
class="form-control"
required>

</div>


<!-- CAPACITY -->

<div class="col-md-6 mb-3">

<label class="form-label">

Capacity

</label>

<input
type="text"
name="capacity"
class="form-control"
placeholder="Enter Capacity">

</div>


<!-- RANGE AREA -->

<div class="col-md-6 mb-3">

<label class="form-label">

Range Area

</label>

<input
type="text"
name="range_area"
class="form-control"
placeholder="Enter Range Area">

</div>


<!-- DISTANCE -->

<div class="col-md-6 mb-3">

<label class="form-label">

Distance

</label>

<input
type="text"
name="distance"
class="form-control"
placeholder="Enter Distance">

</div>


<!-- DIAMETER -->

<div class="col-md-6 mb-3">

<label class="form-label">

Diameter

</label>

<input
type="text"
name="diameter"
class="form-control"
placeholder="Enter Diameter">

</div>


<!-- DEPTH -->

<div class="col-md-6 mb-3">

<label class="form-label">

Depth

</label>

<input
type="text"
name="depth"
class="form-control"
placeholder="Enter Depth">

</div>


<!-- APPROVAL DATE -->

<div class="col-md-6 mb-3">

<label class="form-label">

Approval Date

</label>

<input
type="date"
name="approval_date"
class="form-control">

</div>


<!-- VALIDITY -->

<div class="col-md-6 mb-3">

<label class="form-label">

Validity Years

</label>

<input
type="number"
name="validity_years"
class="form-control"
placeholder="Enter Validity">

</div>


<!-- CREATED BY -->

<div class="col-md-6 mb-3">

<label class="form-label">

Created By

</label>

<input
type="text"
name="created_by"
class="form-control"
placeholder="Created By">

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


<!-- PHOTO -->

<div class="col-md-6 mb-4">

<label class="form-label">

Upload Photo

</label>

<div class="upload-box">

<input
type="file"
name="photo"
class="form-control">

</div>

</div>

</div>


<!-- BUTTON -->

<div class="d-grid">

<button
type="submit"
name="submit"
class="btn btn-primary btn-custom">

Save Borewell

</button>

</div>

</form>

</div>

</div>

</div>

</div>

</body>
</html>