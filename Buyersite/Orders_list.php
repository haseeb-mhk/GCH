<?php
include('includes/Session.php');

$user_id = $_SESSION['user_id'];

// Fetch buyer ID
$query_select_buyer = mysqli_query($con, "SELECT * FROM buyers WHERE user_id = '$user_id'");
$query_select_buyer_row = mysqli_fetch_assoc($query_select_buyer);
$buyer_id = $query_select_buyer_row['id'];


$query_select_orders = mysqli_query($con,"Select * from orders where buyer_id = '$buyer_id'");


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GCH | Carts</title>
    <link rel="icon" type="image/png" href="../logos/favicon.png" sizes="64X64">
    <?php include "includes/Links.php" ?>
</head>

<body>
    <!--================ Start Header Menu Area =================-->

    <?php include "includes/header.php" ?>


    <!--================ End Header Menu Area =================-->
    <main class="site-main">


        <!-- ================ start banner area ================= -->
        <section class="blog-banner-area" id="category">
            <div class="container h-100">
                <div class="blog-banner">
                    <div class="text-center">
                        <h1>Orders List</h1>
                        <nav aria-label="breadcrumb" class="banner-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Orders List</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!-- ================ end banner area ================= -->



        <!--================Cart Area =================-->

       
        <section class="cart_area">
            <div class="container">
                <div class="cart_inner">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Order_id</th>
                                    <th scope="col">Order Date</th>
                                    <th scope="col">Total amount</th>
                                    <th scope="col">Shipping status</th>
                                    <th scope="col">Payment Status</th>
                                    <th scope="col">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row_orders = mysqli_fetch_assoc($query_select_orders)) : ?>
                                    <tr>
                                        <td>
                                        <h5> <?php echo ($row_orders['id']); ?></h5>
                                      
                                        </td>
                                        <td>
                                            <h5> <?php echo ($row_orders['order_date']); ?></h5>
                                        </td>
                                        <td>
                                        <h5> <?php echo($row_orders['total_amount']); ?></h5>
                                  
                                        </td>
                                        <td>
                                            <h5> <?php echo($row_orders['status']); ?></h5>
                                        </td>
                                        <td>
                                            <h5> <?php echo($row_orders['payment_status']); ?></h5>
                                        </td>
                                        <td>
                                            <h5> <a href="confirmation.php?OID=<?php echo $row_orders['id']?>" class="btn btn-primary btn-sm">Orders Details</a></h5>
                                        </td>
                                       
                                    </tr>
                                   
                                <?php endwhile; ?>
  
                                <tr class="out_button_area">
                                    <td class="d-none-l"></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="checkout_btn_inner d-flex align-items-center">
                                            <a class="gray_btn" href="shop.php">Continue Shopping</a>
                                            <!-- <button type="submit" class=" btn primary-btn ml-2"> Proceed to checkouts</button> -->
                                            <a class="primary-btn ml-2" href="Checkouts.php">Proceed to checkout</a>
                                        </div>
                                    </td>
                                </tr>

                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
     
        <!--================End Cart Area =================-->



    </main>


    <!--================ Start footer Area  =================-->
    <?php include("includes/footer.php")  ?>
    <!--================ End footer Area  =================-->


    <?php include("includes/jslinks.php")  ?>
</body>

</html>