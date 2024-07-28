<?php
include("includes/Session.php");
// Select the buyers data 
$query_blogs = mysqli_query($con, "SELECT 
    blogs.id,
    blogs.title,
    blogs.content,
    blogs.image,
    blogs.status,
    blogs.created_at,
    blogs.updated_at,
    CASE 
        WHEN users.role = 'seller' THEN sellers.business_name
        WHEN users.role = 'admin' THEN 'By admin'
        ELSE users.username
    END AS author_name
FROM 
    blogs
JOIN 
    users 
ON 
    blogs.user_id = users.id
LEFT JOIN 
    sellers 
ON 
    users.id = sellers.user_id
ORDER BY 
    blogs.created_at DESC
");

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
              <h1 class="m-0 text-dark">Blogs List</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Manage Blogs</li>
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
                  <th>Photo</th>
                  <th>title</th>
                  <th>contents</th>
                  <th>Posted By</th>
                  <th> Created at</th>
                  <th> Edit</th>
                  <th> Delete</th>

                </tr>
              </thead>
              <tbody>
              <?php
                        while ($row = mysqli_fetch_assoc($query_blogs)) {
                            echo "<tr>";
                            echo "<td><img src='img/blogimages/{$row['image']}' alt='Photo' width='50' height='50'></td>";
                            echo "<td>{$row['title']}</td>";
                           
                            echo "<td>{$row['content']}</td>";
                            echo "<td>{$row['author_name']}</td>";
                            echo "<td>{$row['created_at']}</td>";
                             echo "<td><a href='Add_blogs.php?Uid=$row[id]' class='btn btn-success'>Edit</a></td>";
                            echo "<td><a href='Blogs_list.php?Did={$row['id']}' class='btn btn-danger' onclick='return confirm(\"Are you sure to delete this blog?\")'>Delete</a></td>";
                            echo "</tr>";
                        }
                        ?>



              </tbody>
              <tfoot>
                <tr>
                <th>Photo</th>
                  <th>title</th>
                    <th>contents</th>
                    <th>Posted By</th>
                  <th> Created at</th>
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