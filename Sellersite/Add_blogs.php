<?php
include("includes/Session.php");
include("../includes/Connection.php");

$display_s = "block";
$display_u = "none";
$title = "";
$content =   "";

$user_id  = $_SESSION['user_id'];
$fetch_seller_id_query = "SELECT * FROM sellers WHERE user_id = '$user_id'";
$result = mysqli_query($con, $fetch_seller_id_query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $seller_id = $row['id'];
}

if (isset($_POST['btnSubmit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];
    $b_picture = $_FILES["photo"]["name"];
    move_uploaded_file($_FILES["photo"]["tmp_name"], "../Admin/img/blogimages/" . $_FILES["photo"]["name"]);
    $blog_query = "INSERT INTO blogs(title, content, user_id, image,status) VALUES('$title', '$content', '$user_id', '$b_picture','published')";
    $insert_blog = mysqli_query($con, $blog_query);
    // header('location:Blogs_list.php');
    echo "Data inserted successfully ";
  
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
                                    Add Blogs Details
                                </div>
                                <div class="card-body">
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="row">

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <span style="color:red"></span>
                                                    <label>Title</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="title" placeholder="Enter blog title" required value="<?php echo $title   ?>">
                                                    </div>

                                                </div>

                                                <div class="form-group">
                                                    <span style="color:red"></span>

                                                    <label>Blog Content</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="content" placeholder="Enter blog contents" required value="<?php echo $content  ?>">
                                                    </div>

                                                </div>


                                                <div class="form-group">
                                                    <label>Add Image</label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" id="photo" name="photo">
                                                    </div>
                                                </div>

                                              

                                            </div>


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