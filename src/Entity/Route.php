<?php 
namespace Ben09\Entity;


class Route
{
    
    /**
     * @var string $method
     */
    private $method;
    /**
     * route path ex: '/blog'
     * @var string $path
     */
    private $path;
    /**
     * Add controller and action ex: 'Controller@action' |  ["controller"=>"controllername,"action"=>actionname]
     * @var array|string $params
     */
    private $params;
    /**
     * route name ;
     * @var $name
     */
    private $name;

    private $namespace = 'web';

    public function __construct(string $method,string $path,$params,string $name) {

        $this->method = $method;
        $this->path = trim($path,'/');
        $this->params = $params;
        $this->name = $name;  
    }

    /**
     * Set controller namespace/folder
     * @param string $namespace
     */
    public function setNamespace($namespace) {
        if(!is_null($namespace)) {
            $this->namespace = (string) $namespace;
        }        
    }

    /**
     * Set named uri
     * @param string $name
     * 
     */
    public function setName($names) {
        if(!is_null($name)) {
            $this->name = (string) $name;
        }        
    }

    /**
     * Get URI METHOD 
     * @return string
     */
    public function getMethod():string {
        return $this->method;
    }

    /**
     * Get url path
     * @return string $path
     */
    public function getPath():string {
        return $this->path;
    }

    /**
     * Get Controller and action 
     * @return Array|string $params
     */
    public function getParams() {
        return $this->params;
    }

    /**
     * @return string
     */
    public function getName():string {
        return $this->name;
    }
    /**
     * @return srting
     */
    public function getNamespace():string {
        return $this->namespace;
    }
}