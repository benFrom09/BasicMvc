<?php

use Ben09\Facades\App;

require dirname(__DIR__) . '/src/Core/functions.php';
require dirname(__DIR__) . '/vendor/autoload.php';

/***********************************************************
 * Error and Exception handling
 ***********************************************************/
error_reporting(E_ALL);
set_error_handler('Ben09\Core\Errors\Error::errorHandler');
set_exception_handler('Ben09\Core\Errors\Error::exceptionHandler');

/*************************************************************
 * ROUTING
 ************************************************************/
$route = App::getRouter();


/***********************************************************************
*   ROUTES
*************************************************************************/

$route->get('/','DefaultController@index','index')->withNamespace('web');
$route->get('/home',['HomeControler','index'],'home')->withNamespace('web');

/*************************************************************************
 * APPLICATION START
 *************************************************************************/

$app = App::run();

/**************************************************************************
 * 
 ***************************************************************************/






