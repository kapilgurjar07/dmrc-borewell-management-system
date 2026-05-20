
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



// TOTAL STATIONS

$stationQuery = "SELECT COUNT(*) AS total_station
FROM station";

$stationResult = mysqli_query($conn, $stationQuery);

$stationData = mysqli_fetch_assoc($stationResult);

$totalStations = $stationData['total_station'];



// TOTAL BOREWELLS

$borewellQuery = "SELECT COUNT(*) AS total_borewell
FROM borewell";

$borewellResult = mysqli_query($conn, $borewellQuery);

$borewellData = mysqli_fetch_assoc($borewellResult);

$totalBorewells = $borewellData['total_borewell'];



// ACTIVE BOREWELLS

$activeQuery = "SELECT COUNT(*) AS active_borewell
FROM borewell
WHERE expiry_date >= CURDATE()";

$activeResult = mysqli_query($conn, $activeQuery);

$activeData = mysqli_fetch_assoc($activeResult);

$activeBorewells = $activeData['active_borewell'];



// EXPIRED BOREWELLS

$expiredQuery = "SELECT COUNT(*) AS expired_borewell
FROM borewell
WHERE expiry_date < CURDATE()";

$expiredResult = mysqli_query($conn, $expiredQuery);

$expiredData = mysqli_fetch_assoc($expiredResult);

$expiredBorewells = $expiredData['expired_borewell'];

?>

<?php

$chartQuery = "

SELECT
station.station_name,
COUNT(borewell.borewell_id) AS total

FROM station

LEFT JOIN borewell
ON station.station_id = borewell.station

GROUP BY station.station_id

";

$chartResult = mysqli_query($conn, $chartQuery);

$stationNames = [];

$borewellCounts = [];

while($chart = mysqli_fetch_assoc($chartResult)) {

    $stationNames[] = $chart['station_name'];

    $borewellCounts[] = $chart['total'];
}

?>

<!DOCTYPE html>
<html>
<head>

    <title>DMRC Dashboard</title>

    <!-- Bootstrap CSS -->

    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet">

    <style>

canvas{

    max-height:400px;
}

</style>

</head>

<body class="bg-light">

<!-- NAVBAR -->
 <?php include("../includes/navbar.php"); ?>




<div class="container mt-5">

    <h2 class="mb-4">Dashboard</h2>

    <!-- CARDS -->

    <div class="row">

        <div class="col-md-3">

            <div class="card shadow">

                <div class="card-body">

                    <h1>
                        <?php echo $totalStations; ?>
                    </h1>

                    <p class="text-muted">
                        Total Stations
                    </p>

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card shadow">

                <div class="card-body">

                    <h1>
                        <?php echo $totalBorewells; ?>
                    </h1>

                    <p class="text-muted">
                        Total Borewells
                    </p>

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card shadow">

                <div class="card-body">

                    <h1>
                        <?php echo $activeBorewells; ?>
                    </h1>

                    <p class="text-success">
                        Active Borewells
                    </p>

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card shadow">

                <div class="card-body">

                    <h1>
                        <?php echo $expiredBorewells; ?>
                    </h1>

                    <p class="text-danger">
                        Expired Borewells
                    </p>

                </div>

            </div>

        </div>

    </div>


    <!-- STATION REPORT -->

    <div class="card mt-5 shadow">

        <div class="card-header bg-primary text-white">

            Station Wise Borewell Report

        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead class="table-dark">

                <tr>

                    <th>Station Name</th>
                    <th>Total Borewells</th>

                </tr>

                </thead>

                <tbody>

                <?php

                $reportQuery = "

                SELECT
                station.station_name,
                COUNT(borewell.borewell_id) AS total

                FROM station

                LEFT JOIN borewell
                ON station.station_id = borewell.station

                GROUP BY station.station_id

                ";

                $reportResult = mysqli_query($conn, $reportQuery);

                while($report = mysqli_fetch_assoc($reportResult)) {

                ?>

                <tr>

                    <td>
                        <?php echo $report['station_name']; ?>
                    </td>

                    <td>
                        <?php echo $report['total']; ?>
                    </td>

                </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>


    <!-- EXPIRED BOREWELLS -->

    <div class="card mt-5 shadow mb-5">

        <div class="card-header bg-danger text-white">

            Expired Borewells

        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <thead class="table-dark">

                <tr>

                    <th>Borewell Code</th>
                    <th>Station</th>
                    <th>Expiry Date</th>
                    <th>Status</th>

                </tr>

                </thead>
                

                <tbody>

                <?php

                $expiredListQuery = "

                SELECT
                borewell.*,
                station.station_name

                FROM borewell

                LEFT JOIN station
                ON borewell.station = station.station_id

                WHERE expiry_date < CURDATE()

                ";

                $expiredListResult = mysqli_query($conn, $expiredListQuery);

                while($expired = mysqli_fetch_assoc($expiredListResult)) {

                ?>

                <tr>

                    <td>
                        <?php echo $expired['borewell_code']; ?>
                    </td>

                    <td>
                        <?php echo $expired['station_name']; ?>
                    </td>

                    <td>
                        <?php echo $expired['expiry_date']; ?>
                    </td>

                    <td>

                        <span class="badge bg-danger">

                            Expired

                        </span>

                    </td>

                </tr>

                <?php } ?>

                </tbody>
                

            </table>
            

        </div>
        

    </div>
    <div class="card mt-5 shadow">

<div class="card-header bg-dark text-white">

Borewell Status Analytics

</div>

<div class="card-body">

<canvas id="statusChart"></canvas>

</div>

</div>
<div class="card mt-5 shadow mb-5">

<div class="card-header bg-primary text-white">

Station Wise Borewell Analytics

</div>

<div class="card-body">

<canvas id="stationChart"></canvas>

</div>

</div>

</div>

</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

const ctx = document.getElementById('statusChart');

new Chart(ctx, {

    type: 'pie',

    data: {

        labels: [

            'Active Borewells',
            'Expired Borewells'
        ],

        datasets: [{

            data: [

                <?php echo $activeBorewells; ?>,
                <?php echo $expiredBorewells; ?>

            ],

            backgroundColor: [

                '#198754',
                '#dc3545'
            ]

        }]
    }

});



</script>

<script>

const stationCtx = document.getElementById('stationChart');

new Chart(stationCtx, {

    type: 'bar',

    data: {

        labels: <?php echo json_encode($stationNames); ?>,

        datasets: [{

            label: 'Total Borewells',

            data: <?php echo json_encode($borewellCounts); ?>,

            backgroundColor: '#0d6efd',

            borderRadius: 5

        }]
    },

    options: {

        responsive: true,

        plugins: {

            legend: {

                display: false
            }
        }
    }

});

</script>


</html>