alert("bidablebins");
//myScript();

function myScript(){
	if(document.getElementById("onp").checked == true){
	alert('if block');
	}
	else{
	alert('else block checked'+document.getElementById("onp").checked);
	alert('else block vlaue '+document.getElementById("onp").checked);
	}
}
function addto_sess(paddyfield_id,user_id){
	
	alert(paddyfield_id);
	
	
	if(document.getElementById("sw").checked){
		var endDate = window.prompt("Bid Ends On:");
		//alert(">>"+endDate);
	}
		var res;
		
		$.ajax({  
		type: 'POST',  
		url: 'php/addto_sess_fileds.php', 
		data: {field:paddyfield_id, user:user_id},
		success: function(response) {
			
			alert(response);
			/*var str= JSON.parse(response);
			
			cur_level=str[0].curr_volume;
			max_vol=str[0].max_vol;
			bin_load=str[0].load;*/
			
		}
	});
	return res;
}
	
	