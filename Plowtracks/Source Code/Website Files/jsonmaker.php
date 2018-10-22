<?php


$damp = file_get_contents("latlong.txt");

 $fileContent ="{ \"type\": \"FeatureCollection\",\n
    \"features\": [ \n
      { \"type\": \"Feature\",\n
        \"geometry\": { \n
          \"type\": \"MultiPoint\",\n
          \"coordinates\": \n [

          {$damp}

[ 125.762777,39.037324]
        ]  },\n
        \"properties\": { \n
          \"prop0\": \"value0\"
        }\n
      }\n
       ]\n
     }";


$fileStatus = file_put_contents('feed.json',$fileContent);
if(fileStatus != false)
{
  echo "Success: data written to file";
}
else {
  echo "Fail:could not write to file";
}
?>