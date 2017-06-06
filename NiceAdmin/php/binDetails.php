<?php
/*
*bazura php for get bin levels;
*
*
*/

 
session_start();
 //$binId=$_POST["binid"];
 //$type=$_POST["type"];

 /*if(!isset($_SESSION["user_d"])){
	$_SESSION["user"]=9;
 }*/
 $user=$_SESSION["user_id"];
 
 //echo "$stdno<br>";
 
 include "conn.php";

/*$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bazuradb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//handle by include
*/

		$sql = "SELECT * FROM bin where user_id=".$user."";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				//echo $row["name"]."<BR>";
				$data[] = array(
					'curr_volume'=> $row['curr_vol'],   
					'type'=> $row['bintype'],
					'type'=> $row['bin_id'],
					'max_vol'=> $row['max_vol'],
					'load'=> $row['bin_load'],
					'lat'=> $row['lat'],
					'long'=> $row['long'],
					);
				
			}
			$json = json_encode($data);
			echo $json;
		} else {
			echo "0 results";
			
		}

$conn->close();
?>