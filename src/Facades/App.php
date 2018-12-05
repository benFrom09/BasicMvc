<?php
namespace Ben09\Facades;

use Ben09\Core\Application;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;


class App
{
    protected static $app;

    public static function __callStatic($method,$args) {
        $request = ServerRequest::fromGlobals();
        if(self::$app === null) {
            
            self::$app = new Application($request);
        }
        
        return \call_user_func_array([self::$app,$method],$args);
    }

    public static function getAppName() {
        return self::$app->getConfig('app_name');
    }

    public static function getLocale() {
        return self::$app->getConfig('app_locale');
    }

}