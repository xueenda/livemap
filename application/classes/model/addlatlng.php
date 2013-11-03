<?php
defined('SYSPATH') or die('No direct script access.');


class Model_AddLatLng extends Kohana_Model
 {
 	//insert into page table with lat and lng according to page_id
	public function addLatLng($page_id,$lat,$lng)
    {  
	 DB::update('page')
         ->set(array('latitude'=>$lat, 'longitude'=>$lng))
         ->where('page_id','=',$page_id)
         ->execute();
	}
 }