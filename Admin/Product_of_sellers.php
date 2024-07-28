<?php
include("includes/Session.php");
if (isset($_GET['Sid'])) {
  $seller_id = $_GET['Sid'];

  // Fetch products for the given seller_id
  $product_query = "
      SELECT 
          p.id,
          p.name AS product_name, 
          c.name AS category_name, 
          sc.name AS subcategory_name, 
          p.price, 
          p.quantity, 
          p.product_status 
          
      FROM 
          products p
      JOIN 
          categories c ON p.category_id = c.id
      JOIN 
          sub_categories sc ON p.sub_category_id = sc.id
      WHERE 
          p.seller_id = '$seller_id';
  ";
  $product_result = mysqli_query($con, $product_query);
}

if(isset($_GET['Did'])){
  $product_id = $_GET['Did'];
$delete_product_query = mysqli_query($con, "Delete from products where id ='$product_id'");
if($delete_product_query){
  header("Location: Product_of_sellers.php?Sid=$seller_id");

}
else{
  echo "Deletion Failure";
}
 
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
              <h1 class="m-0 text-dark">Products listed by Sellers</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Sellers</li>
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
                  <th>Name</th>
                  <th> Category</th>
                  <th> Sub category</th>
                  <th> Price </th>
                  <th> Quantity</th>
                  <th> Status</th>
                  <th> Details</th>

                  <th> Delete</th>

                </tr>
              </thead>
              <tbody>
              <?php
                if ($product_result && mysqli_num_rows($product_result) > 0) {
                  $i = 1;
                    while ($row = mysqli_fetch_assoc($product_result)) {
                        echo "<tr>";
                        echo "<td>" . $i. "</td>";
                        echo "<td>" . $row['product_name'] . "</td>";
                        echo "<td>" . $row['category_name'] . "</td>";
                        echo "<td>" . $row['subcategory_name'] . "</td>";
                        echo "<td>" . $row['price'] . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>" . $row['product_status'] . "</td>";
                        
                        echo "<td><a href='Product_details.php?product_id=" . $row['id'] . "' class='btn btn-info'>Details</a></td>";
                        echo "<td><a href='Product_of_sellers.php?Did=" . $row['id'] . "&Sid=" . $seller_id . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this seller?\")'>Delete</a></td>";

                        echo "</tr>";
                        $i++;
                    }
                } else {
                    echo "<tr><td colspan='8'>No products found for this seller.</td></tr>";
                }
                ?>


              </tbody>
              <tfoot>
                <tr>
                  <th>S#</th>
                  <th>Name</th>
                  <th> Category</th>
                  <th> Sub category</th>
                  <th> Price </th>
                  <th> Quantity </th>
                  <th> Status</th>
                  <th> Details</th>
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