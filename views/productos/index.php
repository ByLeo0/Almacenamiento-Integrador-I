<style>
        .imagen-tabla{
            width: 20rem;
        }
    </style>
<main class="contenedor seccion">
        <h1>Seccion Productos</h1>

        <?php if( intval( $resultado ) === 1): ?>
            <p class="alerta exito">Producto Creado Correctamente</p>
        <?php elseif( intval( $resultado ) === 2): ?>
            <p class="alerta exito">Actualizado Correctamente</p>
        <?php elseif( intval( $resultado ) === 3 ): ?>
            <p class="alerta exito">Producto Eliminado Correctamente</p>
        <?php endif; ?>

        <a href="/AgregarProductos" class="boton">Agregar Nuevo Producto</a>

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
            <?php foreach($productos as $producto){ ?>
                <tr>

                    <td><?php echo $producto->id; ?></td>
                    <td><?php echo $producto->descripcion ?></td>
                    <td><?php foreach($categorias as $categoria) {
                        if($categoria->id==$producto->categoria_id){
                            echo $categoria->nombre;
                        }
                    }
                    ?></td>
                    <?php //$categoria=Categoria::findNombre($producto->categoria_id); ?>
                    <?php //$query1="SELECT nombre FROM categoria where idcategoria= ". $producto['categoria_id']." LIMIT 1 ";?>
                    <?PHP //var_dump($categoria); ?>
                    <?php //$resultadoConsulta1=mysqli_query($db,$query1); ?>
                    <?php //$categoria = mysqli_fetch_assoc($resultadoConsulta1) ?>
                    <?PHP //var_dump($categoria['nombre']); ?>
                    <td><?php echo $producto->stock; ?></td>
                    <td> <img src="/imagenes/<?php echo $producto->imagen_producto; ?>" class="imagen-tabla"> </td>
                    
                    <td>
                        
                        <form method="POST" class="" action="/EliminarProductos">

                            <input type="hidden" name="id" value="<?php echo $producto->id; ?>">

                            <input type="submit" class="boton rojo" value="Eliminar">
                        </form>
                    
                        <a href="/ActualizarProductos?id=<?php echo $producto->id; ?>" class="boton naranja">Actualizar</a>
                    </td>
            <?php } ?>
                </tr>
            </tbody>

        </table>

        <a href="/inicio" class="boton">Inicio</a>

    </main>