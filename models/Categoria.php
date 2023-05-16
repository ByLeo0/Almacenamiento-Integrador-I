<?php

namespace Model;

class Categoria extends ActiveRecord{

    protected static $tabla = 'categoria';
    protected static $columnasDB = ['id','nombre'];

    public $id;
    public $nombre;
    

    public function __construct($args=[]){

        $this->id=$args['id'] ?? NULL;//si existe en el array $args un $key llamado 'id', entonces toma NULL.
        $this->nombre=$args['nombre'] ?? '';
        
    }

}