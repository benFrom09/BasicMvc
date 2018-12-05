<?php
return [

      //default options 
      
  define('DS',DIRECTORY_SEPARATOR),
  define('ROOT',dirname(__DIR__)),
  define('VIEWS',dirname(__DIR__) . DS . 'views'),
  define('LAYOUT',VIEWS . DS . 'layout' . DS . 'default.php'),
  define('TWIG_DIRECTORY', ROOT . DS . 'twig'),
  define('WEBROOT',dirname(__DIR__) . DS . 'public'),
  define('DEBUG',true),
  //app
  'app_name' => 'default',
  'app_locale' => 'fr',
  //app session id
  'appId' => \Ben09\Core\Strings\Str::generateRandomSring(),

  //id database

  'driver' => 'mysql',
  'dbhost' =>'localhost',
  'dbname'=>'example',
  'dbuser' =>'root',
  'dbpassword'=>'',
  'charset'=>'utf8',

  //PDO FETCHMODE

  'pdo_default_options'=> [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ],

  //middleware

  'middlewares'=>[\Ben09\Core\Middleware\IpMiddleware::class,
                  \Ben09\Core\Middleware\TrailingslashMiddleware::class,
                  \Ben09\Core\Middleware\CsrfTokenMiddleware::class]


    

];