<?php


namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;


class LoginControllers {

    public static function login(Router $router) {

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);

            $alertas = $usuario->validarLogin();

            if(empty($alertas)) {
                $usuario = Usuario::where('email', $usuario->email);

                if(!$usuario || !$usuario->confirmado) {
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                } else {
                    //El usuario existe
                    if(password_verify($_POST['password'], $usuario->password)) {
    
                        //iniciar la sesion
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre; 
                        $_SESSION['email'] = $usuario->email; 
                        $_SESSION['login'] = true;

                        //redireccionar
                        header('Location: /dashboard');
                    } else {
                        Usuario::setAlerta('error', 'Contraseña incorrecta');
                        debuguear('Incorrecto');
                    }
                } 
            }
        }

        $alertas = Usuario::getAlertas();

        //Render a la vista
        $router->render('auth/login', [
            'titulo' => 'iniciar sesion',
            'alertas' => $alertas
        ]);
    }

    public static function logout() {
        isSession();
        $_SESSION = [];

        header('Location: /');
        
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
                    //Hashear el password
                    $usuario->hashearPassword();

                    //Eliminar password2
                    unset($usuario->password2);

                    //Generar toekn
                    $usuario->crearTOken();

                    //Guardar un nuevo usuario.
                  
                    $resultado = $usuario->guardar();

                    //Enviar Email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);

                    $email->enviarConfirmacion();

                    if($resultado) {
                        header('Location: /mensaje');
                    }
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

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);

            $alertas = $usuario->validarEmail();

            if(empty($alertas)) {
                //Buscar el usuario
                $usuario = Usuario::where('email',$usuario->email);

                if($usuario && $usuario->confirmado) {

                    //Generar un nuevo token
                    $usuario->crearTOken();
                    unset($usuario->password2);

                    //Actualizar el usuario
                    $usuario->guardar();

                    //Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    //Imprimir la alerta
                    Usuario::setAlerta('exito', 'Revisa tu email');
                    //$alertas = Usuario::getAlertas();
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                    //$alertas = Usuario::getAlertas();
                }
            }
        }

        $alertas = Usuario::getAlertas();
        //Render a la vista
        $router->render('auth/olvidar', [
            'titulo' => 'Olv Pass',
            'alertas' => $alertas
        ]);
    }

    public static function restablecer(Router $router) {

        $alertas =[];
        $token = s($_GET['token']);
        $mostrar = true;
        
        if(!$token) header('Location: /');

        //Identificar el usuario con este token
        $usuario = Usuario::where('token', $token);
 
        if(empty($usuario)) {

            Usuario::setAlerta('error', 'Token no valido con el usuario');
            $mostrar = false;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Agregar el nuevo password
            $usuario->sincronizar($_POST);
            
            //Validar el password
            $alertas = $usuario->validarPassword();

            if(empty($alertas)) {
                //Hashear al nuevo password
                $usuario->hashearPassword();
                unset($usuario->password2);

                //Eliminar el token
                $usuario->token = '';

                //Guardar el usuario en la db.
                $resultado = $usuario->guardar();

                //Redireccionar.
                if($resultado) {
                    header('Location: /');
                }
                debuguear($usuario);
            }
        }

        $alertas = Usuario::getAlertas();

        //Render a la vista
        $router->render('auth/restablecer', [
            'titulo' => 'Res password',
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);
    }


    public static function mensaje(Router $router) {

        //Render a la vista
        $router->render('auth/mensaje', [
            'titulo' => 'mensaje'
        ]);
    }

    public static function confirmar(Router $router) {

        $alertas = [];
        $token = s($_GET['token']);
        
        if(!$token) header('Location: /'); 

        //Encontrar al usuario con este token
        $usuario = Usuario::where('token', $token);
        if(empty($usuario)) {
            //No existe un usuario con ese token.
            Usuario::setAlerta('error', 'Token no valido');

        } else {
            //Confirmar la cuenta
            $usuario->confirmado = 1;
            unset($usuario->password2);
            $usuario->token = '';
            
            //Guardar en la base de datos.
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Tu cuenta ya esta valida');
        }

        $alertas = Usuario::getAlertas();

        //Render a la vista
        $router->render('auth/confirmar', [
            'titulo' => 'confirmar',
            'alertas' => $alertas
        ]);

    }

}