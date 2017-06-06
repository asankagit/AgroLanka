<?php
include "conn.php";

$sql = "SELECT * FROM `users_biddablebins` where bindid='".$_GET["id"]."'";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							//echo $row["name"]."<BR>";
							$data[] = array(
								'amt'=> $row['bidAmount'],   
								'date'=> $row['date']
								);
						}
						$json = json_encode($data);
						echo $json;	
					} else {
						echo "0 results";
					}
					
					$conn->close();

?>
