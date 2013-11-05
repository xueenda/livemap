<?php
namespace api_v1;

use api_v1\lib\Request;

class Api{
	
	protected $server_conf;
  	protected $AppId;
  	protected $DeviceId;
 	protected $User;
	protected $request;
  	protected $Device;
  	protected $AppVersion = '';
  
    /**
     * Class constructor method. All entity requests extend a base request to the API.
     *
     * @return void
     */
    public function __construct() {
    	$this->request = new Request;
    }
	
}
?>
