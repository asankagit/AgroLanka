function person(firstName,lastName,age,eyeColor) {
    this.firstName = firstName;
    this.lastName = lastName;
    this.age = age;
    this.eyeColor = eyeColor;
    this.changeName = function (name) {
        this.lastName = name;
    }
}
function bus(){
	this.name="oop_name";
	this.check=function(path){
		alert("inside test bus:"+path[1].lng);
		return "bus return";
	}
}
function JsonReq(){
	this.jsonData="null data";
	this.xmlhttp = new XMLHttpRequest();
	this.url = "json.txt";

	this.xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				alert("connected");
				var myArr = JSON.parse(this.responseText);
				
				
				
			}else{
				alert(this.readyState+":"+this.status);
			}
		};
	this.xmlhttp.open("GET", this.url, true);
	this.xmlhttp.send();
	
	
	
	this.getdata=function(){
	alert("getdata_function");
		return this.jsonData;
	};
}

function point_elevation(){

//http://stackoverflow.com/questions/9922101/get-json-data-from-external-url-and-display-it-in-a-div-as-plain-text;
var getJSON = function(url) {
  return new Promise(function(resolve, reject) {
    var xhr = new XMLHttpRequest();
    xhr.open('get', url, true);
    xhr.responseType = 'json';
    xhr.onload = function() {
      var status = xhr.status;
      if (status == 200) {
        resolve(xhr.response);
      } else {
        reject(status);
      }
    };
    xhr.send();
  });
};
//
alert("came insede line 63");
//https://maps.googleapis.com/maps/api/elevation/json?locations=7.659839,%2081.196465&key=AIzaSyBKpX0gxp3zc2E6bLCqVbYbXInBhx5jVVk
this.getJSON('').then(function(data) {
    alert('Your Json result is:  ' + data.result); //you can comment this, i used it to debug

    result.innerText = data.result; //display the result in an HTML element
}, function(status) { //error detection....
  alert('Something went wrong.');
});

}


