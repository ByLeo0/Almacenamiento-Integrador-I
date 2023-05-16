<main class="contenedor seccion">
        <h1>Seccion Usuarios</h1>
        <?php if( intval( $resultado ) === 1): ?>
            <p class="alerta exito">Usuario Creado Correctamente</p>
        <?php elseif( intval( $resultado ) === 2): ?>
            <p class="alerta exito">Actualizado Correctamente</p>
        <?php elseif( intval( $resultado ) === 3 ): ?>
            <p class="alerta exito">Usuario Eliminado Correctamente</p>
        <?php endif; ?>

        <a href="/AgregarUsuarios" class="boton">Agregar Nuevo Usuario</a>

        <table class="propiedades">
        <thead>
                <tr>
                    <th>Codigo de Usuario</th>
                    <th>Email</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Rol</th>
                    <th>Telefono</th>
                </tr>
        </thead>
        <tbody>
        <?php foreach($usuarios as $usuario){ ?>
            <tr>
                <td><?php echo $usuario->id; ?></td>
                <td><?php echo $usuario->email; ?></td>
                <td><?php echo $usuario->nombre; ?></td>
                <td><?php echo $usuario->apellido; ?></td>
                <td><?php echo $usuario->rol; ?></td>
                <td><?php echo $usuario->telefono; ?></td>
                <td>
                        
                        <form method="POST" class="" action="/EliminarUsuarios">

                            <input type="hidden" name="id" value="<?php echo $usuario->id; ?>">

                            <input type="submit" class="boton rojo" value="Eliminar">
                        </form>
                    
                        <a href="/ActualizarUsuarios?id=<?php echo $usuario->id; ?>" class="boton naranja">Actualizar</a>
                    </td>
        <?php } ?>
            </tr>
        </tbody>

        </table>

        <a href="/inicio" class="boton">Inicio</a>

    </main>