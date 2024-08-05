<?php
include("includes/Session.php");
include("../includes/Connection.php");
$display_s = "block";
$display_u = "none";

$pname  = "";
$cat_id = "";
$sub_cat_id = "";
$Cat_name  = "Select";
$sub_cat_name  = "Select";
$p_desc  = "";
$p_price  = "";
$p_quantity  = "";
$p_img1  = "";
$p_img2  = "";
$p_img3  = "";


// Getting the seller id 

$user_id  = $_SESSION['user_id'];

$fetch_seller_id_query = "SELECT * FROM sellers WHERE user_id = '$user_id'";
$result = mysqli_query($con, $fetch_seller_id_query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $seller_id = $row['id'];
}

if (isset($_POST['btnSubmit'])) {
    $check_subscription_query = mysqli_query($con, "select * from subscriptions where seller_id = '$seller_id'");
    $check_subscription_row  = mysqli_num_rows($check_subscription_query);
    if ($check_subscription_row > 0) {
        $check_status = mysqli_fetch_row($check_subscription_query);
        if ($check_status[4] == "active") {
            // Extract data from the form
            $productName = $_POST['product_name'];
            $productQuantity =  $_POST['product_quantity'];
            $productCategory =  $_POST['product_category'];
            $productSubCategory = $_POST['product_sub_category'];
            $productPrice =  $_POST['product_price'];
            $productDescription =  $_POST['product_description'];
            // Handling file uploads
            $image1 = $_FILES['product_image1']['name'];
            $image2 = $_FILES['product_image2']['name'];
            $image3 = $_FILES['product_image3']['name'];

            // // Move uploaded files to a designated directory
            move_uploaded_file($_FILES['product_image1']['tmp_name'], "img/productimages/" . $image1);
            move_uploaded_file($_FILES['product_image2']['tmp_name'], "img/productimages/" . $image2);
            move_uploaded_file($_FILES['product_image3']['tmp_name'], "img/productimages/" . $image3);
            $insertProductQuery = "INSERT INTO products (name,seller_id, category_id, sub_category_id, price, quantity, description, image1, image2, image3) 
            VALUES ('$productName', '$seller_id', '$productCategory', '$productSubCategory', '$productPrice', '$productQuantity','$productDescription', '$image1', '$image2', '$image3')";

            if (mysqli_query($con, $insertProductQuery)) {
                // echo "Product inserted successfully.";
                header('location:product_list.php');
            } else {
                echo "Error: " . mysqli_error($con);
            }
        } else {
            echo "<script>
            alert('Your account is not activated yet...!');
            window.location.href = 'Subscription.php';
          </script>";
        }
    } else {
        echo "<script>
            alert('you cannot add product until you activate your account<br> subscribe to active you account');
            window.location.href = 'Subscription.php';
          </script>";
        
    }
}



// code for getting the data through id 

if (isset($_GET['PID'])) {
    $p_id = $_GET['PID'];
    $select_product = mysqli_query($con, "Select * from products where id = '$p_id'");
    $row_p = mysqli_fetch_row($select_product);
    $pname  = $row_p[1];
    $cat_id  = $row_p[3];
    // query for getting category name 

    $query_cat = mysqli_query($con, "select * from categories where id  = '$cat_id' ");
    if ($query_cat) {
        $row_cat = mysqli_fetch_row($query_cat);
        $Cat_name = $row_cat[1];
    }

    // getting sub category name 

    $sub_cat_id  = $row_p[4];

    $query_sub_Cat = mysqli_query($con, "Select * from sub_categories where id  = '$sub_cat_id' ");
    if ($query_sub_Cat) {
        $row_query_sub_Cat = mysqli_fetch_row($query_sub_Cat);
        $sub_cat_name = $row_query_sub_Cat[1];
    }


    $p_desc  = $row_p[5];
    $p_price  = $row_p[6];
    $p_quantity  = $row_p[7];
    $p_img1  = $row_p[8];
    $p_img2  = $row_p[9];
    $p_img3  = $row_p[10];
    $display_s = "none";
    $display_u = "block";
}

// code for updating the data 

if (isset($_POST['btnUpd'])) {

    // Extracting data from the form
    $productName = $_POST['product_name'];
    $productQuantity =  $_POST['product_quantity'];
    $productCategory =  $_POST['product_category'];
    $productSubCategory = $_POST['product_sub_category'];
    $productPrice =  $_POST['product_price'];
    $productDescription =  $_POST['product_description'];
    // Handling file uploads
    $image1 = $_FILES['product_image1']['name'];
    $image2 = $_FILES['product_image2']['name'];
    $image3 = $_FILES['product_image3']['name'];

    // // Move uploaded files to a designated directory
    move_uploaded_file($_FILES['product_image1']['tmp_name'], "img/productimages/" . $image1);
    move_uploaded_file($_FILES['product_image2']['tmp_name'], "img/productimages/" . $image2);
    move_uploaded_file($_FILES['product_image3']['tmp_name'], "img/productimages/" . $image3);


    $query_update_product = mysqli_query($con, "UPDATE products SET name='$productName',category_id='$productCategory',sub_category_id='$productSubCategory',description='$productDescription',price='$productPrice',quantity='$productQuantity',image1='$image1',image2='$image2',image3='$image3' WHERE id = '$p_id'");
    if ($query_update_product) {
        // echo "Product Updated Successfully";
        header('location:product_list.php');
    } else {
        echo (mysqli_errno($con));
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="../logos/favicon.png" sizes="64X64">
    <title>GCH | Seller</title>
    <?php include("includes/links.php")  ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include("includes/sidepanel.php")  ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include("includes/header.php")  ?>
                <br><br><br><br>
                <!-- End of Topbar -->


                <!-- Main content  -->
                <main>
                    <!-- Begin Page Content -->
                    <div class="container-fluid">



                    </div>


                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-8">

                            <div class="card mb-4">
                                <div class="card-header" align="center" style="background-color: blue;color: white;">
                                    Add product Details
                                </div>
                                <div class="card-body">
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="row">

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="ProductName">Name</label>
                                                    <input type="text" class="form-control" id="productname" name="product_name" placeholder="Enter Product name" required value="<?php echo $pname ?>">
                                                </div>

                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="quantity">Quantity</label>
                                                    <input type="number" class="form-control" id="productquantity" name="product_quantity" placeholder="Enter Product quantity" required value="<?php echo $p_quantity ?>">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="category">Category</label>
                                                    <select class="form-control" name="product_category" required id="product_category">
                                                        <option selected value="<?php echo ($cat_id); ?>"><?php echo $Cat_name ?></option>
                                                        <?php
                                                        $select_categories = mysqli_query($con, "Select * from categories");

                                                        while ($row_categories = mysqli_fetch_array($select_categories)) {
                                                        ?>
                                                            <option value="<?php echo ($row_categories['id']); ?>"><?php echo ($row_categories['name']) ?></option>
                                                        <?php }   ?>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="subcategory">Sub Category</label>
                                                    <select class="form-control" name="product_sub_category" required id="product_sub_category">
                                                        <option selected value="<?php echo ($sub_cat_id) ?>"><?php echo $sub_cat_name ?></option>
                                                        <?php
                                                        $select_categories2 = mysqli_query($con, "Select * from categories");

                                                        while ($row_categories2 = mysqli_fetch_array($select_categories2)) {
                                                            $parent_id = $row_categories2['id'];
                                                        ?>
                                                        <optgroup  label="<?php echo ($row_categories2['name']); ?>"><?php 
                                                         $select_sub_categories = mysqli_query($con, "Select * from sub_categories where parent_category_id = '$parent_id'");
                                                            while($row_sub_categories = mysqli_fetch_assoc($select_sub_categories)){
                                                        
                                                        ?>
                                                            
                                                            <option value="<?php echo ($row_sub_categories['id']) ?>"><?php echo ($row_sub_categories['name']) ?></option>
                                                        <?php  }  ?>   
                                                        
                                                        </optgroup>
                                                        
                                                            <?php }   ?>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="Productprice">Price</label>
                                                    <input type="number" class="form-control" id="productprice" name="product_price" placeholder="Enter Product price" required value="<?php echo $p_price ?>">
                                                </div>

                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="product_image"> Image 1</label>
                                                    <input type="file" class="form-control-file" id="productimage1" name="product_image1" required value="<?php echo $p_img1 ?>">
                                                </div>

                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="product_image">Image 2</label>
                                                    <input type="file" class="form-control-file" id="productimage1" name="product_image2" value="<?php echo $p_img2 ?>">
                                                </div>

                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="product_image"> Image 3</label>
                                                    <input type="file" class="form-control-file" id="productimage1" name="product_image3" value="<?php echo $p_img3 ?>">
                                                </div>

                                            </div>


                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">description</label>
                                            <textarea class="form-control" id="product_description" rows="3" name="product_description"><?php echo $p_desc ?></textarea>
                                        </div>
                                        <input type="submit" class="btn btn-primary" value="Submit" name="btnSubmit" style="display: <?php echo $display_s ?>;">
                                        <input type="submit" class="btn btn-success" value="Update" name="btnUpd" style="display: <?php echo $display_u ?>;">


                                    </form>




                                </div>
                            </div>

                        </div>
                        <div class="col-2"></div>


                    </div>




                </main>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include("includes/footer.php")  ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <?php include("includes/jslinks.php")  ?>





</body>

</html>