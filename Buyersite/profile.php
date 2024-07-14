
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>GCH | Home</title>
  <?php include "includes/Links.php" ?>
  <style>
    /* CSS for the popup */

    #loginModal .modal-dialog {
      max-width: 70%;
      z-index: 10000000;
    }
  </style>
<style>
    /* CSS for the popup */
    #loginModal .modal-dialog {
      max-width: 70%;
      z-index: 10000000;
    }

    /* Additional CSS for the Buyer Profile */
    .profile-container {
      max-width: 100%;
      margin: 20px auto;
      background: #A7C7E7;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .profile-header {
      text-align: center;
      margin-bottom: 20px;
    }

    .profile-header img {
      border-radius: 50%;
      width: 150px;
      height: 150px;
    }

    .profile-details,
    .profile-update-form {
      margin-bottom: 20px;
    }

  </style>


</head>

<body>
  <!--================ Start Header Menu Area =================-->

  <?php include "includes/header.php" ?>
 
  <?php
if(isset($_POST["btnlogout"])){

    session_destroy();
    header("location:../index.php");
    
}


?>

  <!--================ End Header Menu Area =================-->

  <main class="site-main">

  <div class="profile-container">
      <div class="profile-header">
        <img src="path/to/buyer/photo.jpg" alt="Buyer Photo">
        <h2>Buyer Name</h2>
        <p><?php echo($name); ?></p>
        <form method="post">
        <input type="submit" class="btn btn-danger" value="logOut" name="btnlogout">
        <input type="submit" class="btn btn-success" value="Update" name="btnupd">
        </form> 
    
    </div>


     
    </div>
 
 
  


  </main>




  <!--================ Start footer Area  =================-->
  <?php include("includes/footer.php")  ?>
  <!--================ End footer Area  =================-->



</body>

</html>