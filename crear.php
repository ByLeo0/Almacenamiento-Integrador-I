<?php

    //Base de datos
    require '../../includes/config/database.php';
    $db=conectarDB();

    // Consultar para obtener los categorias
    $consulta = "SELECT * FROM categoria";
    $resultado = mysqli_query($db, $consulta);

    //Arreglo con mensajes de errores
    $errores=[];

    $descripcion='';
    $categoriaId='';
    $stock='';
    $precio_costo='';
    $ganancia='';
    $precioU_Venta='';

    if($_SERVER['REQUEST_METHOD']==='POST'){

        $descripcion=mysqli_real_escape_string( $db, $_POST['descripcion']);
        $categoriaId=mysqli_real_escape_string( $db, $_POST['categoria']);
        $stock=mysqli_real_escape_string( $db, $_POST['stock']);
        $precio_costo=mysqli_real_escape_string( $db, $_POST['precio_costo']);
        $ganancia=mysqli_real_escape_string( $db, $_POST['ganancia']);
        $precioU_Venta=mysqli_real_escape_string( $db, $_POST['precioU_Venta']);

        $imagen = $_FILES['imagen'];

        if(!$descripcion){
            $errores[]="Debes añadir una descripcion";
        }
        if(!$categoriaId){
            $errores[]="Debes elegir la categoria";
        }
        if(!$stock){
            $errores[]="Debes colocar el stock";
        }
        if(!$precio_costo){
            $errores[]="Debes colocar el precio costo";
        }
        if(!$ganancia){
            $errores[]="Debes colocar la ganancia";
        }
        if(!$precioU_Venta){
            $errores[]="Debes colocar el precio unitario de venta";
        }
        if(!$imagen['name'] || $imagen['error'] ) {//el error aparerece porque php solo acepta 2MB maximo
            $errores[] = 'La Imagen es Obligatoria';
        }

        // Validar por tamaño (1mb máximo)
        $medida = 1000 * 1000;

        if($imagen['size'] > $medida ) {
            $errores[] = 'La imagen es muy pesada';
        }


        if(empty($errores)){

            /** SUBIDA DE ARCHIVOS */

            // Crear carpeta
            $carpetaImagenes = '../../imagenes/';

            if(!is_dir($carpetaImagenes)) {
                mkdir($carpetaImagenes);
            }

            // Generar un nombre único
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

            // Subir la imagen
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen );//tmp_name es el atributo que le da el archivo cuando se sube la imagen


            
            //Insertar en la base de datos
            $query = "INSERT INTO productos (descripcion, categoria_id, stock, imagen_producto, precio_costo, ganancia, precio_unitarioVenta)
            VALUES ('$descripcion','$categoriaId', '$stock','$nombreImagen','$precio_costo','$ganancia','$precioU_Venta')";

            //echo $query;
        
            $resultado= mysqli_query($db, $query);

            if($resultado){
                //Para saber si se insertaron los valores en la base de datos
                //echo "Insertado correctamente";

                //Redireccionar al usuario, se usa poco y solo se puede usar si es que no hay html antes de esta funcion
                header('Location: /admin?resultado=1');
            }
        }
    }

?>

    <main>
        <h1>Agregar Producto</h1>

        <a href="/admin" class="boton">Volver</a>

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
            <fieldset>
                <legend>Producto</legend>

                <label for="descripcion">Descripcion:</label>
                <input type="text" id="descripcion" name="descripcion" placeholder="Nombre del producto" value="<?php echo $descripcion; ?>">
                
                <p></p>

                <label for="categoria">Categoria:</label>
                <select name="categoria">
                    <option value="" disabled selected>-- Seleccione --</option>
                    <?php while($categoria =  mysqli_fetch_assoc($resultado) ) : ?>
                        <option <?php echo $categoriaId === $categoria['idcategoria'] ? 'selected' : ''; ?> value="<?php echo $categoria['idcategoria']; ?>"> <?php echo $categoria['nombre']; ?> </option>
                    <?php endwhile; ?>
                </select>

                <p></p>

                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" value="<?php echo $stock; ?>">

                <p></p>

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

                <p></p>

                <label for="precio_costo">Precio Costo:</label>
                <input type="number" id="precio_costo" name="precio_costo" value="<?php echo $precio_costo; ?>" oninput="calcularMultiplicacion()">

                <p></p>

                <label for="ganancia">Ganancia:</label>
                <input type="number" id="ganancia" name="ganancia" placeholder="Ejemplo:1.3,1.7,..." max="5" value="<?php echo $ganancia; ?>" oninput="calcularMultiplicacion()">

                <p></p>
                    
                <label for="precioU_Venta">Precio Unitario Venta:</label>
                <input type="number" id="precioU_Venta" name="precioU_Venta" value="<?php echo $precioU_Venta; ?>" readonly>
                
                <script>
                    function calcularMultiplicacion() {
                        const p_costo = document.getElementById("precio_costo").value;
                        const ganancia = document.getElementById("ganancia").value;
                        if(p_costo && ganancia){
                            const precio_venta = p_costo * ganancia;
                            document.getElementById("precioU_Venta").value = precio_venta;
                        }
                        
                    }
                </script>

            </fieldset>

            <input type="submit" value="Enviar" class="boton">
        </form> 
        
    </main>

