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

//check if id is set if not back to home page of the user
if(isset($_GET['order_id'])){
    $id = $_GET['order_id'];

    // fetch data by id
    $product_info = fetch_account_by_id("product", $id);
    $product = $product_info -> fetch_assoc();

    $prodName = $product['prodName'];
    $prodPrice = $product['prodPrice'];
    $category = $product['category'];
    
    // compute for orders
    $pQTY = 1;
    $subtotal = $pQTY * $prodPrice;
    
    $_SESSION['grand_total'] += $subtotal;
    
    if(insert_order("temp_orders","", $prodName, $prodPrice, $pQTY, $category, $subtotal, "", "", "")){
        header("location:user.php");
        exit;
    }else{
        header("location:user.php");
        exit;
    }
}

?>