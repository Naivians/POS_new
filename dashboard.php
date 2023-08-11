<?php
session_start();
if (!isset($_SESSION['role'])) {
    session_destroy();
    header("location:index.php");
    exit;
} else {
    if ($_SESSION['role'] != "admin") {
        session_destroy();
        header("location:index.php");
        exit;
    }
}

include "functions.php";

// accounts
$listOfProduct = fetch_account("product");
// $listOfOrders = fetch_account("orders");

$numberOfProducts = $listOfProduct->num_rows;

$todays = get_sales("orders", "today");
$month = get_sales("orders", "month");
$year = get_sales("orders", "year");


$todays_sales = 0;
$month_sales = 0;
$year_sales = 0;


// today
while ($row = $todays->fetch_assoc()) {
    $todays_sales += $row['subtotal'];
}

// month
while ($row = $month->fetch_assoc()) {
    $month_sales += $row['subtotal'];
}

// year
while ($row = $year->fetch_assoc()) {
    $year_sales += $row['subtotal'];
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "header.php"; ?>
    <link rel="stylesheet" href="css/accounts.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/dashboard.css?v=<?= time(); ?>">
    <title>Admin | Dashboard</title>

</head>

<body>

    <!-- <a href="logout.php">Logout</a> -->
    <?php include "admin_navbar.php"; ?>
    <main class="main-content">

        <div class="dashboard-container d-flex justify-content-between align-items-center">

            <div class="dash-card d-flex justify-content-between ">
                <div class="top">
                    <h2 class="text-dark"><?= $numberOfProducts ?></h2>
                    <p class="text-secondary ">Total Products</p>
                </div>
                <i class="fa-sharp fa-solid fa-cart-shopping mx-1 text-secondary fs-1"></i>
            </div>


            <div class="dash-card d-flex justify-content-between ">
                <div class="top">
                    <h2 class="text-dark"><sup style="font-size: 1rem;">&#8369</sup><?= $todays_sales ?></h2>
                    <p class="text-secondary ">Sales of the day</p>
                </div>
                <!-- <span>&#8369</span> -->
                <span class=" mx-1 text-secondary fs-1">&#8369</span>
            </div>


            <div class="dash-card d-flex justify-content-between">
                <div class="top">
                    <h2 class="text-dark"><sup style="font-size: 1rem;">&#8369</sup><?= $month_sales ?></h2>
                    <p class="text-secondary ">Sales of the Month</p>
                </div>
                <span class=" mx-1 text-secondary fs-1">&#8369</span>
            </div>


            <div class="dash-card d-flex justify-content-between">
                <div class="top">
                    <h2 class="text-dark"><sup style="font-size: 1rem;">&#8369</sup><?= $year_sales ?></h2>
                    <p class="text-secondary ">Sales of the Year</p>
                </div>
                <span class=" mx-1 text-secondary fs-1">&#8369</span>
            </div>

        </div>

        <!-- charts -->
        <div class="charts">
            <div class="box sales">
                <canvas id="myChart"></canvas>
            </div>
            <div class="box earnings">
                <canvas id="earnings"></canvas>
            </div>
        </div>

    </main>

    <!-- output monthly sales -->
    <?php
    $mysqli = new mysqli("localhost", "root", "", "pos");

    $sql = $mysqli->query("SELECT MONTHNAME(date_added) as mname, SUM(subtotal) as total FROM orders  WHERE `order_status` = 'paid' GROUP BY mname ORDER BY STR_TO_DATE(CONCAT('0001 ', mname, ' 01'), '%Y %M %d') ");

    foreach ($sql as $query) {
        $month_name[] = $query['mname'];
        $total_sales[] = $query['total'];
    }

    $sql = $mysqli->query("SELECT year(date_added) as years, sum(subtotal) as total FROM orders WHERE `order_status` = 'paid' GROUP BY years ORDER BY years;");

    foreach ($sql as $query) {
        $years[] = $query['years'];
        $yearly_sales[] = $query['total'];
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const earnings = document.getElementById('earnings').getContext('2d');

        // month
        const labels = <?php echo json_encode($month_name) ?>;
        const total = <?php echo json_encode($total_sales) ?>;

        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Monthly Sales',
                    data: total,
                    backgroundColor: [
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(153, 102, 255)',
                        'rgba(255, 159, 64)',
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(153, 102, 255)',
                        'rgba(255, 159, 64)',
                        'rgba(255, 99, 132)'
                    ],
                    borderColor: [
                        // 'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(153, 102, 255)',
                        'rgba(255, 159, 64)',
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(153, 102, 255)',
                        'rgba(255, 159, 64)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });


        // yearly
        const yearly_sales = <?php echo json_encode($yearly_sales) ?>;
        const years = <?php echo json_encode($years) ?>;
        // earning charts
        const earningss = new Chart(earnings, {
            type: 'pie',
            data: {
                labels: years,
                datasets: [{
                    label: 'Monthly Earnings',
                    data: yearly_sales,
                    backgroundColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(153, 102, 255)',
                        'rgba(255, 159, 64)',
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(153, 102, 255)',
                        'rgba(255, 159, 64)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(153, 102, 255)',
                        'rgba(255, 159, 64)',
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(153, 102, 255)',
                        'rgba(255, 159, 64)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>


    <?php include "sidebar.php"; ?>
    <?php include "script.php"; ?>
</body>

</html>