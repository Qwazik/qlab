<?php

namespace core\App;

class App
{
    private $view;
    private $router;
    private function __construct()
    {
        $router = new Router();
    }
}