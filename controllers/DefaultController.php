<?php
namespace Controllers;
use Ben09\Core\Auth;
use Ben09\Core\View;
use GuzzleHttp\Psr7\Response;
use Ben09\Core\BaseController;



class DefaultController extends BaseController
{

   
    public function index() {
        
        View::twigRender('static.default');
    }

    public function register() {
        if( null !== $this->request->getParsedBody() && !empty($this->request->getParsedBody())) {
            $auth = new Auth($this->pdo,$this->session,$this->flash);
            $auth->register('users',$this->request->getParsedBody());
        }

         View::twigRender('static.register');
    }

    public function confirm($id,$token) {
        if(isset($id) && isset($token)) {
            $url = 'http://localhost:8000/login';
            $req = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
            $req->execute([$id]);
            $user = $req->fetch();
            if($token === $user->confirm_token) {
                $req = $this->pdo->prepare('UPDATE users SET confirm_token = NULL, confirmed_at = NOW(), updated_at = NOW() WHERE id = ? ');
                $req->execute([$id]);
                $session = $this->session->set('auth', $user->username . \bin2hex(\random_bytes(16)) . '//' . $user->id);
                d($session);
                die();
                header('location:' . $url);               
            }
            elseif($user->confirm_token === NULL) {
            d('alreadyconfirmed');
               header('location:' . $url);
                
            }
            
        }
    }

    public function login() {
        d('HELLO USER');
    }

    public function notFound() {
        echo '<p style="text-align:center; padding:100px;">ERROR: 404 - Not found :(</p>';
    }
}