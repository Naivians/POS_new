<?php

include "config.php";

date_default_timezone_set("Asia/Manila");
$date = date("Y/m/d");

// FETCH ACCOUNT BY ID / display account by id
function fetch_account_by_id($tb_name, $id)
{
    global $mysqli;
    $sql = "SELECT * FROM `$tb_name` WHERE `id` = '$id'";
    $result = $mysqli->query($sql);
    return $result;
}

// fetch account // fetch retrieved account // fetch product // fetch category
function fetch_account($tb_name)
{
    global $mysqli;
    $sql = "SELECT * FROM `$tb_name` ORDER BY `date_added` DESC";
    return $mysqli->query($sql);
}

function get_category_by_name($tb_name)
{
    global $mysqli;
    $sql = "SELECT * FROM `$tb_name` ORDER BY `category` ASC";
    return $mysqli->query($sql);
}

function seletedCategory($category)
{
    global $mysqli;
    $sql = "SELECT * FROM `product` WHERE `category`='$category'";
    return $mysqli->query($sql);
}

// insert account // insert retrieved account
// insert_account("account", $users['fullname'], $users['username'], $users['password'], $users['role'], "date_retrieved", $users['date_added']);
function insert_account($tb_name, $fullname, $username, $password, $role, $dates, $date_adedd)
{
    global $mysqli, $date;

    if ($tb_name == "account") {
        if ($date_adedd == NULL) {
            $sql = "INSERT INTO `$tb_name` (`fullname`, `username`, `password`, `role`, `$dates`) VALUES(?, ?, ?, ?, ?)";
            // prepared statement
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("sssss", $fullname, $username, $password, $role, $date);
            return $stmt->execute();
        } else {
            $sql = "INSERT INTO `$tb_name` (`fullname`, `username`, `password`, `role`, `date_added`, `$dates`) VALUES(?, ?, ?, ?, ?, ?)";
            // prepared statement
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ssssss", $fullname, $username, $password, $role, $date_adedd, $date);
            return $stmt->execute();
        }
    }

    if ($tb_name == "deleted_account") {
        $sql = "INSERT INTO `$tb_name` (`fullname`, `username`, `password`, `role`, `date_added`, `$dates`) VALUES(?, ?, ?, ?, ?, ?)";
        // prepared statement
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ssssss", $fullname, $username, $password, $role, $date_adedd, $date);
        return $stmt->execute();
    }
}

// Update Data
// Update_data("orders", $id, $date_purchase, "", "", "", $category, $pName, $pPrice, $order_status, $date_paid, $subtotal, $pQTY);

function Update_data($tb_name, $id, $fullname, $username, $password, $role, $catName, $pName, $pPrice, $order_status, $date_paid, $subtota, $pQTY)
{
    global $mysqli, $date;

    if ($tb_name == "account") {
        $sql = "UPDATE `$tb_name` SET `fullname`='$fullname',`username`='$username',`password`='$password',`role`='$role', `date_edited` = '$date' WHERE `id`='$id'";
        return $mysqli->query($sql);
    }

    if ($tb_name == "category") {
        $sql = "UPDATE `$tb_name` SET `category`='$catName', `date_edited` = '$date' WHERE `id`='$id'";
        return $mysqli->query($sql);
    }



    if ($tb_name == "product") {
        $sql = "UPDATE `$tb_name` SET `category`='$catName',`prodName` = '$pName',`prodPrice` = '$pPrice', `date_edited` = '$date' WHERE `id`='$id'";
        return $mysqli->query($sql);
    }


    if ($tb_name == "orders") {
        $sql = "UPDATE `$tb_name` SET `category`='$catName', `pName` = '$pName', `pPrice` = '$pPrice', `pQTY` = '$pQTY', `subtotal` = '$subtota', `date_added` = '$fullname' ,`order_status` = '$order_status', `date_paid` = '$date_paid' WHERE `id`='$id'";
        return $mysqli->query($sql);
    }
}


// delete Accounts / permanently delete account from retrieve page
function delete_data($tb_name, $id)
{
    global $mysqli;
    $sql = "DELETE FROM `$tb_name` WHERE `id`='$id'";
    return $mysqli->query($sql);
}

function get_account($username)
{
    // always use prepare statement
    global $mysqli;
    $sql = "SELECT * FROM `account` WHERE `username` = '$username'";
    $result = $mysqli->query($sql);
    return $result;
}

function is_account_exist($tb_name, $id, $fullname, $username, $password, $role, $cat_name, $pName, $pPrice, $order_status, $date_paid, $subtota, $pQTY)
{
    $information = fetch_account_by_id($tb_name, $id);
    $data = $information->fetch_assoc();
    $exist = true;

    if ($tb_name == "account") {
        if ($fullname != $data['fullname']) {
            $exist = false;
            return $exist;
        } elseif ($username != $data['username']) {
            $exist = false;
            return $exist;
        } elseif ($password != $data['password']) {
            $exist = false;
            return $exist;
        } elseif ($role != $data['role']) {
            $exist = false;
            return $exist;
        }
    }

    if ($tb_name == "category") {
        if ($cat_name != $data['category']) {
            $exist = false;
            return $exist;
        }
    }

    if ($tb_name == "product") {
        if ($cat_name != $data['category']) {
            $exist = false;
        }

        if ($pName != $data['prodName']) {
            $exist = false;
        }

        if ($pPrice != $data['prodPrice']) {
            $exist = false;
        }
    }

    if ($tb_name == "orders") {
        if ($cat_name != $data['category']) {
            $exist = false;
        }

        if ($pName != $data['pName']) {
            $exist = false;
        }

        if ($pPrice != $data['pPrice']) {
            $exist = false;
        }

        if ($pQTY != $data['pQTY']) {
            $exist = false;
        }

        if ($subtota != $data['subtotal']) {
            $exist = false;
        }

        if ($order_status != $data['order_status']) {
            $exist = false;
        }

        if ($date_paid != $data['date_paid']) {
            $exist = false;
        }

        if ($fullname != $data['date_added']) {
            $exist = false;
        }
    }



    return $exist;
}

//  ALL ABOUT PRODUCT RELATED DATA
// INSERT

function insert_data($tb_name, $prod_name, $prod_price, $cat_name, $placeholder)
{
    global $mysqli, $date;
    /*  
    1. this function will be use by, category and products
    */
    if ($tb_name == "category") {
        // process category related data
        $sql = "INSERT INTO `$tb_name` (`category`, `date_added`) VALUES(?, ?)";
        // prepared statement
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ss", $cat_name, $date);
        return $stmt->execute();
    }

    if ($tb_name == "product") {
        $sql = "INSERT INTO `$tb_name` (`category`,`prodName`,`prodPrice`,`date_added`) VALUES(?, ?, ?, ?)";
        // prepared statement
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ssss", $cat_name, $prod_name, $prod_price, $date);
        return $stmt->execute();
    }
}

// filter data
function filterData($tb_name, $byCategory)
{
    global $mysqli;

    if ($byCategory == "all") {
        $sql = "SELECT * FROM `$tb_name`";
        return $mysqli->query($sql);
    } else {
        $sql = "SELECT * FROM `$tb_name` WHERE `category` = '$byCategory'";
        return $mysqli->query($sql);
    }
}


// POS Related Data
// insert_order("sales_today", "", "", "", "", "", $todays_sales)
function insert_order($tb_name, $customerName, $pName, $pPrice, $pQTY, $category, $subtotal, $today_sales, $order_status, $date_paid)
{
    global $mysqli, $date;

    if ($tb_name == "temp_orders") {
        $sql = "INSERT INTO `$tb_name` (`pName`, `pPrice`,`pQTY`, `date_added`, `category`, `subtotal`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ssssss", $pName, $pPrice, $pQTY, $date, $category, $subtotal);
        return $stmt->execute();
        // use preapres statements
    }

    if ($tb_name == "orders") {

        if ($order_status == "unpaid") {

            $sql = "INSERT INTO `$tb_name` (`customerName`, `category`, `pName`, `pPrice`, `pQTY`, `subtotal`, `date_added`, `order_status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ssssssss", $customerName, $category, $pName, $pPrice, $pQTY, $subtotal, $date, $order_status);
            return $stmt->execute();
            // use preapres statements
        } else {
            $sql = "INSERT INTO `$tb_name` (`customerName`, `category`, `pName`, `pPrice`, `pQTY`, `subtotal`, `date_added`, `order_status`, `date_paid`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("sssssssss", $customerName, $category, $pName, $pPrice, $pQTY, $subtotal, $date, $order_status, $date);
            return $stmt->execute();
            // use preapres statements
        }
    }

    if ($tb_name == "sales_today") {
        $sql = "INSERT INTO `$tb_name` (`today_sales`, `date_added`) VALUES (?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ss", $today_sales, $date);
        return $stmt->execute();
    }
}

function update_orders($tb_name, $id, $pQTY, $subtotal)
{
    global $mysqli;

    if ($tb_name == "temp_orders") {
        $sql = "UPDATE `temp_orders` SET `pQTY` = '$pQTY', `subtotal` = '$subtotal' WHERE `id` = '$id'";
        return $mysqli->query($sql);
    }
}

function delete_orders($tb_name, $id)
{
    global $mysqli;
    if ($tb_name == "temp_orders") {
        if ($id == "") {
            $sql = "DELETE FROM `$tb_name`";
            return $mysqli->query($sql);
        } else {
            $sql = "DELETE FROM `$tb_name` WHERE `id`= $id";
            return $mysqli->query($sql);
        }
    }

    if ($tb_name == "orders") {
        $sql = "DELETE FROM `$tb_name` WHERE `id`= $id";
        return $mysqli->query($sql);
    }
}

// get sales base on date
function get_sales($tb_name, $dates)
{
    global $mysqli, $date;
    if ($tb_name == "orders") {

        if ($dates == "today") {
            $sql = "SELECT * FROM orders WHERE `date_added` = '$date' AND `order_status`='paid'";
            return $mysqli->query($sql);
        }

        // orders today whether paid or unpaid
        if ($dates == "todays_order") {
            $sql = "SELECT * FROM orders WHERE `date_added` = '$date'";
            return $mysqli->query($sql);
        }

        if ($dates == "month") {
            $sql = "SELECT * FROM orders WHERE month(date_added) = month(now()) AND `order_status`='paid'";
            return $mysqli->query($sql);
        }

        if ($dates == "year") {
            $sql = "SELECT * FROM orders WHERE year(date_added) = year(now()) AND `order_status` = 'paid'";
            return $mysqli->query($sql);
        }
    }
}

// filter between two dates

function filter_date($tb_name, $from_date, $to_date)
{
    global $mysqli;

    if ($tb_name == "orders") {
        // $sql = "SELECT * FROM `$tb_name` WHERE `date_added` BETWEEN '$from_date' AND '$to_date'";
        $sql = "SELECT * FROM `orders` WHERE `date_added` BETWEEN '$from_date' AND '$to_date'";
        return $mysqli->query($sql);
    }
}

// use to get product base on id
function filterProductBaseOnId($table, $id)
{
    global $mysqli;
    $sql = "SELECT * FROM `$table` WHERE `id`= '$id'";
    $res = $mysqli->query($sql);

    return $res;
}

// select Order
function selectOrder($table)
{
    global $mysqli;
    $sql = "SELECT * FROM `$table` ";
    $res = $mysqli->query($sql);
    return $res;
}

function deleteOrderById($table, $id)
{
    global $mysqli;
    $sql = "DELETE FROM `$table` WHERE id='$id'";
    $res = $mysqli->query($sql);
    return $res;
}

function updateQTY($id, $qty, $subtotal)
{
    global $mysqli;
    $sql = "UPDATE `temp_orders` SET `pQTY`='$qty', `subtotal` = '$subtotal' WHERE `id`='$id'";
    $res = $mysqli->query($sql);
    return $res;
}
