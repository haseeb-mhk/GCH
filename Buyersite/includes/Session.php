<?php 
session_start();
include("../includes/Connection.php");
// if (!isset($_SESSION["role"]) || $_SESSION["role"] != "buyer")
if (!isset($_SESSION["role"]) ){
  header("location:Login.php");
  exit();
}
$user_id = $_SESSION['user_id'];
$query_for_name = mysqli_query($con,"select * from buyers where user_id = '$user_id'");
$result = mysqli_fetch_assoc($query_for_name);
$name = $result['full_name'];

// for logout 
if(isset($_POST["btnlogout"])){

    session_destroy();
    header("location:../index.php");
    
}

?>