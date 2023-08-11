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
include "config.php";
include "functions.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = fetch_account_by_id("category", $id);
    $result = $result->fetch_assoc();
    $catName = $result['category'];
} else {
    $_SESSION['message'] = "ID not Set";
    $_SESSION['alert-class'] = "alert-danger";
    header("location:admin_category.php");
    exit;
}

$error = array();

if (isset($_POST['updateCat'])) {
    // get data
    $category = $_POST['category'];

    if ($category == NULL) {
        $error['error'] = "Category is required!";
    }

    if (count($error) === 0) {

        // check if no changes has benn made
        // is_account_exist($tb_name, $id, $fullname, $username, $password, $role, $cat_name, $pName, $pPrice, $order_status, $date_paid, $subtota, $pQTY)
        if(is_account_exist("category", $id, "", "", "", "", $category, "", "", "", "", "", "", "", "")){
            $_SESSION['message'] = "No changes has been made";
            $_SESSION['alert-class'] = "alert-warning";
            header("location:admin_category.php");
            exit;
        }else{
        //    Update_data($tb_name,$id, $fullname, $username, $password, $role, $catName, $pName, $pPrice, $order_status, $date_paid, $subtota, $pQTY)
            if (Update_data("category",$id, "", "", "", "", $category, "", "", "", "", "", "")) {
                $_SESSION['message'] = "Update Successfully";
                $_SESSION['alert-class'] = "alert-success";
                header("location:admin_category.php");
                exit;
            } else {
                $_SESSION['message'] = "Failed to update category";
                $_SESSION['alert-class'] = "alert-danger";
                header("location:admin_category.php");
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
    <title>Admin | Edit Category</title>
</head>

<body>
    <?php include "admin_navbar.php"; ?>

    <main class="main-content">
        <div class="insert-container">
            <h2 class="text-primary text-center">Edit Category</h2>
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
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

                <!-- THE CODE THE LIES  WITHIN THE TAGS ARE ERROR MESSAGES -->

                <div class="mb-2">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" class="form-control 
                    " autocomplete="off" value="<?= $catName ?>">
                </div>

                <!-- form btns -->
                <div class="mb-2">
                    <a href="admin_category.php" class="btn btn-dark">Back</a>
                    <button type="submit" class="btn btn-primary" name="updateCat">Submit</button>
                </div>

            </form>
        </div>
    </main>

    <?php include "sidebar.php"; ?>
    <?php include "script.php"; ?>

</body>

</html>