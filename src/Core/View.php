<?php
namespace Ben09\Core;



class View
{
    public static function render(string $view,?array $vars=[]) {
        $default_path = VIEWS;
        $viewPath = str_replace('.', DS ,$view) . '.php';
        $file = $default_path . DS . $viewPath;
        extract($vars,EXTR_SKIP);
        ob_start();
        if(file_exists($file) && is_readable($file)) {
            require $file;   
        }
        $content = ob_get_clean();
        require LAYOUT;
    }

    public static function twigRender(string $layout,?array $vars=[]) {
        $layout = str_replace('.', DS,$layout) . '.html.twig';
        static $twig = null;
        if($twig === null) {
            $loader = new \Twig_Loader_Filesystem(TWIG_DIRECTORY);
            $twig = new \Twig_Environment($loader,$vars);
            $twigFunction = new \Twig_SimpleFunction('App',function($method){
                \Ben09\Core\App::$method();
            });
            $twig->addFunction($twigFunction);
        }
        if(file_exists(TWIG_DIRECTORY . DS . $layout)) {
            echo $twig->render($layout,$vars);
        }
        
    }
}