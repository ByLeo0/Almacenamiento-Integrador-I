<?php

// Importar la conexión
require 'includes/config/database.php';
$db = conectarDB();

// Crear un email y password
/*

primero ejecutar un usuario y luego el otro

$email = "juan_123@correo.com";
$password = "123456";
$nombre="Juan";
$apellido="Torres";
$rol="administrador";
$telefono="925687125";

//////////////////////

$email = "pedro_321@correo.com";
$password = "123";
$nombre="Pedro";
$apellido="Cardenas";
$rol="trabajador";
$telefono="963852741";
*/


$passwordHash = password_hash($password, PASSWORD_BCRYPT);

//HAY VARIAS MANERAS DE HASHEAR PASSWORDS
//$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Query para crear el usuario
$query = " INSERT INTO usuarios (email, password,nombre,apellido,rol,telefono) VALUES ( '$email', '$passwordHash','$nombre','$apellido','$rol','$telefono'); ";

// echo $query;

// Agregarlo a la base de datos
mysqli_query($db, $query);