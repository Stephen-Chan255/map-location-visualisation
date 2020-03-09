<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <meta charset="utf-8">
  <link rel="stylesheet" href="style/index.css">
  <title>Map Location Visualisation</title>
</head>
<body>
  <div class="content">
    <h3>Address processor</h3>
    <form action="map.php" method="POST">
      <div id="addr">
        <input type="text" id="pac-input_0" name="addr[]" placeholder="Input Address" class="form-control">
      </div>
  
      <div class="btns">
        <div class="text-btn-row">
          <input type="button" onclick="addInput()" value="Add more">
          <input type="button" onclick="removeInput()" value="Remove last one">
        </div>
        <input type="submit" value="Submit">
      </div>
    </form>
  </div>

  <!--Load the API from the specified URL
  * The async attribute: allows the browser to render the page while the API loads
  * The callback parameter executes the initMap() function
  -->
  <script 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4wXyYFhTs8ds_Ppa4jWL3HQEhWRu_Yao&libraries=places&callback=initAutocomplete"
    async defer>
  </script>

  <script>
    var index = 0;

    function addInput() {
      $(document).ready(function(){
        index++;
        var newInput = '<input id=\"pac-input_' + index + '\" type=\"text\" placeholder=\"Input Address\" name=\"addr[]\" class=\"form-control mt-3\">\n'
        $("#addr").append(newInput);
        initAutocomplete();
      });  
    }

    function removeInput() {
      $(document).ready(function(){
        var address = $("#addr");
        if (address.children().length > 1) {
            address.children("input:last").remove();
        }
        index--;
        initAutocomplete();
      });
    }

    function initAutocomplete() {
      console.log(index);
      for (var i = 0; i <= index; i++) {
        console.log('pac-input_'+ i);
        var input = document.getElementById('pac-input_'+ i);
        new google.maps.places.SearchBox(input);
      }
    }
  </script>
  
  <!-- jQuery -->
  <script 
    src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous">
  </script>
</body>
</html>