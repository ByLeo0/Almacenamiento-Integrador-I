<?php

namespace Controllers;
use MVC\Router;

class PaginasController{
    public static function index(Router $router){
        $router->render('principal/index',[

        ]);
    }

    public static function inicio(Router $router){
        $router->render('/inicio/index',[

        ]);
    }
}