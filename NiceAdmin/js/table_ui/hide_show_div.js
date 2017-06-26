
var btn_add=document.getElementById("form_sh_addnew_pf");
btn_add.addEventListener("click",display); 
function display() {
	
    var x = document.getElementById('frm_new_pf');
    if (x.style.display === 'none') {
        x.style.display = 'block';
    } else {
        x.style.display = 'none';
    }
} 