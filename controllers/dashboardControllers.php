<?php

namespace Controllers;

use Model\Proyecto;
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

        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'alertas' => $alertas
        ]);
    }
}