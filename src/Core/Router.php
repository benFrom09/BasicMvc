<?php
namespace Ben09\Core;

use Ben09\Entity\Route;
use Psr\Http\Message\ServerRequestInterface;

class Router
{
    /**
     * Assotiative array of routes
     * @var array $routes
     */
    protected $routes = [];

    /**
     * Parameters of matched routes
     * @var array
     */
    protected $params = [];

    /**
     * Array of matched parameters in url
     * @var array $matches
     */
    protected $matches = [];
    /**
     * @var $currentRoute
     */
    protected $currentRoute;

    /**
     * Instance of Route::class
     * @var Route $route
     */
    protected $route;

    /**
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * @var $url
     */
    protected $url;

    public function __construct(ServerRequestInterface $request) {

        $this->request = $request;
        $this->url = $request->getUri()->getPath();

        
    }

    public function get($path,$params,$name = null) {
        $this->route = $this->addRoute('GET',$path,$params,$name);
        return $this;
    }

    public function post($path,$params,$name) {
        $this->route = $this->addRoute('POST',$path,$params,$name);
        return $this;
    }

    public function withName($name) {
        $this->route->setName($namespace);
        return $this;
    }

    public function withNamespace($namespace) {
        $this->route->setNameSpace($namespace);
        return $this;
    }


    /**
     * Add route to the routing table
     * 
     * @param string $path the route url
     * 
     * @param array|string $options parameters(controller,action..)
     * 
     * @param string $name name of the route
     * 
     * @return Route
     */
    private function addRoute(string $method,string $path,$params,string $name = null):Route {
        if(is_string($params)) {
            $params = explode('@',$params);           
        }
        //convert the route to regular expression:escape the forward slashes
        $regex = preg_replace('#\//#','\\/',$path);
        
        //convert variables :id
        
        $regex= preg_replace('#:([\w]+)#','([^/]+)', $path);

        //Add start and end delimiters
        $regex = '#^' . $regex . '$#i';
        
       
       
        $route = new Route($method,$path,$params,$name);
        $this->routes[$method][$regex] = $route;
        return $route;
    }

    /**
     * get all routes from the routing table
     * 
     * @return array
     */
    public function getRoutes():array {
        return $this->routes;
    }

    /**
     * Match routes in the routing table,setting thze params
     * @param string $url
     * 
     * @return bool 
     */
    public function match(string $url):bool {
        if(empty($this->routes)) {
            return false;
        }
        if(!array_key_exists($_SERVER['REQUEST_METHOD'],$this->routes)) {
            throw new \Exception(' the key REQUEST_METHOD does not exist in ' . $this->routes);
        } 

        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $regex=>$route) {
            if(preg_match($regex,$url,$matches)) {
                array_shift($matches);
                $this->matches[] = $matches;
                $this->currentRoute = $route;
                return true;
            }
            
        }
        return false;
        
    }
    
    /**
     * Remove query string variable from url
     * @param string $url
     * 
     * @return string $url
     */
    public function removeQueryStringFromUrl(string $url):string {
        if($url != '') {
            $parts = explode('?',$url,2);
            if(strpos($parts[0],'=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }
       return $url;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getCurrentRoute(){
        return $this->currentRoute;
    }

    /**
     * Set nameSpace of the controller
     * @return string
     */
    public function setControllerNamespace():string {

        if($this->currentRoute->getNamespace() === 'web') {
           return  $namespace = 'Controllers\\';
        } else {
            return $namespace = 'Controllers\\' . ucfirst($this->currentRoute->getNamespace()) . '\\';
        }
    }

    /**
     * Get the current matched params
     * 
     * @return array
     */
    public function getMatches() {
        return $this->matches;
    }

}