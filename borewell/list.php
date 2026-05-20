<?php

session_start();

if(!isset($_SESSION['user_id'])) {

    header("Location:../auth/login.php");

    exit();
}

include("../config/db.php");

$search = "";

$stationFilter = "";

$statusFilter = "";

if(isset($_GET['search'])) {

    $search = $_GET['search'];
}

if(isset($_GET['station'])) {

    $stationFilter = $_GET['station'];
}

if(isset($_GET['status'])) {

    $statusFilter = $_GET['status'];
}

$query = "

SELECT
borewell.*,
station.station_name

FROM borewell

LEFT JOIN station
ON borewell.station = station.station_id

WHERE 1

";

if($search != "") {

    $query .= "

    AND borewell_code LIKE '%$search%'

    ";
}

if($stationFilter != "") {

    $query .= "

    AND station = '$stationFilter'

    ";
}

if($statusFilter == "active") {

    $query .= "

    AND expiry_date >= CURDATE()

    ";
}

if($statusFilter == "expired") {

    $query .= "

    AND expiry_date < CURDATE()

    ";
}

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>
<head>

<title>Borewell List</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>

body{
    background:#f4f6f9;
    font-family:Arial;
}

.page-title{
    font-weight:bold;
    color:#333;
}

.card-custom{
    border:none;
    border-radius:15px;
    overflow:hidden;
}

.table th{
    background:#212529;
    color:white;
    text-align:center;
    vertical-align:middle;
}

.table td{
    vertical-align:middle;
    text-align:center;
}

.table-hover tbody tr:hover{
    background:#f1f1f1;
    transition:0.3s;
}

.borewell-img{
    width:80px;
    height:80px;
    object-fit:cover;
    border-radius:10px;
    border:2px solid #ddd;
}

.badge-active{
    background:#198754;
    padding:8px 12px;
    border-radius:20px;
    color:white;
    font-size:13px;
}

.badge-expired{
    background:#dc3545;
    padding:8px 12px;
    border-radius:20px;
    color:white;
    font-size:13px;
}

.filter-box{
    background:white;
    padding:20px;
    border-radius:15px;
    box-shadow:0px 2px 10px rgba(0,0,0,0.1);
}

.btn-custom{
    border-radius:10px;
    padding:8px 20px;
}

</style>

</head>

<body>

<?php include("../includes/navbar.php"); ?>

<div class="container mt-5">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2 class="page-title">

Borewell Management

</h2>

<a
href="add.php"
class="btn btn-primary btn-custom">

Add Borewell

</a>

</div>


<!-- FILTER SECTION -->

<div class="filter-box mb-4">

<form method="GET">

<div class="row g-3">

<div class="col-md-3">

<input
type="text"
name="search"
class="form-control"
placeholder="Search Borewell Code"
value="<?php echo $search; ?>">

</div>


<div class="col-md-3">

<select
name="station"
class="form-select">

<option value="">

All Stations

</option>

<?php

$stationQuery = "SELECT * FROM station";

$stationResult = mysqli_query($conn, $stationQuery);

while($stationRow = mysqli_fetch_assoc($stationResult)) {

?>

<option
value="<?php echo $stationRow['station_id']; ?>"

<?php

if($stationFilter == $stationRow['station_id']) {

echo "selected";

}

?>

>

<?php echo $stationRow['station_name']; ?>

</option>

<?php } ?>

</select>

</div>


<div class="col-md-3">

<select
name="status"
class="form-select">

<option value="">

All Status

</option>

<option
value="active"

<?php

if($statusFilter == "active") {

echo "selected";

}

?>

>

Active

</option>

<option
value="expired"

<?php

if($statusFilter == "expired") {

echo "selected";

}

?>

>

Expired

</option>

</select>

</div>


<div class="col-md-3 d-grid">

<button
type="submit"
class="btn btn-dark btn-custom">

Apply Filters

</button>

</div>

</div>

</form>

</div>


<!-- TABLE -->

<div class="card shadow card-custom">

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-hover align-middle">

<thead>

<tr>

<th>ID</th>
<th>Code</th>
<th>Station</th>
<th>Capacity</th>
<th>Approval Date</th>
<th>Expiry Date</th>
<th>Photo</th>
<th>Status</th>
<th>Actions</th>

</tr>

</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>

<td>

<?php echo $row['borewell_id']; ?>

</td>

<td>

<strong>

<?php echo $row['borewell_code']; ?>

</strong>

</td>

<td>

<?php echo $row['station_name']; ?>

</td>

<td>

<?php echo $row['capacity']; ?>

</td>

<td>

<?php echo $row['approval_date']; ?>

</td>

<td>

<?php echo $row['expiry_date']; ?>

</td>

<td>

<img
src="../uploads/<?php echo $row['photo']; ?>"
class="borewell-img">

</td>

<td>

<?php

if(strtotime($row['expiry_date']) < time()) {

?>

<span class="badge-expired">

Expired

</span>

<?php

} else {

?>

<span class="badge-active">

Active

</span>

<?php } ?>

</td>
<td>

<a
href="edit.php?id=<?php echo $row['borewell_id']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a
href="delete.php?id=<?php echo $row['borewell_id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this borewell?')">

Delete

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

</body>
</html>