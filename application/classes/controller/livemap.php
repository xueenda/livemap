<?php //defined('SYSPATH') OR die('No Direct Script Access');
 
require_once LIBPATH . "facebook/facebook.php";

Class Controller_LiveMap extends Controller_Base
{
	
    public function before()
      {
         parent::before();
	     session_start();
		 
      }
      
    public function action_index()
	 {
	    $header                           = array();
	    $navigation                       = array();
	    $content                          = array();
	    $leftcolumn                       = array();
	    //$footer                           = array();
	    $this->template->title            = 'Live Map';
	    $this->template->meta_keywords    = 'live map,livemap,facebook pages map, live page,livepage';
	    $this->template->meta_description = 'The first live local business map in the world. Make better connection between the customer and business owner. Promote your business today.';
	   	//add this script later
	    //$this->template->styles           = array('css/livepage.css' => 'screen');
	    //$this->template->scripts          = array('http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAX5ruIWRi-8tm549-gcMihxQNZZVH92I51WPFHObqbY57QvLULBSBK2-56XCXCdBWo8PMRiGQj1hYVg');
		
		//print_r($_POST);
		
		if(isset($_POST['signed_request'])){
				
			$_SESSION['zoom'] = 13;
		}
		
		if(isset($_POST['latitude'])){
			$livemap                   = new Model_LiveMap();
			
			//Get latitude and longitude
			$location['latitude']=$_POST['latitude'];
			$location['longitude']=$_POST['longitude'];
			$accessToken=PSAccess::get('access_token');
			$results=$livemap->fbSearch(trim($_POST['find']), $location, $accessToken);
	    	$content['results'] = $results; 
			
	    	if(empty($_SESSION['zoom'])){
				
			$_SESSION['zoom']=14;
				
			}    	
	    	
	    	
	    	//display my location and adjust the zoom
	    	//echo "<br>";
	    	//print_r($location);
	    	$content['location']= $location;
	    	
	    	$content['zoom']= $_SESSION['zoom'];
	    	$header['find'] = $_POST['find'];
	    	//$header['location']=$_POST['location'];
	    	$header['latitude'] = $location['latitude'];
	    	$header['longitude']=$location['longitude'];
	    	//$header['accessToken']=$accessToken;
	    		
		}          
	    //$header['redirect_uri']=$this->redirect_uri;

	    $facebook = new Facebook(array(
			  'appId'  => FACEBOOK_APP_ID,
			  'secret' => FACEBOOK_API_SECRET,
			));
	    $fb_user = $facebook->getUser();
	    $access_token = $facebook->getAccessToken();
      	PSAccess::set('access_token', $access_token);
      	//echo $access_token;

	    if (!empty($fb_user)) {
	        try {
	        	$fb_user = $facebook->api('/me');
	        } catch (FacebookApiException $e) {
	          	$fb_user = $fb_user_profile = null;
	        }
	    }

	    $app_id = FACEBOOK_APP_ID;
        $unauth_url = '';
	    $auth_url = '';
		
	    if (!empty($fb_user) && !empty($access_token)) {
	        $unauth_url = $facebook->getLogoutUrl(array('next' => "http://{$_SERVER['HTTP_HOST']}/invite"));
	        $this->template->header = View::factory('layout/header', $header);

        } else {
	        $auth_url = $facebook->getLoginUrl();
	    	$this->template->header = View::factory('layout/header_fb_login', compact('header','auth_url'));

	    }
	    
	    //$this->template->header = View::factory('layout/header', $header);

	    //$this->template->navigation      = View::factory('pages/navigation', $navigation);
	    $this->template->leftcolumn      = View::factory('leftcolumn', $leftcolumn);
	    $this->template->content          = View::factory('layout/content', $content);
	 }

}