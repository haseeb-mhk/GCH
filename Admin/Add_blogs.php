<?php
include("includes/Session.php");;

$display_submit = "block";
$display_update = "none";
$title = "";
$content =   "";



if (isset($_POST['btnSubmit'])) {
  $title = $_POST['title'];
  $content = $_POST['content'];
  $user_id = $_SESSION['user_id'];
  $b_picture = $_FILES["photo"]["name"];
  move_uploaded_file($_FILES["photo"]["tmp_name"], "img/blogimages/" . $_FILES["photo"]["name"]);
  $blog_query = "INSERT INTO blogs(title, content, user_id, image,status) VALUES('$title', '$content', '$user_id', '$b_picture','published')";
  $insert_blog = mysqli_query($con, $blog_query);
  header('location:Blogs_list.php');

}

// fetching data through id for updation 

if (isset($_GET['Uid'])) {
  $display_submit = "none";
  $display_update = "block";
  $edit_id = $_GET['Uid'];
  // Fetch user and buyer information
  $edit_query = "select * from blogs WHERE id = '$edit_id' ";
  $edit_result = mysqli_query($con, $edit_query);
  $edit_row = mysqli_fetch_assoc($edit_result);
$title = $edit_row['title'];
$content =   $edit_row['content'];
}


// for updation of record 

if (isset($_POST['btnUpdate'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $b_picture = $_FILES["photo"]["name"];
    move_uploaded_file($_FILES["photo"]["tmp_name"], "img/blogimages/" . $_FILES["photo"]["name"]);
    

  // Update user information
  $update_blog_query = "
      UPDATE blogs 
      SET 
          title = '$title', 
          content = '$content', 
          image = '$b_picture'
      WHERE 
          id = '$edit_id';
  ";
  mysqli_query($con, $update_blog_query);

  // Redirect back to the buyer list
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
              <h1 class="m-0 text-dark">Add Blogs</h1>
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
        <div class="row">
          <div class="col-2"></div>
          <div class="col-8">
            <form method="post" enctype="multipart/form-data">

              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Enter Blogs Details</h3>
                </div>
                <div class="card-body">
               

                  <div class="form-group">
                    <span style="color:red"></span>
                    <label>Title</label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="title" placeholder="Enter blog title" required value="<?php echo $title   ?>">
                    </div>

                  </div>

                  <div class="form-group">
                    <span style="color:red"></span>

                    <label>Blog Content</label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="content" placeholder="Enter blog contents" required value="<?php echo $content  ?>">
                    </div>

                  </div>
                  
                  </div>
                  
                  

                  <div class="form-group">
                    <label>Add Image</label>
                    <div class="input-group">
                    <input type="file" class="form-control" id="photo" name="photo">
                    </div>
                  </div>

                  <div class="form-group">

                    <div class="input-group">
                      <input type="submit" class="btn btn-primary" name="btnSubmit" value="submit" style="display: <?php echo $display_submit ?>;">
                      <input type="submit" class="btn btn-success" name="btnUpdate" value="Update" style="display: <?php echo $display_update ?>;">
                    </div>

                  </div>
                </div>

              </div>
            </form>
          </div>
          <div class="col-2"></div>


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
</body>

</html>