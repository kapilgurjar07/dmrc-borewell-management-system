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
$search = "";

if(isset($_GET['search'])) {

    $search = $_GET['search'];
}

$query = "

SELECT station.*, line.line_name

FROM station

LEFT JOIN line
ON station.line_id = line.line_id

WHERE

station_name LIKE '%$search%'

OR

station_code LIKE '%$search%'

";

$result = mysqli_query($conn, $query);

?>


<!DOCTYPE html>
<html>
<head>

<title>Station List</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body class="bg-light">
    <?php include("../includes/navbar.php"); ?>

<div class="container mt-5">

    <div class="d-flex justify-content-between mb-3">

        <h2>Station List</h2>

        <a href="add.php" class="btn btn-primary">

            Add Station

        </a>

    </div>
    <form method="GET" class="mb-3">

<div class="row">

<div class="col-md-4">

<input
type="text"
name="search"
class="form-control"
placeholder="Search Station"
value="<?php echo $search; ?>">

</div>

<div class="col-md-2">

<button
type="submit"
class="btn btn-primary">

Search

</button>

</div>

</div>

</form>

    <div class="card shadow">

        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead class="table-dark">

                <tr>

                    <th>ID</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Line</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Actions</th>

                </tr>

                </thead>

                <tbody>

                <?php while($row = mysqli_fetch_assoc($result)) { ?>

                <tr>

                    <td><?php echo $row['station_id']; ?></td>

                    <td><?php echo $row['station_code']; ?></td>

                    <td><?php echo $row['station_name']; ?></td>

                    <td><?php echo $row['line_name']; ?></td>

                    <td><?php echo $row['latitude']; ?></td>

                    <td><?php echo $row['longitude']; ?></td>

                    <td>

                        <a
                        href="edit.php?id=<?php echo $row['station_id']; ?>"
                        class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        <a
                        href="delete.php?id=<?php echo $row['station_id']; ?>"
                        class="btn btn-danger btn-sm">

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

</body>
</html>