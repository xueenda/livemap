<?php
define('GOOGLE_MAP_KEY', 'ABQIAAAAX5ruIWRi-8tm549-gcMihxTO1JVO5AceV6hwkE1qIdqEAbilGhQminRI59G5HPOt6G19g26fDGwZWQ');

	$url = "http://ajax.googleapis.com/ajax/services/search/local?v=1.0&sll=".
			$_POST['latitude'].",".$_POST['longitude']."&q="
			.urlencode($_POST['name'])
			."&rsz=1&key=".GOOGLE_MAP_KEY;
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$body = curl_exec($ch);
	curl_close($ch);

	// now, process the JSON string
	$json = json_decode($body);	
	
	try{
		$result = $json->responseData->results;
	$result = $result[0];
	}catch(Exception $e){}
	
	/*
	base on the location to make sure if the results are match or not
	*/
	if($result->lat < $_POST['latitude']-0.01 || $result->lat > $_POST['latitude']+0.01){
		echo "Not found in Google Business!";
		return;
	}
	
	$overview = "<h4 style=\"margin-bottom:5px\"><a target=\"_blank\" href=$result->url>$result->title</a></h4>";
	if(!empty($result->addressLines[0]))
		$overview = $overview.$result->addressLines[0]."<br>";
	if(!empty($result->addressLines[1]))		
		$overview = $overview.$result->addressLines[1]."<br>";
	if(!empty($result->phoneNumbers[0]->number))
		$overview = $overview.$result->phoneNumbers[0]->number."<br>";
	if(!empty($result->ddUrl)){
		$token =  strrpos($result->ddUrl,"saddr");
		$direction_url=substr($result->ddUrl,0,$token)."saddr=".$_POST['mylocation'];
		$overview = $overview."<a target=\"_blank\" href=$direction_url>Directions</a>";
	}
	if(!empty($result->lat)){
		$latlng=$result->lat.",".$result->lng;
		$overview=$overview."&nbsp; &nbsp;<a target=\"_blank\" href=\"http://www.google.com/maps?layer=c&cbll=$latlng&cbp=0&ll=$latlng\">Street view</a><br>";
	}
	//$overview=addslashes($overview);
	echo $overview;
	
?>