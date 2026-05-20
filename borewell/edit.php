<?php

session_start();

if(!isset($_SESSION['user_id'])) {

    header("Location:../auth/login.php");

    exit();
}

include("../config/db.php");

$id = $_GET['id'];

$getQuery = "

SELECT *

FROM borewell

WHERE borewell_id = '$id'

";

$getResult = mysqli_query($conn, $getQuery);

$row = mysqli_fetch_assoc($getResult);



if(isset($_POST['update'])) {

    $station = $_POST['station'];

    $capacity = $_POST['capacity'];

    $range_area = $_POST['range_area'];

    $distance = $_POST['distance'];

    $diameter = $_POST['diameter'];

    $depth = $_POST['depth'];

    $approval_date = $_POST['approval_date'];

    $latitude = $_POST['latitude'];

    $longitude = $_POST['longitude'];


    $query = "

    UPDATE borewell

    SET

    station = '$station',
    capacity = '$capacity',
    range_area = '$range_area',
    distance = '$distance',
    diameter = '$diameter',
    depth = '$depth',
    approval_date = '$approval_date',
    latitude = '$latitude',
    longitude = '$longitude'

    WHERE borewell_id = '$id'

    ";

    $result = mysqli_query($conn, $query);

    if($result) {

        header("Location:list.php");

    } else {

        echo mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Borewell</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body class="bg-light">

<?php include("../includes/navbar.php"); ?>

<div class="container mt-5">

<div class="card shadow">

<div class="card-body">

<h2 class="mb-4">

Edit Borewell

</h2>

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label>Station</label>

<select
name="station"
class="form-select">

<?php

$stationQuery = "SELECT * FROM station";

$stationResult = mysqli_query($conn, $stationQuery);

while($stationRow = mysqli_fetch_assoc($stationResult)) {

?>

<option
value="<?php echo $stationRow['station_id']; ?>"

<?php

if($row['station'] == $stationRow['station_id']) {

echo "selected";

}

?>

>

<?php echo $stationRow['station_name']; ?>

</option>

<?php } ?>

</select>

</div>


<div class="col-md-6 mb-3">

<label>Capacity</label>

<input
type="text"
name="capacity"
class="form-control"
value="<?php echo $row['capacity']; ?>">

</div>


<div class="col-md-6 mb-3">

<label>Range Area</label>

<input
type="text"
name="range_area"
class="form-control"
value="<?php echo $row['range_area']; ?>">

</div>


<div class="col-md-6 mb-3">

<label>Distance</label>

<input
type="text"
name="distance"
class="form-control"
value="<?php echo $row['distance']; ?>">

</div>


<div class="col-md-6 mb-3">

<label>Diameter</label>

<input
type="text"
name="diameter"
class="form-control"
value="<?php echo $row['diameter']; ?>">

</div>


<div class="col-md-6 mb-3">

<label>Depth</label>

<input
type="text"
name="depth"
class="form-control"
value="<?php echo $row['depth']; ?>">

</div>


<div class="col-md-6 mb-3">

<label>Approval Date</label>

<input
type="date"
name="approval_date"
class="form-control"
value="<?php echo $row['approval_date']; ?>">

</div>


<div class="col-md-6 mb-3">

<label>Latitude</label>

<input
type="text"
name="latitude"
class="form-control"
value="<?php echo $row['latitude']; ?>">

</div>


<div class="col-md-6 mb-3">

<label>Longitude</label>

<input
type="text"
name="longitude"
class="form-control"
value="<?php echo $row['longitude']; ?>">

</div>

</div>

<button
type="submit"
name="update"
class="btn btn-primary">

Update Borewell

</button>

</form>

</div>

</div>

</div>

</body>
</html>