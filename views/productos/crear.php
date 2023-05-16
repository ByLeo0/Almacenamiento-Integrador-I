
<main class="">
        <h1>Agregar Producto</h1>

        <a href="/productos" class="">Volver</a>

        <?php foreach($alertas as $alerta): ?>
        <div class="alerta error">
            <?php echo $alerta; ?>
        </div>
        <?php endforeach; ?>

        <form class="" method="POST" enctype="multipart/form-data">
        <?php include __DIR__.'/formulario.php'; ?>

            <input type="submit" value="Enviar" class="boton">
        </form> 
        
</main>