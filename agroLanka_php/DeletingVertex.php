
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Google Maps JavaScript API v3 Example: Polyline Simple</title>
    <link href="/maps/documentation/javascript/examples/default.css" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
	
	<script src="josnCreate.js"></script>
	<script src="https://www.google.com/jsapi"></script>
	<script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKpX0gxp3zc2E6bLCqVbYbXInBhx5jVVk&callback=elevation">
    </script>
    <script>
	/*async defer*/
var flightPath = null;
var json_path=[];
      function initialize() {
        var myLatLng = new google.maps.LatLng(7.665464, 81.192763);
        var mapOptions = {
          zoom: 15,
          center: myLatLng,
          mapTypeId: google.maps.MapTypeId.TERRAIN
        };

        var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

        var flightPlanCoordinates = [
            new google.maps.LatLng(7.659839, 81.196465),
            new google.maps.LatLng(7.662306, 81.194748),
            new google.maps.LatLng(7.664496, 81.193407),
            new google.maps.LatLng(7.665464, 81.192763)
        ];
        flightPath = new google.maps.Polyline({
          path: flightPlanCoordinates,
          strokeColor: '#FF0000',
          strokeOpacity: 1.0,
          strokeWeight: 2,
          editable: true,
          draggable: true
        });
        google.maps.event.addListener(flightPath, "dragend", getPath);
        google.maps.event.addListener(flightPath.getPath(), "insert_at", getPath);
        google.maps.event.addListener(flightPath.getPath(), "remove_at", getPath);
        google.maps.event.addListener(flightPath.getPath(), "set_at", getPath);
        flightPath.setMap(map);
      }

function getPath() {
   var path = flightPath.getPath();
   var len = path.getLength();
   var coordStr = "";
   for (var i=0; i<len; i++) {
     coordStr += path.getAt(i).toUrlValue(6)+"<br>";
	 jsonPath(path.getAt(i).toUrlValue(6));
   }
   document.getElementById('path').innerHTML = coordStr;
   //check(json_path);
  
	var elevationPath=new elevation();
	//elevationPath.initMap();
	elevationPath.check(json_path);
	//elevationPath.initMap();
   
	alert(json_path[0].lng+":"+json_path[0].lat);
		
	 
}

function jsonPath(point){
var str=point.split(",");
var latv=str[0];
var lngv=str[1];

json_path.push({lat:latv,lng:lngv});

}




    </script>
  </head>
  <body onload="initialize()">
    <div id="map-canvas" style="height:500px; width:600px;"></div>
    <div id="path"></div>
	<div id="map2">ii</div>
	<div id="elevation_chart"></div>
  </body>
</html>

