<?php
include("../includes/Connection.php");

$username_error = "";
$useremail_error = "";

if (isset($_POST['btnGoto'])) {
  $username = $_POST['username'];
  $useremail = $_POST['useremail'];
  $userpass = $_POST['userpassword'];
  $account_type = $_POST['accounttype'];

  try {
    // Insert data into Users table
    $user_query = "INSERT INTO users (username, password, email, role) VALUES ('$username', '$userpass', '$useremail', '$account_type')";
    $insert_user = mysqli_query($con, $user_query);

    if ($insert_user) {
      // Get the last inserted user ID
      $last_inserted_user_id = mysqli_insert_id($con);

      if ($account_type == "Buyer") {
        $b_fullname = $_POST['buyer_fullname'];
        $b_address = $_POST['buyeraddress'];
        $b_picture = $_FILES["photo"]["name"];
        move_uploaded_file($_FILES["photo"]["tmp_name"], "buyerimages/" . $_FILES["photo"]["name"]);
        $buyer_query = "INSERT INTO buyers(user_id, full_name, address, photo) VALUES('$last_inserted_user_id', '$b_fullname', '$b_address', '$b_picture')";
        $insert_buyer = mysqli_query($con, $buyer_query);
            header('location:Login.php?redirect=Registration');
      } else {
        $business_name = $_POST['business_Name'];
        $business_type = $_POST['businesstype'];
        $seller_query = "INSERT INTO sellers(user_id, business_name, business_type) VALUES('$last_inserted_user_id', '$business_name', '$business_type')";
        $insert_seller = mysqli_query($con, $seller_query);
        header('location:Login.php?redirect=Registration');
      }
    }
    // echo "Data inserted successfully";
  } catch (mysqli_sql_exception $e) {
    if (strpos($e->getMessage(), 'username') !== false) {
      $useremail_error = " Username already exists.";
   
    } elseif (strpos($e->getMessage(), 'email') !== false) {
      $useremail_error = "Email already exists.";
    } else {
      echo "Error: Duplicate entry.";
    }
  }
}

?>





<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>GCH | Shop</title>
  <?php include "includes/Links.php" ?>
</head>

<body>
  <!--================ Start Header Menu Area =================-->



  <!--================ End Header Menu Area =================-->

  <main class="site-main">




    <!--================Login Box Area =================-->
    <section class="login_box_area section-margin">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="login_box_img">
              <div class="hover">
                <h4>Already have an account?</h4>
                <p>There are advances being made in science and technology every day, and a good example of this is the</p>
                <a class="button button-account" href="Login.php">Login Now</a>
              </div>
            </div>
          </div>
          <div class="col-lg-6" id="initialinfo">
            <div class="login_form_inner register_form_inner">
              <h3>Create an account</h3>
              <form class="row login_form" id="register_form" method="post" enctype="multipart/form-data">
                <div class="col-md-12 form-group">
                  <span style="color: red;"><?php echo($username_error) ?></span>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Username" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'" required>
                </div>
                <div class="col-md-12 form-group"> 
                <span style="color: red;"><?php echo($useremail_error) ?></span>
                  <input type="email" class="form-control" id="useremail" name="useremail" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'" required>
                </div>
                <div class="col-md-12 form-group">
                  <input type="password" class="form-control" id="userpassword" name="userpassword" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'" required>
                </div>
                <div class="col-md-12 form-group">
                  <select class="form-control" aria-label="Account Type" required name="accounttype" id="accounttype" onchange="toggleFields()">
                    <option value="" selected>Select Account Type</option>
                    <option value="Buyer">Buyer</option>
                    <option value="Seller">Seller</option>
                  </select>
                </div>

                <div id="buyerdetails" style="display: none;" class="col-md-12">
                  <div class="col-md-12 form-group">
                    <input type="text" class="form-control" id="buyername" name="buyer_fullname" placeholder="Full Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Full Name'">
                  </div>
                  <div class="col-md-12 form-group">
                    <input type="text" class="form-control" id="buyeraddress" name="buyeraddress" placeholder="Address" onfocus="this.placeholder = ''" onblur="this.placeholder = ' Address'">
                  </div>
                  <div class="col-md-12 form-group">
                    <input type="file" class="form-control" id="photo" name="photo">
                  </div>



                </div>
                <!-- Selller details  -->
                <div id="sellerdetails" style="display: none;" class="col-md-12">
                  <div class="col-md-12 form-group">
                    <input type="text" class="form-control" id="" name="business_Name" placeholder="Business Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Business Name'" autocomplete="off">
                  </div>
                  <div class="col-md-12 form-group">
                    <select class="form-control" aria-label="Business type" name="businesstype" id="businesstype">
                      <option value="" selected>Select Business Type</option>
                      <option value="home_base_business">Home-Based Business</option>
                      <option value="small_business">Small Business</option>
                      <option value="wholesale_supplier">Wholesale Supplier</option>
                      <option value="Boutique Shop">Boutique Shop</option>
                      <option value="Craftsperson_Artisan">Craftsperson / Artisan</option>
                      <option value="manufacturer">Manufacturer</option>

                    </select>
                  </div>




                </div>
                <br>
                <br>
                <br>
                <br>
                <br>

                <div class="col-md-12 form-group">
                  <button type="submit" value="submit" class="button button-register w-100" name="btnGoto">Register</button>
                </div>
              </form>
            </div>
          </div>

          <!-- Buyer details form -->
          <!-- <div class="col-lg-6" id="buyerdetails" style="display: none;">
                      <div class="login_form_inner register_form_inner">
                          <h3>Buyer Details</h3>
                          <form class="row login_form" id="register_form" method="post">
                              <div class="col-md-12 form-group">
                                  <input type="text" class="form-control" id="buyername" name="buyername" placeholder="Username" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'" required autocomplete="off">
                              </div>
                              <div class="col-md-12 form-group">
                                  <input type="email" class="form-control" id="buyeremail" name="buyeremail" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'" required>
                              </div>
                              <div class="col-md-12 form-group">
                                  <input type="password" class="form-control" id="buyerpassword" name="buyerpassword" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'" required>
                              </div>
                              <div class="col-md-12 form-group">
                                  <button type="submit" value="submit" class="btn btn-primary w-100" name="btnGotoBuyer">Go to Next Step</button>
                              </div>
                          </form>
                      </div>
                  </div> -->

          <!-- Seller details form -->
          <!-- <div class="col-lg-6" >
                    <div class="login_form_inner register_form_inner">
                      <h3>Seller Details</h3>
                      <form class="row login_form" id="register_form" method="post">
                        <div class="col-md-12 form-group">
                          <input type="text" class="form-control" id="sellername" name="sellername" placeholder="Username" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'" required>
                        </div>
                        <div class="col-md-12 form-group">
                          <input type="email" class="form-control" id="selleremail" name="selleremail" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'" required>
                        </div>
                        <div class="col-md-12 form-group">
                          <input type="password" class="form-control" id="sellerpassword" name="sellerpassword" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'" required>
                        </div>
                        <div class="col-md-12 form-group">
                          <button type="submit" value="submit" class="btn btn-primary w-100" name="btnGotoSeller">Go to Next Step</button>
                        </div>
                      </form>
                    </div>
                  </div> -->
        </div>
      </div>
    </section>

    <!--================End Login Box Area =================-->



  </main>

  <!--================ Start footer Area  =================-->

  <!--================ End footer Area  =================-->


  <?php include("includes/jslinks.php")  ?>
  <script type="text/javascript">
    // function validateInitialForm() {
    //   var username = document.getElementById("username").value;
    //   var email = document.getElementById("useremail").value;
    //   var password = document.getElementById("userpassword").value;

    //   if (username === "" || email === "" || password === "") {
    //     alert("Please fill in all fields before selecting an account type.");
    //     return false;
    //   }
    //   return true;
    // }

    function toggleFields() {
      var selectAccountType = document.getElementById("accounttype").value;
      var buyerForm = document.getElementById("buyerdetails");
      var sellerForm = document.getElementById("sellerdetails");
      var initialForm = document.getElementById("initialinfo");

      // if (!validateInitialForm()) {
      //   // Reset the account type select to default if validation fails
      //   document.getElementById("accounttype").value = "";
      //   return;
      // }

      // Hide all forms initially
      buyerForm.style.display = "none";
      sellerForm.style.display = "none";

      // Show the appropriate form based on the selected account type
      if (selectAccountType === "Buyer") {
        // initialForm.style.display = "none";
        buyerForm.style.display = "block";
      } else if (selectAccountType === "Seller") {
        // initialForm.style.display = "none";
        sellerForm.style.display = "block";
      }
    }

    document.addEventListener("DOMContentLoaded", function() {
      document.getElementById("accounttype").addEventListener("change", toggleFields);
    });
  </script>
</body>

</html>