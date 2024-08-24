<?php
$product_query_count = "
  SELECT 
      p.id,
      p.name AS product_name, 
      c.name AS category_name, 
      sc.name AS subcategory_name, 
      p.price, 
      p.quantity, 
      p.product_status 
      
  FROM 
      products p
  JOIN 
      categories c ON p.category_id = c.id
  JOIN 
      sub_categories sc ON p.sub_category_id = sc.id 
      where p.product_status = 'inactive'";
$product_count_result = mysqli_query($con, $product_query_count);
$count_inactive_product = mysqli_num_rows($product_count_result);

if ($count_inactive_product > 0) {
  $count = $count_inactive_product > 0 ? $count_inactive_product : 0;
} else {
  $count = 0;
}



// for low stock alerts 
$product_low_stock = "
SELECT 
    p.id,
    p.name AS product_name, 
    c.name AS category_name, 
    sc.name AS subcategory_name, 
    p.price, 
    p.quantity, 
    p.product_status 
FROM 
    products p
JOIN 
    categories c ON p.category_id = c.id
JOIN 
    sub_categories sc ON p.sub_category_id = sc.id 
WHERE 
    p.quantity < 1
";

$product_low_stock_result = mysqli_query($con, $product_low_stock);
$count_low_Stock = mysqli_num_rows($product_low_stock_result);

if ($count_low_Stock > 0) {
  $count_ls = $count_low_Stock > 0 ? $count_low_Stock : 0;
} else {
  $count_ls = 0;
}



// for new subscription count 
$new_subscriptions_count_query = mysqli_query($con, "
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
        subscriptions.is_new = TRUE;
");
if(mysqli_num_rows($new_subscriptions_count_query)>0){
  $subscription_count = mysqli_num_rows($new_subscriptions_count_query); 
}
else{
  $subscription_count = "";
}


// SQL query to count orders with is_new = 1
$sql = "SELECT COUNT(*) as new_orders_count FROM orders WHERE is_new = 1";

$result_order = mysqli_query($con, $sql);

if ($result_order) {
    $row_result_order = mysqli_fetch_assoc($result_order);
   $count_order =  $row_result_order['new_orders_count'];
} else {
    $count_order = 0;
}

// mysqli_close($con);

?>


<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index.php" class="brand-link">
    <img src="../logos/Admin_logo.png" alt="AdminLTE Logo" class=" " style="opacity: .8" width="200px" height="auto">
    <span class="brand-text font-weight-light"></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="dist/img/AdminLTElogo.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php  echo $_SESSION['username']; ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <!-- Dashboard  -->
        <li class="nav-item has-treeview menu-open">
          <a href="index.php" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard

            </p>
          </a>

        </li>
        <!-- Manage users  -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-address-card"></i>
            <p>
              Manage users
              <i class="right fas fa-angle-left"></i>

            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-cart-arrow-down nav-icon"></i>
                <p>
                  Buyers
                  <i class="right fas fa-angle-left"></i>

                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="Add_buyer.php" class="nav-link">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>Add Buyer</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="Buyer_list.php" class="nav-link">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>Buyer list</p>
                  </a>
                </li>

              </ul>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-cart-plus nav-icon"></i>
                <p>
                  Sellers
                  <i class="right fas fa-angle-left"></i>

                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="Add_seller.php" class="nav-link">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>Add Seller</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="Seller_list.php" class="nav-link">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>Sellers list</p>
                  </a>
                </li>


              </ul>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-chalkboard-teacher nav-icon"></i>
                <p>
                  Admins
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="Add_admin.php" class="nav-link">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>Add Admin user</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="Admin_list.php" class="nav-link">
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>Admins list</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <!-- Manage Products  -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-shopping-cart"></i>
            <p>
              Manage Products

              <i class="right fas fa-angle-left"></i>

              <?php
              $sum = $count + $count_ls;

              if ($sum > 0) {

              ?>
                <span class="badge badge-info right"><?php echo $sum; ?> </span>


              <?php

              } else {
              }
              ?>



            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="Product_list.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Products list</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="Product_approvals.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Products Approvals</p>
                    <?php 
                    if($count>0){
                    ?>


                <span class="badge badge-info right"><?php echo $count ?></span>
                <?php  }else {

                } ?>
              </a>
            </li>
            <li class="nav-item">
              <a href="Low_stock_alert.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Low Stock Alerts</p>

                <?php 
                    if($count_ls>0){
                    ?>


                <span class="badge badge-info right"><?php echo $count_ls ?></span>
                <?php  }else {

                } ?>
           
              </a>
            </li>
          </ul>
        </li>
        <!-- Manage Orders  -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fab fa-cc-mastercard"></i>
            <p>
              Manage Orders
              <i class="fas fa-angle-left right"></i>
              <?php 
              if($count_order > 0){
                ?>
                    <span class="right badge badge-danger">New
                    </span>
                
                <?php
              }
              else{

              }
              
              ?>
          
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="New_order.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>New Orders</p>
                <?php   
                if($count_order> 0 ){
                ?>
                 <span class="right badge badge-danger"><?php echo $count_order  ?></span>
                
                <?php 
                     }
                     else{

                     }
                ?>
               
              </a>
            </li>
            <li class="nav-item">
              <a href="Orders_list.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Orders Lists</p>
              </a>
            </li>


          </ul>
        </li>
        <!-- Manage categories  -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon 	fa fa-server"></i>
            <p>
              Manage Categories
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
          <li class="nav-item">
              <a href="Add_category.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Category</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="Add_sub_category.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Sub Category</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="Categories_list.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Categories List</p>
              </a>
            </li>
          </ul>
        </li>
        <!-- Manage subscriptions  -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-money-check-alt"></i>
            <p>
              Manage subscriptions
              <i class="fas fa-angle-left right"></i>

                    <?php   
                    if(mysqli_num_rows($new_subscriptions_count_query)>0){
                    
                    
                    ?>
                    <span class="right badge badge-danger"><?php echo $subscription_count   ?></span>
                    
                    <?php 
                    
                    }
                    else{
                     
                    }
                    
                    ?>

              
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="Add_subscription.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Subscription</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="Subscriptions_list.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>View Subscriptions</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="New_subscriptions.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>New subscirptions
                <?php   
                    if(mysqli_num_rows($new_subscriptions_count_query)>0){
                    
                    
                    ?>
                    <span class="right badge badge-danger"><?php echo $subscription_count   ?></span>
                    
                    <?php 
                    
                    }
                    else{
                     
                    }
                    
                    ?>


                </p>
                
                
              </a>
            </li>
            <li class="nav-item">
              <a href="near_expiry_subscriptions.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Near expirey Subscriptions</p>
              </a>
            </li>
          </ul>
        </li>
        <!-- Manage Reviews  -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-comments"></i>
            <p>
              Manage Review
              <i class="fas fa-angle-left right"></i>
              <span class="right badge badge-danger">New</span>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="New_reviews.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>New Reviews</p>
                <span class="right badge badge-danger">New</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="Reviews_list.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Reviews List</p>
              </a>
            </li>

          </ul>
        </li>

            <!-- Manage blogs  -->
            <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-comments"></i>
            <p>
              Manage Blogs
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="Add_blogs.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Blogs</p></a>
            </li>
            <li class="nav-item">
              <a href="Blogs_list.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Blogs List</p>
              </a>
            </li>
           

          </ul>
        </li>


      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>