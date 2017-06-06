<?php
session_start();
$uname=$_POST["username"];
$pass=$_POST["password"];

include "conn.php";


$sql = "SELECT * FROM farmer where nic='".$uname."' AND password='".$pass."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        //echo "id: " . $row["uid"]. " - Name: " . $row["name"]. "<br>";
		$_SESSION["user_id"]=$row["nic"];
		$_SESSION["user"]=$uname;//$row["name"];
		header("location:../tables.php");
		
		 
		 
    }
} else {
    echo "0 results";
	echo $uname."\n".$pass;
}

$conn->close();
?>