<?php 
if(isset($_GET["id"])){
 getdata($_GET["id"]);
}

function getdata($id){
	$conn = new mysqli("localhost","root","", "agrolanka");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql="SELECT * FROM canal where id='".$id."'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$data=array();
		$n=0;
		while($row = $result->fetch_assoc()) {
		$n++;
			//echo $row["id"];
			/*$data[$n]=array(
				"id"=>$row["id"],
				"usage"=>$row["currentUsage"],
				"max_volume"=>$row["volume"]
			
			);*/
			$data["id"]=$row["id"];
			$data["usage"]=$row["currentUsage"];
			$data["max_volume"]=$row["volume"];
			
			
		}
		$json=json_encode($data);
		echo $json;
	}
}
?>
