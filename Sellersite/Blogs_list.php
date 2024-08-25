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
$query_blogs = mysqli_query($con, "SELECT 
    blogs.id,
    blogs.title,
    blogs.content,
    blogs.image,
    blogs.status,
    blogs.created_at,
    blogs.updated_at,
    CASE 
        WHEN users.role = 'seller' THEN sellers.business_name
        WHEN users.role = 'admin' THEN 'By admin'
        ELSE users.username
    END AS author_name
FROM 
    blogs
JOIN 
    users 
ON 
    blogs.user_id = users.id
LEFT JOIN 
    sellers 
ON 
    users.id = sellers.user_id
    Where blogs.user_id = '$user_id'
    ORDER BY 
    blogs.created_at DESC
");

// Deleting the record of buyer 

// Handle delete request
if (isset($_GET['Did'])) {
  $blog_id = $_GET['Did'];
  
  // First delete from buyers table
  $delete_blog_query =  mysqli_query($con, "DELETE FROM blogs WHERE id = '$blog_id'");
 
  // Redirect to avoid resubmission of the form
  header("location:Blogs_list.php");
  exit();
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

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">All Blogs List</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered"  width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Photo</th>
                                                <th>title</th>
                                                <th>contents</th>
                                                <th>Posted By</th>
                                                <th> Created at</th>
                                                <th> Edit</th>
                                                <th> Delete</th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                        while ($row = mysqli_fetch_assoc($query_blogs)) {
                            echo "<tr>";
                            echo "<td><img src='../Admin/img/blogimages/{$row['image']}' alt='Photo' width='50' height='50'></td>";
                            echo "<td>{$row['title']}</td>";
                           
                            echo "<td>{$row['content']}</td>";
                            echo "<td>{$row['author_name']}</td>";
                            echo "<td>{$row['created_at']}</td>";
                             echo "<td><a href='Add_blogs.php?Uid=$row[id]' class='btn btn-success'>Edit</a></td>";
                            echo "<td><a href='Blogs_list.php?Did={$row['id']}' class='btn btn-danger' onclick='return confirm(\"Are you sure to delete this blog?\")'>Delete</a></td>";
                            echo "</tr>";
                        }
                        ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Photo</th>
                                                <th>title</th>
                                                <th>contents</th>
                                                <th>Posted By</th>
                                                <th> Created at</th>
                                                <th> Edit</th>
                                                <th> Delete</th>


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