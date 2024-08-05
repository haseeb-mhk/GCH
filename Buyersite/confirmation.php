<?php
include('includes/Session.php');
if(isset($_GET['OID'])){
    $order_id = $_GET['OID'];
    // $payment_status = $_GET['PS'];
    $order_query = mysqli_query($con, "SELECT 
    orders.id AS order_id,
    orders.buyer_id,
    orders.order_date,
    orders.total_amount,
    orders.status,
    orders.payment_status,
    billing_details.full_name,
    billing_details.email,
    billing_details.phone_no,
    billing_details.address,
    billing_details.shipping_address,
    billing_details.order_notes
FROM 
    orders
JOIN 
    billing_details ON orders.id = billing_details.order_id
WHERE 
    orders.id = '$order_id';
");
$row_order = mysqli_fetch_assoc($order_query);


$order_items = mysqli_query($con, "SELECT 
    orders.*, 
    order_items.*, 
    products.name AS product_name
FROM 
    orders
JOIN 
    order_items ON orders.id = order_items.order_id
JOIN 
    products ON order_items.product_id = products.id
WHERE 
    orders.id = '$order_id';  -- Replace 'YOUR_BUYER_ID' with the appropriate buyer_id
");

}





?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GCH | confirmation</title>
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
                        <h1>Order Confirmation</h1>
                        <nav aria-label="breadcrumb" class="banner-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">confirmation</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!-- ================ end banner area ================= -->

  <!--================Order Details Area =================-->
  <section class="order_details section-margin--small">
    <div class="container">
      <p class="text-center billing-alert">Thank you. Your order has been received.</p>
      <div class="row mb-5">
        <div class="col-md-6 col-xl-4 mb-4 mb-xl-0">
          <div class="confirmation-card">
            <h3 class="billing-title">Order Info</h3>
            <table class="order-rable">
              <tr>
                <td>Order number</td>
                <td>: <?php echo $row_order['order_id'];  ?></td>
              </tr>
              <tr>
                <td>Date</td>
                <td>:  <?php echo date("d-m-Y", strtotime($row_order['order_date'])); ?></td>
              </tr>
              <tr>
                <td>Total</td>
                <td>: Rs. <?php echo $row_order['total_amount']  ?></td>
              </tr>
              <tr>
                <td>Shipping status</td>
                <td>: <?php echo $row_order['status']  ?> </td>
              </tr>
              <tr>
                <td>Payment status</td>
                <td>: <?php echo $row_order['payment_status']  ?> </td>
              </tr>
            </table>
          </div>
        </div>
        <div class="col-md-6 col-xl-4 mb-4 mb-xl-0">
          <div class="confirmation-card">
            <h3 class="billing-title">Billing Info</h3>
            <table class="order-rable">
              <tr>
                <td>Name</td>
                <td>: <?php echo $row_order['full_name']  ?></td>
              </tr>
              <tr>
                <td>Email</td>
                <td>: <?php echo $row_order['email']  ?></td>
              </tr>
              <tr>
                <td>Phone No</td>
                <td>: <?php echo $row_order['phone_no']  ?></td>
              </tr>
              
            </table>
          </div>
        </div>
        <div class="col-md-6 col-xl-4 mb-4 mb-xl-0">
          <div class="confirmation-card">
            <h3 class="billing-title">Shipping Address</h3>
            <table class="order-rable">
              <tr>
                <td>- <?php echo $row_order['shipping_address']  ?></td>
              
              </tr>
             
            </table>
          </div>
        </div>
      </div>
      <div class="order_details_table">
        <h2>Order Details</h2>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Product</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php  
              $sub_total = 0;
              while($row_order_items=mysqli_fetch_assoc($order_items)) { 
                
                $sub_total = $row_order_items['total_amount'];
                ?>
              <tr>
                <td>
                  <p><?php echo $row_order_items['product_name']  ?></p>
                </td>
                <td>
                  <h5><?php echo $row_order_items['quantity']  ?></h5>
                </td>
                <td>
                  <p><?php echo $row_order_items['price']  ?></p>
                </td>
              </tr>
              <?php  } ?>


             <tr>
                <td>
                  <h4>Subtotal</h4>
                </td>
                <td>
                  <h5></h5>
                </td>
                <td>
                  <p>Rs. <?php  echo $sub_total ?></p>
                </td>
              </tr>
              <tr>
                <td>
                  <h4>Shipping</h4>
                </td>
                <td>
                  <h5></h5>
                </td>
                <td>
                  <p>0</p>
                </td>
              </tr>
              <tr>
                <td>
                  <h4>Total</h4>
                </td>
                <td>
                  <h5></h5>
                </td>
                <td>
                  <h4> Rs. <?php  echo $sub_total ?></h4>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
  <!--================End Order Details Area =================-->





    </main>


    <!--================ Start footer Area  =================-->
    <?php include("includes/footer.php")  ?>
    <!--================ End footer Area  =================-->


    <?php include("includes/jslinks.php")  ?>


 
</body>

</html>