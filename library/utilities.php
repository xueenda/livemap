<?php
	/**
	 * Return the value of PHPs $_SERVER variable at the specified key.
	 * Converts the key to uppercase to match $_SERVER's indexing.
	 *
	 * @param string $key the key to retrieve value for (can by uppercase or lowercase)
	 * @return mixed value of $_SERVER at key
	 */
	function server($key) {
	  $key = strtoupper($key);
	  return isset($_SERVER[$key]) ? $_SERVER[$key] : null;
	}

	/**
	 * Detect if the request is being made over an SSL connection by checking the
	 * value of the custom X-Forwarded-Proto header.
	 *
	 * @return bool true if SSL, false otherwise
	 */
	function isSSL() {
	    if ((server('server_port') >= 440 && server('server_port') <= 449)
	        || 0 === strcasecmp(server('http_x_forwarded_proto'), 'ssl')
	        || 0 === strcasecmp(server('http_x_forwarded_proto'), 'https')) {
	        return true;
	    }
	    return false;
	}

	/**
	 * Wrapper for PHP's $_COOKIE superglobal
	 *
	 * @param string $key the key of the cookie to return
	 * @return string|null the value of the cookie or null if it isn't set
	 */
	function cookie($key) {
	  return array_key_exists($key, $_COOKIE) ? (string)$_COOKIE[$key] : null;
	}

?>
