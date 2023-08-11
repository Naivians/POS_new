<?php
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
?>

<div class="sidebar">
    <div class="title">
        <img src="./img/logo.png" alt="" class="img">
    </div>
    <div class="navigations">
        <a href="dashboard.php">
            <i class="fa-solid fa-gauge  mx-1"></i>
            Dashboard
        </a>
        <a href="account.php">
            <i class="fa-solid fa-users  mx-1"></i>
            Accounts
        </a>
        <a href="admin_category.php">
            <i class="fa-solid fa-list  mx-1"></i>
            Categories
        </a>
        <a href="product.php">
            <i class="fa-solid fa-cart-plus  mx-1"></i>
            Products
        </a>
        <a href="orders.php">
            <i class="fa-sharp fa-solid fa-cart-shopping mx-1"></i>
            Orders
        </a>
    </div>
</div>