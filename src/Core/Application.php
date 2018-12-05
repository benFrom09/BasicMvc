<?php
namespace Ben09\Core;


use Ben09\Core\Router;
use GuzzleHttp\Psr7\Response;
use Ben09\Core\Session\Session;
use function Http\Response\send;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Application implements RequestHandlerInterface {
    /**
     *@var Router $router;
     */
    private $router;

    /**
    * @var ServerRequestInterface $request
    */
    private $request;

    /**
    * @var array $config
    */
    private $config;

    /**
     * the requested url
     * @var string $url
     */
    private $url;

    /**
     * @var Session $session
     */
    private $session;

    /**
     * 
     */
    private $flash;

    /**
     * @var \PDO $pdo
     */
    private $pdo;


    private $middlewares;


    private $index = 0;





    public function __construct(ServerRequestInterface $request) {
        //1) load config
        $this->getConfig();
        if(DEBUG === true) {
            //debug options
        }
        //set request ;
        $this->request = $request;
        $this->url = $this->request->getUri()->getPath(); 
        $this->router = new Router($this->request);
        //get middlewares from config
        if(array_key_exists('middlewares',$this->config) && !empty($this->config['middlewares'])) {
            foreach($this->config['middlewares'] as $middleware) {
                $this->middlewares[] = new $middleware($this->session);
            }
        }
        $this->pdo = $this->getPDO();
        if($this->session === null) {
            $this->session = new Session();
        }
        if(!is_null($_SESSION) && !array_key_exists('app.id',$_SESSION)) {
            $this->session->set('app.id',$this->config['appId']);    
        }
    }

    public function getPDO() {
        if($this->pdo === null) {
            if(!is_null($this->config) && array_key_exists('driver',$this->config) && $this->config['driver'] === 'mysql') {
                $dsn = 'mysql:dbname=' . $this->config['dbname'] .';host=' . $this->config['dbhost'] .';charset=' . $this->config['charset'] .';';
                $user = $this->config['dbuser'];
                $pass = $this->config['dbpassword'];
                $pdo =  new \PDO($dsn,$user,$pass,$this->config['pdo_default_options']);
               
            }
            $this->pdo = $pdo;
        } 
        return $this->pdo; 
    }

    private function getDsn() {
        return $this->dsn;
    }

    public function run() {
        send($this->handle($this->request));
        
        $response = $this->dispatch();
        return $response;
    }

    private function dispatch() {
        //route of app simple routing;
       if($this->router->match($this->request->getUri()->getPath())) {
             //set the namespace of the controller
             $namespace = $this->router->setControllerNamespace();
             //get the controller and the action
            if(array_key_exists('controller',$this->router->getCurrentRoute()->getParams()) && array_key_exists('action',$this->router->getCurrentRoute()->getParams())) {
                 $controller = $namespace . ucfirst($this->router->getcurrentRoute()->getParams()['controller']) . 'Controller';
                 $action = $this->router->getCurrentRoute()->getParams()['action'];
            } 
            else {
                 $controller = $namespace . ucfirst($this->router->getCurrentRoute()->getParams()[0]);
                 $action = $this->router->getCurrentRoute()->getParams()[1];
            }
            if(class_exists($controller)) {
                 $controller = new $controller($this->router,$this->pdo,$this->session,$this->flash);
                 
                if(method_exists($controller,$action) && is_callable([$controller,$action])) {
                     \call_user_func_array([$controller,$action],$this->router->getMatches()[0]);
                }
                else {
                     throw new \Exception('La methode ' . $action . ' n\'existe pas!');
                }
            } 
            else {
                 throw new \Exception('La classe ' . $controller . ' n\'existe pas!');
            } 
        }
        else {
            return View::render('errors.default404');
        }
    }

    public function pipe($middleware):self {
        $this->middlewares[] = new $middleware($this->session);
        return $this;
    }

    public function handle(ServerRequestInterface $request):ResponseInterface{
        $middleware = $this->getMiddleware();
        if(is_null($middleware)) {
            //no middleware anymore so send fake response;
            return new Response('Fin de chaine des middleware');
        }  
        if($middleware instanceof MiddlewareInterface){
            return $middleware->process($request,$this);
        }    
        
    }

    /**
     * get the  config files 
     * @return array 
     */
    public function getConfig(string $key = null) {
        if($this->config === null) {
            $pathToConfig = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'config';
            $fileName = 'config.php';
            $file = $pathToConfig . DIRECTORY_SEPARATOR . $fileName;
            if(file_exists($file)) {
                $this->config = require $file;      
            } 
        }
        if($key) {
            return $this->config[$key];
        }
        return $this->config;  
    }

    public function getUrl() {
        return $this->url;
    }

    public function get($key) {
        return $this->config[$key];
    }

    private function getMiddleware() {
        if(array_key_exists($this->index,$this->middlewares)) {
            $middleware = $this->middlewares[$this->index];
             $this->index++;
            return $middleware;
        }
       return null;
    }

    public function getRouter() {
        return $this->router;
    }


}