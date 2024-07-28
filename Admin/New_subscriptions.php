<?php
include("includes/Session.php");
// Select the parent category data
$new_subscriptions_query = mysqli_query($con, "
    SELECT 
        subscriptions.*, 
        sellers.business_name 
    FROM 
        subscriptions
    JOIN 
        sellers 
    ON 
        subscriptions.seller_id = sellers.id
    WHERE 
        subscriptions.is_new = TRUE;
");


if (isset($_GET['subscription_id'])) {
  $subscription_id = $_GET['subscription_id'];
  $mark_as_viewed_query = mysqli_query($con, "
      UPDATE 
          subscriptions 
      SET 
          is_new = FALSE 
      WHERE 
          id = '$subscription_id';
  ");
  
  // Redirect back to the admin page
  header("Location: New_subscriptions.php");
  exit();
}



?>



<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>GCH | Dashboard</title>
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
              <h1 class="m-0 text-dark">New Subscriptions</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Manage_subscriptions</li>
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
                  <th>S#</th>
                  <th>Business Name</th>
                  <th>Start Date</th>
                  <th> End Date</th>
                  <th> Status</th>
                  <th> seller_detials</th>
                  <th>Edit</th>
                  <th> Viewed</th>
          

                </tr>
              </thead>
              <tbody>
              <?php
              $i = 1;
                        while ($row = mysqli_fetch_assoc($new_subscriptions_query)) {
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>{$row['business_name']}</td>";
                           
                            echo "<td>{$row['start_date']}</td>";
                            echo "<td>{$row['end_date']}</td>";
                            echo "<td>{$row['status']}</td>";
                                echo "<td><a href='#?Uid=$row[id]' class='btn btn-info'>Details</a></td>";
                                echo "<td><a href='Add_subscription.php?Uid=$row[id]' class='btn btn-success'>Edit</a></td>";
                                echo "<td><a href='New_subscriptions.php?subscription_id=$row[id]' class='btn btn-warning'>Mark Viewed</a></td>";
                                        echo "</tr>";
                        $i++;
                          }
                        ?>



              </tbody>
              <tfoot>
                <tr>
            
                <th>S#</th>
                  <th>Business Name</th>
                  <th>Start Date</th>
                  <th> End Date</th>
                  <th> Status</th>
                  <th> Seller Details</th>
                  <th> Edit</th>
                  <th> Viewed</th>
              

                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
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