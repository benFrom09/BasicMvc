<?php
namespace Ben09\Core\Middleware;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;




class CsrfTokenMiddleware implements MiddlewareInterface
{
    private $session;

    private $key = '_token';

    public function __construct(&$session) {
        $this->session = $session;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler):ResponseInterface {
        $method = $request->getServerParams()['REQUEST_METHOD'];
        if($method === 'POST' || $method === 'PUT' || $method === 'DELETE' ) {
            $params = $request->getParsedBody();
        }
        return $handler->handle($request);
        
    }

    public function generateToken() {

        $this->session[$this->key] = \bin2hex(\random_bytes(32));    
    }
}