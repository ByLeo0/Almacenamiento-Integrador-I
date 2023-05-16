<?php

namespace Model;

class Proveedor extends ActiveRecord{

    protected static $tabla = 'proveedor';
    protected static $columnasDB = ['id','nombre', 'email','telefono'];

    public $id;
    public $nombre;
    public $email;
    public $telefono;
    

    public function __construct($args=[]){

        $this->id=$args['id'] ?? NULL;//si existe en el array $args un $key llamado 'id', entonces toma NULL.
        $this->nombre=$args['nombre'] ?? '';
        $this->email=$args['email'] ?? '';
        $this->telefono=$args['telefono'] ?? '';
        
    }

    public function validar() {

        if(!$this->nombre){
            self::$alertas[]="Debes añadir un nombre";
        }elseif(!preg_match('/^[a-zA-Z0-9\s.]+$/',$this->nombre)){//'/[+][0-9]/' esta funcion toma una expresion regular y hace que siga un patron, en este caso va del 0 al 9 y tiene que tener max 10 digitos
            self::$alertas[]="Formato no válido del nombre";
        }
        if(!$this->email){
            self::$alertas[]="Debes colocar el email";
        }elseif(!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',$this->email)){//esta funcion toma una expresion regular y hace que siga un patron, en este caso va del 0 al 9 y tiene que tener max 10 digitos
            self::$alertas[]="Formato no válido del email";
        }
        if(!$this->telefono){
            self::$alertas[]="Debes colocar el telefono";
        }elseif(!preg_match('/^\+51\s9\d{8}$/', $this->telefono)){//'/[+][0-9]/' esta funcion toma una expresion regular y hace que siga un patron, en este caso va del 0 al 9 y tiene que tener max 10 digitos
            self::$alertas[]="Formato no válido del telefono";
        }
        
        return self::$alertas;

    }

}