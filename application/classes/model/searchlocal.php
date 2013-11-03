<?php
defined('SYSPATH') or die('No direct script access.');


class Model_SearchLocal extends Kohana_Model
 {
 	public function getLocalInfo($find,$location,$range)
    {
    	$latitude=$location['latitude'];
    	$longitude=$location['longitude'];
    	
    	//1 mile equal to 0.0145 degree of latitude
    	$lat_range=$range*0.01448;
    	
    	//1 mile at latitude equal to this much of longitude
    	$mile_of_lng=round(360/(24901.55*sin(90-$latitude)),5); //take 5 numbers
    	$lng_range=$range*$mile_of_lng;
    	
    	//must add fulltext index in mysql with name and company_overview column
		$query = DB::query(Database::SELECT, 'select name,page_url,company_overview,website,type,location,latitude,longitude from page where match(name, company_overview) AGAINST (:keyword)' .
				'and latitude >= :latitude_start and latitude <= :latitude_end and longitude >= :longitude_start and longitude <= :longitude_end');

		$query->parameters(array(
				    ':keyword' => $find,
				    ':latitude_start' => $latitude-$lat_range,
				    ':latitude_end' => $latitude+$lat_range,
				    ':longitude_start' => $longitude-$lng_range,
				    ':longitude_end' => $longitude+$lng_range
				    
				));
    	$result = $query->execute()->as_array();
 
	 	return $result;
    }
}