<?php
// include("../includes/Connection.php");
include("includes/Session.php");



$display_submit = "block";
$display_update = "none";
$seller_name= "Select Seller";
$seller_id= "";
$start_date = date('Y-m-d'); ;
$end_date = "";
$status = "Select Status";



if (isset($_POST['btnSubmit'])) {
  $seller_id = $_POST['seller'];
  $end_date = $_POST['end_date'];
  $status = $_POST['status'];



  // Insert data into Users table
  $subscrition_query = "INSERT INTO subscriptions (seller_id,end_date ,status ) VALUES ('$seller_id', '$end_date','$status')";
  $insert_subscription = mysqli_query($con, $subscrition_query);
  if ($insert_subscription) {
    echo "data inserted successfully";
    // header('location:sub_categories_list.php?Uid=' . $parent_category);
  }
}

// fetching data through id for updation 

if (isset($_GET['Uid'])) {
  $display_submit = "none";
  $display_update = "block";
  $edit_id = $_GET['Uid'];
  // Fetch user  information
  // echo $edit_id;
  $edit_query = mysqli_query($con, "
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
      subscriptions.id = '$edit_id';
");
  $edit_row = mysqli_fetch_assoc($edit_query);
  $seller_id = $edit_row['seller_id'];
  $seller_name = $edit_row['business_name'];
  $start_date =  date('Y-m-d', strtotime($edit_row['start_date']));
  $end_date = date('Y-m-d', strtotime($edit_row['end_date']));
  $status = $edit_row['status'];

  }


// // // for updation of record 

if (isset($_POST['btnUpdate'])) {

  $subscription_id = $_POST['subscription_id'];
  $seller_id = $_POST['seller'];
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $status = $_POST['status'];


  // Update user information
  $update_subscription_query = "
      UPDATE subscriptions 
      SET 
          seller_id = '$seller_id', 
          start_date = '$start_date', 
          end_date = '$end_date', 
          status = '$status'
           
      WHERE 
          id = '$subscription_id' ";
  $update_result = mysqli_query($con, $update_subscription_query);
  if (!$update_result) {
    die('Error updating user: ' . mysqli_error($con));
  } else {
   
    header('location:Subscriptions_list.php');
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
              <h1 class="m-0 text-dark">Add Subscription for Seller Added by admin</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Manage subcription</li>
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
                  <h3 class="card-title">Enter subscription details</h3>
                </div>
                <div class="card-body">
                  <input type="hidden" name="subscription_id" value="<?php echo $edit_id ?>">





                  <div class="form-group">

                    <label> Seller</label>

                    <select class="form-control" aria-label="" name="seller" id="seller">
                  



                      <option value="<?php echo $seller_id;  ?>" selected><?php echo $seller_name   ?></option>
                      <?php
                      $Select_sellers = mysqli_query($con, "Select * from sellers");

                      while ($row_seller = mysqli_fetch_assoc($Select_sellers)) {

                      ?>
                        <option value="<?php echo $row_seller['id'] ?>"><?php echo $row_seller['business_name']  ?></option>
                      <?php   }  ?>
                    </select>


                  </div>

                  <div class="form-group">
                    <label>Start Date</label>
                    <div class="input-group">
                      <input type="date" class="form-control" name="start_date" value="<?php echo $start_date?>" >
                    </div>
                  </div>


                  <div class="form-group">


                    <label>End Date</label>
                    <div class="input-group">
                      <input type="date" class="form-control" name="end_date" value="<?php echo $end_date  ?>">

                    </div>


                  </div>

                  <div class="form-group">

                    <label> Status</label>

                    <select class="form-control" aria-label="Parent Category" name="status" id="status">
                     

                    <option value="<?php echo $status  ?>" selected><?php echo $status  ?></option>
                    <option value="active" >active</option>
                    <option value="inactive" >inactive</option>
                     
                    </select>


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