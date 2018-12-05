<?php
namespace Ben09\Core;


use PDO;
use App\Models\User;
use Ben09\Core\Mail\Mail;
use Ben09\Core\Session\Session;
use Ben09\Core\Session\SessionInterface;


class Auth {

    protected $db;
    
    protected $session;

    protected $flash;

    protected $errors;

    public function __construct(PDO $db,SessionInterface $session, $flash) {

        $this->db = $db;
        $this->session = $session;
        $this->flash = $flash;
    }

    public function login(string $userKey,string $password,$data) {
        //verify

        $req = $this->db->prepare("SELECT * FROM users WHERE $userKey = ?");
        $req->execute([$data]);
        $user = $req->fetch();
        if($user) {
            if(password_verify($password,$user->password)){
                $this->session->set('auth.user',$user->id);
                return  $user;
            }
            $this->flash->withError('Password or email does not match');

        }
        return null;
    }

    public function register(string $table,?array $data = []) {
        if($this->isUnique($table,'email',$data['email'],"L'adrese email est déjà  utilisée") || $this->isUnique($table,'username',$data['username'],"Le pseudo est déjà prit")) {
            $token =  $this->generateToken();
            try {
                $req = $this->db->prepare("INSERT INTO $table SET username = ?, email = ?, password = ?, confirm_token = ?, confirmed_at = NULL, created_at = NOW() , updated_at = NOW() ");
                $req->execute([
                $data['username'],
                $data['email'],
                password_hash($data['password'],PASSWORD_BCRYPT),
            $token,
                ]);
            } catch (\PDOException $e) {

                die('EXCEPTION =>' . $e->getMessage());     
            }       
            $userId = $this->db->lastInsertId();
            $link = 'http://localhost:8000/compte/confirmation?id=' . $userId . '&token=' . $token;
            $mail = new Mail('webmaster@exemple.com');
            $mail->send('webmaster@exemple.com',$data['email'],'<h1>Confirmation de compte<h1>','<p>Veuillez confirmer votre compte en cliquant sur le lien ci-dessous</p><p><a href="' . $link .'">' . $link .'</a></p>');
            
            header('location:/login');
        }
        else {
            d($this->errors);
        }
        
    }

    private function generateToken() {
        return bin2hex(random_bytes(16));
    }

    private function isUnique($table,$key,$value,$message) {
        $req = $this->db->prepare("SELECT COUNT(*) FROM $table WHERE $key = ? ");
        $req->execute([
            $value
        ]);
        $data = (int) $req->fetchColumn();
        if($data > 0) {
           $this->errors['sql'][] = $message;
           return false;
        }
        return true;
    }

    public function isLogged() {
        return !is_null($this->session->get('auth.user')) && !empty($this->session->get('auth.user'));
    }

    
    
}