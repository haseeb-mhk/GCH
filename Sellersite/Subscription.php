<?php
include("includes/Session.php");
include("../includes/Connection.php");
$display1 = "none";
$display2 = "none";
$display3 = "none";

$user_id  = $_SESSION['user_id'];
$fetch_seller_id_query = "SELECT * FROM sellers WHERE user_id = '$user_id'";
$result = mysqli_query($con, $fetch_seller_id_query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $seller_id = $row['id'];
}

$check_subscription_query = mysqli_query($con, "select * from subscriptions where seller_id = '$seller_id'");
$check_subscription_row  = mysqli_num_rows($check_subscription_query);
if ($check_subscription_row > 0) {
    $check_status = mysqli_fetch_row($check_subscription_query);
    if ($check_status[4] == "inactive") {
        $display3 = "block";
    } else {
        $display1 = "none";
        $display3 = "none";
        $display2 = "block";
    }
} else {
    $display1 = "block";
    $display2 = "none";
    $display3 = "none";

}

if (isset($_POST['btnsubscribe'])) {


    $query_subscription = mysqli_query($con, "insert into subscriptions (seller_id)  values('$seller_id')");
    if ($query_subscription) {
        header("location:subscription.php");
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

                        <!-- Page Heading -->

                        <div class="col-xl-12 col-md-12 mb-12" style="display: <?php echo $display1 ?>;">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="container ">
                                            <h2 class="mb-4">Warning : No Subscription</h2>
                                            <div class="row">
                                                <!-- Example Card, should be dynamically generated with server-side data -->
                                                <div class="col-md-12 mb-12">

                                                    <h5 class="card-title">You can't <strong> Add products </strong> until you subscribe </h5>
                                                    <form method="post">
                                                        <button type="submit" class="btn btn-success" name="btnsubscribe">Subscribe Now </button>
                                                    </form>
                                                </div>
                                                <!-- Additional cards would go here -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-12 col-md-12 mb-12" style="display: <?php echo $display2 ?>;">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="container ">
                                            <h2 class="mb-4">Your Subscriptions</h2>
                                            <div class="row">
                                                <!-- Example Card, should be dynamically generated with server-side data -->
                                                <div class="col-md-4 mb-4">

                                                    <h5 class="card-title">Subscription ID: 1</h5>
                                                    <p class="card-text"><strong>Seller ID:</strong> 123</p>
                                                    <p class="card-text"><strong>Start Date:</strong> 2024-01-01</p>
                                                    <p class="card-text"><strong>Expirey Date:</strong> 2024-12-31</p>
                                                    <p class="card-text"><strong>Status:</strong> Active</p>
                                                    <button class="btn btn-primary" onclick="renewSubscription(1)">Renew</button>

                                                </div>
                                                <!-- Additional cards would go here -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-md-12 mb-12" style="display: <?php echo $display3 ?>;">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="container ">
                                            <h2 class="mb-4">Thanks for your Subscription ....!</h2>
                                            <div class="row">
                                                <!-- Example Card, should be dynamically generated with server-side data -->
                                                <div class="col-md-12 mb-12">

                                                    <h5 class="card-title">
                                                        <ul>
                                                            <li> Your request have been send to Admin...</li>
                                                            <li> you will be notified when your account has been activated<br>
                                                            </li>
                                                            <li> <strong>Your can't Add product until activation</strong>
                                                            </li>



                                                        </ul>
                                                    </h5>
                                                    <form method="post">
                                                        <a href="index.php" class="btn btn-success" name="btnsubscribe">Goto Dashboard </a>
                                                    </form>
                                                </div>
                                                <!-- Additional cards would go here -->
                                            </div>
                                        </div>
                                    </div>
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