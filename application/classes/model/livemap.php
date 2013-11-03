<?php
defined('SYSPATH') or die('No direct script access.');

class Model_LiveMap extends Kohana_Model
 {
 	public function fbSearch($find,$location,$accessToken)
    {
    	
    	$latitude=$location['latitude'];
    	$longitude=$location['longitude'];
    	
    	/* facebook place search
    	 *https://graph.facebook.com/search?q=coffee&type=place&center=37.76,-122.427&distance=1000&limit=100&access_token=
    	 */
    	$fbPlaceSearch_url="https://graph.facebook.com/search?q=".$find."&type=place&center=".$latitude.",".$longitude."&distance=1000&limit=100&access_token=".$accessToken;
    	$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $fbPlaceSearch_url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$fbPlaceSearch_result = curl_exec($ch);
		curl_close($ch);
	
		// now, process the JSON string
		$json = json_decode($fbPlaceSearch_result);
		
		if(isset($json->data)){
			$fbResults = $json->data;
			$results['fbResults']=$fbResults;
		}elseif(isset($json->error)){
			echo $fbPlaceSearch_result;
			PSAccess::remove('access_token');
		}else{
			return ;
		}
			
			//try google local search at most 8 results
			$url = "http://ajax.googleapis.com/ajax/services/search/local?v=1.0&" .
    			"sll=$latitude,$longitude&q=$find&rsz=8&key=".GOOGLE_MAP_KEY;
	
			// sendRequest
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$body = curl_exec($ch);
			curl_close($ch);
		
			// now, process the JSON string
			$json = json_decode($body);
			try{
				/*
				echo "<pre>";
				print_r($json);
				echo "</pre>";
				die();
				*/
				$googleResults = $json->responseData->results;
				$results['googleResults']=$googleResults;
			}catch(Exception $e){}
			
			return $results;
		
    }
    
 	public function getFbGoogleInfo($find,$location,$accessToken)
    {
    	$latitude=$location['latitude'];
    	$longitude=$location['longitude'];
    	
    	/* facebook page search*/
    	$condition="name = '".addslashes($find)."' and location.street+location.zip+location.latitude != ''";
				
    	/*
    	 * Search google local
    	 */
    	$url = "http://ajax.googleapis.com/ajax/services/search/local?v=1.0&" .
    			"sll=$latitude,$longitude&q=$find&rsz=filtered_cse&key=".GOOGLE_MAP_KEY;
	
		// sendRequest
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$body = curl_exec($ch);
		curl_close($ch);
	
		// now, process the JSON string
		$json = json_decode($body);
		try{
			$googleResults = $json->responseData->results;
			
			//insert the result into database
			$this->addGoogleResult($googleResults);
			
			$resultNum=count($googleResults);
			
			for($i=0;$i<$resultNum;$i++)
			{
				$condition=$condition." or ";
				$condition=$condition.'name = "'.addslashes($googleResults[$i]->titleNoFormatting).'" and location.latitude + location.street != ""';
			}
		
	    	$results['googleResults']=$googleResults;
		}catch(Exception $e){}

	 	$pages = $this->searchFacebookPage($condition);
	    	
	    $results['pages']=$pages;
	 	return $results;
  	
    }
    
    public function searchFacebookPage($condition)
    {
    	require './src/fbconnect.php';
    	
        //$columns="page_id, name, pic_square, page_url, type, website, company_overview, location";
		$columns="page_id, name, pic_square, pic, page_url, type, website, founded, company_overview, mission, products, location, parking, public_transit, hours";
		$table="page";
			
		$fql = "SELECT $columns from $table where $condition";	
		echo $fql."<br><br>";
		$pages=$facebook->api(array('method' => 'fql.query','query' =>$fql,));
		
		foreach($pages as $index => $item){
			$pages[$index]['latitude']='';
			$pages[$index]['longitude']='';
			foreach($item as $key => $value)
			{	
				if(is_array($value))
				{
					$sum="";
					foreach($value as $element => $detail)
					{
						if(!empty($detail))
							$sum.=$detail." ";
						if($element=='latitude')
							$pages[$index][$element]=$detail;
						if($element=='longitude')
							$pages[$index][$element]=$detail;
					}					
					$pages[$index][$key]=$sum;
				}
			}
		}
		
		//insert search result into database
		$this->addPage($pages);	
		
		return $pages;    	
    }
    
     public function addPage($pages)
	 {
	 	//insert search result into database
		foreach($pages as $page)
	 	{
	 		try{
		 	DB::insert('page', array('page_id',
										'name',
										'pic_square',
										'pic',
										'page_url',
										'type',
										'website',
										'founded',
										'company_overview',
										'mission',
										'products',
										'location',
										'parking',
										'public_transit',
										'hours',
										'latitude',
										'longitude'))
	         ->values($page)
	         ->execute();
	 		}
	 		catch(Exception $e)
	 		{ 			
	 		}
	 	}	 
	}
	
	public function addGoogleResult($results)
	 {
	 	//insert search result into database
		foreach($results as $result)
	 	{
	 		try{
			 	DB::insert('google_result', array('pid',
											'title',
											'get_direction',
											'google_url',
											'phone',
											'street_address',
											'city_country',
											'latitude',
											'longitude'))
		         ->values(array("",
		         			$result->titleNoFormatting,
							 $result->ddUrl,
							 $result->url,
							 $result->phoneNumbers[0]->number,
							 $result->addressLines[0],
							 $result->addressLines[1],
							 $result->lat,
							 $result->lng))
		         ->execute();	         
	 		}
	 		catch(Exception $e)
	 		{ 			
	 		}	 		
	 	}	 
	}
	
	public function appendArray($a,$b,$index)
 	{
 		if(empty($a))
 			return $b;
 		if(empty($b))
 			return $a;
 			
 		$length_a=count($a);
 		$length_b=count($b);		
		
		for($i=0;$i<$length_b;$i++)
		{
			for($j=0;$j<$length_a;$j++)
			{
				if($b[$i][$index]==$a[$j][$index])
				{
					break;
				}			
			}	
			if($j<=$length_a)
				$a[$length_a+$i]=$b[$i];
    	}
    	return $a;
 	}
}

