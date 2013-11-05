<?php
namespace api_v1\lib;

/**
 * Loads information about the HTTP request to the API
 */

class Request {

  public $req_uri;
  public $req_method;
  public $query_string;
  public $host_name;
  public $req_data;
  public $file_data;
  public $is_https;
  public $headers = array();
  public $requestMethod = '';
  public $isSSL = false;
  public $requestData = array();

  /**
   * Sets properties containing variables from the request.
   *
   * @return void
   */
  public function __construct() {
    $this->req_uri = $_SERVER['REQUEST_URI'];
    $this->req_method = strtolower($_SERVER['REQUEST_METHOD']);
    $this->query_string = $_SERVER['QUERY_STRING'];
    $this->host_name = $_SERVER['HTTP_HOST'];
    $this->req_data = $this->data = array_merge($_GET, $_POST);
    $this->file_data = $_FILES;
    $this->is_https = (boolean)((isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS'])) || (preg_match('/^https/i', $this->host_name)));

    $this->requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
    $this->isSSL = isSSL();
    $this->requestData = array_merge($_GET, $_POST);
  }

  /**
   * Return the value of a custom HTTP header from the request
   *
   * @param string $name
   * @return string
   */
  public function header($name) {
    $headerName = 'HTTP_' . strtoupper($name);
    if (isset($_SERVER[$headerName])) {
      return $_SERVER[$headerName];
    }
    return null;
  }
}