<?php
session_start();

if (!isset($_SESSION['role'])) {
    session_destroy();
    header("location:index.php");
    exit;
} else {
    if ($_SESSION['role'] != "user") {
        session_destroy();
        header("location:index.php");
        exit;
    }
}

include "functions.php";

// if (isset($_GET['cancel'])) {

//     if ($_SESSION['grand_total'] != 0) {
//         $_SESSION['grand_total'] = 0;

//         if (delete_orders("temp_orders", "")) {
//             $_SESSION['msg'] = "successfully cancel order";
//             header("location:user.php");
//             exit;
//         } else {
//             header("location:user.php?mgs=Failed cancel order");
//             exit;
//         }
//     } else {
//         $_SESSION['msg'] = "Theres no product!";
//         header("location:user.php");
//         exit;
//     }
// }

// if (isset($_GET['delete_order'])) {
//     $id = $_GET['delete_order'];
//     // get data base on id
//     $results = fetch_account_by_id("temp_orders", $id);
//     // extract qty, price and subtotal
//     $products = $results->fetch_assoc();
//     $pQTY = $products['pQTY'];
//     $pPrice = $products['pPrice'];

//     $deduct = $pQTY * $pPrice;

//     $_SESSION['grand_total'] -= $deduct;

//     if (delete_orders("temp_orders", $id)) {
//         $_SESSION['msg'] = "successfully deleted products";
//         header("location:user.php");
//         exit;
//     } else {
//         header("location:user.php?mgs=Failed cancel order");
//         exit;
//     }
// }

// else {
//     $_SESSION['msg'] = "Error Occurs: Either Id not Set or Empty Products";
//     header("location:user.php");
//     exit;
// }

include "config.php";

if (isset($_POST['deleteBtn'])) {

    $id = $_POST['deleteID'];

    $sql = "DELETE FROM `temp_orders` WHERE `id` = '$id'";
    $res = $mysqli->query($sql);
}

if (isset($_POST['deleteAll'])) {
    // total

    $total = $_POST['total'];

    if ($total == 0) {
        $response = [
            'status' => 402,
            'message' => "There is no transaction",
        ];

        echo json_encode($response);

    } else {

        $sql = "DELETE FROM `temp_orders`";
        $res = $mysqli->query($sql);

        if (!$res) {

            $response = [
                'status' => 402,
                'message' => "There is no transaction",
            ];

            echo json_encode($response);
        } else {
            $response = [
                'status' => 200,
                'message' => "'Order has been canceled'",
            ];
            echo json_encode($response);
        }
    }
}
