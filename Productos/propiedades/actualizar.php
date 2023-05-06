<?php

    
    $idproductos = $_GET['idproductos'];
    $idproductos = filter_var($idproductos, FILTER_VALIDATE_INT);

    if(!$idproductos) {
        header('Location: /Productos');
    }

    //Base de datos
    require '../../includes/config/database.php';
    $db=conectarDB();

    // Obtener los datos de la propiedad
    $consulta = "SELECT * FROM productos WHERE idproductos = $idproductos";
    $resultado = mysqli_query($db, $consulta);
    
    if($resultado->num_rows===0){
        header('Location: /Productos');
    }
   
    $productos = mysqli_fetch_assoc($resultado);

    // Consultar para obtener los vendedores
    $consulta = "SELECT * FROM categoria";
    $resultado = mysqli_query($db, $consulta);

    //Arreglo con mensajes de errores
    $errores=[];

    //muestra los datos de la propiedad, ojo: tiene que ser la variable igual al del sql(lo que está dentro del corchete[])
    $descripcion=$productos['descripcion'];
    $categoriaId=$productos['categoria_id'];
    $stock=$productos['stock'];
    $imagenProducto=$productos['imagen_producto'];
    $precio_costo=$productos['precio_costo'];
    $ganancia=$productos['ganancia'];
    $precioU_Venta=$productos['precio_unitarioVenta'];

    if($_SERVER['REQUEST_METHOD']==='POST'){
        /*
        echo "<pre>";
        var_dump($_POST);
        echo "</pre>";
        */
        
        //sanitizamos con msqli_real_scape_strin($db,......), lo de los puntos seria las variables normales sin satinizar
        $descripcion = mysqli_real_escape_string( $db,  $_POST['descripcion'] );
        $categoriaId = mysqli_real_escape_string( $db,  $_POST['categoria'] );
        $stock = mysqli_real_escape_string( $db,  $_POST['stock'] );
        $precio_costo = mysqli_real_escape_string( $db,  $_POST['precio_costo'] );
        $ganancia = mysqli_real_escape_string( $db,  $_POST['ganancia'] );
        $precioU_Venta = mysqli_real_escape_string( $db,  $_POST['precioU_Venta'] );

        // Asignar files hacia una variable
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
        

        // Validar por tamaño (1mb máximo)
        $medida = 1000 * 1000;

        if($imagen['size'] > $medida ) {
            $errores[] = 'La imagen es muy pesada';
        }

        /*
        echo "<pre>";
        var_dump($errores);
        echo "</pre>";
        */

        if(empty($errores)){

            /** SUBIDA DE ARCHIVOS */
            
            // Crear carpeta
            $carpetaImagenes = '../../img/productos/';

            if(!is_dir($carpetaImagenes)) {
                mkdir($carpetaImagenes);
            }

            $nombreImagen = '';

            /** SUBIDA DE ARCHIVOS */

            if($imagen['name']) {
                // Eliminar la imagen previa, esto es para no llenar mi carpeta de imagenes

                unlink($carpetaImagenes . $productos['imagen_producto']);

                // // Generar un nombre único
                $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

                // // Subir la imagen
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen );
            } else {
                $nombreImagen = $productos['imagen_producto'];
            }

            
            //Insertar en la base de datos
            $query = "UPDATE productos SET descripcion = '$descripcion', categoria_id = $categoriaId, stock=$stock, imagen_producto = '$nombreImagen', precio_costo = $precio_costo, ganancia = $ganancia, precio_unitarioVenta = $precioU_Venta WHERE idproductos = $idproductos";
        
            //echo $query;
                    

            $resultado= mysqli_query($db, $query);

            if($resultado){
                //Para saber si se insertaron los valores en la base de datos
                //echo "Insertado correctamente";

                //Redireccionar al usuario, se usa poco y solo se puede usar si es que no hay html antes de esta funcion
                header('Location: /Productos?resultado=2');
            }
        }
    }

?>  
    <style>
        .imagen-small{
            width: 10rem;
        }
    </style>

    <main>
        <h1>Actualizar Producto</h1>

        <a href="/Productos" class="boton">Volver</a>

        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" enctype="multipart/form-data">
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

                <img src="/img/productos/<?php echo $imagenProducto; ?>" class="imagen-small">

                <p></p>

                <label for="precio_costo">Precio Costo:</label>
                <input type="number" step="0.01" id="precio_costo" name="precio_costo" value="<?php echo $precio_costo; ?>" oninput="calcularMultiplicacion()">

                <p></p>

                <label for="ganancia">Ganancia:</label>
                <input type="number" step="0.01" id="ganancia" name="ganancia" placeholder="Ejemplo:1.3,1.7,..." max="5" value="<?php echo $ganancia; ?>" oninput="calcularMultiplicacion()">

                <p></p>

                <label for="precioU_Venta">Precio Unitario Venta:</label>
                <input type="number" step="0.01" id="precioU_Venta" name="precioU_Venta" value="<?php echo $precioU_Venta; ?>" readonly>

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
