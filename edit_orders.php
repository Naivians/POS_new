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

if (isset($_GET['edit_orderID'])) {
    $id = $_GET['edit_orderID'];
    $results = fetch_account_by_id("orders", $id);
    $product_info = $results->fetch_assoc();

    $catName = $product_info['category'];
    $pName = $product_info['pName'];
    $pPrice = $product_info['pPrice'];
    $pQTY = $product_info['pQTY'];
    $subtotal = $product_info['subtotal'];
    $order_status = $product_info['order_status'];
    $date_paid = $product_info['date_paid'];
    $date_added = $product_info['date_added'];
}

// error handler
$error = array();

if (isset($_POST['edit_orders'])) {
    // filter data

    $category = mysqli_escape_string($mysqli, $_POST['category']);
    $pName = mysqli_escape_string($mysqli, $_POST['pName']);
    $pPrice = mysqli_escape_string($mysqli, $_POST['pPrice']);
    $pQTY = mysqli_escape_string($mysqli, $_POST['pQTY']);
    $subtotal = mysqli_escape_string($mysqli, $_POST['subtotal']);
    $order_status = mysqli_escape_string($mysqli, $_POST['status']);
    $date_paid = mysqli_escape_string($mysqli, $_POST['date_paid']);
    $id = mysqli_escape_string($mysqli, $_POST['update_order_id']);
    $date_added = mysqli_escape_string($mysqli, $_POST['date_purchase']);


    if ($category == NULL || $pName == NULL || $pPrice == NULL || $pQTY == NULL || $subtotal == NULL || $order_status == NULL) {
        $error['field-Error'] = "All fileds is required!";
    }

    // if there are no error then proceed to processesing of data
    if (count($error) === 0) {
        $exist = is_account_exist("orders", $id, $date_added, "", "", "", $category, $pName, $pPrice, $order_status, $date_paid, $subtotal, $pQTY);

        if ($exist) {
            $_SESSION['message'] = "No changes has been made";
            $_SESSION['alert-class'] = "alert-warning";
            header("location:orders.php");
            exit;
        } else {
            
            $result = Update_data("orders", $id, $date_added, "", "", "", $category, $pName, $pPrice, $order_status, $date_paid, $subtotal, $pQTY);

            
            
            if ($result) {
                $_SESSION['message'] = "Successfully Update";
                $_SESSION['alert-class'] = "alert-success";
                header("location:orders.php");
                exit;
            } else {
                $_SESSION['message'] = "Failed to update account";
                $_SESSION['alert-class'] = "alert-danger";
                header("location:orders.php");
                exit;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "header.php"; ?>
    <link rel="stylesheet" href="css/accounts.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/dashboard.css?v=<?= time() ?>">
    <title>User | Edit Products</title>
</head>

<body>
    <?php include "admin_navbar.php" ?>
    <div class="wrapper mt-4">
        <main class="main-content">
            <div class="insert-container">
                <h2 class="text-primary text-center">Edit Orders</h2>
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
                <div class="edit-container">
                    <form method="POST">
                        <div class="mb-2">
                            <label class="form-label">Category Name</label>
                            <input type="text" name="category" class="form-control" value="<?= $catName ?>">
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="pName" class="form-control" value="<?= $pName ?>">
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Product Price</label>
                            <input type="text" name="pPrice" class="form-control" value="<?= $pPrice ?>">
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="pQTY" min="1" max="10000" class="form-control" value="<?= $pQTY ?>">

                            <input type="hidden" name="update_order_id" value="<?=$id?>">
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Subtotal</label>
                            <input type="number" name="subtotal" min="1" max="10000" class="form-control" value="<?= $subtotal ?>">
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Date Purchase</label>
                            <input type="text" name="date_purchase" class="form-control" value="<?= $date_added?>">
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Order Status</label>
                            <input type="text" name="status" class="form-control" value="<?= $order_status ?>">
                        </div>


                        <div class="mb-2">
                            <label class="form-label">Date Paid</label>
                            <input type="text" name="date_paid" class="form-control" value="<?= $date_paid ?>">
                        </div>


                        <!-- form btns -->
                        <div class="mb-2">
                            <a href="orders.php" class="btn btn-dark">Back</a>
                            <button type="submit" class="btn btn-primary" name="edit_orders">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </main>
    </div>

    <?php include "sidebar.php"; ?>
    <?php include "script.php"; ?>

</body>

</html>