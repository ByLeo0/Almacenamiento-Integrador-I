<?php 

function conectarDB(): mysqli {
    $db = mysqli_connect('localhost', 'root', 'root', 'bd_almacen');

    if(!$db) {
        echo "Error no se pudo conectar";
        exit;
    }
    
    return $db;
}