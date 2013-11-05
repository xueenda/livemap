<?php
namespace api_v1;

use Model_LiveMap;

class LiveMap extends Api
{
	public function __construct()
    {
    	parent::__construct();
    	//Authentication
		 
    }
    
    public function action_index(){
    	
    	$search = new Model_LiveMap;
    	$find = trim($this->request->data['find']);
    	$location['latitude'] = $this->request->data['latitude'];
    	$location['longitude'] = $this->request->data['longitude'];
    	$accessToken = $this->request->data['access_token'];
    	$results = $search->fbSearch($find, $location, $accessToken);
    	print_r(json_encode($results));
    }
}
?>
