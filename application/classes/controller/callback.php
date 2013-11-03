<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Abstract controller class for automatic templating.
 *
 * @package    Controller
 * @author     Kohana Team
 * @copyright  (c) 2008-2009 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
require_once LIBPATH . "facebook/facebook.php";

class Controller_Callback extends Controller {

	/**
	 * @var  string  page template
	 */
	public $template = 'callback';

	/**
	 * @var  boolean  auto render template
	 **/
	public $auto_render = TRUE;

	/**
	 * Loads the template View object.
	 *
	 * @return  void
	 */
	public function before()
	{
		if ($this->auto_render === TRUE)
		{
			// Load the template
			$this->template = View::factory($this->template);
		}
	}

	public function action_index() {

	      if (!empty($_GET['code'])) {
	        $facebook = new Facebook(array(
			  'appId'  => FACEBOOK_APP_ID,
			  'secret' => FACEBOOK_API_SECRET,
			));
	        $access_token = $facebook->getAccessToken();
	        $fb_user = $facebook->getUser();
	        $fb_session=array('state'=>$this->get_data['state'], //$facebook->getPersistentData('state'),
	                          'code'=>$this->get_data['code'], //$facebook->getPersistentData('code'),
	                          'access_token'=>$access_token,
	                          'user_id'=>$fb_user
	                         );

	        PSAccess::set('access_token', $access_token);
	      }

        $scripts                 = array(SITE_PATH.'media/js/jquery.min.js');
	      
	    $this->request->response = View::factory('callback', $scripts);
    }

	/**
	 * Assigns the template as the request response.
	 *
	 * @param   string   request method
	 * @return  void
	 */
	public function after()
	{
	}

} // End Controller_Template