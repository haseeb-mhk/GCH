<?php
session_start();
include("../includes/Connection.php");
//  if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin")
if (!isset($_SESSION["role"]) ) {
  header("location:../Buyersite/Login.php");
  exit();
}
if(isset($_POST["btnlogOut"])){

    session_destroy();
    header("location:../Buyersite/Login.php");
    
}

?>