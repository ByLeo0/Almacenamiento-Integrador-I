<?php

namespace Model;

class Producto extends ActiveRecord{

    protected static $tabla = 'productos';
    protected static $columnasDB = ['id','descripcion', 'categoria_id','stock', 'imagen_producto','precio_costo','ganancia','precio_unitarioVenta'];

    public $id;
    public $descripcion;
    public $categoria_id;
    public $stock;
    public $imagen_producto;
    public $precio_costo;
    public $ganancia;
    public $precio_unitarioVenta;

    public function __construct($args=[]){

        $this->id=$args['id'] ?? NULL;//si existe en el array $args un $key llamado 'id', entonces toma NULL.
        $this->descripcion=$args['descripcion'] ?? '';
        $this->categoria_id=$args['categoria_id'] ?? '';
        $this->stock=$args['stock'] ?? '';
        $this->imagen_producto=$args['imagen_producto'] ?? '';
        $this->precio_costo=$args['precio_costo'] ?? '';
        $this->ganancia=$args['ganancia'] ?? '';
        $this->precio_unitarioVenta=$args['precio_unitarioVenta'] ?? '';
    }

    public function validar() {

        if(!$this->descripcion){
            self::$alertas[]="Debes añadir una descripcion";
        }
        if(!$this->categoria_id){
            self::$alertas[]="Debes elegir la categoria";
        }
        if(!$this->stock){
            self::$alertas[]="Debes colocar el stock";
        }
        if(!$this->precio_costo){
            self::$alertas[]="Debes colocar el precio costo";
        }
        if(!$this->ganancia){
            self::$alertas[]="Debes colocar la ganancia";
        }
        if(!$this->precio_unitarioVenta){
            self::$alertas[]="Debes colocar el precio unitario de venta";
        }

        if(!$this->imagen_producto ) {
            self::$alertas[] = 'La Imagen es Obligatoria';
        }


        return self::$alertas;

    }
}