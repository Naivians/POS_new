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

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $results = fetch_account_by_id("product", $id);
    $product_info = $results->fetch_assoc();

    $catName = $product_info['category'];
    $pName = $product_info['prodName'];
    $pPrice = $product_info['prodPrice'];
}


// error handler
$error = array();
// get category and display
$listOfCategories = fetch_account("category");

if (isset($_POST['editProd'])) {
    // filter data
    $category = mysqli_escape_string($mysqli, $_POST['category']);
    $pName = mysqli_escape_string($mysqli, $_POST['pName']);
    $pPrice = mysqli_escape_string($mysqli, $_POST['pPrice']);

    // check for empty Fields

    if ($category == NULL or $pName == NULL or $pPrice == NULL) {
        $error['field-Error'] = "All fileds is required!";
    }

    // if there are no error then proceed to processesing of data
    if (count($error) === 0) {
        // this insert function is dynamic and has a lot of parameters but provide only what is needed and set the rest as "" string

        $exist = is_account_exist("product", $id, "", "", "", "", $category, $pName, $pPrice, "", "", "", "");

        if ($exist) {
            $_SESSION['message'] = "No changes has been made";
            $_SESSION['alert-class'] = "alert-warning";
            header("location:product.php");
            exit;
        } else {
            // Update_data($tb_name,$id, $fullname, $username, $password, $role, $catName, $pName, $pPrice, $order_status, $date_paid, $subtota, $pQTY)
            $result = Update_data("product",$id, "", "", "", "", $category, $pName, $pPrice, "", "", "", "");
            if($result){
                $_SESSION['message'] = "Successfully Update";
                $_SESSION['alert-class'] = "alert-success";
                header("location:product.php");
                exit;
            }else{
                $_SESSION['message'] = "Failed to update account";
                $_SESSION['alert-class'] = "alert-danger";
                header("location:product.php");
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
    <title>Admin | Edit Products</title>
</head>

<body>
    <!-- <a href="logout.php">Logout</a> -->
    <?php include "admin_navbar.php"; ?>

    <main class="main-content">
        <div class="insert-container">
            <h2 class="text-primary text-center">Edit Products</h2>
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
                    <label class="form-label">Product Name</label>
                    <input type="text" name="pName" class="form-control" value="<?= $pName ?>">
                </div>

                <div class="mb-2">
                    <label class="form-label">Product Price</label>
                    <input type="text" name="pPrice" class="form-control" value="<?= $pPrice ?>">
                </div>

                <div class="mb-3 mt-3">
                    <select class="form-select" aria-label="Default select example" name="category">
                        <option value="<?= $catName ?>"><?= ucfirst($catName) ?></option>
                        <?php
                        while ($row = $listOfCategories->fetch_assoc()) {
                        ?>
                            <option value="<?= $row['category'] ?>"><?= ucfirst($row['category']) ?></option>
                        <?php
                        }
                        ?>

                    </select>
                </div>

                <!-- form btns -->
                <div class="mb-2">
                    <a href="product.php" class="btn btn-dark">Back</a>
                    <button type="submit" class="btn btn-primary" name="editProd">Submit</button>
                </div>

            </form>
        </div>
    </main>

    <?php include "sidebar.php"; ?>
    <?php include "script.php"; ?>

</body>

</html>