<?php


$damp = file_get_contents("latlong3.txt");

 $fileContent =" { \"type\": \"FeatureCollection\",
   \"features\": [
     { \"type\": \"Feature\",
       \"geometry\": {\"type\": \"Point\", \"coordinates\": {$damp}}, 
       \"properties\": {\"prop0\": \"value0\"}
       }
      ]
    }   ";


$fileStatus = file_put_contents('feed2.json',$fileContent);
if(fileStatus != false)
{
  echo "Success: data written to file";
}
else {
  echo "Fail:could not write to file";
}
?>