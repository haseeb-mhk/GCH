<?php
include('includes/Session.php');

// for selecting categories 
$query_select_categories = mysqli_query($con, "SELECT * from categories");


// for selecting the products LIMIT by 8
$query_select_products = mysqli_query($con, "SELECT 
  products.id,
  products.name,
  categories.name AS category_name,
  sub_categories.name AS sub_category_name,
  products.price,
  products.quantity,
  products.image1,
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
  products.product_status = 'active'
LIMIT 8;
");

// selecting blogs 
$query_blogs = mysqli_query($con, "SELECT 
    blogs.id,
    blogs.title,
    blogs.content,
    blogs.image,
    blogs.status,
    blogs.created_at,
    blogs.updated_at,
    CASE 
        WHEN users.role = 'seller' THEN sellers.business_name
        WHEN users.role = 'admin' THEN 'By admin'
        ELSE users.username
    END AS author_name
FROM 
    blogs
JOIN 
    users 
ON 
    blogs.user_id = users.id
LEFT JOIN 
    sellers 
ON 
    users.id = sellers.user_id
ORDER BY 
    blogs.created_at DESC LIMIT 3
");

if(isset($_POST['btnAddtocart'])){

// header("locataion:shop.php");



}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>GCH | Home</title>
  <link rel="icon" type="image/png" href="../logos/favicon.png" sizes="64X64">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/style2.css">

  <?php
  include("includes/Links.php")
  
  ?>

  <style>
    .image-container {
      width: 400px;
      height: 400px;
      overflow: hidden;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .square-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  </style>



</head>

<body>
  <!--================ Start Header Menu Area =================-->

  <?php
  include("includes/header.php");

  ?>

  <!-- <header class="header_area">
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
                <a href="shop.php" class="nav-link" >Shop</a>
                
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
              <li class="nav-item"><a class="button button-header" href="Buyersite/Login.php"><i class="ti-user"></i>&#9; Login</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </header> -->


  <!--================ End Header Menu Area =================-->

  <main class="site-main">

    <!--================ Hero banner start =================-->
    <section class="hero-banner">
      <div class="container">
        <div class="row no-gutters align-items-center pt-60px">
          <div class="col-5 d-none d-sm-block">
            <div class="hero-banner__img">
              <img class="img-fluid" src="img/home/hero-banner.png" alt="">
            </div>
          </div>
          <div class="col-sm-7 col-lg-6 offset-lg-1 pl-4 pl-md-5 pl-lg-0">
            <div class="hero-banner__content">
              <h4>Shopping is fun</h4>
              <h3>EXPLORE OUR UNIQUE <br> &nbsp;&nbsp;&nbsp;HANDMADE COLLECTIONS</h3>
              <p>Discover a world where artisans and small businesses bring their finest creations to life. From intricate designs to timeless treasures, our marketplace connects you with the beauty and authenticity of handmade crafts.
                Embrace the charm of unique finds, and support the artisans who pour their heart into every item. </p>
              <a class="button button-hero" href="shop.php">Shop Now</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <hr>
    <!--================ Hero banner start =================-->

    <!--================ Hero Carousel start =================-->
    <section class="section-margin mt-0">
      <div class="owl-carousel owl-theme hero-carousel">

        <?php
        while ($row_category = mysqli_fetch_assoc($query_select_categories)) {





        ?>


          <div class="hero-carousel__slide">
            <div class="image-container">
              <img src="../Sellersite/img/Categoriesimages/<?php echo $row_category['image']; ?>" alt="image not found" class="square-image">
            </div>
            <a href="shop.php?Cat_id=<?php echo $row_category['id']; ?>" class="hero-carousel__slideOverlay">
              <h3><?php echo $row_category['name']; ?></h3>
            </a>
          </div>

        <?php  }  ?>


      </div>
    </section>
    <!--================ Hero Carousel end =================-->

    <!-- ================ trending product section start ================= -->
    <section class="section-margin calc-60px">
      <div class="container">
        <div class="section-intro pb-60px">
          <p>Popular Item in the market</p>
          <h2>Top Pickups <span class="section-intro__style">Foryou</span></h2>
        </div>
        <div class="row">


          <?php while ($row_products = mysqli_fetch_assoc($query_select_products)) {  ?>
            <div class="col-md-6 col-lg-4 col-xl-3">
              <div class="card text-center card-product">
                <div class="card-product__img">
                  <img class="card-img" src="../Sellersite/img/productimages/<?php echo $row_products['image1']   ?>" alt="">
                  <ul class="card-product__imgOverlay">
                   
                    <li>
                    <a href="add_carts.php?PID=<?php echo $row_products['id']; ?>">
                    <button><i class="ti-shopping-cart"></i></button>
                </a>
                  </li>
                    <li><button ><i class="ti-heart"></i></button></li>
               
                  </ul>
                </div>
                <div class="card-body">
                  <p><?php echo $row_products['category_name']  ?></p>
                  <h4 class="card-product__title"><a href="Single_product.php?PID=<?php echo $row_products['id'];  ?>"><?php echo $row_products['name']  ?></a></h4>
                  <p class="card-product__price">RS. <?php echo $row_products['price']  ?></p>
                </div>
              </div>
            </div>
          <?php  }  ?>

        </div>
      </div>
    </section>
    <!-- ================ trending product section end ================= -->
    <hr>
    <!-- ================ New Arrival section start ================= -->
    <div class="container-new-arrival">

      <div class="newarival-img">
        <img src="./img/new_arrival.png">
      </div>
      <div class="offer__content text-center newarival-img">
        <h3>New Arrival!</h3>
        <h4>Woolen Shawl</h4>
        <p>A beautiful handmade Shawl with unique art</p>
        <a class="button button--active mt-3 mt-xl-4" href="shop.php">Shop Now</a>
      </div>




    </div>

    <!-- ================ New Arrival section start ================= -->


    <hr>
    <br><br>
    <!-- ================ Blog section start ================= -->
    <section class="blog">
      <div class="container">
        <div class="section-intro pb-60px">

          <h2>Latest <span class="section-intro__style">News</span></h2>
        </div>

        <div class="row">


        <?php while ($row_blog_query = mysqli_fetch_assoc($query_blogs)){  ?>
          <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
            <div class="card card-blog">
              <div class="card-blog__img">
                <img class="card-img rounded-0" src="../Admin/img/blogimages/<?php echo $row_blog_query['image']   ?>" alt="" width="100%" height="250px">
              </div>
              <div class="card-body">
                <ul class="card-blog__info">
                  <li><a href="#"><?php echo $row_blog_query['author_name']  ?></a></li>
                  <li><a href="#"><i class="ti-comments-smiley"></i> 2 Comments</a></li>
                </ul>
                <h4 class="card-blog__title"><a href="Single_Blog.php?BID=<?php echo $row_blog_query['id']  ?>"><?php echo $row_blog_query['title']  ?></a></h4>
               
               
                <a class="card-blog__link" href="Single_Blog.php?BID=<?php echo $row_blog_query['id']  ?>">Read More <i class="ti-arrow-right"></i></a>
              </div>
            </div>
          </div>
<?php }  ?>


        </div>
      </div>
    </section>
    <!-- ================ Blog section end ================= -->
    <hr>


    </div>
    </div>
    </div>


  </main>


  <!--================ Start footer Area  =================-->
  <?php include("includes/footer.php")
  ?>
  <!--================ End footer Area  =================-->



  <?php
  include("includes/jslinks.php")
  ?>
  <script src="js/main.js"></script>
</body>

</html>