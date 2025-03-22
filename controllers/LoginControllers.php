<?php


namespace Controllers;

use Model\Usuario;
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

        $usuario = new Usuario();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarNuevaCuenta();

            

            if(empty($alertas)) {
                $existeUsuario = Usuario::where('email', $usuario->email);

                if ($existeUsuario) {
                    Usuario::setAlerta('error', 'El usuario ya existe.');
                    $alertas = Usuario::getAlertas();

                } else {
                    //Crear un nuevo usuario.
                }
            }
        }

        //Render a la vista
        $router->render('auth/crear', [
            'titulo' => 'Creating',
            'usuario' => $usuario,
            'alertas' => $alertas
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