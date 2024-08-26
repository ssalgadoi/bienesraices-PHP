<?php
    require 'includes/config/database.php';
    require 'includes/funciones.php'; // Asegúrate de incluir funciones.php aquí

    $db = conectarBD();

    $errores = [];

    // Autenticar usuario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
        $password = mysqli_real_escape_string($db, $_POST['password']);

        if (!$email) {
            $errores[] = "El email es obligatorio o no es válido";
        }
        if (!$password) {
            $errores[] = "El Password es obligatorio";
        }

        if (empty($errores)) {

            // Revisamos si el usuario existe
            $query = "SELECT * FROM usuarios WHERE email = '{$email}'";
            $resultado = mysqli_query($db, $query);

            if ($resultado->num_rows) {
                // Revisamos el password si es correcto
                $usuario = mysqli_fetch_assoc($resultado);

                // Verificar si el password es correcto o no
                $auth = password_verify($password, $usuario['password']);

                if ($auth) {
                    // El usuario está autenticado
                    session_start();
                    $_SESSION['usuario'] = $usuario["email"];
                    $_SESSION['login'] = true;

                    header('Location: /admin'); // Corrección aquí
                    exit; // Importante para detener la ejecución del script

                } else {
                    $errores[] = "El password es incorrecto";
                }

            } else {
                $errores[] = "El Usuario no existe";
            }
        }
    }

    incluirTemplate('header'); // Ahora debería funcionar correctamente
?>

<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar sesión</h1>
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
        </fieldset>
        <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
    </form>
</main>

<?php
    incluirTemplate('footer');
?>
