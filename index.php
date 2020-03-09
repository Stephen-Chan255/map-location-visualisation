<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Places Search Box</title>
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
      #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }
      #target {
        width: 345px;
      }
    </style>
  </head>
  
  <body>
   <div id="map"></div>
 
    <?php
    $locations = $_POST["addr"]; // $locations is an array

    foreach ($locations as $location) {
        
        // construct the url for geocoding request
        $output_format = "json";
        $location = str_replace(' ', '+', $location);        
        $params = "address=$location&key=AIzaSyD4wXyYFhTs8ds_Ppa4jWL3HQEhWRu_Yao";
        $url = "https://maps.googleapis.com/maps/api/geocode/$output_format?$params";

        // get the json obj from the url 
        $json = file_get_contents($url);
        // echo $json . '<br>';

        // parse the json into an assoc array (2nd param: assoc = true)
        $json = json_decode($json, true);
        // print_r($json);

        $location_cord = $json['results'][0]["geometry"]['location'];
        $lat = $location_cord['lat'];
        $lng = $location_cord['lng'];
        $cords[$location] = ["lat" => $lat, "lng" =>$lng];
    }

    // print_r($cords);

    // encode back to pass to js
    $json = json_encode($cords);
    // echo $json;

    echo "<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyD4wXyYFhTs8ds_Ppa4jWL3HQEhWRu_Yao&callback=initMap'
    async defer></script>

      <script type='text/javascript'> 
        function initMap() {

          // 1. init the map centered at Uluru
          // (https://developers.google.com/maps/documentation/javascript/adding-a-google-map)
          var uluru = {lat: -25.344, lng: 131.036};
          var map = new google.maps.Map(document.getElementById('map'), {zoom: 4, center: uluru});

          // 2. put markers on the map
          
          // set ordered labels
          // (https://developers.google.com/maps/documentation/javascript/markers)
          var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
          var labelIndex = 0;

          // extra latLng from json
          console.log('json');    
          console.log($json);

          var positions = [];
          for (var obj in ".$json.") {
            var position = {lat: ".$json."[obj]['lat'], lng: ".$json."[obj]['lng']};
            console.log('position')    
            console.log(position);
            
            // put the marker on the map with ordered label
            var marker = new google.maps.Marker({
                map: map,
                position: position,
                label: labels[labelIndex++ % labels.length],
            });
            positions.push(position);
          } 
          
          // 3. draw the polyline between multiple positions
          // (https://developers-dot-devsite-v2-prod.appspot.com/maps/documentation/javascript/examples/polyline-simple)
          var path = new google.maps.Polyline({
            path: positions,
            geodesic: true,
            strokeColor: '#FF0000',
            strokeOpacity: 1.0,
            strokeWeight: 2
          });
          path.setMap(map);
        }
        </script>";
    ?>
  </body>
</html>
