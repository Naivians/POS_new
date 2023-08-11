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
// include "message.php";

// accounts
$listOfAccounts = fetch_account("account");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "header.php"; ?>
    <link rel="stylesheet" href="css/accounts.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/dashboard.css?v=<?= time(); ?>">
    <title>Admin | Accounts</title>
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

    <?php include "admin_navbar.php"; ?>
    <main class="main-content">
        <div class="account d-flex align-items-center justify-content-between mb-4">
            <h4 class="mt-2">Accounts</h4>
            <a href="insert.php" class="btn btn-primary">
                Add Account
            </a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">SN</th>
                    <th scope="col">Fullname</th>
                    <th scope="col">Username</th>
                    <th scope="col">Password</th>
                    <th scope="col">Role</th>
                    <th scope="col">Date Added</th>
                    <th scope="col">Date edited</th>
                    <th scope="col">Retrieved Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $sn = 1;
                while ($row = $listOfAccounts->fetch_assoc()) {
                ?>
                    <tr>
                        <th scope="row"><?= $sn ?></th>
                        <td><?= $row['fullname'] ?></td>
                        <td><?= $row['username'] ?></td>
                        <td><?= $row['password'] ?></td>
                        <td><?= $row['role'] ?></td>
                        <td><?= $row['date_added'] ?></td>
                        <td><?= $row['date_edited'] ?></td>
                        <td><?= $row['date_retrieved'] ?></td>
                        <td>
                            <a href="edit_acc.php?id=<?= $row['id'] ?>">
                                <i class="fa-solid fa-user-pen fs-5"></i>
                            </a>

                            <a href="delete.php?user_id=<?= $row['id'] ?>">
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