<?php
namespace Ben09\Core\Session;


interface SessionInterface
{
    /**
     * get a session key
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key,$default = null);

    /**
     * Set a value to a session
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, $value):void;

    /**
     * Remove a session key
     * @param string $key
     * 
     */
    public function remove(string $key):void;
}