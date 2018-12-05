<?php
namespace Ben09\Core;


class BaseController
{
    protected $request;
    protected $pdo;
    protected $flash;
    protected $session;
    protected $router;


    public function __construct($router,$pdo,$flash,$session) {
        
        $this->router = $router;
        $this->pdo = $pdo;
        $this->flash = $flash;
        $this->session = $session;
    }
}