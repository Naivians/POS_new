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

<div class="admin_top_nav">
    <!-- it has a height about 70px
    content inside are:
    1. search bar
    2. admin account
    -->
    <div class="search">

        <div>
            <span class="text-secondary"><?= date("F j, Y") ?></span>
            <span id="clock" class="text-secondary"></span>
        </div>

        <div class="admin_acc">
            <p class="mx-2 text-secondary"><?= ucwords($_SESSION['username']) ?></p>
            <div class="dropdown">
                <!-- <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">

                </button> -->
                <i class="fas fa-laugh-wink dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></i>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="logout.php">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>