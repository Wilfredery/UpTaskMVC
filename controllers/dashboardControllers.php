<?php

namespace Controllers;

use MVC\Router;

class dashboardControllers {
    public static function index(Router $router) {
        isSession();
        isAuth();
        $router->render('dashboard/index', [
            'titulo' => 'Proyectos'
        ]);
    }

    public static function crear(Router $router) {
        isSession();
        isAuth();

        $alertas = [];

        $router->render('dashboard/crear', [
            'titulo' => 'Crear',
            'alertas' => $alertas
        ]);
    }

    public static function perfil(Router $router) {
        isSession();
        isAuth();

        $alertas = [];

        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'alertas' => $alertas
        ]);
    }
}