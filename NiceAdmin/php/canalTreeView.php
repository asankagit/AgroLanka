<?php 
include 'Splstack.php';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agrolanka";


$canalid=$_GET['id'];
$req_vol=$_GET['reqvol'];
$req_speed=$req_vol/(2*30*24*60);//m3per munite

//echo"<script>alert('inside phptree ');</script>";

$stack = new Splstack();
$canal_list=new Splstack();
$final_result=0;//water can be issued or not
//$canal_list->push($canalid);

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
			$GLOBALS['stack']->push($row['inflow']."volume".$row['volume']);
						//echo "<script> alert('came line 50"."".$GLOBALS['req_speed']."id".$row['inflow']."vol-cusage".($row['volume']-$row['currentUsage'])."');</script>";
			
			//check canal's max speed to new request;
			if($GLOBALS['req_speed']<($row['volume']-$row['currentUsage'])){						
						//update_current_usage($row['inflow'],$row['currentUsage']);
						$canal= new Canal();
						$canal->setId($row['inflow']);
						$canal->setUsage($row['currentUsage']);
						$GLOBALS['canal_list']->push($canal);
			}else{
			//water cannot be issued because of canal volume is not enough;
			$GLOBALS['final_result']--;
			echo "<br>line 49 no water incanals".$row['id'];
			}
			
			
			
			if($row['tankID']==""){
				treeview($row['inflow']);
				//keep loop continue till tank/root found;
			}else{
				//check wheather water available in tanks ;
				tankDetails($row['tankID'],$GLOBALS['req_vol']);
				$GLOBALS['stack']->push($row['tankID']);
				$GLOBALS['stack']->push('root');
				
			}
		}
		update_current_usage();
		
		
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
				//check water is availbales for issuing from tank;
				$GLOBALS['final_result']++;
				
				$sqlqry="UPDATE tank  SET requestedVol ='".($row["requestedVol"]+$volume)."' WHERE id = '".$tank_id."' ";
					if ($conn->query($sqlqry) === TRUE) {
						//echo "Record updated successfully";
					} else {
						//echo "Error updating record: " . $conn->error;
					}
					
			}else{
				echo "<br>water IS NOT ENOUGH";
				$GLOBALS['final_result']--;
			}
			
		}
	}
	$conn->close();

}
function update_current_usage(/*$id,$current_usage*/){
	if($GLOBALS['final_result']>0){
		$stack=$GLOBALS['canal_list'];
		$n=count($stack);
		for($i=0;$i<$n;$i++){
			$canal =$stack->pop();
			$inner_conn = new mysqli("localhost","root","", "agrolanka");
			$sql="UPDATE canal SET currentUsage = '".($canal->getUsage()+$GLOBALS["req_speed"])."' WHERE `canal`.`id` = '".$canal->getId()."';";
			if ($inner_conn->query($sql) === TRUE) {
				//echo "Record updated successfully";
			} else {
				echo "Error updating record: " . $conn->error;
			}
		}
	}
		//$conn->close();
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
		 treeview($canalid);//treeview($inflow);
	}
$stack=$GLOBALS['stack'];
$n=count($stack);
for($i=0;$i<$n;$i++){
//print("<br>stack:".$stack->pop());
}

}


echo $GLOBALS['final_result'];
//-------------------------------------------------
class Canal {
      var $id;
      var $current;
      function setId($par){
         $this->id = $par;
      }
      function getId(){
        return $this->id;
      }
      
      function setUsage($par){
         $this->current = $par;
      }
      
      function getUsage(){
         return $this->current;
      }
   }	
?>