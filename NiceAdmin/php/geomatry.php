 <?php
 //include 'canalTreeView.php';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agrolanka";

$field_volume=$_GET["vol_acres"];
$filed_id=$_GET["field_id"];

//convert_vol to rate m3s-1
$per_acre=5261;
$cubicmetres=$field_volume*$per_acre;
$water_speed =$cubicmetres/(2*30*24*60);//m3min-1

function distance($point,$id){

		$tmp_min=0;
		$conn = new mysqli("localhost", "root", "", "agrolanka");
		if ($conn->connect_error) {
			 //echo "error conn";
		} ////echo " no error conn";
			
			//$str = "GEOMETRYCOLLECTION(POINT(6.00 70.2316),POINT(6.1111 79.5623),POINT(6.2222 79.2356))')";
			$str=$point;
			$lanlat=explode("POINT",$str);
			////echo "xxxxxx".$lanlat[1];
			//echo "<br>\n". sizeof($lanlat)."pints were found <br>";
			//print_r (explode(" ",$lanlat[0]));
				
			for($i=1;$i<sizeof($lanlat);$i++) {
				$sql="SELECT ST_Distance(ST_GeomFromText('POINT".$lanlat[$i]."'), ST_GeomFromText('POINT(80 6550)'));";	
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					$row = $result->fetch_array();
					if($tmp_min>$row[0]||$i==1){
						$tmp_min=$row[0];
					}
					//echo "\n distance".$row[0]."<br>";
				}
			}	
			//echo "\n minimun".$tmp_min;
			
		//$sql="SELECT ST_Distance(ST_GeomFromText('POINT(180 6550)'), ST_GeomFromText('POINT(80 6550)'));";	
		$conn->close();
		return $tmp_min;
}



function request_water($id){

	$conn = new mysqli("localhost", "root", "", "agrolanka");
	$sql="select * from canal where id='".$id."'";
	$result = $conn->query($sql);
	$row=$result->fetch_array();

	if($GLOBALS['water_speed'] < $row["volume"]-$row["currentUsage"]){
		//echo "<br> water can be issue by canal ".$id."<br>amount".($row["volume"]-$row["currentUsage"]);
		//echo $id.":".$GLOBALS['cubicmetres'];
		$data[] = array(
					'id'=> $id,   
					'cubicmeters'=> $GLOBALS['cubicmetres'],
					
					);
			
			$json = json_encode($data);
			echo $json;
	}else{
		//echo "<br>".$GLOBALS['field_volume'].">".$row["currentVol"]."-".$row["currentUsage"];
	}
}


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//$sql = "SELECT AsText(geometryN(gpsPath,3)) ,id FROM canal ";
//$sql="SELECT AsText(GeometryN(GeomFromText('GeometryCollection(Point(1 1),POINT(2 2 ))'),1)),id from canal";
$sql="SELECT AsText(geometrycollection(gpsPath)) ,id FROM canal";

$result = $conn->query($sql);
$tmp=0;
$canal_id=0;
$final_min=0;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_array()) {
       // //echo $row[0];
		//echo "<br>\n canal id:".$row['id'];
		if($row[0]==''){
			//echo "null";
		}else{
			$tmp=distance($row[0],$row['id']);
			if($final_min>$tmp||$final_min==0){
				$final_min=$tmp;
				$canal_id=$row['id'];
			}
		}
    }
	//echo "<br> <br>final min---->".$final_min."id is ".$canal_id;
	request_water($canal_id);
} else {
    //echo "0 results";
}
$conn->close();
?> 