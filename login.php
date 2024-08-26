<?php

    require  'includes/config/database.php';

    $db = conectarBD();

    $errores = [];

    // autenticar usuario
    if ( $_SERVER['REQUEST_METHOD'] === 'POST') {
        // var_dump($_POST);

        $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL ));
        // var_dump($email);
        $password = mysqli_real_escape_string( $db, $_POST['password']);


        if ( !$email ) {
            $errores[] = "El email es obligatorio o no es valido";
        }
        if ( !$password ) {
            $errores[] = "El Password es obligatorio";
        }

        if (empty($errores)) {

            // REvisamos si el usuario existe
            $query = "SELECT * FROM usuarios WHERE email = '{$email}'  ";
            $resultado = mysqli_query($db, $query);

            if( $resultado->num_rows  ) {
                // Revisamos el pasword si es correcto
                $usuario = mysqli_fetch_assoc($resultado);

                // Verificar si el password es correcto o no
                $auth = password_verify($password,$usuario['password'] );

                if ($auth) {
                    // El usuario esta autenticado
                    session_start();
                    $_SESSION['usuario'] = $usuario["email"];
                    $_SESSION['login'] = true;

                    // echo "<pre>";
                    // var_dump($_SESSION);
                    // echo "</pre>";

                } else {
                    $errores[] = "El password es incorrecto";
                }

            } else {
                $errores[] = "El Usuario no existe";
            }
     
        }

    }



    require 'includes/funciones.php';
   
    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar seccion</h1>
        <?php foreach($errores as $error) :?>
            <div class="alerta error">
                <?php echo $error;?>
            </div>
        <?php endforeach; ?>

        <form action="" class="formulario" method="POST" novalidate>
        <fieldset>
                <legend>Datos del Usuario</legend>

                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="Tu Email" id="email" required>

                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Tu Password" required id="password">

                <!-- <label for="mensaje">Mensaje:</label>
                <textarea id="mensaje"></textarea> -->
            </fieldset>
            <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
        </form>
    </main>

    <?php
     incluirTemplate('footer');
?> 