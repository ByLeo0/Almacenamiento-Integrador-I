<?php

namespace Controllers;

use MVC\Router;
use Model\Producto;
use Model\Categoria;
use Intervention\Image\ImageManagerStatic as Image;

class ProductosController{
    public static function productos(Router $router){
        $productos=Producto::all();
        $categorias=Categoria::all();

        //Muestra mensaje condicional
        $resultado=$_GET['resultado'] ?? null;

        $router->render('productos/index',[
            'productos'=>$productos,
            'categorias'=>$categorias,
            'resultado'=>$resultado
        ]);

    }

    public static function crear(Router $router){
        $producto= new Producto;//esto es para tener al objeto vacio

        // Consultar para obtener los categorias
        $categorias = Categoria::all();
    
        //Arreglo con mensajes de errores
        $alertas=Producto::getAlertas();

        if($_SERVER['REQUEST_METHOD']==='POST'){

            $producto= new Producto($_POST['productos']);
    
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";
    
            // Setear la imagen
            // Realiza un resize a la imagen con intervention
            if($_FILES['productos']['tmp_name']['imagen_producto']){//si existe entonces lo va a colocar(setImagen)
                $image = Image::make($_FILES['productos']['tmp_name']['imagen_producto'])->fit(800,600);//estas son funciones del composer
                $producto->setImagen($nombreImagen);//ponemos el nombre de la imagen en el array $propiedad
            }
    
            // Validar
            $alertas = $producto->validar();
    
    
            if(empty($alertas)){
    
                // Crear la carpeta para subir imagenes
                if(!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }
    
                // Guarda la imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);
    
                $resultado=$producto->guardar();
                if($resultado) {
                    header('location: /productos?resultado=1');
                }
    
            }

        }

        $router->render('productos/crear',[
            'alertas' => $alertas,
            'producto'=>$producto,
            'categorias'=>$categorias
        ]);
    }

    public static function actualizar(Router $router){
        $id = validarORedireccionar('/productos');

        // Obtener los datos de la propiedad
        $producto= Producto::find($id);
        
        // Consultar para obtener los vendedores
        $categorias = Categoria::all();

        //Arreglo con mensajes de errores
        $alertas=Producto::getAlertas();
        

        if($_SERVER['REQUEST_METHOD']==='POST'){

            $args=$_POST['productos'];
    
            //para que los valores que actualices, se inserten en una array nuevo
            $producto->sincronizar($args);
            //y luego sean validadas, es decir si está está completa
            $alertas=$producto->validar();
    
            // Subida de archivos
            // Generar un nombre único
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";
    
            if($_FILES['productos']['tmp_name']['imagen_producto']) {//si existe esta imagen, entonces 
                $image = Image::make($_FILES['productos']['tmp_name']['imagen_producto'])->fit(800,600);//crea la imagen como se pide
                $producto->setImagen($nombreImagen);//ponemos el nombre de la imagen en el array $propiedad
            }
    
    
            if(empty($alertas)){
    
                // Almacenar la imagen
                //como el "actualizar" de imagen es "eliminar y crear", entonces hacemos de nuevo la comprobacion
                if($_FILES['productos']['tmp_name']['imagen_producto']) {
                    $image->save(CARPETA_IMAGENES . $nombreImagen);//entonces guardamos la imagen en el array
                    //el codigo de arriba solo se debe ejecutar si hay una nueva imagen
                }
                $resultado=$producto->guardar();
                if($resultado){
                    header('Location: /productos?resultado=2');
                }
            }
        }

        $router->render('productos/actualizar',[
            'producto'=>$producto,
            'alertas'=>$alertas,
            'categorias'=>$categorias
        ]);
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            
            if($id) {
    
                $eliminar=Producto::find($id);

                $resultado=$eliminar->eliminar();

                if ($resultado) {
                    $eliminar->borrarImagen();
                    header('location: /productos?resultado=3');
                }
            }
            
        }
        
    }
}