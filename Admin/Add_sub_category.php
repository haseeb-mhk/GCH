<?php
// include("../includes/Connection.php");
include("includes/Session.php");



$display_submit = "block";
$display_update = "none";

$sub_cat_name = "";
$sub_cat_description = "";
$parent_cat_name="Select Parent Category";
$parent_cat_id = "";


if (isset($_POST['btnSubmit'])) {
  $sub_cat_name = $_POST['sub_cat_name'];
  $sub_cat_description = $_POST['sub_cat_description'];
  $parent_category = $_POST['parent_category'];



  // Insert data into Users table
  $cat_query = "INSERT INTO sub_categories (name,parent_category_id ,description ) VALUES ('$sub_cat_name', '$parent_category','$sub_cat_description' )";
  $insert_cat = mysqli_query($con, $cat_query);
  if ($insert_cat) {
    // echo "data inserted successfully";
    header('location:sub_categories_list.php?Uid=' . $parent_category);
  }
}

// fetching data through id for updation 

if (isset($_GET['Uid'])) {
  $display_submit = "none";
  $display_update = "block";
  $edit_id = $_GET['Uid'];
  // Fetch user  information
  // echo $edit_id;
  $edit_query = mysqli_query($con, "SELECT * FROM sub_categories WHERE id = '$edit_id' ");

  $edit_row = mysqli_fetch_assoc($edit_query);
  $sub_cat_name = $edit_row['name'];
  $parent_cat_id = $edit_row['parent_category_id'];
  $sub_cat_description =   $edit_row['description'];
}


// // // for updation of record 

if (isset($_POST['btnUpdate'])) {

  $sub_cat_id = $_POST['sub_cat_id'];
  $sub_cat_name = $_POST['sub_cat_name'];
  $parent_cat_id = $_POST['parent_category'];
  $sub_cat_description = $_POST['sub_cat_description'];


  // Update user information
  $update_cat_query = "
      UPDATE sub_categories 
      SET 
          name = '$sub_cat_name', 
          parent_category_id = '$parent_cat_id', 
          description = '$sub_cat_description'
           
      WHERE 
          id = '$sub_cat_id' ";
  $update_result = mysqli_query($con, $update_cat_query);
  if (!$update_result) {
    die('Error updating user: ' . mysqli_error($con));
  } else {
    echo 'User updated successfully';
    // header('location:sub_categories_list.php?Uid='.$parent_cat_id);
  }
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
              <h1 class="m-0 text-dark">Add Sub Category</h1>
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
            <form method="post" enctype="">

              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Enter Sub Category Details</h3>
                </div>
                <div class="card-body">
                  <input type="hidden" name="sub_cat_id" value="<?php echo $edit_id ?>">



                  <div class="form-group">

                    <label> Sub Category Name</label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="sub_cat_name" placeholder="Enter Category name" required value="<?php echo $sub_cat_name ?>">
                    </div>

                  </div>


                  <div class="form-group">

                    <label> Parent Category</label>

                    <select class="form-control" aria-label="Parent Category" name="parent_category" id="parent_category">
                      <?php
                      $parent_cat_name_query = mysqli_query($con, "Select * from categories where id = '$parent_cat_id'");
                      $row_parent_cat_name_query  = mysqli_fetch_assoc($parent_cat_name_query);
                      $parent_cat_name = $row_parent_cat_name_query['name'];


                      ?>



                      <option value="<?php echo $parent_cat_id ?>" selected><?php echo $parent_cat_name ?></option>
                      <?php
                      $Select_parent_categories = mysqli_query($con, "Select * from categories");

                      while ($row_parent_categories = mysqli_fetch_assoc($Select_parent_categories)) {

                      ?>
                        <option value="<?php echo $row_parent_categories['id'] ?>"><?php echo $row_parent_categories['name']  ?></option>
                      <?php   }  ?>
                    </select>


                  </div>

                  <div class="form-group">


                    <label>Category Description</label>
                    <div class="input-group">
                      <textarea name="sub_cat_description" placeholder="Enter Description of Category" class="form-control"><?php echo $sub_cat_description ?></textarea>


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