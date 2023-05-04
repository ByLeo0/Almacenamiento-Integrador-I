<?php

    //Base de datos
    require '../../includes/config/database.php';
    $db=conectarDB();

    // Consultar para obtener los vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);
