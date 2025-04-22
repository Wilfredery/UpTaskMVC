<?php

namespace Model;

class Usuario extends ActiveRecord {
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    public $id;
    public $nombre;
    public $email;
    public $password;
    public $password2;
    public $token;
    public $confirmado;
    public $password_actual;
    public $password_nuevo;

    public function __construct($args=[]) {
        
        $this->id = $args ['id'] ?? null;
        $this->nombre = $args['nombre'] ?? ''; 
        $this->email = $args['email'] ?? ''; 
        $this->password = $args['password'] ?? ''; 
        $this->password2 = $args['password2'] ?? ''; 
        $this->password_actual = $args['password_actual'] ?? ''; 
        $this->password_nuevo = $args['password_nuevo'] ?? '';
        $this->token = $args['token'] ?? ''; 
        $this->confirmado = $args['confirmado'] ?? 0; 
    }

    //Validar el login de usuarios
    public function validarLogin() {

        if(!$this->email) {
            self::$alertas['error'][] = 'El E-mail del usuario es obligatorio';
        }

        //Validacion de que tenga el @
        //Dos parametros uno lo que va a buscar y el segundo es el filtro que queremos bregar.
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no valido';
        }


        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña del usuario es obligatorio';
        }
        
        return self::$alertas;
    }

    //Validacion para cuentas nuevas
    public function validarNuevaCuenta() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre del usuario es obligatorio';
        }

        if(!$this->email) {
            self::$alertas['error'][] = 'El E-mail del usuario es obligatorio';
        }

        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña del usuario es obligatorio';
        }

        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La contraseña debe de tener al menos 6 caracteres';
        }

        if($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Los password son diferentes';
        }

        return self::$alertas;
    }

    //Validacion para el perfil
    public function validarPerfil() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre del usuario es obligatorio';
        }

        if(!$this->email) {
            self::$alertas['error'][] = 'El E-mail del usuario es obligatorio';
        }

        return self::$alertas;
    }

    public function nuevo_password() {

        if(!$this->password_actual) {
            self::$alertas['error'][] = 'El password actual es obligatorio';
        }   

        if(!$this->password_nuevo) {
            self::$alertas['error'][] = 'El password nuevo es obligatorio';
        }  


        if(strlen($this->password_nuevo) < 6) {
            self::$alertas['error'][] = 'La contraseña debe de tener al menos 6 caracteres';
        }

        return self::$alertas;
    }

    //comprobar el password
    public function comprobar_password() : bool{
        return password_verify($this->password_actual, $this->password);
    }

    //Hashea el password
    public function hashearPassword() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function validarPassword() : array {
        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña del usuario es obligatorio';
        }

        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La contraseña debe de tener al menos 6 caracteres';
        }

        return self::$alertas;
    }
    //Generar un Token
    public function crearTOken() : void {
        //Generar un token unico
        $this->token = uniqid();
    }

    public function validarEmail() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }

        //Validacion de que tenga el @
        //Dos parametros uno lo que va a buscar y el segundo es el filtro que queremos bregar.
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no valido';
        }

        return self::$alertas;
    }
}