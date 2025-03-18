<?php


namespace controllers;

class LoginControllers {

    public static function login() {

        echo "Desde el login.";

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }
    }

    public static function logout() {

        echo "Desde el logout";

        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }

    }

    public static function crear() {

        echo "Desde el crear.";

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }
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