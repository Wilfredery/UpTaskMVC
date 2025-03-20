<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\LoginControllers;
use MVC\Router;
$router = new Router();

$router->get('/', [LoginControllers::class, 'login']);
$router->post('/', [LoginControllers::class, 'login']);
$router->get('/logout', [LoginControllers::class, 'logout']);

//Crear cuenta
$router->get('/crear', [LoginControllers::class, 'crear']);
$router->post('/crear', [LoginControllers::class, 'crear']);

//Olvide mi password.
$router->get('/olvidar', [LoginControllers::class, 'olvidar']);
$router->post('/olvidar', [LoginControllers::class, 'olvidar']);

//Colocar el nuevo password
$router->get('/restablecer', [LoginControllers::class, 'restablecer']);
$router->post('/restablecer', [LoginControllers::class, 'restablecer']);

//Colocar el nuevo password
$router->get('/mensaje', [LoginControllers::class, 'mensaje']);
$router->get('/confirmar', [LoginControllers::class, 'confirmar']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();