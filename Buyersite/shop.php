<?php
include('includes/Session.php');


// Fetching products 
if (isset($_GET['Cat_id'])) {
  $cat_id = $_GET['Cat_id'];
  $query_select_products = mysqli_query($con, "SELECT 
  products.id,
  products.name,
  categories.name AS category_name,
  sub_categories.name AS sub_category_name,
  products.price,
  products.quantity,
  products.image1,
  products.image2,
  products.image3,
  products.product_status
  
FROM 
  products
JOIN 
  categories 
ON 
  products.category_id = categories.id
JOIN 
  sub_categories 
ON 
  products.sub_category_id = sub_categories.id
WHERE 
  products.product_status = 'active' AND category_id = '$cat_id'
");
} else if (isset($_GET['sub_Cat_id'])) {
  $sub_cat_id = $_GET['sub_Cat_id'];

  $query_select_products = mysqli_query($con, "SELECT 
  products.id,
  products.name,
  categories.name AS category_name,
  sub_categories.name AS sub_category_name,
  products.price,
  products.quantity,
  products.image1,
  products.image2,
  products.image3,
  products.product_status
  
FROM 
  products
JOIN 
  categories 
ON 
  products.category_id = categories.id
JOIN 
  sub_categories 
ON 
  products.sub_category_id = sub_categories.id
WHERE 
  products.product_status = 'active' AND sub_category_id = '$sub_cat_id'");
} else {


  $query_select_products = mysqli_query($con, "SELECT 
  products.id,
  products.name,
  categories.name AS category_name,
  sub_categories.name AS sub_category_name,
  products.price,
  products.quantity,
  products.image1,
  products.image2,
  products.image3,
  products.product_status
  
FROM 
  products
JOIN 
  categories 
ON 
  products.category_id = categories.id
JOIN 
  sub_categories 
ON 
  products.sub_category_id = sub_categories.id
WHERE 
  products.product_status = 'active';
");
}


// fetching all categories 

$query_select_categories = mysqli_query($con, "SELECT * from categories");







?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>GCH | Shop</title>
  <link rel="icon" type="image/png" href="../logos/favicon.png" sizes="64X64">
  <?php include "includes/Links.php" ?>


</head>

<body>
  <!--================ Start Header Menu Area =================-->

  <?php include "includes/header.php" ?>


  <!--================ End Header Menu Area =================-->

  <main class="site-main">


    <!-- ================ start banner area ================= -->
    <section class="blog-banner-area" id="category">
      <div class="container h-80">
        <div class="blog-banner">
          <div class="text-center">
            <h1>Shop </h1>
            <nav aria-label="breadcrumb" class="banner-breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shop </li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </section>
    <!-- ================ end banner area ================= -->

    <!-- ================ category section start ================= -->
    <section class="section-margin--small mb-5">
      <div class="container">
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12">

            <div class="sidebar-categories">
              <div class="head">Browse Categories</div>
              <ul class="main-categories list-unstyled" style="display: flex;">


                <?php
                while ($row_Category = mysqli_fetch_assoc($query_select_categories)) {




                ?>
                  <li class="">
                    <div class="dropdown">
                      <a href="Shop.php?Cat_id=<?php echo $row_Category['id'];  ?>" type="button" class="btn" style="color: black;">

                        <?php echo $row_Category['name'];  ?></a>

                      <button type="button" class="btn  dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="babyDropdown">
                        <?php
                        $category_id = $row_Category['id'];
                        $select_sub_Categories = mysqli_query($con, "select * from sub_categories where parent_category_id = '$category_id'");
                        while ($row_sub_Category =  mysqli_fetch_assoc($select_sub_Categories)) {



                        ?>
                          <a class="dropdown-item" href="Shop.php?sub_Cat_id=<?php echo $row_sub_Category['id'];  ?>"> <?php echo $row_sub_Category['name']   ?></a>
                        <?php  } ?>
                      </div>
                    </div>
                  </li>


                <?php  } ?>
                <li class="common-filter">
                  <div class="dropdown" style="margin-left: 20px;margin-top: -10px;">
                    <div class="input-group filter-bar-search">
                      <input type="text" placeholder="Search">
                      <div class="input-group-append">
                        <button type="button"><i class="ti-search"></i></button>
                      </div>
                    </div>
                  </div>
                </li>

              </ul>
            </div>




          </div>


        </div>

        <div class="row">

          <div class="">
            <!-- Start Filter Bar -->

            <!-- End Filter Bar -->
            <!-- Start Best Seller -->
            <section class="lattest-product-area pb-40 category-list">
              <div class="row">

                <?php

                while ($row_query_select_product = mysqli_fetch_assoc($query_select_products)) {

                ?>

                  <div class="col-md-6 col-lg-3">
                    <div class="card text-center card-product">
                      <div class="card-product__img" style="min-width: 100%; min-height: 100%; max-width: 100%; max-height: 100%;">
                        <img class="card-img" src="../Sellersite/img/productimages/<?php echo $row_query_select_product['image1']; ?>" style="width: 100%; height: auto;" alt="">
                        <ul class="card-product__imgOverlay">
                          <li>
                            <a href="add_carts.php?PID=<?php echo $row_query_select_product['id']; ?>">
                              <button><i class="ti-shopping-cart"></i></button>
                            </a>
                          </li>
                          <li><button><i class="ti-heart"></i></button></li>
                        </ul>
                      </div>
                      <div class="card-body">
                        <p><?php echo $row_query_select_product['category_name']; ?></p>
                        <h4 class="card-product__title"><a href="Single_product.php?PID=<?php echo $row_query_select_product['id']  ?>"><?php echo $row_query_select_product['name']; ?></a></h4>
                        <p class="card-product__price">RS. <?php echo $row_query_select_product['price']; ?></p>
                      </div>
                    </div>
                  </div>


                <?php    } ?>




              </div>
            </section>
            <!-- End Best Seller -->
          </div>
        </div>
      </div>
    </section>
    <!-- ================ category section end ================= -->





  </main>


  <!--================ Start footer Area  =================-->
  <?php include("includes/footer.php")  ?>
  <!--================ End footer Area  =================-->


  <?php include("includes/jslinks.php")  ?>
</body>

</html>