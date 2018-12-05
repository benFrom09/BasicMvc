<?php
namespace Ben09\Core\Session;

class Session implements SessionInterface
{

    public function __construct() {
        $this->started();
    }

    /**
     * Check if session started
     */
    private function started() {
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
     /**
     * get a session key
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key,$default = null) {
        $this->started();
        if(array_key_exists($key,$_SESSION)) {
            return $_SESSION[$key];
        }
        return $default;
    }

    /**
     * Set a value to a session
     * @param string $key
     * @param string $value
     * @return void
     */
    public function set(string $key, $value):void{
        $this->started();
        $_SESSION[$key] = $value;
    }

    /**
     * Remove a session key
     * @param string $key
     * 
     */
    public function remove(string $key):void {
        $this->started();
        unset($_SESSION[$key]);
    }
}