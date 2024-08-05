<?php
include("includes/Session.php");
// query for selecting All orders 
$select_orders = mysqli_query($con, "SELECT orders.*, buyers.full_name AS buyer_name
FROM orders
JOIN buyers ON orders.buyer_id = buyers.id;");


// if(isset($_POST['btnupd'])){
// $shipping_status = 


// }

// Deleting the record of buyer 

// Handle delete request
if (isset($_GET['Did'])) {
  $blog_id = $_GET['Did'];

  // First delete from buyers table
  $delete_blog_query =  mysqli_query($con, "DELETE FROM blogs WHERE id = '$blog_id'");

  // Redirect to avoid resubmission of the form
  header("location:Blogs_list.php");
  exit();
}


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
              <h1 class="m-0 text-dark">All orders List</h1>
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

        <div class="card">
          <div class="card-header">
            <h3 class="card-title"></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Order Id</th>
                  <th>Buyer</th>
                  <th>Total amount</th>
                  <th>Order Date</th>
                  <th> Shipping Status</th>
                  <th> Payment Status</th>
                  <th> Details</th>
                  <th> Edit</th>


                </tr>
              </thead>
              <tbody>
                <?php while ($row_order_query = mysqli_fetch_assoc($select_orders)) {  ?>
                  <tr>
                    <td><?php echo $row_order_query['id']   ?></td>
                    <td><?php echo $row_order_query['buyer_name']   ?></td>
                    <td>Rs. <?php echo $row_order_query['total_amount']   ?></td>
                    <td><?php echo $row_order_query['order_date']   ?></td>
                    <td><?php echo $row_order_query['status']   ?></td>
                    <td><?php echo $row_order_query['payment_status']   ?></td>
                    <td><a href="Order_details.php?OID=<?php echo $row_order_query['id'];  ?>" class="btn btn-info"> Details</a></td>
                    <td> <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                        Edit
                      </button></td>



                  </tr>
                <?php  } ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>Order Id</th>
                  <th>Buyer</th>
                  <th>Total amount</th>
                  <th>Order Date</th>
                  <th> Shipping Status</th>
                  <th> Payment Status</th>
                  <th> Details</th>
                  <th> Edit</th>


                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
      </section>
      <div class="modal fade" id="modal-default">
        <form method="post">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Update Shipping Status</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <select class="form-control" name="shipping_Status" required id="shipping_status">
                <option selected value="pending">Pending </option>
                <option selected value="shipped">Shipped </option>
                <option selected value="delivered">Delivered </option>
                <option selected value="cancelled">Cancelled </option>
              </select>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="btnupd">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        </form>
        
        <!-- /.modal-dialog -->
      </div>
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
    <script>
      $(function() {
        $("#example1").DataTable({
          "responsive": true,
          "autoWidth": false,
        });
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        });
      });
    </script>
</body>

</html>