<?php
class Cookie {

  var $options = array();

  function __construct() {
    $this->options = array(
      'value' => null,
      'expire' => 0,
      'path' => '/',
      'domain' => $_SERVER['HTTP_HOST'],
      'secure' => false,
      'httponly' => false,
      'raw' => false
    );
  }

  function __destruct() {
  }

  function reset_options() {
    $this->options = array();
  }

  function set_option($option, $value) {
    $this->options[$option] = $value;
  }

  function set_option_array($options) {
    foreach ($options as $option => $value) {
      $this->options[$option] = $value;
    }
  }

  function set($name) {
    if (empty($name)) {
      return false;
    }

    $cookie_func = (!empty($this->options['raw'])) ? 'setrawcookie' : 'setcookie';

    $cookie_func(
      $name,
      $this->options['value'],
      $this->options['expire'],
      $this->options['path'],
      $this->options['domain'],
      $this->options['secure'],
      $this->options['httponly']
    );
  }

  function get($name) {
    if (array_key_exists($name, $_COOKIE)) {
      return $_COOKIE[$name];
    } else {
      return null;
    }
  }
}