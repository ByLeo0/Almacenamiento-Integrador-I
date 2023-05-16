<style>
        .imagen-small{
            
            width: 20rem;
        }
</style>
<main>
    <h1>Actualizar Producto</h1>

    <a href="/productos" class="boton">Volver</a>

    <?php foreach ($alertas as $alerta) : ?>
        <div class="alerta error">
            <?php echo $alerta; ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST" enctype="multipart/form-data">

    <?php include __DIR__.'/formulario.php'; ?>

        <input type="submit" value="Enviar" class="boton">
    </form>

</main>