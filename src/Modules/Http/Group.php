<?php

namespace Jonathan13779\Framework\Modules\Http;

class Group{
    public function __construct(
        public $route,
        public $callable,
        public $middlewares         
    )
    {
        
    }
}