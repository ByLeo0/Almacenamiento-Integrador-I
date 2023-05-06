<?php

    
    $idproveedor = $_GET['idproveedor'];
    $idproveedor = filter_var($idproveedor, FILTER_VALIDATE_INT);

    if(!$idproveedor) {
        header('Location: /Proveedores');
    }

    //Base de datos
    require '../../includes/config/database.php';
    $db=conectarDB();

    // Obtener los datos del proveedor
    $consulta = "SELECT * FROM proveedor WHERE idproveedor = $idproveedor";
    $resultado = mysqli_query($db, $consulta);
    $proveedor = mysqli_fetch_assoc($resultado);

    //Arreglo con mensajes de errores
    $errores=[];

    //muestra los datos de la propiedad, ojo: tiene que ser la variable igual al del sql(lo que está dentro del corchete[])
    $nombreProv=$proveedor['nombre'];
    $emailProv=$proveedor['email'];
    $telefonoProv=$proveedor['telefono'];

    if($_SERVER['REQUEST_METHOD']==='POST'){
        
        $nombreProv = mysqli_real_escape_string($db, $_POST['nombre']);
        $emailProv = mysqli_real_escape_string($db, $_POST['email']);
        $telefonoProv = mysqli_real_escape_string($db, $_POST['telefono']);

        if (!$nombreProv) {
            $errores[] = "Debes añadir un nombre";
        }
        if (!$emailProv) {
            $errores[] = "Debes colocar el email";
        }
        if (!$telefonoProv) {
            $errores[] = "Debes colocar el telefono";
        }
        
        if (empty($errores)) {

            //Insertar en la base de datos
            $query = "UPDATE proveedor SET nombre='$nombreProv',email='$emailProv',telefono='$telefonoProv' WHERE idproveedor = $idproveedor";
    
            //echo $query;
    
    
            $resultado = mysqli_query($db, $query);
    
            
            if ($resultado) {
                //Para saber si se insertaron los valores en la base de datos
                //echo "Insertado correctamente";
    
                //Redireccionar al usuario, se usa poco y solo se puede usar si es que no hay html antes de esta funcion
                header('Location: /Proveedores?resultado=2');
            }
        }
    }

?>

    <main>

        <h1>Actualizar Proveedores</h1>

        <a href="/Proveedores" class="boton">Volver</a>

        <?php foreach ($errores as $error) : ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST"><!--enctype="multipart/form-data"  Para agregar imagenes-->
            <fieldset>
                <legend>Proveedor</legend>

                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Nombre del proveedor" value="<?php echo $nombreProv; ?>">

                <p></p>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Ej: proveedor@gmail.com" value="<?php echo $emailProv; ?>">

                <p></p>

                <label for="telefono">Telefono:</label>
                <input type="tel" id="telefono" name="telefono" placeholder="+51 938456239, +31..." value="<?php echo $telefonoProv; ?>">


            </fieldset>

            <input type="submit" value="Enviar" class="boton">

        </form>
