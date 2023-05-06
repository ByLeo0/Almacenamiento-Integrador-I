<?php 

    require 'includes/config/database.php';
    $db = conectarDB();
    // Autenticar el usuario

    $errores = [];

    

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";

        $email = mysqli_real_escape_string($db,  filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL) );
        $password = mysqli_real_escape_string($db,  $_POST['password']);

        if(!$email) {
            $errores[] = "El email es obligatorio o no es válido";
        }

        if(!$password) {
            $errores[] = "El Password es obligatorio";
        }

        if(empty($errores)) {

            // Revisar si el usuario existe.
            $query = "SELECT * FROM usuarios WHERE email = '$email' ";
            $resultado = mysqli_query($db, $query);


            

            if( $resultado->num_rows ) {
                // Revisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);

                // var_dump($usuario['password']);

                // Verificar si el password es correcto o no

                $auth = password_verify($password, $usuario['password']);

                if($auth) {
                    // El usuario esta autenticado
                    session_start();

                    // Llenar el arreglo de la sesión
                    $_SESSION['usuario'] = $usuario['rol'];

                    if($_SESSION['usuario']=="administrador"){
                        $_SESSION['login'] = true;
                    }else{
                        $_SESSION['login'] = false;
                    }


                    header('Location: /');

                } else {
                    $errores[] = 'El password es incorrecto';
                }
            } else {
                $errores[] = "El Usuario no existe";
            }
        }

    }



?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesión</h1>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form method="POST" class="formulario" novalidate>
            <fieldset>
                <legend>Email y Contraseña</legend>

                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="Tu email" id="email">

                <p></p>

                <label for="password">Contraseña</label>
                <input type="password" name="password" placeholder="Tu contraseña" id="password">
            </fieldset>
        
            <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
        </form>
    </main>