<?php
include "config.php";
include "functions.php";

session_start();
$error = array();

if (isset($_POST['login'])) {

    $username = mysqli_escape_string($mysqli, $_POST['username']);
    $password = mysqli_escape_string($mysqli, $_POST['password']);

    // check for empty fields
    if ($username == NULL || $password == NULL) {
        $error['fieldError'] = "Field must not be empty";
    }
    
    if (count($error) === 0) {
        // process data
        $result = get_account($username);
        $row_count = $result->num_rows;

        if ($row_count > 0) {
            // awjhdawjdjkadh

            $result = $result->fetch_assoc();
            $role = $result['role'];
            $fullname = $result['fullname'];

            if ($password == $result['password']) {
                // check what type of role
                if ($role == "admin") {
                    $_SESSION['role'] = "admin";
                    $_SESSION['username'] = $fullname;

                    //redirect to admin page
                    header("location:dashboard.php");
                    exit;
                } else if ($role == "user") {

                    $_SESSION['role'] = "user";
                    $_SESSION['username'] =  $fullname;
                    header("location:user.php");
                    exit;
                }
                // redirect to the page accrding to the role
            } else {
                $error['password_error'] = "Incorrect Password";
            }
        } else {
            $error['username_error'] = "Wrong Credentials";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "header.php"; ?>
    <link rel="stylesheet" href="css/style.css?v=<?= time(); ?>">
    <!-- change this -->
    <title>MC-POS | Login</title> 
</head>

<body>
    <div class="login-wrapper">
        <?php
        if (count($error) > 0) {
            foreach ($error as $errors) {
        ?>
                <div class="alert alert-danger"><?= $errors ?></div>
        <?php
            }
        }
        ?>
        <div class="login-container">
            <div class="left-log">
                <img src="img/print3.jpg" alt="MCPS Logo">
            </div>
            <div class="right-log">
                <!-- change this -->
                <h2 class="text-center mb-3 fs-2 text-dark">MC Printing Shop</h2>
                <form action="" method="post">

                    <div class="mb-2">
                        <input type="text" name="username" id="" class=" mb-2" autocomplete="off">
                        <label for="" class="form-label">Username</label>
                    </div>

                    <div class="mb-2">
                        <input type="password" name="password" id="" class="mb-2" autocomplete="off">
                        <label for="" class="form-label">Password</label>
                    </div>

                    <div class="mt-3">
                        <input type="submit" value="Login" name="login">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script></script>
</body>

</html>