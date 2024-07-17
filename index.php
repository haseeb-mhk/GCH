<?php
session_start();

include('includes/Connection.php');
$top_message = "";
$authentication_msg = "";
if (isset($_GET['redirect']) && $_GET['redirect'] == 'Registration') {
	$top_message = "Your Account was Registered Successfully...!";
} else {
	$top_message = "Login to your Account";
}



if (isset($_POST['btnLogin'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];


	$username = mysqli_real_escape_string($con, $username);
	$password = mysqli_real_escape_string($con, $password);


	$query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
	$result = mysqli_query($con, $query);

	if (mysqli_num_rows($result) > 0) {
		$user = mysqli_fetch_assoc($result);


		$_SESSION['user_id'] = $user['id'];
		$_SESSION['username'] = $user['username'];
		$_SESSION['role'] = $user['role'];

		$user_id = $user['id'];
		$role = $user['role'];

		if ($role == 'buyer') {
			$status_query = "SELECT account_status FROM buyers WHERE user_id = '$user_id'";
		} elseif ($role == 'seller') {
			$status_query = "SELECT account_status FROM sellers WHERE user_id = '$user_id'";
		} elseif ($role == 'admin') {
			$status_query = "SELECT account_status FROM admins WHERE user_id = '$user_id'";
		}

		$status_result = mysqli_query($con, $status_query);

		if (mysqli_num_rows($status_result) > 0) {
			$status_row = mysqli_fetch_assoc($status_result);
			$account_status = $status_row['account_status'];

			if ($account_status == 'active') {

				if ($role == 'buyer') {
					// echo("Welcome to our site");
					header('Location:Buyersite/index.php');
				} elseif ($role == 'seller') {
					// echo("Welcome to Seller Dashboard");
					header('Location: sellersite/index.php');
				} elseif ($role == 'admin') {
					// echo("Welcome to admin panel");
					header('Location: Admin/index.php');
				}
				exit();
			} else {
				$authentication_msg = "Your account is not active. Please contact support.";
			}
		} else {
			$authentication_msg = "Account status not found.";
		}
	} else {
		$authentication_msg = "Invalid username or password.";
	}
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>GCH | Home</title>
  <link rel="stylesheet" href="Buyersite/vendors/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="Buyersite/vendors/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="Buyersite/vendors/themify-icons/themify-icons.css">
	<link rel="stylesheet" href="Buyersite/vendors/linericon/style.css">
  <link rel="stylesheet" href="Buyersite/vendors/owl-carousel/owl.theme.default.min.css">
  <link rel="stylesheet" href="Buyersite/vendors/owl-carousel/owl.carousel.min.css">
  <link rel="stylesheet" href="Buyersite/vendors/nice-select/nice-select.css">
  <link rel="stylesheet" href="Buyersite/vendors/nouislider/nouislider.min.css">

  <link rel="stylesheet" href="Buyersite/css/style.css">
  <link rel="stylesheet" href="Buyersite/css/style2.css">
  <?php 
//   include ("Buyersite/includes/Links.php")
   ?>
  <style>
    /* CSS for the popup */

    #loginModal .modal-dialog {
      max-width: 70%;
      z-index: 10000000;
    }
  </style>


</head>

<body>
  <!--================ Start Header Menu Area =================-->

  <header class="header_area">
    <div class="main_menu">
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
          <a class="navbar-brand logo_h" href="index.php"><img src="Buyersite/img/GCH_logo_2.jpg" alt=""></a>
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
                <a href="Buyersite/shop.php" class="nav-link" >Shop</a>
                
							</li>
              <li class="nav-item ">
                <a href="Buyersite/Blogs.php" class="nav-link">Blog</a>
               
							</li>
							<li class="nav-item ">
                <a href="Buyersite/About.php" class="nav-link " >About Us</a>
                
              </li>
              <li class="nav-item"><a class="nav-link" href="Buyersite/Contact.php">Contact Us</a></li>
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
  </header>


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
        <div class="hero-carousel__slide">
          <img src="img/home/hero-slide1.png" alt="" class="img-fluid">
          <a href="shop.php" class="hero-carousel__slideOverlay">
            <h3>Fashion and Apparel</h3>
            <p>Cloth, Shawls, Purse....</p>
          </a>
        </div>
        <div class="hero-carousel__slide">
          <img src="img/home/hero-slide2.png" alt="" class="img-fluid">
          <a href="shop.php" class="hero-carousel__slideOverlay">
            <h3>Babies and Kids</h3>
            <p>Toys, Blankets, Clothing....</p>
          </a>
        </div>
        <div class="hero-carousel__slide">
          <img src="img/home/hero-slide3.png" alt="" class="img-fluid">
          <a href="shop.php" class="hero-carousel__slideOverlay">
            <h3>Furnitures</h3>
            <p>Beds, Tables, Cupboards....</p>
          </a>
        </div>
      </div>
    </section>
    <!--================ Hero Carousel end =================-->

    <!-- ================ trending product section start ================= -->
    <section class="section-margin calc-60px">
      <div class="container">
        <div class="section-intro pb-60px">
          <p>Popular Item in the market</p>
          <h2>Trending <span class="section-intro__style">Product</span></h2>
        </div>
        <div class="row">
          <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card text-center card-product">
              <div class="card-product__img">
                <img class="card-img" src="img/product/product1.png" alt="">
                <ul class="card-product__imgOverlay">
                  <li><button><i class="ti-search"></i></button></li>
                  <li><button><i class="ti-shopping-cart"></i></button></li>
                  <li><button><i class="ti-heart"></i></button></li>
                </ul>
              </div>
              <div class="card-body">
                <p>Accessories</p>
                <h4 class="card-product__title"><a href="single-product.html">Quartz Belt Watch</a></h4>
                <p class="card-product__price">$150.00</p>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card text-center card-product">
              <div class="card-product__img">
                <img class="card-img" src="img/product/product2.png" alt="">
                <ul class="card-product__imgOverlay">
                  <li><button><i class="ti-search"></i></button></li>
                  <li><button><i class="ti-shopping-cart"></i></button></li>
                  <li><button><i class="ti-heart"></i></button></li>
                </ul>
              </div>
              <div class="card-body">
                <p>Beauty</p>
                <h4 class="card-product__title"><a href="single-product.html">Women Freshwash</a></h4>
                <p class="card-product__price">$150.00</p>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card text-center card-product">
              <div class="card-product__img">
                <img class="card-img" src="img/product/product3.png" alt="">
                <ul class="card-product__imgOverlay">
                  <li><button><i class="ti-search"></i></button></li>
                  <li><button><i class="ti-shopping-cart"></i></button></li>
                  <li><button><i class="ti-heart"></i></button></li>
                </ul>
              </div>
              <div class="card-body">
                <p>Decor</p>
                <h4 class="card-product__title"><a href="single-product.html">Room Flash Light</a></h4>
                <p class="card-product__price">$150.00</p>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card text-center card-product">
              <div class="card-product__img">
                <img class="card-img" src="img/product/product4.png" alt="">
                <ul class="card-product__imgOverlay">
                  <li><button><i class="ti-search"></i></button></li>
                  <li><button><i class="ti-shopping-cart"></i></button></li>
                  <li><button><i class="ti-heart"></i></button></li>
                </ul>
              </div>
              <div class="card-body">
                <p>Decor</p>
                <h4 class="card-product__title"><a href="single-product.html">Room Flash Light</a></h4>
                <p class="card-product__price">$150.00</p>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card text-center card-product">
              <div class="card-product__img">
                <img class="card-img" src="img/product/product5.png" alt="">
                <ul class="card-product__imgOverlay">
                  <li><button><i class="ti-search"></i></button></li>
                  <li><button><i class="ti-shopping-cart"></i></button></li>
                  <li><button><i class="ti-heart"></i></button></li>
                </ul>
              </div>
              <div class="card-body">
                <p>Accessories</p>
                <h4 class="card-product__title"><a href="single-product.html">Man Office Bag</a></h4>
                <p class="card-product__price">$150.00</p>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card text-center card-product">
              <div class="card-product__img">
                <img class="card-img" src="img/product/product6.png" alt="">
                <ul class="card-product__imgOverlay">
                  <li><button><i class="ti-search"></i></button></li>
                  <li><button><i class="ti-shopping-cart"></i></button></li>
                  <li><button><i class="ti-heart"></i></button></li>
                </ul>
              </div>
              <div class="card-body">
                <p>Kids Toy</p>
                <h4 class="card-product__title"><a href="single-product.html">Charging Car</a></h4>
                <p class="card-product__price">$150.00</p>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card text-center card-product">
              <div class="card-product__img">
                <img class="card-img" src="img/product/product7.png" alt="">
                <ul class="card-product__imgOverlay">
                  <li><button><i class="ti-search"></i></button></li>
                  <li><button><i class="ti-shopping-cart"></i></button></li>
                  <li><button><i class="ti-heart"></i></button></li>
                </ul>
              </div>
              <div class="card-body">
                <p>Accessories</p>
                <h4 class="card-product__title"><a href="single-product.html">Blutooth Speaker</a></h4>
                <p class="card-product__price">$150.00</p>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card text-center card-product">
              <div class="card-product__img">
                <img class="card-img" src="img/product/product8.png" alt="">
                <ul class="card-product__imgOverlay">
                  <li><button><i class="ti-search"></i></button></li>
                  <li><button><i class="ti-shopping-cart"></i></button></li>
                  <li><button><i class="ti-heart"></i></button></li>
                </ul>
              </div>
              <div class="card-body">
                <p>Kids Toy</p>
                <h4 class="card-product__title"><a href="#">Charging Car</a></h4>
                <p class="card-product__price">$150.00</p>
              </div>
            </div>
          </div>
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
        <a class="button button--active mt-3 mt-xl-4" href="#">Shop Now</a>
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
          <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
            <div class="card card-blog">
              <div class="card-blog__img">
                <img class="card-img rounded-0" src="img/blog/blog1.png" alt="">
              </div>
              <div class="card-body">
                <ul class="card-blog__info">
                  <li><a href="#">By Admin</a></li>

                </ul>
                <h4 class="card-blog__title"><a href="single-blog.html">The Richland Center Shooping News and weekly shooper</a></h4>
                <p>Let one fifth i bring fly to divided face for bearing divide unto seed. Winged divided light Forth.</p>
                <a class="card-blog__link" href="#">Read More <i class="ti-arrow-right"></i></a>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
            <div class="card card-blog">
              <div class="card-blog__img">
                <img class="card-img rounded-0" src="img/blog/blog2.png" alt="">
              </div>
              <div class="card-body">
                <ul class="card-blog__info">
                  <li><a href="#">By Admin</a></li>
                  <li><a href="#"><i class="ti-comments-smiley"></i> 2 Comments</a></li>
                </ul>
                <h4 class="card-blog__title"><a href="single-blog.html">The Shopping News also offers top-quality printing services</a></h4>
                <p>Let one fifth i bring fly to divided face for bearing divide unto seed. Winged divided light Forth.</p>
                <a class="card-blog__link" href="#">Read More <i class="ti-arrow-right"></i></a>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
            <div class="card card-blog">
              <div class="card-blog__img">
                <img class="card-img rounded-0" src="img/blog/blog3.png" alt="">
              </div>
              <div class="card-body">
                <ul class="card-blog__info">
                  <li><a href="#">By Admin</a></li>
                  <li><a href="#"><i class="ti-comments-smiley"></i> 2 Comments</a></li>
                </ul>
                <h4 class="card-blog__title"><a href="single-blog.html">Professional design staff and efficient equipment you’ll find we offer</a></h4>
                <p>Let one fifth i bring fly to divided face for bearing divide unto seed. Winged divided light Forth.</p>
                <a class="card-blog__link" href="#">Read More <i class="ti-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ================ Blog section end ================= -->
    <hr>


    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="false">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
       	<!--================Login Box Area =================-->
		<section class="login_box_area section-margin">
			<div class="container">
				<div class="row">

					<div class="col-12">

						<h2 align="center"><?php echo ($top_message);  ?></h2>

					</div>

				</div>

				<hr>

				<div class="row">
					<div class="col-lg-6">
						<div class="login_box_img">
							<div class="hover">
								<h4>New to our website?</h4>
								<p>There are advances being made in science and technology everyday, and a good example of this is the</p>
								<a class="button button-account" href="Buyersite/Registration.php">Create an Account</a>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="login_form_inner">
							<h3>Log in to enter</h3>
              <span style="color: red;"><?php echo($authentication_msg) ?></span>
							<form class="row login_form" method="post" id="contactForm">
								<div class="col-md-12 form-group">
									<input type="text" class="form-control" id="username" name="username" placeholder="Username" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'">
								</div>
								<div class="col-md-12 form-group">
									<input type="password" class="form-control" id="password" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
								</div>
								<div class="col-md-12 form-group">
									
								</div>
								<div class="col-md-12 form-group">
									<button type="submit" value="submit" class="button button-login w-100" name="btnLogin">Log In</button>
									<a href="#">Forgot Password?</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--================End Login Box Area =================-->


        </div>
      </div>
    </div>


  </main>


  <!--================ Start footer Area  =================-->
  <?php include("Buyersite/includes/footer.php") 
   ?>
  <!--================ End footer Area  =================-->



  <?php
//    include("Buyersite/includes/jslinks.php")  
  ?>
  
<script src="Buyersite/vendors/jquery/jquery-3.2.1.min.js"></script>
  <script src="Buyersite/vendors/bootstrap/bootstrap.bundle.min.js"></script>
  <script src="Buyersite/vendors/skrollr.min.js"></script>
  <script src="Buyersite/vendors/owl-carousel/owl.carousel.min.js"></script>
  <script src="Buyersite/vendors/nice-select/jquery.nice-select.min.js"></script>
  <script src="Buyersite/vendors/jquery.ajaxchimp.min.js"></script>
  <script src="Buyersite/vendors/nouislider/nouislider.min.js"></script>
  <script src="Buyersite/vendors/mail-script.js"></script>
  <script src="Buyersite/js/main.js"></script>
  <script>
    $(document).ready(function() {
      // Show the modal after a delay (e.g., 10 seconds)
      setTimeout(function() {
        $('#loginModal').modal('show');
      }, 10000); // 10000 milliseconds = 10 seconds

      // Optional: Close modal logic
      $('#loginModal .close').on('click', function() {
        $('#loginModal').modal('hide');
      });
    });
  </script>
</body>

</html>