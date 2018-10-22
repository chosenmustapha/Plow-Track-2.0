<?php


$damp = file_get_contents("latlong2.txt");

 $fileContent ="
<!DOCTYPE html>
<html>
  <head>
    <meta charset=\"utf-8\">
    <title>Heatmaps</title>
    <style>
    
    .container {
          overflow: hidden;
          background-color: #333;
          font-family: Arial;
      }
  
      .container a {
          float: left;
          font-size: 16px;
          color: white;
          text-align: center;
          padding: 14px 16px;
          text-decoration: none;
      }
  
      .dropdown {
          float: left;
          overflow: hidden;
      }
  
      .dropdown .dropbtn {
          cursor: pointer;
          font-size: 16px;
          border: none;
          outline: none;
          color: white;
          padding: 14px 16px;
          background-color: inherit;
      }
  
      .container a:hover, .dropdown:hover .dropbtn {
          background-color: red;
      }
  
      .dropdown-content {
          display: none;
          position: absolute;
          background-color: #f9f9f9;
          min-width: 160px;
          box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
          z-index: 1;
      }
  
      .dropdown-content a {
          float: none;
          color: black;
          padding: 12px 16px;
          text-decoration: none;
          display: block;
          text-align: left;
      }
  
      .dropdown-content a:hover {
          background-color: #ddd;
      }
  
      .show {
          display: block;
      }
    
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
       #map {
        height: 640px;
        width: 1100px;
        margin-left: 10%;
        padding: 0;
        top: 10px;
         left: 7%;
      }
      /* Optional: Makes the sample page fill the window. */
       html, body {
        
        margin-auto: 0;
        padding: 0;
      }
      
       
#awcc1490053462422 {
               left: 0.5%;
               width: 216px;
               padding: 0;
             position: absolute;
             top: 140px;
               z-index: 5;
              }
#abc{        visibility:visible;
               left: 10px;
               width: 216px;
               padding: 0;
             position: absolute;
             top: 300px;
               z-index: 5;
              }
          
             
    </style>
<META HTTP-EQUIV=\"refresh\" CONTENT=\"300\">
  </head>

  <body
  background=\"http://plowtrackscom.000webhostapp.com/WORLDMMAP.jpg\">


<a href=\"https://www.accuweather.com/en/us/buffalo-ny/14202/weather-forecast/349726\" class=\"aw-widget-legal\">
<!--
By accessing and/or using this code snippet, you agree to AccuWeatherÃÂ¢ÃÂÃÂs terms and conditions (in English) which can be found at https://www.accuweather.com/en/free-weather-widgets/terms and AccuWeatherÃÂ¢ÃÂÃÂs Privacy Statement (in English) which can be found at https://www.accuweather.com/en/privacy.
-->
</a><div id=\"awcc1490053462422\" class=\"aw-widget-current\"  data-locationkey=\"349726\" data-unit=\"f\" data-language=\"en-us\" data-useip=\"false\" data-uid=\"awcc1490053462422\"></div><script type=\"text/javascript\" src=\"https://oap.accuweather.com/launch.js\"></script>



  
  
 

 <h1>Snow Plow tracking Service </h1>

  <div class=\"container\">
       <a href=\"https://plowtrackscom.000webhostapp.com/heatmap.html\">Home</a>
        <a href=\"https://plowtrackscom.000webhostapp.com/weather.html\">Weather Forecast</a>
        <div class=\"dropdown\">
          <button class=\"dropbtn\" onclick=\"myFunction()\">Locate Plow vehicle</button>
          <div class=\"dropdown-content\" id=\"myDropdown\">
            <a href=\"https://plowtrackscom.000webhostapp.com/home.html\">Plow Vehicle Routes</a>
            <a href=\"https://plowtrackscom.000webhostapp.com/currentloc.html\">Plow Vehicle Location</a>
           
          </div>
        </div>
      </div>
   
    <div id=\"map\"></div>

<div id=\"abc\"><img src=\"https://plowtrackscom.000webhostapp.com/key.jpeg\"  style=\"width:100%;height:100%;\">
</div>
    <script>


    /* When the user clicks on the button,
    toggle between hiding and showing the dropdown content */
    function myFunction() {
        document.getElementById(\"myDropdown\").classList.toggle(\"show\");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(e) {
      if (!e.target.matches('.dropbtn')) {
        var myDropdown = document.getElementById(\"myDropdown\");
          if (myDropdown.classList.contains('show')) {
            myDropdown.classList.remove('show');
          }
      }
    }

      // This example requires the Visualization library. Include the libraries=visualization
      // parameter when you first load the API. For example:
      // <script src=\"https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=visualization\">

      var map, heatmap;

      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
           center: {lat: 42.933972, lng: -78.883728},
          mapTypeId: 'terrain'
        });

        heatmap = new google.maps.visualization.HeatmapLayer({
data: getPoints(),
        map: map,
          gradient: gradient,
          radius:radius
        });
      }
var gradient = [
          'rgba(0, 255, 255, 0)',
          'rgba(0, 255, 255, 1)',
          'rgba(0, 191, 255, 1)',
          'rgba(0, 127, 255, 1)',
          'rgba(0, 63, 255, 1)',
          'rgba(0, 0, 255, 1)',
          'rgba(0, 0, 223, 1)',
          'rgba(0, 0, 191, 1)',
          'rgba(0, 0, 159, 1)',
          'rgba(0, 0, 127, 1)',
          'rgba(63, 0, 91, 1)',
          'rgba(127, 0, 63, 1)',
          'rgba(191, 0, 31, 1)',
          'rgba(255, 0, 0, 1)'
        ]
var radius= [20]
     
      
      // Heatmap data: 500 Points
      function getPoints() {
        return [
          {$damp}
 ];
      }
    </script>
    <script async defer
        src=\"https://maps.googleapis.com/maps/api/js?key=AIzaSyBEjeTuBB3q__N03HPbk84bnlwLXYYQMnI&libraries=visualization&callback=initMap\">
    </script>
  </body>
</html>
";


$fileStatus = file_put_contents('heatmap.html',$fileContent);
if(fileStatus != false)
{
  echo "Success: data written to file";
}
else {
  echo "Fail:could not write to file";
}
?>