<?php 
include 'Splstack.php';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agrolanka";


$canalid=$_GET['id'];
$req_vol=$_GET['reqvol'];
$req_speed=$req_vol/(2*30*24*60);//m3per munite

$stack = new Splstack();

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
function treeview($outflow){
	
	$conn = new mysqli("localhost","root","", "agrolanka");
	$sql="SELECT * FROM canelnet left JOIN canal ON canal.id= canelnet.inflow where outflow='".$outflow."'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	$row;
	$n=0;
		while($row = $result->fetch_assoc()) {
		$n++;
		//echo "<br>".$n.$outflow;
			//echo "<br> inflow:".$row['inflow'];
			
			$GLOBALS['stack']->push($row['inflow']);//"volume".$row['volume']
			
			if($row['tankID']==""){
				treeview($row['inflow']);
			}else{
			//check wheather water available in tanks ;
				tankDetails($row['tankID'],$GLOBALS['req_vol']);
				$GLOBALS['stack']->push($row['tankID']);
				//$GLOBALS['stack']->push('root');
				
			}
		}
		
		
	}
}
function tankDetails($tank_id,$volume){
//update tank updated volume;
	//echo "<script> alert('came line 50".$tank_id."');</script>";
	$conn = new mysqli("localhost","root","", "agrolanka");
	$sql="SELECT * from tank where id='".$tank_id."'";
	$result = $conn->query($sql);
	//echo "<br>CAME INSIDE BEFOR result";
	if ($result->num_rows > 0) {
				
		while($row = $result->fetch_assoc()) {
				
			if($volume<$row["curr_vol"]-$row["requestedVol"]){
				//echo "<br>CAME INSIDE IF".$row["requestedVol"]."<>".$volume."sum=".($row["requestedVol"]+$volume);
				$sqlqry="UPDATE tank  SET requestedVol ='".($row["requestedVol"]+$volume)."' WHERE id = '".$tank_id."' ";
					if ($conn->query($sqlqry) === TRUE) {
						//echo "Record updated successfully";
					} else {
						//echo "Error updating record: " . $conn->error;
					}
					
			}else{
				//echo "IS NOT ENOUGH";
			}
			
		}
	}
	$conn->close();

}
function update_current_usage($id){
	$conn = new mysqli("localhost","root","", "agrolanka");
	$sql="UPDATE canal SET volume = '3' WHERE `canal`.`id` = '".$id."';";
	if ($conn->query($sql) === TRUE) {
		//echo "Record updated successfully";
	} else {
		//echo "Error updating record: " . $conn->error;
	}
	$conn->close();
}
$sql="SELECT * from canelnet where outflow='".$canalid."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	$inflow;
	while($row = $result->fetch_assoc()) {
		$inflow=$row['inflow'];
		//echo $row['inflow'];
		$GLOBALS['stack']->push($_GET['id']);
		$GLOBALS['stack']->push($row['inflow']);
		 treeview($inflow);
	}
$stack=$GLOBALS['stack'];
$n=count($stack);

$data;// = array();

	 $d;
	 $d[0]["children"]= array(
        "build" => "1.0",
        "name" => "xgggg",
        "version" => "1.0",
		
     );
$data["nodestructure"]=array(
        "build" => "1.0",
        "name" => "xxxxxx",
        "version" => "1.0",
		
     );
	 $data["nodestructure"]["chil"][]="v";
	 $data["nodestructure"]["chil"][]=$d[0]["children"];
$data["children"][]= array(
        "build" => "1.0",
        "name" => "xgggg",
        "version" => "1.0",
		
     );
//$data["nodestructure"]=	$data["children"]; 
$data[1]["custome"][]=$data["children"];
$data_str["d"]["nm"]=$data[1];
for($i=2;$i<$n;$i++){
$data[$i]["id"]="$i";
$data[$i]["name"]="name";
//print("<br>".$stack->pop());
}
$json = json_encode($data);
echo $json;

$str=json_decode($json,true);
print_r ($str["children"]);
}
	
?>