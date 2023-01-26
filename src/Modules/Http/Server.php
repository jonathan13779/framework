<?php
namespace Jonathan13779\Framework\Modules\Http;

class Server{
    public function get($name)
    {
        if (isset($_SERVER[$name])){
            return $_SERVER[$name];
        }
        return false;
    }
}