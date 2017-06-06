<?php
include "conn.php";


//$conn = mysqli_connect("localhost","root","","bazuradb");
$query ="Insert into users(name,nic,address,pass) values('".$_POST["uname"]."','".$_POST["nic"]."','".$_POST["address"]."','".$_POST["password"]."')";

if(mysqli_query($conn,$query)){

header('Location: ../login.php');
}else{
	echo mysqli_error();
}

?>