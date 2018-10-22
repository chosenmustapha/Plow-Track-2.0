<?php
$var1 = $_GET['latitude'];
$var2 = $_GET['longitude'];



$fileContent = "[{$var2},{$var1}],";


$fileStatus = file_put_contents('latlong.txt',$fileContent,FILE_APPEND);
if(fileStatus != false)
{
  echo "Success: data written to file";
}
else {
  echo "Fail:could not write to file";
}

include('jsonmaker.php');
include('heatdata.php');
include('currentloc.php');
?>