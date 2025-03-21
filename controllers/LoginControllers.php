<?php


namespace Controllers;

use MVC\Router;

class LoginControllers {

    public static function login(Router $router) {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }
        //Render a la vista
        $router->render('auth/login', [
            'titulo' => 'iniciar sesion'
        ]);
    }

    public static function logout() {

        echo "Desde el logout";

        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }

    }

    public static function crear(Router $router) {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }

        //Render a la vista
        $router->render('auth/crear', [
            'titulo' => 'Creating'
        ]);
    }

    public static function olvidar(Router $router) {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }

        //Render a la vista
        $router->render('auth/olvidar', [
            'titulo' => 'Rec cuenta'
        ]);
    }

    public static function restablecer(Router $router) {

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }

        //Render a la vista
        $router->render('auth/restablecer', [
            'titulo' => 'Rec password'
        ]);
    }


    public static function mensaje(Router $router) {

        //Render a la vista
        $router->render('auth/mensaje', [
            'titulo' => 'mensaje'
        ]);
    }

    public static function confirmar(Router $router) {

        //Render a la vista
        $router->render('auth/confirmar', [
            'titulo' => 'confirmar'
        ]);

    }

}