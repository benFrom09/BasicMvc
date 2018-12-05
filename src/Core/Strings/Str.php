<?php
namespace Ben09\Core\Strings;




class Str
{
    public static function generateRandomSring() {
        return bin2hex(\random_bytes(32));
    }
}