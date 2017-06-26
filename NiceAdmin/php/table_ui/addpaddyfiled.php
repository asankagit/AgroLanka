<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agrolanka";

 
$name=$_POST['name'];
$area=$_POST['acres'];
$point=$_POST['loc'];//7.29546 80.5214
$point="7.29546 80.5214";
$gramaseva=$_POST['grama'];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "INSERT INTO `agrolanka`.`paddyfield` (`id`, `location`, `name`, `farmerid`, `status`, `acres`, `gramaseva_div`) 
VALUES (NULL, GeomFromText('POINT(".$point.")',0), '".$name."', '".$_SESSION["user_id"]."', '1', '".$area."', '".$gramaseva."');";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>