<?php
namespace Ben09\Core\Session;

use ben09\Core\Session\SessionInterface;

class Flash
{
    private $session;
    protected $sessionKey = 'flash';
    private $messages;

    public function __construct(SessionInterface $session) {
        $this->session = $session;
    }

    public function withSuccess(string $message):void {
        $flash = $this->session->get($this->sessionKey,[]);
        $flash['success'] = $message;
        $this->session->set($this->sessionKey,$flash);
        
    }

    public function withError(string $message):void {
        $flash = $this->session->get($this->sessionKey,[]);
        $flash['error'] = $message;
        $this->session->set($this->sessionKey,$flash);
        
    }

    public function get(string $type):?string {
        if(is_null($this->messages)) {
            $this->messages = $this->session->get($this->sessionKey,[]);
            $this->session->remove($this->sessionKey);
        }
        if(array_key_exists($type,$this->messages)) {
            return $this->messages[$type];
        }
        return null;
    }
}