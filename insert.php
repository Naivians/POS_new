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

    // check for existing username
    $result = get_account($username);
    $result  = $result->num_rows;

    if ($result > 0) {
        $_SESSION['exist'] = "Username Already Exist";
        $error['is_exit'] = $_SESSION['exist'];
    }
}

if (isset($_POST['addBtn'])) {
    // filter data
    $fullname = mysqli_escape_string($mysqli, $_POST['fullname']);
    $username = mysqli_escape_string($mysqli, $_POST['username']);
    $password = mysqli_escape_string($mysqli, $_POST['password']);
    $confirmPassword = mysqli_escape_string($mysqli, $_POST['confirmPassword']);
    $role = mysqli_escape_string($mysqli, $_POST['role']);

    // display username and fullname to avoid retyping
    $displayFullname = $fullname;
    $displayUsername = $username;

    // error handler
    // empty field
    // password matching
    // length of a field should be atleast 6-8 character

    emptyFieldChecker($fullname, $username, $password, $confirmPassword, $role);

    // if there are no error then proceed to processesing of data
    if (count($error) === 0) {
        $result = insert_account("account",$fullname, $username, $password, $role, "date_added", "");
        if($result){
            $_SESSION['message'] = "Successfully added new record";
            $_SESSION['alert-class'] = "alert-success";
            header("location:account.php");
            exit;
        }else{
            $_SESSION['message'] = "Failed to make record";
            $_SESSION['alert-class'] = "alert-danger";
            header("location:account.php");
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
    <title>Admin | Accounts</title>
</head>

<body>
    <!-- <a href="logout.php">Logout</a> -->
    <?php include "admin_navbar.php"; ?>

    <main class="main-content">
        <div class="insert-container">
            <h2 class="text-primary text-center">Add New Record</h2>

            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

                <!-- THE CODE THE LIES  WITHIN THE TAGS ARE ERROR MESSAGES -->

                <div class="mb-2">
                    <label class="form-label">Fullname</label>
                    <input type="text" name="fullname" id="fullname" class="form-control 
                    <?php if ($fullnameError) {echo $fullnameError;}?>" autocomplete="off" value="<?=$displayFullname?>">
                </div>

                <div class="mb-2">
                    <label class="form-label">Username</label>
                    <?php
                        // this will occur if username is already exist 
                        if (isset($_SESSION['exist'])) {
                            ?>
                                <small class="text-danger">(
                                    <?php
                                    echo $_SESSION['exist'];
                                    unset($_SESSION['exist']);
                                    ?>
                                    )</small>
                            <?php
                        }
                        ?>
                    <input type="text" name="username" id="username" class="form-control 
                    <?php if ($usernameError) {echo $usernameError;}?>" autocomplete="off" value="<?=$displayUsername?>">
                </div>

                <div class="mb-2">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control 
                    <?php if ($passwordError) {echo $passwordError;} ?>" autocomplete="off">
                </div>

                <div class="mb-2">
                    <label class="form-label">Confirm Password</label>
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

                    <input type="password" name="confirmPassword" id="confirmPassword" class="form-control 
                    <?php if ($passwordError) {echo $passwordError;} ?>" autocomplete="off">

                </div>

                <div class="mb-2">
                    <label class="form-label">Roles</label>
                    <select class="form-select <?php if ($roleError) {echo $roleError;}?> " aria-label="Default select example" name="role" id="role">
                        <option value="">Roles</option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                    
                <!-- form btns -->
                <div class="mb-2">
                    <a href="account.php" class="btn btn-dark">Back</a>
                    <button type="submit" class="btn btn-primary" name="addBtn">Submit</button>
                </div>
                
            </form>
        </div>
    </main>

    <?php include "sidebar.php"; ?>
    <?php include "script.php"; ?>

</body>

</html>