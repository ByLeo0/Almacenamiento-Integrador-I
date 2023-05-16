<fieldset>
    <legend>Usuario</legend>

    <label for="email">Email:</label>
    <input type="email" id="email" name="usuario[email]" placeholder="Ej: usuario@correo.com" value="<?php echo s(trim($usuario->email)); ?>">

    <p></p>

    <?PHP if(is_null($usuario->id)) {  ?>
    <label for="contraseña">Contraseña:</label>
    <input type="password" id="contraseña" name="usuario[password]" placeholder="Contraseña" value="<?php echo s($usuario->password); ?>">

    <p></p>
    <?php } ?>

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="usuario[nombre]" placeholder="Nombre" value="<?php echo s($usuario->nombre); ?>">

    <p></p>

    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="usuario[apellido]" placeholder="Apellido" value="<?php echo s($usuario->apellido); ?>">
    
    <p></p>

    <label for="rol">Rol:</label>
    <input type="text" id="rol" name="usuario[rol]" placeholder="Admin/Trabajador" value="<?php echo s(trim($usuario->rol)); ?>">

    <p></p>

    <label for="telefono">Telefono:</label>
    <input type="text" id="telefono" name="usuario[telefono]" placeholder="938456239, 987..." value="<?php echo s(trim($usuario->telefono)); ?>">


</fieldset>