<fieldset>
    <legend>Proveedor</legend>

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="proveedor[nombre]" placeholder="Nombre del proveedor" value="<?php echo s(trim($proveedor->nombre))?>">

    <p></p>

    <label for="email">Email:</label>
    <input type="email" id="email" name="proveedor[email]" placeholder="Ej: proveedor@gmail.com" value="<?php echo s(trim($proveedor->email))?>">

    <p></p>

    <label for="telefono">Telefono:</label>
    <input type="text" id="telefono" name="proveedor[telefono]" placeholder="+51 938456239, +31..." value="<?php echo s(trim($proveedor->telefono))?>">


</fieldset>