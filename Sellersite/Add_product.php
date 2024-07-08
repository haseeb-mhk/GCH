<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

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
                                    <form>
                                        <div class="row">

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="ProductName">Name</label>
                                                    <input type="text" class="form-control" id="productname" name="product_name" placeholder="Enter Product name">
                                                </div>

                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="quantity">Quantity</label>
                                                    <input type="number" class="form-control" id="productquantity" name="product_quantity" placeholder="Enter Product quantity">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="category">Category</label>
                                                    <select class="form-control">
                                                        <option selected>select</option>
                                                        <option >Fashion & Apparel</option>
                                                        <option >Baby and Kids</option>
                                                        <option >Furnitures</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="subcategory">Sub Category</label>
                                                    <select class="form-control">
                                                        <option selected>select</option>
                                                        <option >Fashion & Apparel</option>
                                                        <option>Baby and Kids</option>
                                                        <option >Furnitures</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">

<div class="col-6">
    <div class="form-group">
        <label for="Productprice">Price</label>
        <input type="number" class="form-control" id="productprice" name="product_price" placeholder="Enter Product price">
    </div>

</div>

</div>

<div class="row">

<div class="col-4">
    <div class="form-group">
    <label for="product_image"> Image 1</label>
    <input type="file" class="form-control-file" id="productimage1" name="product_image1">
     </div>

</div><div class="col-4">
    <div class="form-group">
    <label for="product_image">Image 2</label>
    <input type="file" class="form-control-file" id="productimage1" name="product_image2">
     </div>

</div><div class="col-4">
    <div class="form-group">
    <label for="product_image"> Image 3</label>
    <input type="file" class="form-control-file" id="productimage1" name="product_image3">
     </div>

</div>


</div>
<div class="form-group">
    <label for="exampleFormControlTextarea1">description</label>
    <textarea class="form-control" id="product_description" rows="3" name="product_description"></textarea>
  </div>
                                <a href="#" class="btn btn-primary">Submit</a>
                                <a href="#" class="btn btn-success">Update</a>
                                        
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