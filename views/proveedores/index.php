<main class="contenedor seccion">

    <h1>Seccion Proveedores</h1>
    <?php if (intval($resultado) === 1) : ?>
        <p class="alerta exito">Proveedor Creado Correctamente</p>
    <?php elseif (intval($resultado) === 2) : ?>
        <p class="alerta exito">Actualizado Correctamente</p>
    <?php elseif (intval($resultado) === 3) : ?>
        <p class="alerta exito">Proveedor Eliminado Correctamente</p>
    <?php endif; ?>

    <a href="/AgregarProveedores" class="boton">Agregar Nuevo Proveedor</a>
        
    <form method="GET" action="/proveedores">
        <input type="text" name="buscar" placeholder="Ingresa tu búsqueda">
        <button type="submit">Buscar</button>
    </form>


<?php if($_POST['buscar']){ ?>
    <table class="propiedades">
        <thead>
            <tr>
                <th>Codigo del proveedor</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Telefono</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prov as $pro) { ?>
                <tr>
                    <td><?php echo $pro->id; ?></td>
                    <td><?php echo $pro->nombre; ?></td>
                    <td><?php echo $pro->email; ?></td>
                    <td><?php echo $pro->telefono; ?></td>
                </tr>
            <?php } ?>
        </tbody>

    </table>
<?php } ?>

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
            <?php foreach ($proveedores as $proveedor) { ?>
                <tr>
                    <td><?php echo $proveedor->id; ?></td>
                    <td><?php echo $proveedor->nombre; ?></td>
                    <td><?php echo $proveedor->email; ?></td>
                    <td><?php echo $proveedor->telefono; ?></td>
                    <td>

                        <form method="POST" class="" action="/EliminarProveedores">

                            <input type="hidden" name="id" value="<?php echo $proveedor->id; ?>">

                            <input type="submit" class="boton rojo" value="Eliminar">
                        </form>

                        <a href="/ActualizarProveedores?id=<?php echo $proveedor->id; ?>" class="boton naranja">Actualizar</a>
                    </td>
                <?php } ?>
                </tr>
        </tbody>

    </table>

    <a href="/inicio" class="boton">Inicio</a>

</main>