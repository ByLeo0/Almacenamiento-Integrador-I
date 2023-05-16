<main>

    <h1>Actualizar Usuarios</h1>

    <a href="/usuarios" class="boton">Volver</a>

    <?php foreach ($alertas as $alerta) : ?>
        <div class="alerta error">
            <?php echo $alerta; ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST"><!--enctype="multipart/form-data"  Para agregar imagenes-->
        <?php include __DIR__.'/formulario.php'; ?>

        <input type="submit" value="Enviar" class="boton">

    </form>
</main>