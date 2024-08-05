<?php
include('includes/Session.php');

$user_id = $_SESSION['user_id'];

// Fetch buyer ID
$query_select_buyer = mysqli_query($con, "SELECT * FROM buyers WHERE user_id = '$user_id'");
$query_select_buyer_row = mysqli_fetch_assoc($query_select_buyer);
$buyer_id = $query_select_buyer_row['id'];


if(isset($_POST['BtnTrack'])){

$order_id = $_POST['order_id'];

$query_select_order = mysqli_query($con, "select * from orders where id  = '$order_id'");

if($query_select_order){
 $row = mysqli_fetch_assoc($query_select_order);
 $order_id = $row['id'];
 header('location:confirmation.php?OID='.$order_id);
}
else{
    echo "something else is occur";
}


}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GCH | Tracking</title>
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
                        <h1>Order Tracking</h1>
                        <nav aria-label="breadcrumb" class="banner-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page"> Order Tracking</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!-- ================ end banner area ================= -->
  
  <!--================Tracking Box Area =================-->
  <section class="tracking_box_area section-margin--small">
      <div class="container">
          <div class="tracking_box_inner">
              <p>To track your order please enter your Order ID in the box below and press the "Track" button. </p>
              <form class="row tracking_form"  method="post" >
                  <div class="col-md-12 form-group">
                      <input type="text" class="form-control" id="order" name="order_id" placeholder="Order ID" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Order ID'" required>
                  </div>
                 
                  <div class="col-md-12 form-group">
                      <button type="submit" value="submit" class="button button-tracking" name="BtnTrack"> Track Order</button>
                  </div>
              </form>
          </div>
      </div>
  </section>
  <!--================End Tracking Box Area =================-->



    </main>


    <!--================ Start footer Area  =================-->
    <?php include("includes/footer.php")  ?>
    <!--================ End footer Area  =================-->


    <?php include("includes/jslinks.php")  ?>
</body>

</html>