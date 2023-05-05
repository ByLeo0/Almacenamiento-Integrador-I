<?php


    //Importar la conexión
    require '../includes/config/database.php';
    $db = conectarDB();

    //Escribir el Query
    $query= "SELECT * FROM productos";

    //Consultar la BD
    $resultadoConsulta=mysqli_query($db,$query);

    $query1= "SELECT nombre
    FROM categoria
    INNER JOIN productos ON idcategoria = productos.categoria_id ORDER BY idproductos;";
    $resultadoConsulta1=mysqli_query($db,$query1);
    
    

    //Muestra mensaje condicional
    $resultado=$_GET['resultado'] ?? null;
    
    
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $idproductos = $_POST['idproductos'];
        $idproductos = filter_var($idproductos, FILTER_VALIDATE_INT);

        if($idproductos) {

            // Eliminar el archivo
            $query = "SELECT imagen_producto FROM productos WHERE idproductos = $idproductos";

            $resultado = mysqli_query($db, $query);
            $producto = mysqli_fetch_assoc($resultado);
            
            unlink('../imagenes/' . $producto['imagen_producto']);
    
            // Eliminar la propiedad
            $query = "DELETE FROM productos WHERE idproductos = $idproductos";
            $resultado = mysqli_query($db, $query);

            if($resultado) {
                header('location: /admin?resultado=3');
            }
        }
        
    }
    
    

?>
    <style>
        .imagen-tabla{
            width: 10rem;
        }
    </style>
    <main class="contenedor seccion">
        <h1>Administrador de bienes Raices</h1>

        <?php if( intval( $resultado ) === 1): ?>
            <p class="alerta exito">Anuncio Creado Correctamente</p>
        <?php elseif( intval( $resultado ) === 2): ?>
            <p class="alerta exito">Actualizado Correctamente</p>
        <?php elseif( intval( $resultado ) === 3 ): ?>
            <p class="alerta exito">Anuncio Eliminado Correctamente</p>
        <?php endif; ?>

        <a href="/admin/propiedades/crear.php" class="boton">Agregar Nuevo Producto</a>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>Codigo del producto</th>
                    <th>Descripcion</th>
                    <th>Categoria</th>
                    <th>Stock</th>
                    <th>Imagen del Producto</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
            <?php while( $producto = mysqli_fetch_assoc($resultadoConsulta)): ?>
                <tr>

                    <td><?php echo $producto['idproductos']; ?></td>
                    <td><?php echo $producto['descripcion']; ?></td>
                    <?php $categoria = mysqli_fetch_assoc($resultadoConsulta1) ?>
                    <td><?php echo $categoria['nombre']; ?></td>
                    <td><?php echo $producto['stock']; ?></td>
                    <td> <img src="/imagenes/<?php echo $producto['imagen_producto']; ?>" class="imagen-tabla"> </td>
                    
                    <td>
                        
                        <form method="POST" class="">

                            <input type="hidden" name="idproductos" value="<?php echo $producto['idproductos']; ?>">

                            <input type="submit" class="boton rojo" value="Eliminar">
                        </form>
                    
                        <a href="admin/propiedades/actualizar.php?idproductos=<?php echo $producto['idproductos']; ?>" class="boton naranja">Actualizar</a>
                    </td>
            <?php endwhile; ?>
                </tr>
            </tbody>

        </table>
    </main>
