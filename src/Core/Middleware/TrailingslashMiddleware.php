<?php
namespace Ben09\Core\Middleware;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;




class TrailingslashMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler):ResponseInterface {    
        $url = $request->getUri()->getPath();
        if(!empty($url) && $url[-1] === '/') {
            $response = (new Response());
            $response = $response->withHeader('location',substr($url,0,-1));
            $response = $response->withStatus(301);
            return $response;
        }    
        return $handler->handle($request);       
    }
}