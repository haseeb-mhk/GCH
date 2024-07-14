<?php
session_start();
include("../includes/Connection.php");
if (!isset($_SESSION["role"]) || $_SESSION["role"] != "buyer") {
  header("location:Login.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$query_for_name = mysqli_query($con,"select * from buyers where user_id = '$user_id'");
$result = mysqli_fetch_assoc($query_for_name);
$name = $result['full_name'];

?>



<header class="header_area">
    <div class="main_menu">
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
          <a class="navbar-brand logo_h" href="index.php"><img src="img/GCH_logo_2.jpg" alt=""></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
            <ul class="nav navbar-nav menu_nav ml-auto mr-auto">
              <li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
              <li class="nav-item">
                <a href="Shop.php" class="nav-link" >Shop</a>
                
							</li>
              <li class="nav-item ">
                <a href="Blogs.php" class="nav-link">Blog</a>
               
							</li>
							<li class="nav-item ">
                <a href="About.php" class="nav-link " >About Us</a>
                
              </li>
              <li class="nav-item"><a class="nav-link" href="Contact.php">Contact Us</a></li>
            </ul>

            <ul class="nav-shop">
              <li class="nav-item">  
              <a href="#"><i class="ti-heart"></i></a></li>
              <li class="nav-item"><a href="Cart.php"><i class="ti-shopping-cart"></i><span class="nav-shop__circle"></span></a> </li>
              <li class="nav-item"><a href="profile.php" title="Profile"><i class="ti-user"></i><span class="nav-shop__circle">&#9;&#9;&#9;<?php echo($name);?></span></a> </li>
              
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </header>