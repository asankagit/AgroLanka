<?php

include "conn.php";
$bin=$_GET["binid"];
$user=$_GET["userid"];
//get bid winner and related info
				$sql_maxbid="SELECT * FROM users_biddablebins where bindid=".$bin." AND userid=".$user." AND bidAmount in (select max(bidamount) from users_biddablebins)";
				$result = $conn->query($sql_maxbid);
				$row =$result->fetch_array();
				echo $row["userId"];
				//end of get bid winner and related info
				//$winnerQuery = "INSERT INTO bidwin (userid,binid,amount) values('".$result['userId']."','".$bin."','".$result['bidAmount']."'); ";
				$winnerQuery = "INSERT INTO bidwin (userid,binid,amount) values('".$row['userId']."','".$bin."','".$row['bidAmount']."'); ";
				
?>
<html>
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css" />
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="../index.php"><i class="icon-home icon-white"></i> Home</a></li>              
              <li class="active"><a href="../tables.html"><i class="icon-th icon-white"></i> Tables</a></li>
              <li><a href="../login.php"><i class="icon-lock icon-white"></i> Logout</a></li>
              <li><a href="../user.html"><i class="icon-user icon-white"></i> User</a></li>

            </ul>
          </div>
	<div class="row">
		<div class="col-sm-3"></div>
		<div class="col-sm-6">
			<h1> the Winner is <?php echo $row["userid"];?></h1>
			<button class="btn btn-success">Issue bin</button>
			<br/><br/>
			<p><img src="#"></p>
		</div>
		<div class="col-sm-3"></div>
	</div>
</html>