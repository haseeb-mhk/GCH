<?php
include('includes/Session.php');
// $blog_id = "";
if (isset($_GET['BID'])) {

	$blog_id = $_GET['BID'];
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

WHERE blogs.id = '$blog_id'");
	$row_blogq_query = mysqli_fetch_assoc($query_blogs);
}


// Insertion of comments 

if (isset($_POST['btnSubmit'])) {

	$user_id = $_SESSION['user_id'];
	$comment = $_POST['message'];
	$insert_blog = mysqli_query($con, "INSERT INTO blog_comments (blog_id, user_id, comment) VALUES ('$blog_id', '$user_id', '$comment')");

	if ($insert_blog) {


		header('location:Single_Blog.php?BID=' . $blog_id);
	} else {
		echo "insertion failure";
	}
}


// feching all the comments on the blog

$query_select_comments = mysqli_query($con, "
    SELECT 
        blog_comments.comment,
        blog_comments.created_at,
        buyers.full_name AS user_name,
        buyers.photo AS user_image
    FROM 
        blog_comments
    JOIN 
        buyers 
    ON 
        blog_comments.user_id = buyers.user_id
    WHERE 
        blog_comments.blog_id = '$blog_id'
    ORDER BY 
        blog_comments.created_at DESC
");


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>GCH | BLogs</title>
	<?php include "includes/Links.php" ?>
</head>

<body>
	<!--================ Start Header Menu Area =================-->

	<?php include "includes/header.php" ?>


	<!--================ End Header Menu Area =================-->
	<main class="site-main">


		<!-- ================ start banner area ================= -->
		<section class="blog-banner-area" id="blog">
			<div class="container h-10">
				<div class="blog-banner">
					<div class="text-center">
						<h1>Blog Details</h1>
						<nav aria-label="breadcrumb" class="banner-breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Blog Details</li>
							</ol>
						</nav>
					</div>
				</div>
			</div>
		</section>
		<!-- ================ end banner area ================= -->



		<!--================Blog Area =================-->
		<section class="blog_area single-post-area py-80px section-margin--small">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 posts-list">
						<div class="single-post row">
							<div class="col-lg-6">
								<div class="feature-img">
									<img class="img-fluid" src="../Admin/img/blogimages/<?php echo $row_blogq_query['image']  ?>" alt="" style="height: 400px; width: 500px;">

								</div>
							</div>
							<div class="col-lg-4  col-md-3">
								<div class="blog_info text-left">

									<ul class="blog_meta list">
										<li>
											<h2><?php echo $row_blogq_query['title']  ?></h2>
											<p class="excert">
												<?php echo $row_blogq_query['content']  ?>
											</p>

										</li>
										<li>
											<a href="#"><?php echo $row_blogq_query['author_name']   ?>
												<i class="lnr lnr-user"></i>
											</a>
										</li>
										<li>
											<a href="#"><?php echo $row_blogq_query['created_at']  ?>
												<i class="lnr lnr-calendar-full"></i>
											</a>
										</li>


									</ul>

								</div>
							</div>
						

						</div>



					</div>
				</div>
				<div class="row">

						<div class="col-6">
						<div class="comments-area">
							<?php while ($row_comments = mysqli_fetch_assoc($query_select_comments)) { ?>
								<div class="comment-list">
									<div class="single-comment justify-content-between d-flex">
										<div class="user justify-content-between d-flex">
											<div class="thumb">
												<img src="buyerimages/<?php echo $row_comments['user_image'];   ?>" alt="" width="100px" height="100px" style="border-radius: 50%;">
											</div>
											<div class="desc">
												<h5>
													<a href="#">
														<?php echo $row_comments['user_name']  ?>
													</a>
												</h5>
												<p class="date"><?php echo $row_comments['created_at'];  ?> </p>
												<p class="comment">
													<?php echo $row_comments['comment']  ?>
												</p>
											</div>
										</div>

									</div>
								</div>
							<?php }  ?>
						</div>


						</div>			
						<div class="col-6">

						<div class="comment-form">
							<h4>Leave a Reply</h4>
							<form method="post">
								<div class="form-group form-inline">
									<div class="form-group col-lg-6 col-md-6 name">
										<input type="text" class="form-control" id="name" placeholder="Enter Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Name'">
									</div>
									<div class="form-group col-lg-6 col-md-6 email">
										<input type="email" class="form-control" id="email" placeholder="Enter email address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'">
									</div>
								</div>

								<div class="form-group">
									<textarea class="form-control mb-10" rows="5" name="message" placeholder="Messege" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Messege'" required=""></textarea>
								</div>
								<input type="submit" class="button button--active" name="btnSubmit" value="Post Comment">

							</form>
						</div>
						</div>			


				</div>						


			</div>
			</div>
		</section>
		<!--================Blog Area =================-->


	</main>

	<!--================ Start footer Area  =================-->
	<?php include("includes/footer.php")  ?>
	<!--================ End footer Area  =================-->



	<?php include("includes/jslinks.php")  ?>
</body>

</html>