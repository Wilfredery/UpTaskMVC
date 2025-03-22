<?php

namespace Model;

class Usuario extends ActiveRecord {
    protected static $tabla = 'usuarios';
    protected static $colunasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    public $id;
    public $nombre;
    public $email;
    public $password;
    public $password2;
    public $token;
    public $confirmado;

    public function __construct($args=[]) {
        
        $this->id = $args ['id'] ?? null;
        $this->nombre = $args['nombre'] ?? ''; 
        $this->email = $args['email'] ?? ''; 
        $this->password = $args['password'] ?? ''; 
        $this->password2 = $args['password2'] ?? ''; 
        $this->token = $args['token'] ?? ''; 
        $this->confirmado = $args['confirmado'] ?? ''; 
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

}