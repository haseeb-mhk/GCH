<?php
include("../includes/Connection.php");

$username_error = "";
$useremail_error = "";
$display_submit = "block";
$display_update = "none";
$user_id = "";
$seller_id =   "";
$username =   "";
$email = "";
$pass = "";
$business_name = "";
$business_type = "";



if (isset($_POST['btnSubmit'])) {
  $username = $_POST['username'];
  $useremail = $_POST['useremail'];
  $userpass = $_POST['userpassword'];
  $account_type = $_POST['userrole'];

  try {
    // Insert data into Users table
    $user_query = "INSERT INTO users (username, password, email, role) VALUES ('$username', '$userpass', '$useremail', '$account_type')";
    $insert_user = mysqli_query($con, $user_query);

    if ($insert_user) {
      // Get the last inserted user ID
      $last_inserted_user_id = mysqli_insert_id($con);
      $business_name = $_POST['business_name'];
      $business_type = $_POST['businesstype'];
      $seller_query = "INSERT INTO sellers(user_id, business_name, business_type) VALUES('$last_inserted_user_id', '$business_name', '$business_type')";
      $insert_seller = mysqli_query($con, $seller_query);
      header('location:Seller_list.php');
    }
    // echo "Data inserted successfully";
  } catch (mysqli_sql_exception $e) {
    if (strpos($e->getMessage(), 'username') !== false) {
      $username_error = " Username already exists.";
    } elseif (strpos($e->getMessage(), 'email') !== false) {
      $useremail_error = "Email already exists.";
    } else {

      echo mysqli_errno($con);
    }
  }
}

// // fetching data through id for updation 

if (isset($_GET['Uid'])) {
  $display_submit = "none";
  $display_update = "block";
  $edit_id = $_GET['Uid'];

  // Fetch user and seller information
  $edit_query = "
    SELECT 
        users.id AS user_id, 
        users.username, 
        users.email, 
        users.password,
        users.created_at,
        sellers.id AS seller_id, 
        sellers.business_name, 
        sellers.business_type 
    FROM 
        users
    JOIN 
        sellers 
    ON 
        users.id = sellers.user_id
    WHERE 
        users.id = '$edit_id';
    ";

  $edit_result = mysqli_query($con, $edit_query);
  $edit_row = mysqli_fetch_assoc($edit_result);

  $user_id = $edit_row['user_id'];
  $seller_id = $edit_row['seller_id'];
  $username = $edit_row['username'];
  $email = $edit_row['email'];
  $pass = $edit_row['password'];
  $business_name = $edit_row['business_name'];
  $business_type = $edit_row['business_type'];
}


// // for updation of record 
if (isset($_POST['btnUpdate'])) {
  $user_id = $_POST['user_id'];
  $seller_id = $_POST['seller_id'];
  $username = $_POST['username'];
  $email = $_POST['useremail'];
  $password = $_POST['userpassword'];
  $business_name = $_POST['business_name'];
  $business_type = $_POST['businesstype'];

  // Update user information
  $update_user_query = "
      UPDATE users 
      SET 
          username = '$username', 
          email = '$email', 
          password = '$password' 
      WHERE 
          id = '$user_id';
  ";
  mysqli_query($con, $update_user_query);

  // Update seller information
  $update_seller_query = "
      UPDATE sellers 
      SET 
          business_name = '$business_name', 
          business_type = '$business_type'
      WHERE id = '$seller_id';
  ";

  mysqli_query($con, $update_seller_query);

  // Redirect back to the seller list
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
              <h1 class="m-0 text-dark">Add Sellers</h1>
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
        <div class="row">
          <div class="col-2"></div>
          <div class="col-8">
            <form method="post" enctype="multipart/form-data">

              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Enter Seller Details</h3>
                </div>
                <div class="card-body">
                  <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
                  <input type="hidden" name="seller_id" value="<?php echo $seller_id ?>">


                  <div class="form-group">
                    <span style="color:red"><?php echo ($username_error)  ?></span>
                    <label>User Name</label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="username" placeholder="Enter user name" required value="<?php echo $username ?>">
                    </div>

                  </div>

                  <div class="form-group">
                    <span style="color:red"><?php echo ($useremail_error)  ?></span>

                    <label>Email</label>
                    <div class="input-group">
                      <input type="email" class="form-control" name="useremail" placeholder="Enter user email" required value="<?php echo $email ?>">
                    </div>

                  </div>

                  <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                      <input type="password" class="form-control" name="userpassword" placeholder="Enter user password" required value="<?php echo $pass ?>">
                    </div>

                  </div>

                  <div class="form-group">
                    <label>role</label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="userrole" value="seller" readonly>
                    </div>

                  </div>
                  <div class="form-group">
                    <label>Business Name</label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="business_name" placeholder="Enter Business name" value="<?php echo $business_name; ?>" required>
                    </div>

                  </div>

                  <div class="form-group">
                    <label>Business Type</label>
                    <div class="input-group">
                      <select class="form-control" aria-label="Business type" name="businesstype" id="businesstype">
                        <option value="<?php echo $business_type ?>" selected><?php echo $business_type ?></option>
                        <option value="home_base_business">Home-Based Business</option>
                        <option value="small_business">Small Business</option>
                        <option value="wholesale_supplier">Wholesale Supplier</option>
                        <option value="Boutique Shop">Boutique Shop</option>
                        <option value="Craftsperson_Artisan">Craftsperson / Artisan</option>
                        <option value="manufacturer">Manufacturer</option>

                      </select>
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