<?php
session_start();
include("../includes/Connection.php");
if (!isset($_SESSION["role"]) || $_SESSION["role"] != "seller")  {
    header("location:../Buyersite/Login.php");
  exit();
}

$name = $_SESSION['username'];
if(isset($_POST["btnLogout"])){

    session_destroy();
    header("location:../Buyersite/index.php");
    
}
?>