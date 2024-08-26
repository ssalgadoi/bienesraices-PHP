<?php

session_start();
    // echo "<pre>";
    // var_dump($_SESSION);
    // echo "</pre>";

    $auth = $_SESSION['login'];

    if ( !$auth ) {
        header('Location: /');
    } 


require '../includes/config/database.php';
$db = conectarBD();

$query = "SELECT * FROM propiedades";
$resultadoConsulta = mysqli_query($db, $query);

$mensaje = $_GET['resultado'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {
        // Obtener la imagen de la base de datos
        $query = "SELECT imagen FROM propiedades WHERE id = {$id}";
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            $propiedad = mysqli_fetch_assoc($resultado);

            if ($propiedad) {
                // Eliminar archivo si existe
                $imagen = $propiedad['imagen'];
                $rutaImagen = '../imagenes/' . $imagen;
                if (file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }

                // Eliminar propiedad
                $query = "DELETE FROM propiedades WHERE id = {$id}";
                $resultado = mysqli_query($db, $query);

                if ($resultado) {
                    header('Location: /admin?resultado=3');
                    exit;
                }
            }
        }
    }
}

require '../includes/funciones.php';
incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Administrador de Bienes Raices</h1>

    <?php if ($mensaje === '1'): ?>
        <p class="alerta exito">Anuncio Creado Correctamente</p>
    <?php elseif ($mensaje === '2'): ?>
        <p class="alerta exito">Anuncio Actualizado Correctamente</p>
        <?php elseif ($mensaje === '3'): ?>
        <p class="alerta exito">Anuncio Eliminado Correctamente</p>
    <?php endif; ?>

    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($propiedad = mysqli_fetch_assoc($resultadoConsulta)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($propiedad['id']); ?></td>
                    <td><?php echo htmlspecialchars($propiedad['titulo']); ?></td>
                    <td><img class="imagen-tabla" src="/imagenes/<?php echo htmlspecialchars($propiedad['imagen']); ?>" alt="Imagen Propiedad"></td>
                    <td>$ <?php echo htmlspecialchars($propiedad['precio']); ?></td>
                    <td>
                        <form action="" method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($propiedad['id']); ?>">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        
                        <a href="admin/propiedades/actualizar.php?id=<?php echo htmlspecialchars($propiedad['id']); ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<?php
mysqli_close($db);
incluirTemplate('footer');
?>
