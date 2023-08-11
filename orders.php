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
include "config.php";

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


// update status

if (isset($_POST['update_status'])) {
    $id = $_POST['status_id'];
    $order_status = $_POST['status_value'];

    // update specific orders
    $res = $mysqli->query("UPDATE `orders` SET `order_status` = 'paid', `date_paid` = '$date' WHERE `id`= '$id'");

    if ($res) {
        $_SESSION['message'] = "Update Successfully";
        $_SESSION['alert-class'] = "alert-success";
        header("location:orders.php");
        exit;
    } else {
        $_SESSION['message'] = "Failed to update. Please check your query";
        $_SESSION['alert-class'] = "alert-danger";
        header("location:orders.php");
        exit;
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
$listOfOrders = fetch_account("orders");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "header.php"; ?>
    <link rel="stylesheet" href="css/accounts.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/dashboard.css?v=<?= time(); ?>">
    <title>Admin | Orders</title>
</head>

<body>

    <?php
    if (isset($_SESSION['message'])) {
    ?>
        <div class="modal-container" id="modal-container">
            <div class="modal-message" id="modal-message">
                <!-- logo -->
                <img src="./icons/check.png" alt="database picture">
                <!-- Message -->
                <h5 class="mt-3 mb-3"><?= $_SESSION['message'] ?></h5>

                <button id="close" onclick="close()" class="btn btn-danger">Close</button>
            </div>
        </div>

    <?php
        unset($_SESSION['message']);
    }
    ?>

    <!-- <a href="logout.php">Logout</a> -->
    <?php include "admin_navbar.php"; ?>

    <main class="main-content">
        <?php
        if (isset($_SESSION['message'])) {
        ?>
            <div class="alert <?= $_SESSION['alert-class'] ?>">
                <!-- message -->
                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                unset($_SESSION['alert-class']);
                ?>
            </div>
        <?php
        }

        ?>
        <?php
        if (count($error) > 0) {
        ?>
            <div class="alert alert-danger">
                <?php
                foreach ($error as $err) {
                ?>
                    <?= $err ?>
                <?php
                }
                ?>
            </div>
        <?php
        }
        ?>
        <div class="account d-flex align-items-center justify-content-between">
            <h5>Purchase History</h5>
        </div>

        <div class="filter_date mb-3 mt-1">
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
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sn = 1;

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
                                if ($row['order_status'] != "paid") {
                                ?>
                                    <td>
                                        <form method="post">
                                            <input type="hidden" name="status_id" value="<?= $row['id'] ?>">
                                            <input type="hidden" name="status_value" value="<?= $row['order_status'] ?>">
                                            <input type="submit" value="<?= $row['order_status'] ?>" name="update_status" class="btn btn-danger">
                                        </form>
                                    </td>
                                <?php
                                } else {
                                ?>
                                    <td><?= $row['order_status'] ?></td>
                                <?php
                                }
                                ?>
                                <td><?= ucfirst($row['date_paid']) ?></td>

                                <td>
                                    <a href="edit_orders.php?edit_orderID=<?= $row['id'] ?>">
                                        <i class="fa-solid fa-user-pen fs-5"></i>
                                    </a>

                                    <a href="delete.php?del_order_id=<?= $row['id'] ?>">
                                        <i class="fa fa-trash fs-5 text-danger"></i>
                                    </a>
                                </td>
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
                                if ($row['order_status'] != "paid") {
                                ?>
                                    <td>
                                        <form method="post">
                                            <input type="hidden" name="status_id" value="<?= $row['id'] ?>">
                                            <input type="hidden" name="status_value" value="<?= $row['order_status'] ?>">
                                            <input type="submit" value="<?= $row['order_status'] ?>" name="update_status" class="btn btn-danger">
                                        </form>
                                    </td>
                                <?php
                                } else {
                                ?>
                                    <td><?= $row['order_status'] ?></td>
                                <?php
                                }
                                ?>
                                <td><?= ucfirst($row['date_paid']) ?></td>

                                <td>
                                    <a href="edit_orders.php?edit_orderID=<?= $row['id'] ?>">
                                        <i class="fa-solid fa-user-pen fs-5"></i>
                                    </a>

                                    <a href="delete.php?del_order_id=<?= $row['id'] ?>">
                                        <i class="fa fa-trash fs-5 text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                    <?php $sn++;
                        }
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <?php include "sidebar.php"; ?>
    <?php include "script.php"; ?>

</body>

</html>


