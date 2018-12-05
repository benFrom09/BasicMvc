<?php
namespace Ben09\Core\Middleware;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;




class IpMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler):ResponseInterface {
        //ip if shared connection
        if(isset($request->getServerParams()['HTTP_CLIENT_IP'])) {

            $ip = $request->getServerParams()['HTTP_CLIENT_IP'];
        }
        //ip if proxy
        elseif(isset($request->getServerParams()['HTTP_X_FORWARDED_FOR'])) {

            $ip = $request->getServerParams()['HTTP_X_FORWARDED_FOR'];
        }
        else {

            $ip = isset($request->getServerParams()['REMOTE_ADDR']) ?  $request->getServerParams()['REMOTE_ADDR'] : '';
        }
        
        return $handler->handle($request);
        
    }
}
