<?php
$var1 = $_GET['latitude'];
$var2 = $_GET['longitude'];



$fileContent = "new google.maps.LatLng({$var1}, {$var2}),\n";


$fileStatus = file_put_contents('latlong2.txt',$fileContent,FILE_APPEND);
if(fileStatus != false)
{
  echo "Success: data written to file";
}
else {
  echo "Fail:could not write to file";
}
include('htmlmakertest.php')
?>