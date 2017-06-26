<!doctype html>

<?php 
session_start();
if($_SESSION["user_id"]==""){
	echo "".$_SESSION["user_id"];
	header('Location: http://localhost/Agrolanka/NiceAdmin/login.html');
}
include "php/conn.php";


function getmax($bin,$user){
	require 'php/conn.php';
	$max_bid=0;
	$sql_maxbid="SELECT * FROM users_biddablebins where bindid=".$bin." AND userid=".$user." AND bidAmount in (select max(bidamount) from users_biddablebins)";
	$result = $conn->query($sql_maxbid);

						if ($result->num_rows > 0) {
							// output data of each row
							
							while($row = $result->fetch_assoc()) {
								$max_bid=$row["bidAmount"];
								
							}
						} else {
							//echo "Not Yet Bidded!";
						}
						return $max_bid;
	}
?>

<html><head>
    <meta charset="utf-8">
    <title>Bazura</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />

    <!-- DATA TABLE CSS -->
    <link href="css/table.css" rel="stylesheet">
	<link href="css/btn_toggle.css" rel="stylesheet">

    <script type="text/javascript" src="js/jquery.js"></script>    
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

    <!--script type="text/javascript" src="js/admin.js"></script-->
	<script type="text/javascript" src="js/table_ui/bidable_bin.js"></script>
	<script type="text/javascript" src="js/Chart.js"></script>

    <style type="text/css">
      body {
        padding-top: 60px;
      }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
        
  	<!-- Google Fonts call. Font Used Open Sans -->
  	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">

  	<!-- DataTables Initialization -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script type="text/javascript" src="js/datatables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="js/table_ui/hide_show_div.js"></script>
	<script type="text/javascript" src="js/table_ui/ajax_snd_to_php.js"></script>
	<script type="text/javascript" src="js/table_ui/session_on_off.js"></script>
	<script type="text/javascript" src="js/table_ui/bidable_bin.js"></script>
  			<script type="text/javascript" charset="utf-8">
  			    $(document).ready(function () {
  			        $('#dt1').dataTable();
  			    });
	</script>

    
  </head>
  <body>
  
  	<!-- NAVIGATION MENU -->

    <div class="navbar-nav navbar-inverse navbar-fixed-top">
        <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><img src="images/logo30.png" alt=""> ArgoLanka</a>
        </div> 
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="index.php"><i class="icon-home icon-white"></i> Home</a></li>              
              <li class="active"><a href="tables.html"><i class="icon-th icon-white"></i> Tables</a></li>
              <li><a href="login.php"><i class="icon-lock icon-white"></i> Login</a></li>
              <li><a href="user.html"><i class="icon-user icon-white"></i> User</a></li>

            </ul>
          </div><!--/.nav-collapse -->
        </div>
    </div>

    <div class="container">

      <!-- CONTENT -->
	<div class="row">
		<div class="col-sm-12 col-lg-12">
			<h4><strong>Your Fileds</strong></h4>
			  <table class="display">
	          <thead>
	            <tr>
	              <th> ID</th>
				  <th>Filed name</th>
	              <th>Gramaseva Division</th>
				  <th>Current Volume</th>
	              <th>Crop Variation</th>
				   <th>Cultivation</th>
				  
				 
	            </tr>
	          </thead>
	          <tbody>
	            
				<?php 
					$ifChecked ='';
					$staus=0;
					$sql = "SELECT * FROM paddyfield where farmerid='".$_SESSION["user_id"]."'";
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {
						// output data of each row
						$n=0;
						while($row = $result->fetch_assoc()) {
							//getting the intial toggle
							
							/*$sqlTestIfBid = "SELECT * FROM paddyfield WHERE farmerid='".$row["bin_id"]."'";	
							$resultTestIfBid = $conn->query($sqlTestIfBid);	
							$record = $resultTestIfBid ->fetch_array();
							
							*/
							if($row['status']>0){
								$ifChecked ='checked';
								$staus=1;
							}else{
								$ifChecked ='';
								$staus=0;
							}
							
							//End of getting the intial toggle
							//$bid=getmax($row["bin_id"],$_SESSION["user_id"]);
							
							print '
								<tr id="'.$row["id"].'" onclick="showchart(this.id);">
								  <td>'.$row["id"].'</td>
								  <td>'.$row["name"].'</td>
								  <td>'.$row["gramaseva_div"].'</td>
								 
								  <td class="center">'.$row["acres"].'</td>
								 
								  <td>See Crop Variation &nbsp &nbsp <a href="php/displayWinner.php?binid='.$row["id"].'&userid='.$_SESSION["user_id"].'"><span class="glyphicon glyphicon-triangle-right"></a></td>
								  <td> <label class="switch">'.
									  "<input id='sw' ".$ifChecked."  type=\"checkbox\" onclick=\"addto_sess(".$row["id"].",'".$_SESSION["user_id"]."',".$staus.",".$row["acres"].")\"> ".
									  '<div class="slider round"></div>
									</label>
								  </td>
								  
								  
								</tr>
								';
								$n++;
						}
					} else {
						echo "0 results";
					}
					$conn->close();
				
				
				?>
	            
	            
	          </tbody>
	         </table><!--/END First Table -->
			 <br>
			 <div class="btn btn-success" id="form_sh_addnew_pf" onclick="display()">Add New Paddy Fields</div>
			 <br>
			 <!--SECOND Table -->


		

		
	
		</div><!--/span12 -->
      </div><!-- /row -->
	  <div class="row col-sm-2" > </div>
	  <div class="row col-sm-10" align="center" > 
		<div class="panel-body text-center" style="display:none;background-color:lavender">
			<h2>Anual Water levels</h2>
           <canvas id="canvas" style="" id="line" height="200" width="550"></canvas>
		   <script>
		   
		   
		   function showchart(binid){
		   var amount=[1,0,0];
					$.ajax({  
					type: 'GET',  
					url: 'php/drawChart.php?id='+binid, 
					data: {id:binid},
					success: function(response) {
						
						
						var str= JSON.parse(response);
						
						for(var i=0;i<str.length;i++){
							amount[i]=str[i].amt;
							
						}
						//chart_draw(date);
						//amount=str[0].amt;
						//date=str[0].date;
						
						
					}
				});
				chart_draw(amount);
		   }
		   function chart_draw(arr){
		   
		   		var lineChartData = {
			labels : ["January","February","March","April","May","June","July"],
			datasets : [
				{
					fillColor : "rgba(220,220,220,0.5)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(220,220,220,1)",
					pointStrokeColor : "#fff",
					data : arr
					
				},
				{
					fillColor : "rgba(151,187,205,0.5)",
					strokeColor : "rgba(151,187,205,1)",
					pointColor : "rgba(151,187,205,1)",
					pointStrokeColor : "#fff",
					data : arr
				}
			]
			
		}

		var myLine = new Chart(document.getElementById("canvas").getContext("2d")).Line(lineChartData);
		}
	</script>
        </div>
	  </div>
	  <div class="form-group add-new-field" id="div_new_pf_add">
	  <br>
		<form  id="frm_new_pf">
			<tr>
			<label for="fieldname" class="col-sm-2" >Field</label>
			<label for="a" class="col-sm-1">Volume</label>
			<label for="l" class="col-sm-2">Location</label>
			<label for="gd" class="col-sm-2">Gramaseva Divsion</label><br>
			</tr>
			<br>
			<input id="txt_pf_name" type="fieldname" class="form-control-col-sm-2" id="email" placeholder="කුඹුරේ නම">
			<input id="txt_pf_area" type="a" class="form-control-col-sm-2" id="email" placeholder="අක්කර ප්රමාණය">
			<input id="txt_pf_gps" type="l" class="form-control-col-sm-2" id="email" placeholder="භූ පිහිටුම">
			<input id="txt_pf_grama" type="gd" class="form-control-col-sm-2" id="email" placeholder="ග්රාමසේවා කොට්ඨාශය">
			
			<br><br><input type="button" value="add" class="btn btn-red" id="btn_add_new_paddyfld" onclick="new_pf_to_DB()">
		
		</form>
	  </div>
	  <!--div class="row" align="center"> 
	  <br/>
	  
		<a href="pathFinder/PathBucket.html"><button class="btn btn-success">View Map</button></a>
	  </div-->
     </div> <!-- /container -->
    	

      	<!-- /container -->
      	<br>
	
</body></html>