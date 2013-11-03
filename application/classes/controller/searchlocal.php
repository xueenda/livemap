<?php //defined('SYSPATH') OR die('No Direct Script Access');
 
Class Controller_SearchLocal extends Controller_DefaultTemplate
{
    
    public function action_index()
	 {
	    $header                           = array();
	    $navigation                       = array();
	    $content                          = array();
	    $leftcolumn                       = array();
	    //$footer                           = array();
	    $this->template->title            = 'Search Local';
	    $this->template->meta_keywords    = 'facebook page map, live page,livepage';
	    $this->template->meta_description = 'A prototype of facebook pages with google maps api';
	   	//add this script later
	    //$this->template->styles           = array('css/livepage.css' => 'screen');
	    //$this->template->scripts          = array('http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAX5ruIWRi-8tm549-gcMihxQNZZVH92I51WPFHObqbY57QvLULBSBK2-56XCXCdBWo8PMRiGQj1hYVg');
	
		if($_POST){
			$searchLocal                   = new Model_SearchLocal();
			
			//Get latitude and longitude
			$location['latitude']=$_POST['latitude'];
			$location['longitude']=$_POST['longitude'];

			$range=$_POST['distance'];//need to convert to range
			
	    	$content['pages']=$searchLocal->getLocalInfo($_POST['find'],$location,$range); 
	    	
	    	switch($range){
	    		case 10: $zoom=11;break;
	    		case 25: 
	    		case 35: 
	    		case 50: 
	    		case 75: $zoom=10;break; 
	    		case 100:$zoom=9; break;
	    		default:$zoom=12;break;	
	    	};
	    	
	    	//display my location and adjust the zoom
	    	$content['location']= $location;
	    	$content['zoom']= $zoom;
	    	 		
		}                
	                                            
	    $this->template->header          = View::factory('pages/searchlocal/header', $header);
	    //$this->template->navigation      = View::factory('pages/navigation', $navigation);
	    $this->template->leftcolumn      = View::factory('pages/leftcolumn', $leftcolumn);
	    $this->template->content          = View::factory('pages/content', $content);
	 }
}