<?php

namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;


class dashboardControllers {
    public static function index(Router $router) {
        isSession();
        isAuth();

        $id = $_SESSION['id'];
        $proyectos = Proyecto::belogsTo('propietarioid', $id);


        $router->render('dashboard/index', [
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos
        ]);
    }

    public static function crearP(Router $router) {
        isSession();
        isAuth();

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proyecto = new Proyecto($_POST);

            //Validacion
            $alertas = $proyecto->validarProyecto();

            if(empty($alertas)) {
                //Generar una url unico
                $hash=md5(uniqid()); //Genera un codigo aleatorio para ocultar.
                $proyecto->url = $hash;

                //Almacenar el creador del proyecto
                $proyecto->propietarioid = $_SESSION['id']; //tomamos el id del usuario.

                //guardar el proyecto
                $proyecto->guardar();

                //redireccionar
                header('Location: /proyecto?id='. $proyecto->url);
            }
        }

        $router->render('dashboard/crearP', [
            'titulo' => 'Crear',
            'alertas' => $alertas

        ]);
    }

    public static function proyecto(Router $router) {
        isSession();
        isAuth();

        $token = $_GET['id'];

        if(!$token) header('Location: /dashboard');
        

        //Revisar quien visita el proyecto es quien la creo.
        $proyecto = Proyecto::where('url', $token);
        
        if($proyecto->propietarioid !== $_SESSION['id'] ) {
            header('Location: /dashboard');
        }

        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto
        ]);
    }

    public static function perfil(Router $router) {
        isSession();
        isAuth();

        $alertas = [];

        $usuario = Usuario::find($_SESSION['id']);
       
        if($_SERVER['REQUEST_METHOD'] === 'POST') {


            $usuario->sincronizar($_POST);

            //Validacion
            $alertas = $usuario->validarPerfil();

            if(empty($alertas)) {
                //Validar el usuario
                $existeUsuario = Usuario::where('email', $usuario->email);
            
                if($existeUsuario && $existeUsuario->id !== $usuario->id) {

                    Usuario::setAlerta('error', 'El E-mail ya esta en uso');
                    $alertas = Usuario::getAlertas();

                } else {
                    //Guardar el usuario
                    $usuario->guardar();

                    Usuario::setAlerta('exito', 'Guardado correctamente');
                    $alertas = Usuario::getAlertas();

                    //Asignar el nombre nuevo a la barra
                    $_SESSION['nombre'] = $usuario->nombre;
                }

            }
        }
        

        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);
    }

    public static function cambiarPassword(Router $router) {
        isSession();
        isAuth();

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = Usuario::find($_SESSION['id']);
            //sincronizar el objeto
            $usuario->sincronizar($_POST);

            //Validacion
            $alertas = $usuario->nuevo_password();

            if(empty($alertas)) {
                
                $resultado = $usuario->comprobar_password();

                //Verificar el password
                if($resultado) {
                    
                    $usuario->password = $usuario->password_nuevo; //asignar el nuevo password

                    //eliminar el password2 del objeto
                    unset($usuario->password_actual); 
                    unset($usuario->password_nuevo);

                    //hashear el password
                    $usuario->hashearPassword(); //hashear el password nuevo

                    //Actualizar el password
                    $resultado = $usuario->guardar(); //actualizar el password en la base de datos

                    if($resultado) {
                        Usuario::setAlerta('exito', 'Password actualizado correctamente');
                        $alertas = Usuario::getAlertas();
                    } else {
                        Usuario::setAlerta('error', 'Error al actualizar el password');
                        $alertas = Usuario::getAlertas();
                    }

                } else {
                    Usuario::setAlerta('error', 'La contraseña es incorrecta');
                    $alertas = Usuario::getAlertas();
                }
            }
        }

        $router->render('dashboard/cambiar-password', [
            'titulo' => 'Cambiar Password',
            'alertas' => $alertas
        ]);
    }
}