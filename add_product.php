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


// error handler
$error = array();
// get category and display
$listOfCategories = fetch_account("category");

if (isset($_POST['addProduct'])) {
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
        $result = insert_data("product", $pName, $pPrice, $category, "");
        if ($result) {
            $_SESSION['message'] = "Successfully added new products";
            $_SESSION['alert-class'] = "alert-success";
            header("location:product.php");
            exit;
        } else {
            $_SESSION['message'] = "Failed to add products. Please check your query!";
            $_SESSION['alert-class'] = "alert-danger";
            header("location:product.php");
            exit;
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
    <title>Admin | Add Products</title>
</head>

<body>
    <!-- <a href="logout.php">Logout</a> -->
    <?php include "admin_navbar.php"; ?>

    <main class="main-content">
        <div class="insert-container">
            <h2 class="text-primary text-center">Add New Products</h2>
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
                    <input type="text" name="pName" class="form-control ">
                </div>

                <div class="mb-2">
                    <label class="form-label">Product Price</label>
                    <input type="text" name="pPrice" class="form-control">
                </div>
                
                <div class="mb-3 mt-3">
                    <select class="form-select" aria-label="Default select example" name="category">
                        <option value="">Select Category</option>
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
                    <button type="submit" class="btn btn-primary" name="addProduct">Submit</button>
                </div>

            </form>
        </div>
    </main>

    <?php include "sidebar.php"; ?>
    <?php include "script.php"; ?>

</body>

</html>