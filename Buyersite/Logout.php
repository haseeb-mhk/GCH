<?php   
include("includes/Session.php");


    session_destroy();
    header("location:Login.php");
    


?>