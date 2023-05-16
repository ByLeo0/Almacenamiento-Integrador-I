<fieldset>
    <legend>Clientes</legend>

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="cliente[nombre]" placeholder="Nombre del cliente" value="<?php echo s(trim($cliente->nombre))?>">

    <p></p>

    <label for="email">Email:</label>
    <input type="email" id="email" name="cliente[email]" placeholder="Ej: cliente@gmail.com" value="<?php echo s(trim($cliente->email))?>">

    <p></p>

    <label for="telefono">Telefono:</label>
    <input type="text" id="telefono" name="cliente[telefono]" placeholder="+51 938456239, +31..." value="<?php echo s(trim($cliente->telefono))?>">


</fieldset>