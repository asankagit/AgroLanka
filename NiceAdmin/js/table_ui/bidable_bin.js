function myScript(){
	alert("hi");
	if(document.getElementById("onp").checked == true){
	alert('if block');
	}
	else{
	alert('else block checked'+document.getElementById("onp").checked);
	alert('else block vlaue '+document.getElementById("onp").checked);
	}
}
function send_data_canalTreeView(cid,cubicmeters){
	alert("inside-------"+cid+""+cubicmeters);
	$.ajax({  
			type: 'GET',  
			url: 'php/canalTreeView.php?id='+cid+'&reqvol='+cubicmeters+'', 
			data: {id:cid,reqvol:cubicmeters},
			success: function(response) {
				//content.html(response);
				//document.write(response);
				//jsParse(response);
				//showRSS(response);
				//var str= JSON.parse(response);
				document.write(response);
				
			}
	
		});
		
}
//url: 'php/addto_sess_fileds.php', 
function addto_sess(pf_id,u_id,status,acres){
	
		$.ajax({  
			type: 'POST',  
			url: 'php/addto_sess_fileds.php', 
			data: {field:pf_id,user:u_id},
			success: function(response) {
				//alert(response);
				//content.html(response);
				//document.write(response);
				//jsParse(response);
				//showRSS(response);
				//document.write(response);
				
				
			}
	
		});
	if(status<1){
		alert("clicked:"+acres);
		request_water(pf_id,acres);
		//var endDate = window.prompt("Bid Ends On:");
		//alert(">>"+endDate);
	}else{
		//alert("not-clicked");
	}
}
function request_water(id,area){
var str;
	$.ajax({  
			type: 'GET',  
			url: 'php/geomatry.php?field_id='+id+'&vol_acres='+area+'', 
			data: {field_id:id,vol_acres:area},
			success: function(response) {
				
				//content.html(response);
				//document.write(response);
				//jsParse(response);
				//showRSS(response);
				str= JSON.parse(response);
				//send_data_canalTreeView(str[0].id,str[0].cubicmeters);
				//document.write(str[0].id+":"+str[0].cubicmeters);
				send_data_canalTreeView(str[0].id,str[0].cubicmeters);
			}
	
		});
	
}

	
	