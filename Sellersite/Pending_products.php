<?php
include("includes/Session.php");
include("../includes/Connection.php");
// Getting the seller id 

$user_id  = $_SESSION['user_id'];

$fetch_seller_id_query = "SELECT * FROM sellers WHERE user_id = '$user_id'";
$result = mysqli_query($con, $fetch_seller_id_query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $seller_id = $row['id'];
    
}

$select_products = mysqli_query($con,"SELECT p.*, c.name AS category_name, sc.name AS sub_category_name 
          FROM products p 
          JOIN categories c ON p.category_id = c.id 
          JOIN sub_categories sc ON p.sub_category_id = sc.id where seller_id =  '$seller_id' and product_status = 'inactive'");
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

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Pending Products </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Quantity</th>
                                                <th>Category</th>
                                                <th>Sub-Cat</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Uploaded at</th>
                                                
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php    
                                            while($row= mysqli_fetch_array($select_products)){
                                            ?>
                                            <tr>
                                                <td><?php
                                                $imagename  = $row['image1'];
                                                $folder = "img/productimages/";
                                                $completepath = $folder.$imagename; ?>
                                            <img src="<?php echo $completepath ?>" width="50px" height="50px">    
                                            </td>
                                                <td><?php  echo $row['name'] ?></td>
                                                <td><?php  echo $row['quantity'] ?></td>
                                                <td>   <?php echo $row['category_name']?> </td>
                                                <td><?php  echo $row['sub_category_name'] ?></td>
                                                <td><?php  echo $row['price'] ?></td>
                                                <td><?php 
                                                if($row['product_status'] == "inactive"){
                                                    ?>
                                                    <button class="btn btn-warning">Pending</button>
                                                    
                                                    <?php
                                                }else{
                                                        ?>
                                                        
                                                        <button class="btn btn-success">Approved</button>
                                                    
                                                        
                                                        <?php
                                                }
                                               
                                                ?></td>
                                                <td><?php  echo $row['created_at'] ?></td>
                                            
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Quantity</th>
                                                <th>Category</th>
                                                <th>Sub-Cat</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>uploaded at</th>
                                               
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>
                    <!-- /.container-fluid -->
                </main>
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