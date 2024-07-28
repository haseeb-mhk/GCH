<?php
include("includes/Session.php");
include("../includes/Connection.php");

$user_id  = $_SESSION['user_id'];
$fetch_seller_id_query = "SELECT * FROM sellers WHERE user_id = '$user_id'";
$result = mysqli_query($con, $fetch_seller_id_query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $seller_id = $row['id'];
}
if (isset($_POST['btnSend'])) {
    $email = $_POST['email'];
    $query = $_POST['query'];
    $user_id  = $_SESSION['user_id'];
    $query_for_username = mysqli_query($con, "SELECT * FROM users WHERE id = '$user_id'");
    $row_query_for_username = mysqli_fetch_row($query_for_username);
    if ($row_query_for_username) {
        $username = $row_query_for_username[1];
        $insert_query = mysqli_query($con, "INSERT INTO `contact`( `user_id`, `name`, `email`, `message`) VALUES ('$user_id','$username','$email','$query')");
        if($insert_query){
            echo "your message has been send ";
        }
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

                        <!-- Page Heading -->
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-8">

                                <div class="card mb-4">
                                    <div class="card-header" align="center" style="background-color: blue;color: white;">
                                        Contact Form
                                    </div>
                                    <div class="card-body">
                                        <form method="post">

                                            <div class="form-group">
                                                <label for="ProductName">Email</label>
                                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email through which you will get response" required>
                                            </div>



                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Message</label>
                                                <textarea class="form-control" id="query" rows="3" name="query" placeholder="Enter your query"></textarea>
                                            </div>
                                            <input type="submit" class="btn btn-primary" value="Send" name="btnSend" width="500px">


                                        </form>




                                    </div>
                                </div>

                            </div>
                            <div class="col-2"></div>


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