<?php
// include("../includes/Connection.php");
include("includes/Session.php");



$display_submit = "block";
$display_update = "none";

$cat_name = "";
$cat_description = "";


if (isset($_POST['btnSubmit'])) {
  $cat_name = $_POST['cat_name'];
  $cat_description = $_POST['cat_description'];
  $cat_picture = $_FILES["photo"]["name"];
  move_uploaded_file($_FILES["photo"]["tmp_name"], "../Sellersite/img/Categoriesimages/" . $_FILES["photo"]["name"]);


    // Insert data into Users table
    $cat_query = "INSERT INTO categories (name, description,image ) VALUES ('$cat_name', '$cat_description','$cat_picture' )";
    $insert_cat = mysqli_query($con, $cat_query);
        if($insert_cat){
              header('location:Categories_list.php');

        }
 
}

// fetching data through id for updation 

if (isset($_GET['Uid'])) {
  $display_submit = "none";
  $display_update = "block";
  $edit_id = $_GET['Uid'];
  // Fetch user  information
  // echo $edit_id;
  $edit_query = mysqli_query($con, "SELECT * FROM Categories WHERE id = '$edit_id' ");

  $edit_row = mysqli_fetch_assoc($edit_query);
  $cat_name = $edit_row['name'];
  $cat_description =   $edit_row['description'];
  
}


// // // for updation of record 

if (isset($_POST['btnUpdate'])) {

  $cat_id = $_POST['cat_id'];
  $cat_name = $_POST['cat_name'];
  $cat_description = $_POST['cat_description'];
  $cat_picture = $_FILES["photo"]["name"];
  move_uploaded_file($_FILES["photo"]["tmp_name"], "../Sellersite/img/Categoriesimages/" . $_FILES["photo"]["name"]);


  // Update user information
  $update_cat_query = "
      UPDATE categories 
      SET 
          name = '$cat_name', 
          description = '$cat_description',
          image = '$cat_picture'
           
      WHERE 
          id = '$cat_id' ";
  $update_result = mysqli_query($con, $update_cat_query);
  if (!$update_result) {
    die('Error updating user: ' . mysqli_error($con));
} else {
    echo 'User updated successfully';
    header('location:Categories_list.php');
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
              <h1 class="m-0 text-dark">Add Category</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Manage Category</li>
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
                  <h3 class="card-title">Enter Category Details</h3>
                </div>
                <div class="card-body">
                  <input type="hidden" name="cat_id" value="<?php echo $edit_id ?>">
                


                  <div class="form-group">
                 
                    <label> Category Name</label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="cat_name" placeholder="Enter Category name" required value="<?php echo $cat_name ?>">
                    </div>

                  </div>
                  <div class="form-group">
                    <label>Add Sample photo</label>

                    <input type="file" class="form-control" id="photo" name="photo">

                  </div>

                  <div class="form-group">
                  

                    <label>Category Description</label>
                    <div class="input-group">
                          <textarea name="cat_description" placeholder="Enter Description of Category" class="form-control"><?php  echo $cat_description ?></textarea>    
                  
                  
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