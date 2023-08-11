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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "header.php"; ?>
    <link rel="stylesheet" href="css/user.css?v=<?= time(); ?>">
    <title>MCPS | User</title>
</head>

<body>
    <!--Customer name Modal  -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Customer Name</h1>
                </div>

                <div class="modal-body">
                    <form method="post">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Customer Name</label>

                            <input type="text" class="form-control" id="customerName">

                            <div id="emailHelp" class="form-text">We'll never share your name with anyone else.</div>

                            <select id="order_status" class="form-control mt-2">
                                <option value="" selected>Select Status</option>
                                <option value="paid">Paid</option>
                                <option value="unpaid">Unpaid</option>
                            </select>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="customer">Done Order</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Qty Modal  -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Product</h1>
                </div>

                <div class="modal-body">
                    <form>
                        <input type="hidden" name="" id="id">
                        <div class="mb-3">
                            <!-- form here -->
                            <label>Category</label>
                            <input type="text" name="" id="category" class="form-control" disabled>
                        </div>

                        <div class="mb3">
                            <label>Product Name</label>
                            <input type="text" name="" id="pName" class="form-control" disabled>
                        </div>

                        <div class="mb3">
                            <label>Product Price</label>
                            <input type="text" name="" id="pPrice" class="form-control" disabled>

                        </div>

                        <div class="mb3">
                            <label>Product Qty</label>
                            <input type="number" name="" id="qty" class="form-control" min="1" max="1000" require>
                        </div>

                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateQTY()">Update</button>
                </div>

            </div>
        </div>
    </div>


    <!-- navigation area -->
    <div class="header bg-success text-light">
        <div class="logo">
            <h1>MCPS</h1>
        </div>

        <div class="userinfo text-light">
            <p class="mx-1 text-light"><?= ucwords($_SESSION['username']) ?></p>
            <a href="users_order.php" class="text-light mx-3">Orders</a>
            <div class="d-flex align-items-center justify-content-center">
                <div>
                    <a href="logout.php" class="text-light mx-2 btn btn-danger text-decoration-none">
                        <!-- <i class="fa-solid fa-arrow-right-from-bracket"></i> -->
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </div>


    <!-- filter -->
    <div class="filter-container">

        <div class="row">
            <div class="col">
                <div class="input-group">
                    <select class="form-select" id="selectedItem" name="category" onchange="selectCategory()">
                        <?php
                        $results = get_category_by_name("category");
                        while ($row = $results->fetch_assoc()) {
                        ?>
                            <option value="<?= $row['category'] ?>"><?= $row['category'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="sales">
            <h2 class="mx-4 fs-1"><span class="text-dark">Total:</span> <span id="total">&#8369</span></h2>
            <input type="hidden" name="" id="grandTotal">
        </div>

    </div>
    <!-- main content -->
    <main class="main-content">
        <!-- left table -->
        <div class="left-table" id="displayCat">
        </div>

        <!-- right table -->
        <div class="right-table" id="displayOrder">

        </div>
    </main>
    <!-- footer for payment button -->
    <div class="payments">
        <div class="d-flex align-items-center justify-content-center">
            <h4 class="text-dark mx-2"><?= date("F j, Y") ?></h4>
            <h4 id="clock" class="text-dark"></h4>
        </div>

        <div class="d-flex align-items-center justify-content-center mx-4">
            <!-- customer name -->
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success me-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add Customer and proceed
            </button>

            <button type="button" class="btn btn-danger" onclick="deleteAll()">
                Cancel Order
            </button>

        </div>
    </div>

    <?php include "script.php"; ?>
    

    <script>
        $(document).ready(function() {
            setInterval(function() {
                $("#clock").load("time.php");
            }, 1000);
            // proceed function
            proceed();
            // call this function 
            customersName();
            displayCategory();
            displayOrder();
            displayTotal();
        });

        // Update Product QTY
        function updateQTY() {
            // id
            // price
            // qty
            var pPrice = $("#pPrice").val();
            var qty = $("#qty").val();
            var id = $("#id").val();
            $("#editModal").modal("hide");

            if (qty == "") {
                Swal.fire({
                    icon: 'error',
                    title: "Quantity must not be empty",
                });
            } else {
                // process 
                $.ajax({
                    url: "payment.php",
                    method: "POST",
                    data: {
                        qtyBtn: 1,
                        price: pPrice,
                        qty: qty,
                        id: id
                    },
                    success: (res, status) => {

                        if(status != "success"){

                            Swal.fire({
                                icon: 'error',
                                title: response.message,
                            });
                        } else {
                            displayOrder();
                            displayTotal();
                        }
                    }
                });
            }

        }

        // delete all
        function deleteAll() {
            var total = document.getElementById("grandTotal").value;
            Swal.fire({
                title: 'Are you sure you want to cancel all orders?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "delete_order.php",
                        method: "POST",
                        data: {
                            deleteAll: 1,
                            total: total,
                        },
                        success: (res, status) => {

                            if (status != "success") {
                                Swal.fire({
                                    icon: 'error',
                                    title: "Failed to delete product",
                                });
                            } else {
                                var response = JSON.parse(res);

                                if (response.status != 200) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: response.message,
                                    });
                                } else {
                                    Swal.fire(
                                        'Cancelled!',
                                        response.message,
                                        'success'
                                    )
                                    displayOrder();
                                    displayTotal();
                                }
                            }
                        }
                    });
                }
            });
        }

        function deleteProd(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "delete_order.php",
                        method: "POST",
                        data: {
                            deleteBtn: 1,
                            deleteID: id
                        },
                        success: (res, status) => {

                            if (status != "success") {
                                Swal.fire({
                                    icon: 'error',
                                    title: "Failed to delete product",
                                });
                            } else {
                                Swal.fire(
                                    'Deleted!',
                                    'Product has been deleted!',
                                    'success'
                                )
                                
                                displayOrder();
                                displayTotal();
                            }
                        }
                    });
                }
            });
        }

        function editProduct(id) {

            // get the qty and the id
            $("#id").val(id);
            $.ajax({
                url: "payment.php",
                method: "POST",
                data: {
                    updateBtn: 1,
                    updateId: id
                },
                success: (res, status) => {
                    // call display order
                    if (status != "success") {
                        Swal.fire({
                            icon: 'error',
                            title: res,
                        });
                    } else {

                        var response = JSON.parse(res);
                        $("#category").val(response.category);
                        $("#pName").val(response.pName);
                        $("#pPrice").val(response.pPrice);
                        $("#qty").val(response.pQTY);
                        $("#editModal").modal("show");

                    }


                }
            });

        }

        function displayTotal() {
            $.ajax({
                url: "payment.php",
                method: "POST",
                data: {
                    totalBtn: 1
                },
                success: (res) => {
                    // return total
                    document.getElementById("total").innerText = res;
                    document.getElementById("grandTotal").value = res;
                }
            });
        }
        // buy products
        function buy(prodId) {
            $.ajax({
                url: "payment.php",
                method: "POST",
                data: {
                    buyBtn: 1,
                    prodId: prodId
                },
                success: (res, status) => {
                    var s = 0;
                    if (status != "success") {
                        Swal.fire({
                            icon: 'error',
                            title: "Failed",
                        });
                    } else {
                        displayOrder();
                        displayTotal();
                    }

                }
            });
        }

        function displayOrder() {
            $.ajax({
                url: "displayData.php",
                method: "POST",
                data: {
                    orderBtn: 1
                },
                success: (res) => {
                    // displayCat
                    $("#displayOrder").html(res);
                }
            });
        }
        // display category
        function displayCategory(id) {
            $.ajax({
                url: "displayData.php",
                method: "POST",
                data: {
                    catBtn: 1
                },
                success: (res) => {
                    // displayCat
                    $("#displayCat").html(res);
                }
            });
        }

        // check for customer namd and payment status
        function customersName() {
            // add customer name
            $('#customer').on('click', () => {
                var customerName = $('#customerName').val();
                var orderStatus = $('#order_status').val();
                var total = $("#grandTotal").val();

                // check for empty fields
                if (customerName == "" || orderStatus == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Check if payment status or customer name is empty',
                    });
                    reset();
                } 

                else if(total == 0){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Theres no transaction',
                    });
                    reset();
                }
                else {
                    $.ajax({
                        url: 'payment.php',
                        method: 'POST',
                        data: {
                            btn: 1,
                            name: customerName,
                            order_status: orderStatus,
                        },
                        success: (res, status) => {
                            if (status != "success") {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Check if payment status or customer name is empty',
                                });
                            } else{
                                reset();
                                displayOrder();
                                displayTotal();
                                $("#exampleModal").modal("hide");
                            }
                        },
                    });
                }
            });
        }

        function reset() {
            $('.modal').modal('hide');
            $('#customerName').val('');
            $('#order_status').val('');
        }

        // go to payment.php when click
        function proceed() {
            $('#proceed').on('click', () => {
                window.location.href = "payment.php";
            })
        }

        function deleteOrder() {
            $("#delete").on('click', () => {
                var id = $("#delete").val();
                console.log(id);
            })
        }

        // select onchange function
        function selectCategory() {
            // getselected item
            var selectItem = $("#selectedItem").val();
            // 
            $.ajax({
                url: "displayData.php",
                method: "POST",
                data: {
                    selectCategory: 1,
                    category: selectItem,
                },
                success: (res) => {
                    $("#displayCat").html(res);
                }
            });
        }
    </script>


</body>

</html>