<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesión</h1>

    <?php foreach($alertas as $alerta): ?>
        <div class="alerta error">
            <?php echo $alerta; ?>
        </div>
    <?php endforeach; ?>

    <form method="POST" class="formulario" action="/login" novalidate>
        <fieldset>
            <legend>Email y Password</legend>

            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="Tu Email" id="email" value="<?php echo $auth->email; ?>">

            

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Tu Password" id="password" value="<?php echo $auth->password; ?>">
        </fieldset>
    
        <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
    </form>
</main>