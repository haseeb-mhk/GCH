<?php
// include("../includes/Connection.php");
include("includes/Session.php");


$username_error = "";
$useremail_error = "";
$display_submit = "block";
$display_update = "none";
$user_id = "";
$buyer_id =   "";
$username =   "";
$email = "";
$pass = "";
$full_name = "";
$address = "";



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
      $insert_admin = mysqli_query($con, "INSERT INTO admins (user_id)  VALUES($last_inserted_user_id)");
      header('location:Admin_list.php ');
    }
    // echo "Data inserted successfully";
    
  } catch (mysqli_sql_exception $e) {
    if (strpos($e->getMessage(), 'username') !== false) {
      $username_error = " Username already exists.";
    } elseif (strpos($e->getMessage(), 'email') !== false) {
      $useremail_error = "Email already exists.";
    } else {
      echo "Error: Duplicate entry.";
    }
  }
}

// fetching data through id for updation 

if (isset($_GET['Uid'])) {
  $display_submit = "none";
  $display_update = "block";
  $edit_id = $_GET['Uid'];
  // Fetch user  information
  // echo $edit_id;
  $edit_query = mysqli_query($con, "SELECT * FROM users WHERE id = '$edit_id' ");

  $edit_row = mysqli_fetch_assoc($edit_query);
  $user_id = $edit_row['id'];
  $username =   $edit_row['username'];
  $email = $edit_row['email'];
  $pass = $edit_row['password'];
}


// // for updation of record 

if (isset($_POST['btnUpdate'])) {

  $user_id = $_POST['user_id'];
  //  echo $user_id;
  $uname = $_POST['username'];
  $uemail = $_POST['useremail'];
  $upassword = $_POST['userpassword'];


  // Update user information
  $update_user_query = "
      UPDATE users 
      SET 
          username = '$uname', 
          email = '$uemail', 
          password = '$upassword' 
      WHERE 
          id = '$user_id' ";
  $update_result = mysqli_query($con, $update_user_query);
  if (!$update_result) {
    die('Error updating user: ' . mysqli_error($con));
} else {
    echo 'User updated successfully';
    header('location:Admin_list.php');
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
              <h1 class="m-0 text-dark">Add new Admin</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">users</li>
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
                  <h3 class="card-title">Enter Admin Details</h3>
                </div>
                <div class="card-body">
                  <input type="hidden" name="user_id" value="<?php echo $edit_id ?>">
                


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
                      <input type="text" class="form-control" name="userrole" value="admin" readonly>
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