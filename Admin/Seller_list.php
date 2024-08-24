<?php
include("includes/Session.php");
// Select the buyers data 
$query_sellers = mysqli_query($con, "SELECT 
    users.id AS user_id, 
    users.username, 
    users.email,
    users.password,
    users.created_at,
    sellers.id AS seller_id, 
    sellers.business_name, 
    sellers.business_type, 
    sellers.account_status 
FROM 
    users
JOIN 
    sellers 
ON 
    users.id = sellers.user_id
WHERE 
    users.role = 'seller';
");


// Deleting the record of buyer 

if (isset($_GET['Did'])) {
  $user_id = $_GET['Did'];

  // First delete from sellers table
  $delete_seller_query = mysqli_query($con, "DELETE FROM sellers WHERE user_id = '$user_id'");

  if ($delete_seller_query) {
    // Then delete from users table
    $delete_user_query = "DELETE FROM users WHERE id = '$user_id'";
    mysqli_query($con, $delete_user_query);
  } else {
    echo "Deletion failure";
  }

  // Redirect to avoid resubmission of the form
  header("location:Seller_list.php");
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
              <h1 class="m-0 text-dark">Sellers List</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Seller</li>
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
                  <th>Business Name</th>
                  <th> Business type</th>
                  <th> created at</th>
                  <th> products</th>
                  <th> Edit</th>
                  <th> Delete</th>

                </tr>
              </thead>
              <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($query_sellers)) {
                  echo "<tr>";
                  echo "<td>{$row['business_name']}</td>";
                  echo "<td>{$row['business_type']}</td>";
                  echo "<td>{$row['created_at']}</td>";
                  echo "<td style='align-content: center;'><a href='Product_of_sellers.php?Sid={$row['seller_id']}' class='btn btn-info'>Products</a></td>";
                  echo "<td><a href='Add_seller.php?Uid={$row['user_id']}' class='btn btn-success'>Edit</a></td>";

                  echo "<td><a href='Seller_list.php?Did={$row['user_id']}' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this seller?\")'>Delete</a></td>";
                  echo "</tr>";
                }
                ?>


              </tbody>
              <tfoot>
                <tr>
                  <th>Photo</th>
                  <th>Full Name</th>

                  <th> created at</th>
         
                  <th> products</th>

                  <th> Edit</th>
                  <th> Delete</th>

                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
      </section>
      <!-- /.content -->
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