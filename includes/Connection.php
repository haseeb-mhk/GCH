<?php

$host="localhost";
$uname="root";
$upass="";
$db="gch_db";
$con=mysqli_connect($host,$uname,$upass,$db);
if(mysqli_errno($con)){
	echo("not connectted");
}
else{
	// echo(" connected to Database");
	
}
?>


 