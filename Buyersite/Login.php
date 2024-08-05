<?php
session_start();

include('../includes/Connection.php');
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
					header('Location:index.php');
				} elseif ($role == 'seller') {
					// echo("Welcome to Seller Dashboard");
					header('Location: ../sellersite/index.php');
				} elseif ($role == 'admin') {
					// echo("Welcome to admin panel");
					header('Location: ../Admin/index.php');
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
	<title>GCH | Shop</title>
	<link rel="icon" type="image/png" href="../logos/favicon.png" sizes="64X64">
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
								<a class="button button-account" href="Registration.php">Create an Account</a>
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


	</main>

	<!--================ Start footer Area  =================-->

	<!--================ End footer Area  =================-->


	<?php include("includes/jslinks.php")  ?>
</body>

</html>