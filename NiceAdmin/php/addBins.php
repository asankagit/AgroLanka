<?php 
session_start();

	include "conn.php";
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$sql = "INSERT INTO bin (bintype,max_vol,bin_load,user_id,location)
		VALUES ('".$_POST["category"]."', '".$_POST["mv"]."', 0,'".$_SESSION["user_id"]."','".$_POST["location"]."')";

		if ($conn->query($sql) === TRUE) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

	$conn->close();
?>
<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css" />
    
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/font-style.css" rel="stylesheet">
    <link href="../css/register.css" rel="stylesheet">

	<script type="text/javascript" src="../js/jquery.js"></script>    
    <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../js/bootstrap.js"></script>
	
</head>
<body style='padding:0px;'>

		<div class="navbar-collapse collapse" style="background-color:black">
            <ul class="nav navbar-nav">
              <li class="active"><a href="../index.php"><i class="icon-home icon-white"></i> Home</a></li>                            
              <li><a href="../tables.php"><i class="icon-th icon-white"></i> Tables</a></li>
              <li><a href="../login.php"><i class="icon-lock icon-white"></i> Login</a></li>
              <li><a href="../user.html"><i class="icon-user icon-white"></i> User</a></li>

            </ul>
        </div>
		
		<div class="col-sm-2 col-lg-2"></div>	
		  
	<div class="col-sm-8 col-lg-8">
        		<div id="register-wraper">
        		    <form id="register-form" class="form" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
        		        <legend>Add Bins</legend>
        		    
        		        <div class="">
        		        	<!-- first name -->
    		        		
    		        		<select name='category' style='width: 320px;height:34px;margin-left:-30px;'>
								<option value='none'>Choose Category</option>
								<option value='paper'>paper</option>
								<option value='glass'>glass</option>
								<option value='plastic'>plastic | polythene</option>
							</select>
							
        		        	<br/>
        		        	<br/>
    		        		<label for="mv"></label>
    		        		<input name="mv" class="input-huge" type="text" placeholder='Max Volume'>
        		        	<br/>
        		        	<label></label>
        		        	<input name="location" class="input-huge" type="text" placeholder='Location'>
        		        
        		        	<input  name="uname"class="input-huge" type="hidden" value='<?php $_SESSION['user']?>'>
        		        

        		        </div>
        		    
        		        <div class="footer">
        		           
        		            <input type="submit" style='width: 320px;height: 34px;margin-left: -33px;' value="Register">
        		        </div>
        		    </form>
        		</div>
        	</div>
			
		<div class="col-sm-12 col-lg-12"></div>
			<div id="footerwrap" style="background-image:url(../images/footer-image.1png)">
			
      	<footer class="clearfix"></footer>
      	<div class="container">
      		<div class="row">
      			<div class="col-sm-12 col-lg-12">
      			<p><img src="../images/footer-image.png" alt=""></p>
      			<p>Bazura - Copyright 2017</p>
      			</div>

      		</div><!-- /row -->
      	</div><!-- /container -->		
	</div>

</body>
</html>

