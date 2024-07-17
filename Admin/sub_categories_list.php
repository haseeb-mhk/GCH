<?php
include("includes/Session.php");
// Select the parent category data

if(isset($_GET['Uid'])){
    
    $parent_cat_id = $_GET['Uid'];
    // echo $parent_cat_id;
    $parent_cat_query = mysqli_query($con,"Select * from categories where id = '$parent_cat_id'");
    $result_parent_cat_query = mysqli_fetch_assoc($parent_cat_query);
    $parent_cat_name = $result_parent_cat_query['name'];
    // echo $parent_cat_name;
    $query_cat = mysqli_query($con, "SELECT * from sub_categories where parent_category_id = '$parent_cat_id'");


}



// Deleting the record of buyer 

// Handle delete request
if (isset($_GET['Did'])) {
  $cat_id = $_GET['Did'];
  $parent_cat_id = $_GET['Uid'];
//   header("location:sub_categories_list.php?Uid=".$parent_cat_id);

  $delete_cat_query =  mysqli_query($con, "DELETE FROM sub_categories WHERE id = '$cat_id'");
 
  if($delete_cat_query){
    header("location:sub_categories_list.php?Uid=".$parent_cat_id);


  }
  else{
    echo "deletion failure";
  }
  // Redirect to avoid resubmission of the form
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
              <h1 class="m-0 text-dark"> "<?php echo $parent_cat_name   ?>" Sub Categories List</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Sub Categories</li>
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
                  <th>Description</th>
                  <th> Created At</th>
                  
                  <th> Edit</th>
                  <th> Delete</th>

                </tr>
              </thead>
              <tbody>
              <?php
              $i = 1;
                        while ($row = mysqli_fetch_assoc($query_cat)) {
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>{$row['name']}</td>";
                           
                            echo "<td>{$row['description']}</td>";
                            echo "<td>{$row['created_at']}</td>";
                                echo "<td><a href='Add_sub_category.php?Uid=$row[id]' class='btn btn-success'>Edit</a></td>";
                                echo "<td><a href='sub_categories_list.php?Did=" . $row['id'] . "&Uid=" . $parent_cat_id . "' class='btn btn-danger' onclick='return confirm(\"Are you sure to delete this Category?\")'>Delete</a></td>";
                                echo "</tr>";
                        $i++;
                          }
                        ?>



              </tbody>
              <tfoot>
                <tr>
                  <th>S#</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th> Created At</th>
                
                  <th> Edit</th>
                  <th> Delete</th>

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