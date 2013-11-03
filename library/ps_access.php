<?php
/**
 * Singleton class that handles accessing of data in persistent storage, specifically cookies.
 * Manages encrypting and decrypting the stored values during get and set access.
 *
 * Examples:
 *   Save a string for an hour --> PersistentStorage::set('myCookie', 'myCookieData', time()+3600);
 *   Save an array until browser closes --> PersistentStorage::set('myArrayCookie', array(1,2,3,4,5));
 *   Get the array from 'myArrayCookie' --> PersistentStorage::get('myArrayCookie');
 *   Remove 'myArrayCookie' --> PersistentStorage::remove('myArrayCookie');
 *
 * @property object $instance holds an instance of PersistentStorage
 * @constant string encryptFunction the function to use for encrypting cookie data
 * @constant string decryptFunction the function to use for decrypting cookie data
 * @constant string keyHashFunction the function to use for hashing cookie keys
 */

class PSAccess {

    private static $instance;

    /**
     * Return an instance of PersistentStorage if one has been created, otherwise
     * create a new instance and return it.
     *
     * @return object an instance of PersistentStorage
     */
    private static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new PSAccess;
        }
        return self::$instance;
    }

    /**
     * Set the value of a persistent storage key
     *
     * @param string $key The key to store the cookie under (will be encrypted)
     * @param mixed $data The data to be saved in the cookie.
     * @param int $ttl Number of seconds to store cookie. Defaults to 0 for "until browser closes"
     * @return bool true if cookie set, false otherwise
     */
    public static function set($key, $data, $ttl = 0, $sslonly = false, $httponly = false) {
        global $hostname;
        $instance = self::getInstance();
        $hashedKey = $instance->keyHash($key);
        $encryptedData = $instance->encrypt($data);
        $domain = 'www.livemap.ca' == $hostname ? 'www.livemap.ca' : '127.0.0.1';
        $instance->setCookie($hashedKey, $encryptedData, $ttl, $domain, $sslonly, $httponly);
        return true;
    }

    /**
     * Remove data from persistent storage based on the given storage key.
     * Removal is done by setting the data to null and expiring the storage key.
     *
     * @param string $key The key of the cookie to destroy.
     * @return bool true if cookie set, false otherwise
     */
    public static function remove($key, $sslonly = false, $httponly = false) {
        $instance = self::getInstance();
        $hashedKey = $instance->keyHash($key);
		$domain = 'livemap.ca' == SITE_PATH ? 'livemap.ca' : '127.0.0.1';
        $instance->setCookie($hashedKey, null, time() - 3600, $domain, $sslonly, $httponly);
        return true;
    }

    /**
     * Get the value of a persistent storage key
     *
     * @param string $key
     * @return mixed
     */
    public static function get($key) {
        $instance = self::getInstance();
        $hashedKey = $instance->keyHash($key);
        return $instance->decrypt($instance->getCookie($hashedKey));
    }

    /**
     * Hash the given key using the defined hashing method
     *
     * @param string $key the key to hash
     * @return string the hashed key
     */
    private function keyHash($key) {
        return $key;
        // Don't hash key for now
        //return self::$keyHashFunction($key);
    }

    /**
     * Encrypt the given data by first serializing and then encrypting
     * using the defined encrypting function.
     *
     * @param mixed $data the data to encrypt
     * @return string the encrypted data
     */
    private function encrypt($data) {
        return base64_encode($this->_serialize($data));
    }

    /**
     * Decrypt the given data by first unserializing and then decrypting
     * using the defined decrypting function.
     *
     * @param mixed $data the data to decrypt
     * @return string the decrypted data
     */
    private function decrypt($data) {
        return $this->_unserialize(base64_decode($data));
    }

    /**
     * Wrapper function for serializing data
     *
     * @param mixed $data the data to be serialized
     * @return string the serialized data
     */
    private function _serialize($data) {
        return serialize($data);
    }

    /**
     * Wrapper function for unserializing data
     *
     * @param string $data the serialized string to be unserialized
     * @return mixed the unserialized data
     */
    private function _unserialize($data) {
        return unserialize($data);
    }

    /**
     * Set a cookie.
     *
     * @param string $key the key to save the cookie under
     * @param string $data the data to save in the cookie
     * @param int $ttl time-to-live, the expiry in seconds of the cookie
     * @return void
     */
    private function setCookie($key, $data, $ttl, $domain, $sslonly = false, $httponly = false) {
        setcookie($key, $data, $ttl, '/', $domain, $sslonly, $httponly);
    }

    /**
     * Return data stored in a specific cookie
     *
     * @param string $key the key the cookie is saved under
     * @return string the cookie data
     */
    private function getCookie($key) {
        return cookie($key);
    }
    
    
}