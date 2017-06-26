//add new paddy fileds;
function new_pf_to_DB(){
	alert("ajax called new pf");
	var field_name=document.getElementById("txt_pf_name").value;
	var volume=document.getElementById("txt_pf_area").value;
	var location=document.getElementById("txt_pf_gps").value;
	var grama_div=document.getElementById("txt_pf_grama").value;
	
	
	$.ajax({  
    type: 'POST',  
    url: 'php/table_ui/addpaddyfiled.php', 
    data: { name:field_name,acres:volume,loc:location ,grama:grama_div},
    success: function(response) {
        //content.html(response);
		//document.write(response);
		//jsParse(response);
		//showRSS(response);
		//document.write(response);
		
		
    }
});

}