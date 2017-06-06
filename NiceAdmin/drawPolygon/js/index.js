var pol_mdl;
function initialize() {
  // Map Center
  var myLatLng = new google.maps.LatLng(33.5190755, -111.9253654);
  // General Options
  var mapOptions = {
    zoom: 12,
    center: myLatLng,
    mapTypeId: google.maps.MapTypeId.RoadMap
  };
  var map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
  // Polygon Coordinates
  var triangleCoords = [
    new google.maps.LatLng(33.5362475, -112.9267386),
    new google.maps.LatLng(33.5104882, -112.9627875),
    new google.maps.LatLng(34.5004686, -112.9027061),
	new google.maps.LatLng(34.5004686, -112.9027061)
  ];
  var triangleCoords2 = [
    new google.maps.LatLng(33.6362475, -111.9267386),
    new google.maps.LatLng(33.6104882, -111.9627875),
    new google.maps.LatLng(33.6004686, -111.9027061),
	new google.maps.LatLng(33.6004896, -111.9027061)
  ];
  // Styling & Controls
  myPolygon = new google.maps.Polygon({
    paths: triangleCoords,
    draggable: true, // turn off if it gets annoying
    editable: true,
    strokeColor: '#FF0000',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#80ff78',
    fillOpacity: 0.35
  });
 myPolygon2 = new google.maps.Polygon({
    paths: triangleCoords2,
    draggable: true, // turn off if it gets annoying
    editable: true,
    strokeColor: '#FF0000',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#FF0000',
    fillOpacity: 0.35
  });
	

  myPolygon.setMap(map);
  myPolygon2.setMap(map);

google.maps.event.addListener(myPolygon, "dragend", getPolygonCoords);
  google.maps.event.addListener(myPolygon.getPath(), "insert_at", getPolygonCoords);
  //google.maps.event.addListener(myPolygon.getPath(), "remove_at", getPolygonCoords);
  google.maps.event.addListener(myPolygon.getPath(), "set_at", getPolygonCoords);
    
	pol_mdl=myPolygon;
	return pol_mdl;
}
	
	

//Display Coordinates below map
function getPolygonCoords() {
  var len = myPolygon.getPath().getLength();
  var htmlStr = "";
  for (var i = 0; i < len; i++) {
	alert(myPolygon.getPath().getAt(i).toUrlValue(5));
	alert(typeof(myPolygon.getPath().getAt(i)));
	
    htmlStr += "new google.maps.LatLng(" + myPolygon.getPath().getAt(i).toUrlValue(5) + "), ";
    //Use this one instead if you want to get rid of the wrap > new google.maps.LatLng(),
    //htmlStr += "" + myPolygon.getPath().getAt(i).toUrlValue(5);
  }
  document.getElementById('info').innerHTML = htmlStr;
}
function copyToClipboard(text) {
  window.prompt("Copy to clipboard: Ctrl+C, Enter", text);
}
function polygonPath(callback) {
	
	callback("k");
  //return myPolygon.getPath().getAt(i).toUrlValue(5);
}
	

