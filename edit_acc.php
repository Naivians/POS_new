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

if (!isset($_GET['id'])) {
    $_SESSION['message'] = "ID not set";
    $_SESSION['alert-class'] = "alert-danger";
    header("location:account.php");
    exit;
}

include "config.php";
include "functions.php";

// display user_accounts base on id
$result = fetch_account_by_id("account", $_GET['id']);

// error handler
$error = array();
$passwordError = "";
$fullnameError = "";
$usernameError = "";
$roleError = "";
$confirmPasswordError = "";
$displayUsername = "";
$displayFullname = "";

function emptyFieldChecker($fullname, $username, $password, $confirmPassword, $role)
{
    global $error, $passwordError, $fullnameError, $usernameError, $roleError, $confirmPasswordError;

    // check for empty fields
    if ($fullname == NULL) {
        $fullnameError = "error";
        $error['fullnameError'] = $fullnameError;
    }

    if ($username == NULL) {
        $usernameError = "error";
    }

    if ($password == NULL) {
        $passwordError = "error";
        $error['passwordError'] = $passwordError;
    }

    if ($confirmPassword == NULL) {
        $passwordError = "error";
        $error['passwordError'] = $passwordError;
    }

    if ($role == NULL) {
        $roleError = "error";
        $error['roleError'] = $roleError;
    }

    if ($password != $confirmPassword) {
        $_SESSION['notMatch'] = "Password does not match!";
        $error['notMatch'] = $_SESSION['notMatch'];
    }

    // check for number of characters
    if (strlen($username) < 5 || strlen($password) < 5 || strlen($username) < 5) {
        echo "<script>alert('Fullname, Username and Password should be atleast 6 to 8 Characters')</script>";
        $error['length'] = "Length Error";
    }
}

if (isset($_POST['editBtn'])) {
    // filter data
    $fullname = mysqli_escape_string($mysqli, $_POST['fullname']);
    $username = mysqli_escape_string($mysqli, $_POST['username']);
    $password = mysqli_escape_string($mysqli, $_POST['password']);
    $confirmPassword = mysqli_escape_string($mysqli, $_POST['confirmPassword']);
    $role = mysqli_escape_string($mysqli, $_POST['role']);
    $user_id = $_POST['id'];

    // error handler
    // empty field
    // password matching
    // length of a field should be atleast 6-8 character

    emptyFieldChecker($fullname, $username, $password, $confirmPassword, $role);

    // if there are no error then proceed to processesing of data
    if (count($error) === 0) {

        // 
        // is_account_exist($tb_name, $id, $fullname, $username, $password, $role, $cat_name, $pName, $pPrice, $order_status, $date_paid, $subtota, $pQTY)
        $exist = is_account_exist("account", $user_id, $fullname, $username, $password, $role, "", "", "", "", "","", "");
        
        if ($exist) {
            $_SESSION['message'] = "No changes has been made";
            $_SESSION['alert-class'] = "alert-warning";
            header("location:account.php");
            exit;
        } else {
            // Update_data($tb_name,$id, $fullname, $username, $password, $role, $catName, $pName, $pPrice, $order_status, $date_paid, $subtota, $pQTY)
            $result = Update_data("account",$user_id, $fullname, $username, $password, $role, "", "", "", "", "", "", "");
            if($result){
                $_SESSION['message'] = "Successfully Update";
                $_SESSION['alert-class'] = "alert-success";
                header("location:account.php");
                exit;
            }else{
                $_SESSION['message'] = "Failed to update account";
                $_SESSION['alert-class'] = "alert-danger";
                header("location:account.php");
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
    <title>Admin | Edit Accounts</title>
</head>

<body>
    <!-- <a href="logout.php">Logout</a> -->
    <?php include "admin_navbar.php"; ?>

    <main class="main-content">
        <div class="insert-container">
            <h2 class="text-primary text-center">Update Account</h2>

            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

                <?php
                while ($row = $result->fetch_assoc()) {
                ?>
                    <!-- THE CODE THE LIES  WITHIN THE TAGS ARE ERROR MESSAGES -->
                    <!-- get id -->
                    <input type="hidden" name="id" value="<?= $row['id']?>">
                    
                    <div class="mb-2">
                        <label class="form-label text-secondary">Fullname</label>
                        <input type="text" name="fullname" id="fullname" class="form-control 
                        <?php if ($fullnameError) {echo $fullnameError;} ?>" autocomplete="off" value="<?= $row['fullname'] ?>">
                    </div>

                    <div class="mb-2">
                        <label class="form-label text-secondary">Username</label>
                        <input type="text" name="username" id="username" class="form-control <?php if ($usernameError) {echo $usernameError;} ?>" autocomplete="off" value="<?= $row['username'] ?>">
                    </div>

                    <div class="mb-2">
                        <label class="form-label text-secondary">Password</label>
                        <input type="password" name="password" id="password" class="form-control
                        <?php if ($passwordError) {echo $passwordError;} ?>" autocomplete="off" value="<?= $row['password'] ?>">
                    </div>

                    <div class="mb-2">
                        <label class="form-label text-secondary">Confirm Password</label>
                        <?php
                        if (isset($_SESSION['notMatch'])) {
                        ?>
                            <small class="text-danger">(
                                <?php
                                echo $_SESSION['notMatch'];
                                unset($_SESSION['notMatch']);
                                ?>
                                )</small>
                        <?php
                        }
                        ?>

                        <input type="password" name="confirmPassword" id="confirmPassword" class="form-control<?php if ($passwordError) { echo $passwordError;} ?>" autocomplete="off" value="<?= $row['password'] ?>">

                    </div>

                    <div class="mb-2">
                        <label class="form-label text-secondary">Roles</label>
                        <select class="form-select <?php if ($roleError) {echo $roleError;} ?> " aria-label="Default select example" name="role" id="role">
                            <option value="<?= $row['role'] ?>"><?= $row['role'] ?></option>
                            <option value="admin">admin</option>
                            <option value="user">user</option>
                        </select>
                    </div>

                    <!-- form btns -->
                    <div class="mb-2">
                        <a href="account.php" class="btn btn-dark">Back</a>
                        <button type="submit" class="btn btn-primary" name="editBtn">Submit</button>
                    </div>

                <?php
                }
                ?>
            </form>
        </div>
    </main>

    <?php include "sidebar.php"; ?>
    <?php include "script.php"; ?>

</body>

</html>