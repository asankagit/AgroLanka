<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Deleting a vertex</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      .delete-menu {
        position: absolute;
        background: white;
        padding: 3px;
        color: #666;
        font-weight: bold;
        border: 1px solid #999;
        font-family: sans-serif;
        font-size: 12px;
        box-shadow: 1px 3px 3px rgba(0, 0, 0, .3);
        margin-top: -10px;
        margin-left: 10px;
        cursor: pointer;
      }
      .delete-menu:hover {
        background: #eee;
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKpX0gxp3zc2E6bLCqVbYbXInBhx5jVVk"></script>
    <script>
      function initialize() {
        var mapOptions = {
          zoom: 3,
          center: new google.maps.LatLng(0, -180),
          mapTypeId: 'terrain'
        };

        var map = new google.maps.Map(document.getElementById('map'), mapOptions);

        var flightPlanCoordinates = [
          new google.maps.LatLng(37.772323, -122.214897),
          new google.maps.LatLng(21.291982, -157.821856),
          new google.maps.LatLng(-18.142599, 178.431),
          new google.maps.LatLng(-27.46758, 153.027892)
        ];
        var flightPath = new google.maps.Polyline({
          path: flightPlanCoordinates,
          editable: true,
          strokeColor: '#FF0000',
          strokeOpacity: 1.0,
          strokeWeight: 2,
          map: map
        });

        var deleteMenu = new DeleteMenu();
/*may add:http://stackoverflow.com/questions/15693077/event-handler-for-editing-a-google-maps-polyline*/
google.maps.event.addListener(flightPath, "dragend", getPath);
function getPath() {
	window.alert("draged");
  var path = flightPath.getPath();
  var len = path.getLength();
  var coordStr = "";
  for (var i = 0; i < len; i++) {
    coordStr += path.getAt(i).toUrlValue(6) + "<br>";
  }
  
  document.getElementById('path').innerHTML = coordStr;
  alert("drag");
}

        google.maps.event.addListener(flightPath, 'rightclick', function(e) {
          // Check if click was on a vertex control point
		  window.alert("");
          if (e.vertex == undefined) {
            return;
          }
          deleteMenu.open(map, flightPath.getPath(), e.vertex);
        });
      }

      /**
       * A menu that lets a user delete a selected vertex of a path.
       * @constructor
       */
      function DeleteMenu() {
        this.div_ = document.createElement('div');
        this.div_.className = 'delete-menu';
        this.div_.innerHTML = 'Delete';

        var menu = this;
        google.maps.event.addDomListener(this.div_, 'click', function() {
		window.alert("clcik");
          menu.removeVertex();
        });
      }
      DeleteMenu.prototype = new google.maps.OverlayView();

      DeleteMenu.prototype.onAdd = function() {
        var deleteMenu = this;
        var map = this.getMap();
        this.getPanes().floatPane.appendChild(this.div_);

        // mousedown anywhere on the map except on the menu div will close the
        // menu.
        this.divListener_ = google.maps.event.addDomListener(map.getDiv(), 'mousedown', function(e) {
          if (e.target != deleteMenu.div_) {
            deleteMenu.close();
          }
        }, true);
      };

      DeleteMenu.prototype.onRemove = function() {
        google.maps.event.removeListener(this.divListener_);
        this.div_.parentNode.removeChild(this.div_);

        // clean up
        this.set('position');
        this.set('path');
        this.set('vertex');
      };

      DeleteMenu.prototype.close = function() {
        this.setMap(null);
      };

      DeleteMenu.prototype.draw = function() {
	 alert("draw");
        var position = this.get('position');
        var projection = this.getProjection();

        if (!position || !projection) {
          return;
        }

        var point = projection.fromLatLngToDivPixel(position);
        this.div_.style.top = point.y + 'px';
        this.div_.style.left = point.x + 'px';
      };

      /**
       * Opens the menu at a vertex of a given path.
       */
      DeleteMenu.prototype.open = function(map, path, vertex) {
	  alert("+++");
	  alert(path.getAt(vertex));
	  
        this.set('position', path.getAt(vertex));
        this.set('path', path);
        this.set('vertex', vertex);
        this.setMap(map);
        this.draw();
      };

      /**
       * Deletes the vertex from the path.
       */
      DeleteMenu.prototype.removeVertex = function() {
	   alert(this.get('vertex'));
        var path = this.get('path');
        var vertex = this.get('vertex');

        if (!path || vertex == undefined) {
          this.close();
          return;
        }

        path.removeAt(vertex);
        this.close();
      };

      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>
  <body>
  	
The simple Polyline example from the documentation modified to add events on changes (insert_at, remove_at, set_at, dragend).

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Google Maps JavaScript API v3 Example: Polyline Simple</title>
    <link href="/maps/documentation/javascript/examples/default.css" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script>
var flightPath = null;

      function initialize() {
        var myLatLng = new google.maps.LatLng(0, -180);
        var mapOptions = {
          zoom: 3,
          center: myLatLng,
          mapTypeId: google.maps.MapTypeId.TERRAIN
        };

        var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

        var flightPlanCoordinates = [
            new google.maps.LatLng(37.772323, -122.214897),
            new google.maps.LatLng(21.291982, -157.821856),
            new google.maps.LatLng(-18.142599, 178.431),
            new google.maps.LatLng(-27.46758, 153.027892)
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
   }
   document.getElementById('path').innerHTML = coordStr;
}

    </script>
  </head>
  <body onload="initialize()">
    <div id="map-canvas" style="height:500px; width:600px;"></div>
    <div id="path"></div>
  </body>
</html>
working example

code snippet:

var flightPath = null;

function initialize() {
  var myLatLng = new google.maps.LatLng(0, -180);
  var mapOptions = {
    zoom: 3,
    center: myLatLng,
    mapTypeId: google.maps.MapTypeId.TERRAIN
  };

  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

  var flightPlanCoordinates = [
    new google.maps.LatLng(37.772323, -122.214897),
    new google.maps.LatLng(21.291982, -157.821856),
    new google.maps.LatLng(-18.142599, 178.431),
    new google.maps.LatLng(-27.46758, 153.027892)
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
  for (var i = 0; i < len; i++) {
    coordStr += path.getAt(i).toUrlValue(6) + "<br>";
  }
  document.getElementById('path').innerHTML = coordStr;
}
google.maps.event.addDomListener(window, 'load', initialize);
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKpX0gxp3zc2E6bLCqVbYbXInBhx5jVVk"></script>
    <div id="map"></div>
	<div id="path"></div>
  </body>
</html>