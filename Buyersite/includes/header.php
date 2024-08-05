<?php   
$user_id2 = $_SESSION['user_id'];
$query_select_buyer2 = mysqli_query($con, "Select * from buyers where user_id = '$user_id'");
$query_select_buyer_row2 = mysqli_fetch_assoc($query_select_buyer2);
$buyer_id2 = $query_select_buyer_row2['id'];

$query_count_products = "
    SELECT COUNT(DISTINCT cart_items.product_id) AS total_products 
    FROM cart_items 
    JOIN carts ON cart_items.cart_id = carts.id 
    WHERE carts.buyer_id = $buyer_id2";
$result_count_products = mysqli_query($con, $query_count_products);
if ($result_count_products) {
  $row_count_products = mysqli_fetch_assoc($result_count_products);
  if($row_count_products>0){
  $total_products = $row_count_products['total_products'];
  }
  else{
    $total_products = "";
  }
  
 
} else {
  die("Error counting products: " . mysqli_error($con));
}

?>



<header class="header_area">
  <div class="main_menu">
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container">
        <a class="navbar-brand logo_h" href="index.php"><img src="img/GCH_logo_3.png" alt="" width="200px" height="40px"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
          <ul class="nav navbar-nav menu_nav ml-auto mr-auto">
            <li class="nav-item "><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item">
              <a href="Shop.php" class="nav-link">Shop</a>

            </li>

            <li class="nav-item ">
              <a href="Blogs.php" class="nav-link">Blog</a>

            </li>


       
            <li class="nav-item"><a class="nav-link" href="Contact.php">Contact Us</a></li>
          </ul>

          <ul class="nav nav-shop navbar-nav">
            <li class="nav-item" style="margin-top: 30px;">
              <a href="#"><i class="ti-heart"></i></a>
            </li>
         
            <li class="nav-item" style="margin-top: 30px;"><button onclick = "window.location.href='Cart.php'"><i class="ti-shopping-cart"></i><span class="nav-shop__circle"><?php 
            if($total_products > 0){
              echo $total_products;
            }
            else{
              
            }
            
            ?></span></button> </li>
            
            
            <li class="nav-item submenu dropdown" ><a href="profile.php" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
            aria-expanded="false" title="Profile"><i class="ti-user"></i><span class="nav-shop__circle">&#9;&#9;&#9;<?php echo ($name); ?></span></a>
            <ul class="dropdown-menu">
                  <li class="nav-item"><a class="nav-link" href="Orders_list.php">Orders List</a></li>
                  <li class="nav-item"><a class="nav-link" href="Order_Tracking.php">Order Tracking</a></li>
                  <!-- <li class="nav-item"><a class="nav-link" href="#">Order Confimation</a></li> -->
                  <li class="nav-item"><a class="nav-link" href="Logout.php">Logout</a></li>
                </ul>
          
          </li>
           
          </ul>
        </div>
      </div>
    </nav>
  </div>
</header>