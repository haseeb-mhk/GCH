<?php
include('includes/Session.php');
require('includes/config.php');
// require 'vendor/autoload.php'; // Include the Stripe PHP library

// \Stripe\Stripe::setApiKey(''); // Replace with your actual secret key

// Get the payment token and amount from the form submission
$fullName = $_POST['name'];
$email = $_POST['email'];
$phoneNumber = $_POST['number'];
$address = $_POST['address'];
$shippingAddress = $_POST['shipping_address'];
$orderNotes = $_POST['message'];
$token = $_POST['stripeToken'];
// echo $fullName;
$amount = $_POST['amount'] * 100; 
try {
    $charge = \Stripe\Charge::create([
        "amount" => $amount, // Amount in cents
        "currency" => "pkr",
        "description" => "Testing payment transaction",
        "source" => $token,
    ]);

    // // Extract information from the charge object
    $chargeId = $charge->id;
    $amountPaid = $charge->amount / 100; // Convert back to original currency units
    $paymentStatus = $charge->status;
    echo $paymentStatus;

    // // Assume you have these variables from the checkout process
    $userId = $_SESSION['user_id']; // User ID from session
    $query_select_buyer = mysqli_query($con, "SELECT * FROM buyers WHERE user_id = '$user_id'");
    $query_select_buyer_row = mysqli_fetch_assoc($query_select_buyer);
    $buyer_id = $query_select_buyer_row['id'];
    $orderDate = date("Y-m-d H:i:s");
    // // $shippingMethodId = $_POST['shipping_method_id']; // From form input
    // // $shippingAddress = $_POST['shipping_address']; // From form input

    // // Insert order details into the orders table
    $orderQuery = "INSERT INTO orders (buyer_id, order_date, total_amount,payment_status )
                    VALUES ('$buyer_id', '$orderDate', '$amountPaid', '$paymentStatus' )";
    $insertOrder = mysqli_query($con, $orderQuery);


    if ($insertOrder) {
        // Get the last inserted order ID
        $orderId = mysqli_insert_id($con);
        $insert_billing_details = mysqli_query($con, "INSERT INTO `billing_details`( `order_id`, `full_name`, `email`, `phone_no`, `address`, `shipping_address`, `order_notes`) 
        VALUES ('$orderId','$fullName','$email','$phoneNumber','$address','$shippingAddress','$orderNotes')");

        $cartAndItemsQuery = "
        SELECT 
            carts.id AS cart_id,
            carts.buyer_id,
            cart_items.id AS cart_item_id,
            cart_items.product_id,
            cart_items.quantity,
            products.price
            FROM 
            carts
        JOIN 
            cart_items ON carts.id = cart_items.cart_id
        JOIN 
            products ON cart_items.product_id = products.id
        WHERE 
            carts.buyer_id = '$buyer_id'
    ";

        $cartAndItemsResult = mysqli_query($con, $cartAndItemsQuery);
        $cart_id = "";

        // Insert each cart item as an order item
        while ($cartItem = mysqli_fetch_assoc($cartAndItemsResult)) {
            $productId = $cartItem['product_id'];
            $quantity = $cartItem['quantity'];
            $price = $cartItem['price'];
            $cart_id = $cartItem['cart_id'];

            $orderItemQuery = "INSERT INTO order_items (order_id, product_id, quantity, price)
                               VALUES ('$orderId', '$productId', '$quantity', '$price')";
            mysqli_query($con, $orderItemQuery);
        }
       
        // Clear the cart for the user after order placement
        $clearCartQuery =    mysqli_query($con,"DELETE FROM cart_items WHERE cart_id = '$cart_id'");
        if($clearCartQuery){
            echo ("Carts are clear successfully");
        }else{
            echo mysqli_errno($con);
        }

        // echo "Order has been successfully processed.";
        // Optionally, redirect to a confirmation page
        header("Location: confirmation.php?OID=".$orderId."&PS=".$paymentStatus);
        exit();
    } else {
        echo "Failed to store order details in the database.";
    }
} catch (\Stripe\Exception\CardException $e) {
    // Display error message if card is declined
    echo 'Error: ' . $e->getError()->message;
}
