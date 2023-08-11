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

// accounts
$listOfCategories = fetch_account("category");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "header.php"; ?>
    <link rel="stylesheet" href="css/accounts.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/dashboard.css?v=<?= time(); ?>">
    <title>Admin | Category</title>
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
        <div class="account d-flex align-items-center justify-content-between mb-4">
            <h4 class="mt-2">Product Category</h4>
            <form method="post">
                <div class="d-flex align-items-center justify-content-between">
                    <input type="text" name="category" id="" class="form-control" placeholder="Add Category">
                    <input type="submit" class="btn btn-primary ms-2" name="addCat">
                    </input>
                </div>
            </form>

        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">SN</th>
                    <th scope="col">Category</th>
                    <th scope="col">Date Added</th>
                    <th scope="col">Date edited</th>
                    <th scope="col">Date Retrieved</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sn = 1;
                while ($row = $listOfCategories->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?= $sn ?></td>
                        <td><?= ucfirst($row['category']) ?></td>
                        <td><?= ucfirst($row['date_added']) ?></td>
                        <td><?= ucfirst($row['date_edited']) ?></td>
                        <td><?= ucfirst($row['date_retrieved']) ?></td>
                        <td>
                            <a href="admin_editcat.php?id=<?= $row['id'] ?>">
                                <i class="fa-solid fa-user-pen fs-5"></i>
                            </a>
                            <a href="delete.php?cat_id=<?= $row['id'] ?>">
                                <i class="fa fa-trash fs-5 text-danger"></i>
                            </a>
                        </td>
                    </tr>
                <?php $sn++;
                }

                ?>
            </tbody>
        </table>
    </main>

    <?php include "sidebar.php"; ?>
    <?php include "script.php"; ?>

</body>

</html>