
<?php 

$check_row_pending_products = mysqli_query($con,"SELECT p.*, c.name AS category_name, sc.name AS sub_category_name 
          FROM products p 
          JOIN categories c ON p.category_id = c.id 
          JOIN sub_categories sc ON p.sub_category_id = sc.id where seller_id =  '$seller_id' and product_status = 'inactive'");

$check_row_pending_products_numrows = mysqli_num_rows($check_row_pending_products);

?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <img src="../logos/AdminLogo_3.png" alt="Image Not found" width="200px" height="auto">
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="index.php?p_name=Welcome to Seller Store...!">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>


<hr class="sidebar-divider">


<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
        aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-fw fa-shopping-cart"></i>
        <span>Products</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">  Manage Products</h6>
            <a class="collapse-item" href="Add_product.php?p_name=Add Products to your Store"> <i class="fas fa-fw fa-plus"></i>Add Product</a>
            <a class="collapse-item" href="Product_list.php?p_name=Manage your products"> <i class="fas fa-fw fa-table"></i>Products List</a>
            <a class="collapse-item" href="Products_approvals.php?p_name= Approved Products List">
        <i class="fas fa-fw fa-thumbs-up"></i>
        <span>Approved Products</span></a>
        <a class="collapse-item" href="Pending_products.php?p_name= Pending Products List">
        <i class="	far fa-compass"></i>
       
        <span>Pending Products    <sup style="display: inline-block; background-color: red; color: white; border-radius: 50%; width: 1.5em; height: 1.5em; line-height: 1.5em; text-align: center;font-weight:bold"><?php echo $check_row_pending_products_numrows; ?></sup></span>

        </a>
        <a class="collapse-item" href="Low_stock_alert.php?p_name=Low stock Products List">
        <i class="	far fa-compass"></i>
       
        <span>Low Stock alert   </span>

        </a>
        </div>
    </div>
</li>
<li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-comments"></i>
                    <span>Blogs</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Manage Blogs:</h6>
                        <a class="collapse-item" href="Add_blogs.php">Add Blogs</a>
                        <a class="collapse-item" href="Blogs_list.php">Blogs List</a>
                       
                    </div>
                </div>
            </li>
<!-- Nav Item - Tables -->
<li class="nav-item">
    <a class="nav-link" href="Subscription.php?p_name=Check Your Subscription Details">
        <i class="fas fa-fw fa-bell"></i>
        <span>Subscription</span></a>
</li>

<li class="nav-item">
    <a class="nav-link" href="Contact_admin.php?p_name=Contact to Admin for any query">
        <i class="fas fa-fw fa-comments"></i>
        <span>Contact Admin</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>


</ul>