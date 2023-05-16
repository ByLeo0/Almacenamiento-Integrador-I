<fieldset>
    <legend>Producto</legend>

    <label for="descripcion">Descripcion:</label>
    <input type="text" id="descripcion" name="productos[descripcion]" placeholder="Nombre del producto" value="<?php echo s( $producto->descripcion ); ?>">

    <p></p>
    
    <label for="categoria">Categoria:</label>
    <select name="productos[categoria_id]">
        <option value="" disabled selected>-- Seleccione --</option>
        <?php foreach ($categorias as $categoria) { ?>
            <option <?php echo $producto->categoria_id === $categoria->id ? 'selected' : ''; ?> value="<?php echo s($categoria->id); ?>"> <?php echo s($categoria->nombre); ?> </option>
        <?php } ?>
    </select>
    
    <p></p>

    <label for="stock">Stock:</label>
    <input type="number" id="stock" name="productos[stock]" value="<?php echo s( $producto->stock ); ?>">
    
    <p></p>
    
    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="productos[imagen_producto]">

    <?php if($producto->imagen_producto) { ?>
        <img src="/imagenes/<?php echo $producto->imagen_producto ?>" class="imagen-small">
    <?php } ?>

    <p></p>

    <label for="precio_costo">Precio Costo:</label>
    <input type="number" step="0.01" id="precio_costo" name="productos[precio_costo]" value="<?php echo s( $producto->precio_costo ); ?>" oninput="calcularMultiplicacion()">

    <p></p>

    <label for="ganancia">Ganancia:</label>
    <input type="number" step="0.01" id="ganancia" name="productos[ganancia]" placeholder="Ejemplo:1.3,1.7,..." max="5" value="<?php echo s( $producto->ganancia ); ?>" oninput="calcularMultiplicacion()">

    <p></p>

    <label for="precioU_Venta">Precio Unitario Venta:</label>
    <input type="number" step="0.01" id="precioU_Venta" name="productos[precio_unitarioVenta]" value="<?php echo s( $producto->precio_unitarioVenta ); ?>" readonly>

    <script>
        function calcularMultiplicacion() {
            const p_costo = document.getElementById("precio_costo").value;
            const ganancia = document.getElementById("ganancia").value;
            if (p_costo && ganancia) {
                const precio_venta = p_costo * ganancia;
                document.getElementById("precioU_Venta").value = precio_venta;
            }

        }
    </script>

</fieldset>