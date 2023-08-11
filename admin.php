<?php
    session_start();
    if(!isset($_SESSION['role'])){ 
        session_destroy();
        header("location:index.php");
        exit;
    }else{
        if($_SESSION['role'] != "admin"){
            session_destroy();
            header("location:index.php");
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "header.php"; ?>
    <link rel="stylesheet" href="css/dashboard.css?v=<?= time(); ?>">
    <title>Admin | Dashboard</title>
</head>

<body>
    <!-- <a href="logout.php">Logout</a> -->
    <?php include "admin_navbar.php";?>
    <div class="dashboards">

    </div>
    <?php include "sidebar.php"; ?>
    <?php include "script.php"; ?>

    <script>
        $(document).ready(function(){
            setInterval(function(){
                $("#clock").load("time.php");
            }, 1000);
        });
    </script>
</body>

</html>