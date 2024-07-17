
<?php 
include("includes/Session.php");
$display_Active = "none";
$display_deactive = "none";
$pid = $_GET['product_id'];
if(isset($_GET['product_id'])){
    $pid = $_GET['product_id'];
    $product_query = "
    SELECT 
        p.*, 
        c.name AS category_name, 
        sc.name AS subcategory_name
    FROM 
        products p
    JOIN 
        categories c ON p.category_id = c.id
    JOIN 
        sub_categories sc ON p.sub_category_id = sc.id
    WHERE 
        p.id = '$pid';
";

$product_result = mysqli_query($con, $product_query);
$row_product_result = mysqli_fetch_assoc($product_result);
$pid = $row_product_result['id'];
$pname = $row_product_result['name'];
$category_name = $row_product_result['category_name'];
$sub_category_name = $row_product_result['subcategory_name'];
$Description = $row_product_result['description'];
$price = $row_product_result['price'];
$quantity = $row_product_result['quantity'];
$image1 = $row_product_result['image1'];
$image2 = $row_product_result['image2'];
$image3 = $row_product_result['image3'];
$product_status = $row_product_result['product_status'];
if($product_status == "active"){
            $display_deactive  = "block";
}
else{
    $display_Active = "block";
}
}
$seller_id = $row_product_result['seller_id'];
$query_select_seller = mysqli_query($con, "Select * from sellers where id = '$seller_id'");
if($query_select_seller){
  $seller_row = mysqli_fetch_assoc($query_select_seller);
  $seller_name = $seller_row['business_name']; 
}
else{
  echo mysqli_error($con);
}


if(isset($_POST['btnActive'])){
    $update_Status = mysqli_query($con,"update products SET product_status = 'active' where id = '$pid'");
    header("location:Product_details.php?product_id=$pid");
   
}
if(isset($_POST['btnDeactive'])){
    $update_Status = mysqli_query($con,"update products SET product_status = 'inactive' where id = '$pid'");
    header("location:Product_details.php?product_id=$pid");
   
}



?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>GCH| Dashboard</title>
        <?php 
        include("includes/links.php");
        ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <?php 
        include("includes/header.php");
        ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php 
        include("includes/sidepanel.php");
        ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Product Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active"> Products</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <div class="card card-solid">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-6">
                <div class="col-12">
                <img src="../Sellersite/img/productimages/<?php echo $image1?>" class="product-image" alt="Product Image">
              </div>
              <div class="col-12 product-image-thumbs">
                <div class="product-image-thumb active"><img src="../Sellersite/img/productimages/<?php echo $image1?>" alt="Product Image"></div>
                <div class="product-image-thumb" ><img src="../Sellersite/img/productimages/<?php echo $image2?>" alt="Product Image"></div>
                <div class="product-image-thumb" ><img src="../Sellersite/img/productimages/<?php echo $image3?>" alt="Product Image"></div>
                 </div>
            </div>
            <div class="col-12 col-sm-6">
              <h3 class="my-3"><?php echo $pname;  ?></h3>
              <p> <?php echo $Description;  ?></p>

              <hr>
              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-default text-center active">
                <h6>quantity:</h6>
                </label>
                <label class="btn btn-default text-center active">
                  <?php echo $quantity  ?>
                </label>
                
                
              </div> 
              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-default text-center active">
                <h6>Price:</h6>
                </label>
                <label class="btn btn-default text-center active">Rs.
                  <?php echo $price  ?>
                </label>
                
                
              </div> 
              <br> 
              <br>

              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-default text-center active">
                <h6>Category:</h6>
                </label>
                <label class="btn btn-default text-center active">
                  <?php echo $category_name  ?>
                </label>
                
                
              </div> 
              <br> 
              <br> 
              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-default text-center active">
                <h6>sub category:</h6>
                </label>
                <label class="btn btn-default text-center active">
                  <?php echo $sub_category_name  ?>
                </label>
                
                
              </div> 
              <br> 
              <br> 
              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-default text-center active">
                <h6>Added By:</h6>
                </label>
                <label class="btn btn-default text-center active">
                  <?php echo $seller_name ?>
                </label>
                
                
              </div> 

              <br> 
              <br> 
              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-default text-center active">
                <h6>Status:</h6>
                </label>
                <label class="btn btn-default text-center active">
                  <?php echo $product_status  ?>
                </label>
                
                
              </div> 

             

              <div class="mt-4">
                <form method="post">
                    
                <input type="submit" class="btn btn-primary" style="display: <?php echo $display_Active?>;" value="Activate" name="btnActive" width="300px">
                <input type="submit" class="btn btn-danger" style="display: <?php echo $display_deactive; ?>" value="Deactivate" name="btnDeactive" onclick="return confirm('Are you sure do deactivate. This will be remove from the site?');">

                
                </form>
              </div>

              

            </div>
          </div>
          <div class="row mt-4">
            <nav class="w-100">
              <div class="nav nav-tabs" id="product-tab" role="tablist">
                  <a class="nav-item nav-link active" id="product-comments-tab" data-toggle="tab" href="#product-comments" role="tab" aria-controls="product-comments" aria-selected="false">Comments</a>
                <a class="nav-item nav-link" id="product-rating-tab" data-toggle="tab" href="#product-rating" role="tab" aria-controls="product-rating" aria-selected="false">Rating</a>
              </div>
            </nav>
            <div class="tab-content p-3" id="nav-tabContent">
               <div class="tab-pane fade show active" id="product-comments" role="tabpanel" aria-labelledby="product-comments-tab"> Vivamus rhoncus nisl sed venenatis luctus. Sed condimentum risus ut tortor feugiat laoreet. Suspendisse potenti. Donec et finibus sem, ut commodo lectus. Cras eget neque dignissim, placerat orci interdum, venenatis odio. Nulla turpis elit, consequat eu eros ac, consectetur fringilla urna. Duis gravida ex pulvinar mauris ornare, eget porttitor enim vulputate. Mauris hendrerit, massa nec aliquam cursus, ex elit euismod lorem, vehicula rhoncus nisl dui sit amet eros. Nulla turpis lorem, dignissim a sapien eget, ultrices venenatis dolor. Curabitur vel turpis at magna elementum hendrerit vel id dui. Curabitur a ex ullamcorper, ornare velit vel, tincidunt ipsum. </div>
              <div class="tab-pane fade" id="product-rating" role="tabpanel" aria-labelledby="product-rating-tab"> Cras ut ipsum ornare, aliquam ipsum non, posuere elit. In hac habitasse platea dictumst. Aenean elementum leo augue, id fermentum risus efficitur vel. Nulla iaculis malesuada scelerisque. Praesent vel ipsum felis. Ut molestie, purus aliquam placerat sollicitudin, mi ligula euismod neque, non bibendum nibh neque et erat. Etiam dignissim aliquam ligula, aliquet feugiat nibh rhoncus ut. Aliquam efficitur lacinia lacinia. Morbi ac molestie lectus, vitae hendrerit nisl. Nullam metus odio, malesuada in vehicula at, consectetur nec justo. Quisque suscipit odio velit, at accumsan urna vestibulum a. Proin dictum, urna ut varius consectetur, sapien justo porta lectus, at mollis nisi orci et nulla. Donec pellentesque tortor vel nisl commodo ullamcorper. Donec varius massa at semper posuere. Integer finibus orci vitae vehicula placerat. </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <?php
        include("includes/footer.php");
 ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<?php  include('includes/jslinks.php'); ?>
</body>
</html>
