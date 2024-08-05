<?php
include('includes/Session.php');
if (isset($_GET['PID'])) {
	$product_id = $_GET['PID'];

	$query_select_products = mysqli_query($con, "SELECT 
products.id,
products.name,
categories.name AS category_name,
sub_categories.name AS sub_category_name,
products.description,
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
  products.id = $product_id;
");
	$row_query_selecy_product = mysqli_fetch_assoc($query_select_products);
}

// code for rating 
if (isset($_POST['btnSubmit'])) {
	$rating = $_POST['rating'];
	$comment = $_POST['comment'];
	$user_id = $_SESSION['user_id'];

	$insert_rating = mysqli_query($con, "INSERT into reviews (product_id, user_id, rating, comment)  VALUES('$product_id','$user_id','$rating','$comment') ");
	if ($insert_rating) {
		header('location:Single_product.php?PID=' . $product_id);
	}
}


// for adding product to cart 

if (isset($_POST['btnAddtocart'])) {
	$user_id = $_SESSION['user_id'];
	$query_select_buyer = mysqli_query($con, "Select * from buyers where user_id = '$user_id'");
	$query_select_buyer_row = mysqli_fetch_assoc($query_select_buyer);
	$buyer_id = $query_select_buyer_row['id'];
	$quantity = $_POST['qty'];
	// Check if a cart already exists for the buyer
	$cart_query = "SELECT id FROM carts WHERE buyer_id = $buyer_id ";
	$cart_result = mysqli_query($con, $cart_query);
	if (mysqli_num_rows($cart_result) > 0) {
		$row = mysqli_fetch_assoc($cart_result);
		$cart_id = $row['id'];
	} else {
		// If no cart exists, create a new one
		$create_cart_query = "INSERT INTO carts (buyer_id) VALUES ($buyer_id)";
		if (mysqli_query($con, $create_cart_query)) {
			$cart_id = mysqli_insert_id($con);
		} else {
			die("Error creating cart: " . mysqli_error($con));
		}
	}

	// Insert the product into the cart_item table
	$add_to_cart_query = "INSERT INTO cart_items (cart_id, product_id, quantity) VALUES ($cart_id, $product_id, $quantity)";
	if (mysqli_query($con, $add_to_cart_query)) {
		echo "Product added to cart successfully!";


		// Optionally, update the total price in the cart table
		$update_cart_query = "UPDATE carts
	SET total_price = (SELECT SUM(cart_items.quantity * products.price) 
					   FROM cart_items 
					   JOIN products ON cart_items.product_id = products.id 
					   WHERE cart_items.cart_id = $cart_id),
		updated_at = NOW()
	WHERE id = $cart_id";
		mysqli_query($con, $update_cart_query);
		// Update the quantity of the product in the products table
		$update_product_quantity_query = "UPDATE products 
 SET quantity = quantity - $quantity 
 WHERE id = $product_id";
		if (!mysqli_query($con, $update_product_quantity_query)) {
			die("Error updating product quantity: " . mysqli_error($con));
		}
		header('location:Cart.php');
	} else {
		die("Error adding product to cart: " . mysqli_error($con));
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
	<style>
		.star-rating {
			direction: rtl;
			display: inline-flex;
		}

		.star-rating input[type="radio"] {
			display: none;
		}

		.star-rating label {
			font-size: 2em;
			color: #ddd;
			cursor: pointer;
			margin: 0 0.1em;
		}

		.star-rating label:before {
			content: '★';
		}

		.star-rating input[type="radio"]:checked~label {
			color: gold;
		}

		.star-rating label:hover,
		.star-rating label:hover~label {
			color: gold;
		}
	</style>



</head>



<body>
	<!--================ Start Header Menu Area =================-->

	<?php include "includes/header.php" ?>


	<!--================ End Header Menu Area =================-->

	<main class="site-main">


		<!--================Single Product Area =================-->
		<div class="product_image_area">
			<div class="container">
				<div class="row s_product_inner">
					<div class="col-lg-6">
						<div class="owl-carousel owl-theme s_Product_carousel" style="">
							<div class="single-prd-item">
								<img class="img-fluid" src="../Sellersite/img/productimages/<?php echo $row_query_selecy_product['image1'] ?>" alt="">
							</div>
							<div class="single-prd-item">
								<img class="img-fluid" src="../Sellersite/img/productimages/<?php echo $row_query_selecy_product['image2'] ?>" alt="">
							</div>
							<div class="single-prd-item">
								<img class="img-fluid" src="../Sellersite/img/productimages/<?php echo $row_query_selecy_product['image3'] ?>" alt="">
							</div>
						</div>
					</div>
					<div class="col-lg-5 offset-lg-1">
						<div class="s_product_text">
							<h3><?php echo $row_query_selecy_product['name'];  ?></h3>
							<h2>RS. <?php echo $row_query_selecy_product['price'];  ?></h2>
							<ul class="list">
								<li><a class="active" href="#"><span>Category</span> : <?php echo $row_query_selecy_product['category_name'];  ?></a></li>
								<li><a href="#"><span>Availibility</span> : <?php

																			if ($row_query_selecy_product['quantity'] > 0) {
																				echo "In Stock";
																			} else {
																				echo " Not In Stock";
																			}

																			?></a></li>
							</ul>
							<p><?php echo $row_query_selecy_product['description']   ?></p>
							<form method="post">

								<div class="product_count">
									<label for="qty">Quantity:</label>
									<input type="text" name="qty" id="sst" size="2" maxlength="12" value="1" title="Quantity:" class="input-text qty">


								</div>


								<input type="submit" class="button primary-btn" name="btnAddtocart" value="Add to Cart">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--================End Single Product Area =================-->

		<!--================Product Description Area =================-->
		<section class="product_description_area">
			<div class="container">
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review" aria-selected="false">Reviews</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">

					<div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
						<div class="row">
							<div class="col-lg-6">

								<div class="review_list">


									<?php
									$query_reviews = "
							SELECT 
								reviews.rating, 
								reviews.comment, 
								reviews.review_date,  
								buyers.full_name, 
								buyers.photo 
							FROM 
								reviews 
							JOIN 
								users 
							ON 
								reviews.user_id = users.id 
							JOIN 
								buyers 
							ON 
								users.id = buyers.user_id 
							WHERE 
								reviews.product_id = '$product_id' 
							ORDER BY 
								reviews.review_date DESC
						";

									$result_reviews = mysqli_query($con, $query_reviews);
									while ($row_reviews = mysqli_fetch_assoc($result_reviews)) {
									?>
										<div class="review_item">
											<div class="media">
												<div class="d-flex">
													<img src="buyerimages/<?php echo $row_reviews['photo']  ?>" alt="" width="70px" height="71px" style="border-radius: 50%;">
												</div>
												<div class="media-body">
													<h4><?php echo $row_reviews['full_name']  ?></h4>
													<p><?php echo date('d-m-Y', strtotime($row_reviews['review_date'])); ?>
													</p>

													<?php
													$star_count = $row_reviews['rating'];
													for ($i = 1; $i <= $star_count; $i++) {  ?>

														<i class="fa fa-star"></i>
													<?php
													}

													?>



												</div>
											</div>
											<p><?php echo $row_reviews['comment']  ?></p>
										</div>
									<?php   } ?>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="review_box">


									<form class="form-contact form-review mt-3" method="post">

										<div class="form-group">
											<label for="rating">Give Rating:</label><br>
											<div class="star-rating">
												<input type="radio" id="star5" name="rating" value="5" required /><label for="star5" title="Excellent"></label>
												<input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="Good"></label>
												<input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="Okay"></label>
												<input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="Bad"></label>
												<input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="Very Bad"></label>
											</div>
										</div>



										<div class="form-group">
											<input class="form-control" name="name" type="text" placeholder="Enter your name" required>
										</div>
										<div class="form-group">
											<input class="form-control" name="email" type="email" placeholder="Enter email address" required>
										</div>

										<div class="form-group">
											<textarea class="form-control different-control w-100" name="comment" id="textarea" cols="30" rows="5" placeholder="Enter your Message"></textarea>
										</div>
										<div class="form-group text-center text-md-right mt-3">
											<button type="submit" class="button button--active button-review" name="btnSubmit">Submit Now</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--================End Product Description Area =================-->


	</main>


	<!--================ Start footer Area  =================-->
	<?php include("includes/footer.php")  ?>
	<!--================ End footer Area  =================-->


	<?php include("includes/jslinks.php")  ?>
</body>

</html>