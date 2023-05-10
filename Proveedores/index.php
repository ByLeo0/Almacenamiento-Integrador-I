<?php
    require '../includes/funciones.php';
    $auth = estaAutenticado();

    if(!$auth) {
        header('Location: /');
    }

    //Importar la conexión
    require '../includes/config/database.php';
    $db = conectarDB();

    //Escribir el Query
    $query= "SELECT * FROM proveedor";

    //Consultar la BD
    $resultadoConsulta=mysqli_query($db,$query);


    //Muestra mensaje condicional
    $resultado=$_GET['resultado'] ?? null;

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $idproveedor = $_POST['idproveedor'];
        $idproveedor = filter_var($idproveedor, FILTER_VALIDATE_INT);

        if($idproveedor) {

            
            // Eliminar los proveedores
            $query = "DELETE FROM proveedor WHERE idproveedor = $idproveedor";
            $resultado = mysqli_query($db, $query);

            if($resultado) {
                header('location: /Proveedores?resultado=3');
            }
        }
        
    }
?>


    <main class="contenedor seccion">
        <h1>Seccion Proveedores</h1>
        <?php if( intval( $resultado ) === 1): ?>
            <p class="alerta exito">Proveedor Creado Correctamente</p>
        <?php elseif( intval( $resultado ) === 2): ?>
            <p class="alerta exito">Actualizado Correctamente</p>
        <?php elseif( intval( $resultado ) === 3 ): ?>
            <p class="alerta exito">Proveedor Eliminado Correctamente</p>
        <?php endif; ?>

        <a href="/Proveedores/propiedades/crear.php" class="boton">Agregar Nuevo Proveedor</a>

        <table class="propiedades">
        <thead>
                <tr>
                    <th>Codigo del proveedor</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
        </thead>
        <tbody>
        <?php while( $proveedor = mysqli_fetch_assoc($resultadoConsulta)): ?>
            <tr>
                <td><?php echo $proveedor['idproveedor']; ?></td>
                <td><?php echo $proveedor['nombre']; ?></td>
                <td><?php echo $proveedor['email']; ?></td>
                <td><?php echo $proveedor['telefono']; ?></td>
                <td>
                        
                        <form method="POST" class="">

                            <input type="hidden" name="idproveedor" value="<?php echo $proveedor['idproveedor']; ?>">

                            <input type="submit" class="boton rojo" value="Eliminar">
                        </form>
                    
                        <a href="Proveedores/propiedades/actualizar.php?idproveedor=<?php echo $proveedor['idproveedor']; ?>" class="boton naranja">Actualizar</a>
                    </td>
        <?php endwhile; ?>
            </tr>
        </tbody>

        </table>

        <a href="/" class="boton">Inicio</a>

    </main>