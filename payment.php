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


// get all products form temp_order

include "functions.php";

if (isset($_POST['btn'])) {

    $customerName = $_POST['name'];
    $order_status = $_POST['order_status'];
    
    // check if input fileds are empty
    $results  = fetch_account("temp_orders");
    
    while ($row = $results->fetch_assoc()) {
        insert_order("orders", $customerName, $row['pName'], $row['pPrice'], $row['pQTY'], $row['category'], $row['subtotal'], "", $order_status, "");
    }

    delete_orders("temp_orders", "");

}


if (isset($_POST['buyBtn'])) {
    $prodId = $_POST['prodId'];
    include "config.php";
    // get the product info base on product ID
    $res = filterProductBaseOnId("product", $prodId);

    $product = $res->fetch_assoc();

    $prodName = $product['prodName'];
    $prodPrice = $product['prodPrice'];
    $category = $product['category'];
    $subtotal = 0;
    $qty = 1;
    $total = array();

    $subtotal = $prodPrice * $qty;
    // insert this information in in the temp order table

    //insert rpoduct to temp order table

    $sql = "INSERT INTO `temp_orders` (pName, pPrice, pQTY, category, subtotal) VALUES('$prodName', ' $prodPrice', '$qty', ' $category', $subtotal)";
    $res = $mysqli->query($sql);

    if (!$res) {
        echo "Failed to insert Data";
    }
}


if (isset($_POST['updateBtn'])) {
    $updateId = $_POST['updateId'];

    // get data from temp_order
    $res = filterProductBaseOnId("temp_orders", $updateId);

    if ($res->num_rows > 0) {
        $response = array();
        while ($row = $res->fetch_assoc()) {
            $response = $row;
        }

        // encode to json format
        echo json_encode($response);
    }else{
        echo "Failed to retrieve data";
    }
}


// displal grand total

if (isset($_POST['totalBtn'])) {
    $res = selectOrder("temp_orders");

    $total = 0;

    while ($row = $res->fetch_assoc()) {
        $total += $row['subtotal'];
    }

    echo $total;
}

// qtyBtn: 1,
// price: pPrice,
// qty: qty,
// id: id

if(isset($_POST['qtyBtn'])){
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $id = $_POST['id'];

    $subtotal = $qty * $price;
    // update qty
    $res = updateQTY($id, $qty, $subtotal);

    if(!$res){
       echo "Failed to update QTY";
    }

}
