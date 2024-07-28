<?php
include('includes/Session.php');
include('includes/config.php');

$user_id = $_SESSION['user_id'];
$query_select_buyer = mysqli_query($con, "SELECT * FROM buyers WHERE user_id = '$user_id'");
$query_select_buyer_row = mysqli_fetch_assoc($query_select_buyer);
$buyer_id = $query_select_buyer_row['id'];
$buyer_name = $query_select_buyer_row['full_name'];
$buyer_photo = $query_select_buyer_row['photo'];

// Fetch cart items
$query_cart_items = "
    SELECT 
        cart_items.id AS cart_item_id,
        cart_items.cart_id AS cart_id,
        products.id AS product_id,
        products.name AS product_name,
        products.price AS product_price,
        products.image1 AS product_image,
        cart_items.quantity AS product_quantity,
        carts.total_price AS sub_total
    FROM 
        cart_items
    JOIN 
        carts ON cart_items.cart_id = carts.id
    JOIN 
        products ON cart_items.product_id = products.id
    WHERE 
        carts.buyer_id = '$buyer_id'
";
$result_cart_items = mysqli_query($con, $query_cart_items);

$sub_total_price = 0;



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GCH | Checkouts</title>
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
                        <h1>Product Checkout</h1>
                        <nav aria-label="breadcrumb" class="banner-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!-- ================ end banner area ================= -->


        <!--================Checkout Area =================-->
        <section class="checkout_area section-margin--small">
            <div class="container">


                <div class="billing_details">
                    <div class="row">
                        <div class="col-lg-8">
                            <h3>Billing Details</h3>
                            <form class="row contact_form" action="#" method="post" novalidate="novalidate">
                                <div class="col-md-6 form-group p_star">
                                    <input type="text" class="form-control" id="full_name" name="name" placeholder=" Full Name">
                                </div>

                                <div class="col-md-6 form-group">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="  Email">
                                </div>
                                <div class="col-md-6 form-group p_star">
                                    <input type="text" class="form-control" id="number" name="number" placeholder="  phone number">
                                </div>
                                <div class="col-md-6 form-group p_star">
                                    <input type="text" class="form-control" id="address" name="address" placeholder="  Address">
                                </div>


                                <div class="col-md-12 form-group mb-0">
                                    <div class="creat_account">
                                        <h3>Shipping Address</h3>
                                        <input type="text" class="form-control" id="address" name="address" placeholder="  Address">

                                    </div><br>
                                    <h3>Order Notes</h3>
                                    <textarea class="form-control" name="message" id="message" rows="1" placeholder="Order Notes"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-4">
                            <div class="order_box">
                                <h2>Your Order</h2>
                                <ul class="list">
                                    <li><a href="#">
                                            <h4>Product <span>Total</span></h4>
                                        </a></li>

                                    <?php
                                    while ($row_cart_item = mysqli_fetch_assoc($result_cart_items)) {



                                    ?>

                                        <li><a href="Single_product.php?PID=<?php echo $row_cart_item['product_id']  ?>"><?php echo $row_cart_item['product_name'];  ?> <span class="middle">x <?php echo $row_cart_item['product_quantity']  ?></span> <span class="last">Rs.<?php echo ($row_cart_item['product_price'] * $row_cart_item['product_quantity']);
                                                                                                                                                                                                                                                                                $sub_total_price += $row_cart_item['product_price'] * $row_cart_item['product_quantity'];

                                                                                                                                                                                                                                                                                ?></span></a></li>
                                    <?php  } ?>

                                </ul>
                                <ul class="list list_2">
                                    <li><a href="#">Subtotal <span>Rs. <?php echo $sub_total_price;  ?></span></a></li>
                                    <li><a href="#">Shipping <span>0</span></a></li>
                                    <li><a href="#">Total <span>Rs. <?php echo $sub_total_price; ?></span></a></li>
                                </ul>
                                <div class="creat_account">
                                    <input type="checkbox" id="f-option4" name="selector">
                                    <label for="f-option4">I’ve read and accept the </label>
                                    <a href="#">terms & conditions*</a>
                                </div>
                                <div class="text-center">

                                    <form method="post" action="submit.php">
                                    <input type="hidden" name="amount" value="<?php echo $sub_total_price; ?>">
                                    <script src="https:checkout.stripe.com/checkout.js" class="stripe-button" data-key="<?php echo $Publishable_key ?>" data-amount="<?php echo $sub_total_price * 100  ?>" data-currency="pkr" data-name="<?php echo $buyer_name  ?>" data-description="Enter your cards Details for payment Transaction" data-image="buyerimages/<?php echo $buyer_photo;  ?>" data-label="Proceed to Payment" data-locale="auto">
                                                

                                        </script>



                                    </form>
           
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--================End Checkout Area =================-->




    </main>


    <!--================ Start footer Area  =================-->
    <?php include("includes/footer.php")  ?>
    <!--================ End footer Area  =================-->


    <?php include("includes/jslinks.php")  ?>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var stripeButton = document.querySelector('.stripe-button-el');
            if (stripeButton) {
                var label = stripeButton.querySelector('.text');
                if (label) {
                    label.innerHTML = label.innerHTML.replace('PKR', 'Rs. ');
                }
            }
        });
    </script>
</body>

</html>