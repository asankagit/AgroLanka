<?php 
$conn = new mysqli("localhost", "root", "", "agrolanka");
get_canal_gpspath();
//convert to object
function distance($point,$id){
		$conn = new mysqli("localhost", "root", "", "agrolanka");
		if ($conn->connect_error) {
			 echo "error conn";
		} 
			$str=$point;
			echo $point;
			$lanlat=explode("POINT",$str);
			for($i=1;$i<sizeof($lanlat)-1;$i++) {
				//echo "<br>". explode(" ",$lanlat[$i])[1];
				echo "<br>".$lanlat[$i];
				//echo "<br> ".explode(" ",$lanlat[$i])[1].",".explode(" ",$lanlat[$i])[2];
			}	
		
		$conn->close();
		
}



//get all  canals
function get_canal_gpspath(){
$sql="SELECT AsText(geometrycollection(gpsPath)) ,id FROM canal";
$conn=$GLOBALS['conn'];
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_array()) {
		
		if($row[0]==''){
			echo "null";
		}else{
			$tmp=distance($row[0],$row['id']);
			
		}
    }
	
	
} else {
    echo "0 results";
}

}

?>
