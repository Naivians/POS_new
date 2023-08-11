<?php

include "functions.php";

if (isset($_POST['catBtn'])) {

    $res = get_category_by_name("product");

    $table = ' <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">SN#</th>
                        <th scope="col">Category</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Product Price</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>';

    while ($row = $res->fetch_assoc()) {
        $table .= ' <tr>
                    <td><?= $sn ?></td>
                    <td>' . $row['category'] . '</td>
                    <td>' . $row['prodName'] . '</td>
                    <td>' . $row['prodPrice'] . '</td>
                    <td>
                    <button class="btn" onclick="buy(' . $row['id'] . ')">
                    <i class="bx bxs-cart-add fs-4 text-primary"></i>
                    </button>
                    </td>
                </tr>';
    }
    $table .= "</table>";

    echo $table;
}

if (isset($_POST['selectCategory'])) {

    $selectCategory = $_POST['category'];
    $res = seletedCategory($selectCategory);

    $table = ' <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">SN#</th>
                        <th scope="col">Category</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Product Price</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>';
    
    while ($row = $res->fetch_assoc()) {
        $table .= ' <tr>
                    <td><?= $sn ?></td>
                    <td>' . $row['category'] . '</td>
                    <td>' . $row['prodName'] . '</td>
                    <td>' . $row['prodPrice'] . '</td>
                    <td>
                    <button class="btn" onclick="buy(' . $row['id'] . ')"><i class="bx bxs-cart-add fs-4 text-primary"></i></button>
                    </td>
                </tr>';
    }
    $table .= "</table>";

    echo $table;
}

if (isset($_POST['orderBtn'])) {

    $res = selectOrder("temp_orders");

    $table = ' <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Category</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Product Price</th>
                        <th scope="col">QTY</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>';

    while ($row = $res->fetch_assoc()) {
        $table .= ' <tr>
                    <td>' . $row['category'] . '</td>
                    <td>' . $row['pName'] . '</td>
                    <td>' . $row['pPrice'] . '</td>
                    <td>' . $row['pQTY'] . '</td>
                    <td>' . $row['subtotal'] . '</td>
                    <form>
                                <td>
                                    <button type="button" class="btn" onclick="editProduct(' . $row['id'] . ')">
                                    <i class="bx bx-edit text-primary"></i>
                                    </button>

                                    <button class="btn" onclick="deleteProd(' . $row['id'] . ')">
                                    <i class="bx bxs-trash text-danger" ></i>
                                    </button>

                                </td>


                            </form>
                    </tr>';
    }
    $table .= "</table>";

    echo $table;
}

// 
?>

<!-- <button class="btn" onclick="updateQty('.$row['id'].')">
                            
                            </button>

                            -->