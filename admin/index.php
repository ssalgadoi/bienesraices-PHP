<?php


// Este archivo se usa para conectarse a la base de datos.
require '../includes/config/database.php';

// Conexión a la base de datos.
$db = conectarBD();

// EScribir query
$query = "SELECT * FROM propiedades";
//Consultar


$resultadoConsulta = mysqli_query($db, $query);




$resultado = $_GET['resultado'] ?? null;

// Incluir el archivo de funciones y la plantilla del encabezado.
require '../includes/funciones.php';
incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Administrador de Bienes Raices</h1>
    <?php 
    // Mostrar un mensaje de éxito si el valor de $mensaje es 1.
    if ($mensaje === 1): ?>
        <p class="alerta exito">Anuncio creado correctamente</p>
    <?php endif; ?>
    
    <!-- Botón para crear una nueva propiedad -->
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
        <!-- Mostrar los resultados -->
        <tbody>
    <?php while($propiedad = mysqli_fetch_assoc($resultadoConsulta)): ?>
        <tr>
            <td><?php echo $propiedad['id'];?></td>
            <td><?php echo $propiedad['titulo'];?></td>
            <td><img class="imagen-tabla" src="/imagenes/<?php echo $propiedad['imagen'];?>" alt="Imagen Propiedad"></td>
            <td>$ <?php echo $propiedad['precio'];?></td>
            <td>
                <a href="#" class="boton-rojo-block">Eliminar</a>
                <a href="admin/propiedades/actualizar.php?id=<?php echo $propiedad['id']; ?>" class="boton-amarillo-block">Actualizar</a>
            </td>
        </tr>
    <?php endwhile; ?>
</tbody>

    </table>
</main>

<?php
mysqli_close($db);

// Incluir la plantilla del pie de página.
incluirTemplate('footer');
?>