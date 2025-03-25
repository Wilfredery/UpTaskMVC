<?php

namespace Controllers;

use MVC\Router;

class dashboardControllers {
    public static function index(Router $router) {
        isSession();
        isAuth();
        $router->render('dashboard/index', [

        ]);
    }
}