<?php defined('SYSPATH') OR die('No direct access allowed.');

/*
 * Created on 2011-02-27
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
  
/**
 * Locale settings
 */
date_default_timezone_set('America/New_York');

mb_internal_encoding('UTF-8');

//error_reporting(E_ERROR);

$hostname = $_SERVER['SERVER_NAME'];

if (strstr($hostname, '127.0.0.1')) 
	 define('SITE_PATH','http://127.0.0.1:88/livemap/');
else
	define('SITE_PATH','http://www.livemap.ca/');

 /*
	App ID 197858790244379
	API Key 401a311d7e1f5822dfe735cb095ab75f
	App Secret 03092ab6ef5120de37d8d305ede8c1c2
	Site URL http://www.livemap.ca/livepage/

 */
define("FACEBOOK_APP_ID", "197858790244379");
define("FACEBOOK_API_SECRET","03092ab6ef5120de37d8d305ede8c1c2");
 //define('FACEBOOK_APP_PATH','http://apps.facebook.com/pagesmap/');
 
 /*
  * Google Maps API Key
 */
 define('GOOGLE_MAP_KEY', 'ABQIAAAAX5ruIWRi-8tm549-gcMihxR_dZCaZn0NEX0g9RW63sIpdyF0tRQckprf8p23eL06O0x-zy9YEx1sRA');
