<?php
include('includes/Session.php');


if (isset($_POST['btnSend'])) {
$email = $_POST['email'];
  $query = $_POST['message'];
  $user_id  = $_SESSION['user_id'];
  $query_for_username = mysqli_query($con, "SELECT * FROM users WHERE id = '$user_id'");
  $row_query_for_username = mysqli_fetch_row($query_for_username);
  if ($row_query_for_username) {
      $username = $row_query_for_username[1];
      $insert_query = mysqli_query($con, "INSERT INTO `contact`( `user_id`, `name`, `email`, `message`) VALUES ('$user_id','$username','$email','$query')");
      if($insert_query){
         echo "<script>alert('Your message has been send successfully.')</script>";
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
  <title>GCH | Contact Us</title>
  <?php include "includes/Links.php" ?>
</head>
<body>
  <!--================ Start Header Menu Area =================-->
	
   <?php include "includes/header.php" ?>
  
  
	<!--================ End Header Menu Area =================-->

  <main class="site-main">

	<!-- ================ start banner area ================= -->
	<section class="blog-banner-area" id="contact">
		<div class="container h-100">
			<div class="blog-banner">
				<div class="text-center">
					<h1>Contact Us</h1>
					<nav aria-label="breadcrumb" class="banner-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
            </ol>
          </nav>
				</div>
			</div>
    </div>
	</section>
	<!-- ================ end banner area ================= -->

	<!-- ================ contact section start ================= -->
  <section class="section-margin--small">
    <div class="container">
   
     	  <div class="row">
            <div class="col-12">

            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3274.1461365838095!2d72.4397125!3d34.8525552!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38dc22ebd0d7e8fb%3A0xa2dfaf0f3167971d!2sUniversity%20of%20Swat!5e0!3m2!1sen!2s!4v1706199399522!5m2!1sen!2s" width="100%" height="500px" style="border:0;padding: 10px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
			

            </div>


        </div>
				<br>
				<br>
				<br>
				<br>

      <div class="row">
        <div class="col-md-4 col-lg-3 mb-4 mb-md-0">
          <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-home"></i></span>
            <div class="media-body">
              <h3>University of Swat</h3>
              <p>Charbagh Swat, Pakistan</p>
            </div>
          </div>
          <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-headphone"></i></span>
            <div class="media-body">
              <h3><a href="tel:454545654"> (+92) 349 3717259</a></h3>
              <p>Mon to Fri 9am to 6pm</p>
            </div>
          </div>
          <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-email"></i></span>
            <div class="media-body">
              <h3><a href="mailto:support@colorlib.com">gch@gmail.com</a></h3>
              <p>Send us your query anytime!</p>
            </div>
          </div>
        </div>
        <div class="col-md-8 col-lg-9">
          <form  class="form-contact contact_form"  method="post" id="contactForm" novalidate="novalidate">
            <div class="row">
              <div class="col-lg-5">
                <div class="form-group">
                  <input class="form-control" name="name" id="name" type="text" placeholder="Enter your name">
                </div>
                <div class="form-group">
                  <input class="form-control" name="email" id="email" type="email" placeholder="Enter email address">
                </div>
                
              </div>
              <div class="col-lg-7">
                <div class="form-group">
                    <textarea class="form-control different-control w-100" name="message" id="message" cols="30" rows="5" placeholder="Enter Message"></textarea>
                </div>
              </div>
            </div>
            <div class="form-group text-center text-md-right mt-3">
              <button type="submit" class="button button--active button-contactForm" name="btnSend">Send Message</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
	<!-- ================ contact section end ================= -->
  

    

  </main>


  <!--================ Start footer Area  =================-->	
               <?php include("includes/footer.php")  ?> 
	<!--================ End footer Area  =================-->


    <?php include("includes/jslinks.php")  ?>
</body>
</html>