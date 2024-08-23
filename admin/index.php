<?php
require '../includes/config/database.php';
$db = conectarBD();

$query = "SELECT * FROM propiedades";
$resultadoConsulta = mysqli_query($db, $query);

$mensaje = $_GET['resultado'] ?? null;

require '../includes/funciones.php';
incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Administrador de Bienes Raices</h1>

    <?php if ($mensaje === '1'): ?>
        <p class="alerta exito">Anuncio Creado Correctamente</p>
    <?php elseif ($mensaje === '2'): ?>
        <p class="alerta exito">Anuncio Actualizado Correctamente</p>
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
            <?php while($propiedad = mysqli_fetch_assoc($resultadoConsulta)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($propiedad['id']); ?></td>
                    <td><?php echo htmlspecialchars($propiedad['titulo']); ?></td>
                    <td><img class="imagen-tabla" src="/imagenes/<?php echo htmlspecialchars($propiedad['imagen']); ?>" alt="Imagen Propiedad"></td>
                    <td>$ <?php echo htmlspecialchars($propiedad['precio']); ?></td>
                    <td>
                        <a href="#" class="boton-rojo-block">Eliminar</a>
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
