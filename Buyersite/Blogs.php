<?php
include('includes/Session.php');

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
ORDER BY 
    blogs.created_at DESC 
");

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>GCH | BLogs</title>
  <link rel="icon" type="image/png" href="../logos/favicon.png" sizes="64X64">
  <?php include "includes/Links.php" ?>
</head>
<body>
  <!--================ Start Header Menu Area =================-->
	
   <?php include "includes/header.php" ?>
  
  
	<!--================ End Header Menu Area =================-->
<main class="site-main">
<section class="blog-banner-area" id="category">
		<div class="container h-10">
			<div class="blog-banner">
				<div class="text-center">
					<h1>Blogs</h1>
					<nav aria-label="breadcrumb" class="banner-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Blogs</li>
            </ol>
          </nav>
				</div>
			</div>
    </div>
	</section>
<section class="blog">
      <div class="container">
        <div class="section-intro pb-60px">
          <p>Popular Item in the market</p>
          <h2>Latest <span class="section-intro__style">News</span></h2>
        </div>

        <div class="row">
        <?php while ($row_blog_query = mysqli_fetch_assoc($query_blogs)){  ?>
          <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
            <div class="card card-blog">
              <div class="card-blog__img">
                <img class="card-img rounded-0" src="../Admin/img/blogimages/<?php echo $row_blog_query['image']   ?>" alt="" width="100%" height="250px">
              </div>
              <div class="card-body">
                <ul class="card-blog__info">
                  <li><a href="#"><?php echo $row_blog_query['author_name']  ?></a></li>
                  <li><a href="#"><i class="ti-comments-smiley"></i> 2 Comments</a></li>
                </ul>
                <h4 class="card-blog__title"><a href="Single_Blog.php?BID=<?php echo $row_blog_query['id']  ?>"><?php echo $row_blog_query['title']  ?></a></h4>
               
               
                <a class="card-blog__link" href="Single_Blog.php?BID=<?php echo $row_blog_query['id']  ?>">Read More <i class="ti-arrow-right"></i></a>
              </div>
            </div>
          </div>
<?php }  ?>
        </div>
      </div>
    </section>

</main>


  <!--================ Start footer Area  =================-->	
               <?php include("includes/footer.php")  ?> 
	<!--================ End footer Area  =================-->



    <?php include("includes/jslinks.php")  ?>
</body>
</html>