<?php  
include('includes/Session.php');

if(isset($_GET['PID'])){

    $user_id = $_SESSION['user_id'];
	$query_select_buyer = mysqli_query($con, "Select * from buyers where user_id = '$user_id'");
	$query_select_buyer_row = mysqli_fetch_assoc($query_select_buyer);
	$buyer_id = $query_select_buyer_row['id'];
	$quantity = 1;
    $product_id = $_GET['PID'];
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