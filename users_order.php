<?php
session_start();
if (!isset($_SESSION['role'])) {
    session_destroy();
    header("location:user.php");
    exit;
} else {
    if ($_SESSION['role'] != "user") {
        session_destroy();
        header("location:user.php");
        exit;
    }
}

include "functions.php";

$error = array();

if (isset($_POST['addCat'])) {
    // get data
    $category = $_POST['category'];

    if ($category == NULL) {
        $error['error'] = "Category is required!";
    }

    if (count($error) === 0) {

        if (insert_data("category", "", "", $category, "")) {
            $_SESSION['message'] = "Successfully added new category";
            $_SESSION['alert-class'] = "alert-success";
            header("location:admin_category.php");
            exit;
        } else {
            $_SESSION['message'] = "Failed to add new category";
            $_SESSION['alert-class'] = "alert-danger";
            header("location:admin_category.php");
            exit;
        }
    }
}

// filter date

$from = "";
$to = "";

if (isset($_POST['filter'])) {
    $from_date = str_replace("-", "/", $_POST['from_date']);
    $to_date = str_replace("-", "/", $_POST['to_date']);

    if ($from_date == NULL || $to_date == NULL) {
        echo " <script> alert('Please fill up the dates')</script>";
    } else {
        // process it
        $filter_dates = filter_date("orders", $from_date, $to_date);
        $filter_row = $filter_dates->num_rows;
    }
}



// accounts
$listOfProducts = fetch_account("product");
$listOfOrders = get_sales("orders", "todays_order");
$sales = get_sales("orders", "today");

$row_count = $sales->num_rows;

$todays_sales = 0;

if ($row_count > 0) {
    // today
    while ($row = $sales->fetch_assoc()) {
        $todays_sales += $row['subtotal'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "header.php"; ?>
    <link rel="stylesheet" href="css/accounts.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/dashboard.css?v=<?= time(); ?>">
    <title>User | View Orders</title>
</head>

<body>
    <?php
    if (isset($_SESSION['msg'])) {
        $mgs = $_SESSION['msg'];
        echo "<script>alert('$mgs')</script>";
        unset($_SESSION['msg']);
    }

    ?>
    <!-- push everything to the center -->
    <div class="header bg-success text-light">
        <div class="logo">
            <h1>MCPS</h1>
        </div>

        <div class="userinfo text-light">
            <p class="mx-1 text-light"><?= ucwords($_SESSION['username']) ?></p>
            <a href="users_order.php" class="text-light mx-3">Orders</a>
            <div class="d-flex align-items-center justify-content-center">
                <div>
                    <a href="user.php" class="text-dark btn btn-warning">
                        <!-- <i class="fa-solid fa-arrow-right-from-bracket"></i> -->
                        Back
                    </a>
                </div>
            </div>
            <!-- <img src="./img/logo.png" alt="logo image" class="img mx-2"> -->
        </div>
    </div>
    <div class="wrapper">
        <main class="main-content">
            <div class="account d-flex align-items-center justify-content-between mb-2 mt-2">
                <h2 class="mt-2">Purchase History</h2>
                <h2>Today's Sale: <span>&#8369</span><span><?= $todays_sales ?></span></h2>
            </div>
            <div class="filter_date mb-4">
                <form method="POST" class="d-flex">
                    <div class="mb3 d-flex align-items-center justify-contnet-center">
                        <label for="" class="form-label me-1"><strong>From</strong></label>
                        <input type="date" name="from_date" class="form-control">
                    </div>
                    <div class="mb3 d-flex align-items-center justify-contnet-center mx-3">
                        <label for="" class="form-label me-1"><strong>To</strong></label>
                        <input type="date" name="to_date" class="form-control">
                    </div>

                    <div class="mb3">
                        <input type="submit" value="Filter" class="btn btn-success" name="filter">
                    </div>
                </form>
            </div>

            <div class="table-container">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">SN</th>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Product Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col">Date Purchase</th>
                            <th scope="col">Order Status</th>
                            <th scope="col">Date Paid</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sn = 1;
                        // if nothing is selected then display this 
                    
                        if (isset($filter_row)) {
                            while ($row = $filter_dates->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?= $sn ?></td>
                                    <td><?= ucfirst($row['customerName']) ?></td>
                                    <td><?= ucfirst($row['category']) ?></td>
                                    <td><?= ucfirst($row['pName']) ?></td>
                                    <td><?= ucfirst($row['pPrice']) ?></td>
                                    <td><?= ucfirst($row['pQTY']) ?></td>
                                    <td><?= ucfirst($row['subtotal']) ?></td>
                                    <td><?= ucfirst($row['date_added']) ?></td>
                                    <?php
                                    if ($row['order_status'] == "unpaid") {
                                    ?>
                                        <form method="POST">
                                            <input type="hidden" name="status_id" value="<?= $row['id'] ?>">
                                            <td><input type="submit" value="Unpaid" class="btn btn-danger" name="update_status"></td>
                                        </form>
                                    <?php
                                    } else {
                                    ?>
                                        <td><?= ucfirst($row['order_status']) ?></td>
                                    <?php
                                    }
                                    ?>

                                    <td><?= ucfirst($row['date_paid']) ?></td>
                                </tr>
                            <?php $sn++;
                            }
                        } else {
                            while ($row = $listOfOrders->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?= $sn ?></td>
                                    <td><?= ucfirst($row['customerName']) ?></td>
                                    <td><?= ucfirst($row['category']) ?></td>
                                    <td><?= ucfirst($row['pName']) ?></td>
                                    <td><?= ucfirst($row['pPrice']) ?></td>
                                    <td><?= ucfirst($row['pQTY']) ?></td>
                                    <td><?= ucfirst($row['subtotal']) ?></td>
                                    <td><?= ucfirst($row['date_added']) ?></td>
                                    <?php
                                    if ($row['order_status'] == "unpaid") {
                                    ?>
                                        <td class="text-danger"><?= ucfirst($row['order_status']) ?></td>
                                    <?php
                                    } else {
                                    ?>
                                        <td class="text-success"><?= ucfirst($row['order_status']) ?></td>
                                    <?php
                                    }
                                    ?>

                                    <td><?= ucfirst($row['date_paid']) ?></td>
                                </tr>
                        <?php $sn++;
                            }
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <?php include "script.php"; ?>

    <script>
        $(document).ready(function() {
            // real time date and time
            setInterval(function() {
                $("#clock").load("time.php");
            }, 1000);
        });
    </script>

</body>

</html>