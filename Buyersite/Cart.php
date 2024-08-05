<?php
include('includes/Session.php');

$user_id = $_SESSION['user_id'];

// Fetch buyer ID
$query_select_buyer = mysqli_query($con, "SELECT * FROM buyers WHERE user_id = '$user_id'");
$query_select_buyer_row = mysqli_fetch_assoc($query_select_buyer);
$buyer_id = $query_select_buyer_row['id'];

// Fetch cart items
$query_cart_items = "
    SELECT 
        cart_items.id AS cart_item_id,
        cart_items.cart_id AS cart_id,
        products.id AS product_id,
        products.name AS product_name,
        products.price AS product_price,
        products.image1 AS product_image,
        cart_items.quantity AS product_quantity
    FROM 
        cart_items
    JOIN 
        carts ON cart_items.cart_id = carts.id
    JOIN 
        products ON cart_items.product_id = products.id
    WHERE 
        carts.buyer_id = '$buyer_id'
";
$result_cart_items = mysqli_query($con, $query_cart_items);

$total_price = 0;




// deleteing the cart Item


if (isset($_POST['btndelete'])) {
    $cart_item_id = $_POST['cart_item_id'];
    $cart_id = $_POST['cart_id'];
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['product_quantity'];
    $total_item_price = $product_price * $product_quantity;

    // Fetch the product ID associated with the cart item
    $product_query = mysqli_query($con, "SELECT product_id FROM cart_items WHERE id = '$cart_item_id'");
    $product_row = mysqli_fetch_assoc($product_query);
    $product_id = $product_row['product_id'];

    // Delete the cart item
    $delete_query = "DELETE FROM cart_items WHERE id = '$cart_item_id'";
    if (mysqli_query($con, $delete_query)) {
        // Update the cart's total price
        $update_cart_query = "
            UPDATE carts 
            SET 
                total_price = total_price - $total_item_price, 
                updated_at = NOW() 
            WHERE id = '$cart_id'
        ";
        mysqli_query($con, $update_cart_query);

        // Update the product's quantity in the products table
        $update_product_quantity_query = "
            UPDATE products 
            SET quantity = quantity + $product_quantity 
            WHERE id = '$product_id'
        ";
        mysqli_query($con, $update_product_quantity_query);

        // Refresh the page to reflect the changes
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        die("Error deleting cart item: " . mysqli_error($con));
    }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GCH | Carts</title>
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
            <div class="container h-100">
                <div class="blog-banner">
                    <div class="text-center">
                        <h1>Shopping Cart</h1>
                        <nav aria-label="breadcrumb" class="banner-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!-- ================ end banner area ================= -->



        <!--================Cart Area =================-->

       
        <section class="cart_area">
            <div class="container">
                <div class="cart_inner">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row_cart_item = mysqli_fetch_assoc($result_cart_items)) : ?>
                                    <tr>
                                        <td>
                                            <div class="media">
                                                <div class="d-flex">
                                                    <img src="../Sellersite/img/productimages/<?php echo $row_cart_item['product_image']; ?>" alt="" width="100px" height="100px">
                                                </div>
                                                <div class="media-body">
                                                    <p><?php echo $row_cart_item['product_name']; ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <h5>RS. <?php echo number_format($row_cart_item['product_price'], 2); ?></h5>
                                        </td>
                                        <td>
                                            <div class="product_count">
                                                <h5><?php echo $row_cart_item['product_quantity']; ?></h5>
                                            </div>
                                        </td>
                                        <td>
                                            <h5>RS. <?php echo number_format($row_cart_item['product_price'] * $row_cart_item['product_quantity'], 2); ?></h5>
                                        </td>
                                        <td>
                                            <form method="post">
                                                <input type="hidden" name="cart_item_id" value="<?php echo $row_cart_item['cart_item_id']; ?>">
                                                <input type="hidden" name="cart_id" value="<?php echo $row_cart_item['cart_id']; ?>">
                                                <input type="hidden" name="product_price" value="<?php echo $row_cart_item['product_price']; ?>">
                                                <input type="hidden" name="product_quantity" value="<?php echo $row_cart_item['product_quantity']; ?>">
                                                <input type="submit" class="btn btn-danger btn-sm" value="X" name="btndelete" onclick="return confirm('Are you sure you want to delete this item?');">
                                            </form>
                                        </td>
                                    </tr>
                                    <?php $total_price += $row_cart_item['product_price'] * $row_cart_item['product_quantity']; ?>
                                <?php endwhile; ?>
                                <tr>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                    <td>
                                        <h5>Subtotal</h5>
                                    </td>
                                    <td>
                                        <h5>RS. <?php echo number_format($total_price, 2); ?></h5>
                                    </td>


                                </tr>
                                <tr class="shipping_area">
                                    <td class="d-none d-md-block">

                                    </td>
                                    <td>

                                    </td>
                       
                                    <td>
                                      
                                    </td>
                                </tr>
                                <tr class="out_button_area">
                                    <td class="d-none-l"></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="checkout_btn_inner d-flex align-items-center">
                                            <a class="gray_btn" href="shop.php">Continue Shopping</a>
                                            <!-- <button type="submit" class=" btn primary-btn ml-2"> Proceed to checkouts</button> -->
                                            <a class="primary-btn ml-2" href="Checkouts.php">Proceed to checkout</a>
                                        </div>
                                    </td>
                                </tr>

                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
     
        <!--================End Cart Area =================-->



    </main>


    <!--================ Start footer Area  =================-->
    <?php include("includes/footer.php")  ?>
    <!--================ End footer Area  =================-->


    <?php include("includes/jslinks.php")  ?>
</body>

</html>