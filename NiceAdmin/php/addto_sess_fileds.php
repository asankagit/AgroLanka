<?php 
session_start();
//add bins as biddable;
$user_id=$_POST["user"];
$field=$_POST["field"];



include "conn.php";
	$sqlTestIfBid = "SELECT * FROM paddyfield WHERE farmerid='".$user_id."' AND id='".$field."'";	
	$resultTestIfBid = $conn->query($sqlTestIfBid);	
	$record = $resultTestIfBid ->fetch_array();
	
	$status=0;
	if($record['status']>0){
		$status=0;
	}else{
		$status=1;
	}
	
		$sql = "UPDATE paddyfield SET status=".$status." WHERE id='".$field."'";

		if ($conn->query($sql) === TRUE) {
			echo "<scrtpit>alert('success')</scrtpit>";
		} else {
			echo "<scrtpit>alert('".$conn->error."')</scrtpit>";
		}
	

	$conn->close(); 

?>