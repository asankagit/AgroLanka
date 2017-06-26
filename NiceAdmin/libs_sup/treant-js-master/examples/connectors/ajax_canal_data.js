
function canal_data(id,callback){
	
	//
var result;
$.ajax({  
			type: 'GET',  
			url: 'canalData.php?id=b89', 
			data: {id:id},
			success: function(response) {
				//content.html(response);
				//document.write(response);
				//jsParse(response);
				//showRSS(response);
				//var str= JSON.parse(response);
				//document.write(response);
				callback(response);
			}
	
		});

}