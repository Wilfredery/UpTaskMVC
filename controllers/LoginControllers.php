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

        echo "Desde el crear.";

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }

        //Render a la vista
        $router->render('auth/crear', [
            'titulo' => 'Creating'
        ]);
    }

    public static function olvidar() {

        echo "Desde el olvidar.";

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }
    }

    public static function restablecer() {

        echo "Desde el restablecer.";

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }
    }


    public static function mensaje() {

        echo "Desde el mensaje.";

    }

    public static function confirmar() {

        echo "Desde el restablecer.";

    }

}