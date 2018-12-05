<?php
namespace Ben09\Core\Errors;

class Error
{
    public static function errorHandler($level,$message,$file,$line) {
        if(error_reporting() !== 0) {
            throw new \ErrorException($message,0,$level,$file,$line);
        }
    }

    public static function exceptionHandler($exception) {
        echo "<div style=\"background:black;color:red;padding:20px;text-align:center;line-height:1.5em;font-size:20px;border-radius:5px;\">";
        echo "<h1>Fatal error</h1>";
        echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
        echo "<p>Message: '" . $exception->getMessage() . "'</p>";
        echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
        echo "<p style=\"font-size:20px;\">Thrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "</pre></p>";
        echo "</div>";
    }
}