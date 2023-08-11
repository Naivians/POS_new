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

// delete accounts
if(isset($_GET['user_id'])){
    $id = $_GET['user_id'];
    $information = fetch_account_by_id("account", $id);
    $users = $information->fetch_assoc();
    
    insert_account("deleted_account", $users['fullname'], $users['username'], $users['password'], $users['role'], "deleted_date", $users['date_added']);

    if(delete_data("account", $id)){
        $_SESSION['message'] = "Successfully deleted Account";
        $_SESSION['alert-class'] = "alert-success";
        header("location:account.php");
        exit;
    }else{
        $_SESSION['message'] = "Failed to delete Account. Please check your query";
        $_SESSION['alert-class'] = "alert-danger";
        header("location:account.php");
        exit;
    }
}
// delete category
if(isset($_GET['cat_id'])){
    $id = $_GET['cat_id'];
    if(delete_data("category", $id)){
        $_SESSION['message'] = "Successfully deleted category";
        $_SESSION['alert-class'] = "alert-success";
        header("location:admin_category.php");
        exit;
    }else{
        $_SESSION['message'] = "Failed to delete category. Please check your query";
        $_SESSION['alert-class'] = "alert-danger";
        header("location:admin_category.php");
        exit;
    }
}

// delete products

if(isset($_GET['prod_id'])){
    $id = $_GET['prod_id'];
    if(delete_data("product", $id)){
        $_SESSION['message'] = "Successfully deleted product";
        $_SESSION['alert-class'] = "alert-success";
        header("location:product.php");
        exit;
    }else{
        $_SESSION['message'] = "Failed to delete product. Please check your query";
        $_SESSION['alert-class'] = "alert-danger";
        header("location:product.php");
        exit;
    }
}

if (isset($_GET['del_order_id'])) {

    $id = $_GET['del_order_id'];
    // echo $id;
    
    // die;
    if (delete_orders("orders", $id)) {
        $_SESSION['message'] = "Delete Successfully";
        header("location:orders.php");
        exit;
    } else {
        $_SESSION['message'] = "Failed to delete products";
        header("location:orders.php");
        exit;
    }
}

else{
    $_SESSION['message'] = "ID not set";
    $_SESSION['alert-class'] = "alert-danger";
    header("location:account.php");
    exit;
}


// delteBtn: 1,
// deleteID: id


