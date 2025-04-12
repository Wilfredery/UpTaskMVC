<?php

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;

class TareaControllers {

    public static function index() {
        
        isSession();

        $proyectoid = $_GET['id'];

        if(!$proyectoid) header('Location: /dashboard');

        $proyecto = Proyecto::where('url', $proyectoid);

        if(!$proyecto || $proyecto->propietarioid != $_SESSION['id']) header('location: /404');


        $tareas = Tarea::belogsTo('proyectoid', $proyecto->id);
        echo json_encode(['tareas' => $tareas]);
    }
    
    public static function crear() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            isSession();

            $proyectoid = $_POST['proyectoid'];

            $proyecto = Proyecto::where('url', $proyectoid);

            if(!$proyecto || $proyecto->propietarioid !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un Error al agregar la tarea.',
                    'proyectoid' => $proyecto->id
                ];

                echo json_encode($respuesta);
                return;
            } 

            //Todo bien, instanciar y crear la tarea.

            $tarea = new Tarea($_POST);
            $tarea->proyectoid = $proyecto->id;
            $resultado = $tarea->guardar();
            $respuesta = [
                'tipo' =>'exito',
                'id' => $resultado['id'],
                'mensaje' => 'Tarea creada correctamente',
                
            ];
            echo json_encode($respuesta);
            //     $respuesta = [
            //         'tipo' => 'exito',
            //         'mensaje' => 'La tarea se agrego correctamente.'
            //     ];

            //     echo json_encode($respuesta);
            // }
        }
    }
    
    public static function actualizar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }
    }
}