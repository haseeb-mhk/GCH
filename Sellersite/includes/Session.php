<?php
session_start();
include("../includes/Connection.php");
if (!isset($_SESSION["role"]) || $_SESSION["role"] != "seller")  {
    header("location:../Buyersite/Login.php");
  exit();
}


?>