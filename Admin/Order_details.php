<?php
include("includes/Session.php");

if(isset($_GET['OID'])){
    
$order_id = $_GET['OID'];



$order_details_query = mysqli_query($con, "SELECT orders.*,  billing_details.*
FROM orders

JOIN billing_details ON orders.id = billing_details.order_id
Where orders.id = '$order_id'

");
$row = mysqli_fetch_assoc($order_details_query);


$order_items= mysqli_query($con, "SELECT order_items.order_id,
        order_items.product_id,
        order_items.quantity AS order_product_quantity,

 products.*
FROM order_items
JOIN products ON order_items.product_id = products.id Where order_items.order_id = '$order_id'");

}
$sub_total = 0;

?>



<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>GCH | Dashboard</title>
  <link rel="icon" type="image/png" href="../logos/favicon.png" sizes="64X64">
   
  <?php
  include("includes/links.php");
  ?>



</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <?php
    include("includes/header.php");
    ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php
    include("includes/sidepanel.php");
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Order Details</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Manage Orders</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            


            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> Global Craft Hub.
                    <small class="float-right"><?php  echo date("d/m/Y"); ?></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong>Global Craft Hub.</strong><br>
                    University of Swat, Pakistan<br>
                    Email: gch@gmail.com
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  To
                  <address>
                    <strong><?php echo $row['full_name']  ?></strong><br>
                    <?php echo $row['address'];  ?><br>
                    
                    Phone: <?php echo $row['phone_no']  ?><br>
                    Email: <?php echo $row['email']  ?>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                
                  <b>Order ID:</b> <?php echo $order_id ?><br>
                  <b>Payment Status:</b> <?php echo $row['payment_status']  ?><br>
                  <b>Shipping Status:</b> <?php echo $row['status']  ?> 
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                    <th>Serial #</th>
                      <th>Product Name</th>
                      <th>Description</th>
                      <th>Qty</th>
                      <th>Price</th>
                     
                      <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        while($row_order_items = mysqli_fetch_assoc($order_items)){   ?>
                    <tr>
                      <td><?php echo $i;  ?></td>
                      <td><?php  echo $row_order_items['name']  ?></td>
                      <td><?php echo $row_order_items['description']  ?></td>
                      <td><?php echo $row_order_items['order_product_quantity']  ?></td>
                      <td><?php echo $row_order_items['price']  ?></td>
                     
                      <td>Rs. <?php  $total_price = $row_order_items['price'] * $row_order_items['order_product_quantity']; 
                      echo $total_price;
                      $sub_total += $total_price;
                      ?></td>
                    </tr>
                   <?php  $i++; } ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
            <div class="col-6"></div>
                <!-- /.col -->
                <div class="col-6">
                  

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>Rs. <?php echo $sub_total;  ?></td>
                      </tr>
                      <tr>
                        <th>Tax (9.3%)</th>
                        <td>0</td>
                      </tr>
                      <tr>
                        <th>Shipping:</th>
                        <td>0</td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td><?php  echo $sub_total  ?></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-4"></div>
                <div class="col-4"></div>
                <div class="col-2"></div>
                <div class="col-2">
                  <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                  
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div>
      </section>

      <!-- /.content-wrapper -->
      <?php
      include("includes/footer.php");
      ?>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <?php include('includes/jslinks.php'); ?>
    
</body>

</html>