<?php
require '../../includes/funciones.php';
$auth = estaAutenticado();

if ( !$auth ) {
    header('Location: /');
} 


// Este archivo se usa para conectarse a la base de datos.
require '../../includes/config/database.php';

// Conexión a la base de datos.
$db = conectarBD();


// Realiza una consulta para obtener todos los vendedores de la base de datos.
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

// Creamos un arreglo vacío donde guardaremos los mensajes de error si algo sale mal.
$errores = [];

// Inicializamos varias variables para almacenar la información que se va a enviar.
$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$vendedores_id = '';

// Verificamos si el formulario ha sido enviado.
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    // Asignamos los valores que el usuario ingresó en el formulario a nuestras variables.
    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($db, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
    $vendedores_id = mysqli_real_escape_string($db, $_POST['vendedor']);
    $create = date('Y/m/d');

    // Asignar files hacia una variable
    $imagen = $_FILES['imagen'];

    // Verificamos que cada campo tenga información.
    if (!$titulo) {
        $errores[] = "Debes añadir un título";
    }
    if (!$precio) {
        $errores[] = "Debes añadir un precio";
    }
    if (!$imagen['name'] || $imagen['error']) {
        $errores[] = "Debes añadir una imagen";
    }
    $medida = 100 * 1024; // 100 KB
    if ($imagen['size'] > $medida) {
        $errores[] = 'La imagen es muy pesada';
    }
    if (strlen($descripcion) < 50) {
        $errores[] = "Debes añadir una descripción y debe tener al menos 50 caracteres";
    }
    if (!$habitaciones) {
        $errores[] = "Debes añadir una habitación";
    }
    if (!$wc) {
        $errores[] = "Debes añadir un baño";
    }
    if (!$estacionamiento) {
        $errores[] = "Debes añadir un estacionamiento";
    }
    if (!$vendedores_id) {
        $errores[] = "Debes añadir un vendedor";
    }

    // Si no hay errores, procedemos a guardar la información en la base de datos.
if (empty($errores)) {
    // Subida de Archivos
    $carpetaImagenes = '../../imagenes/';
    if (!is_dir($carpetaImagenes)) {
        mkdir($carpetaImagenes);
    }

    // Generar un nombre único
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

    // Subir Imágenes
    if (move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen)) {
        // Esta es la consulta SQL que inserta la nueva propiedad en la base de datos.
        $query = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, `create`, vendedores_id) 
        VALUES ('$titulo', '$precio', '$nombreImagen' , '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$create',  '$vendedores_id')";

        // Ejecutamos la consulta SQL.
        $resultado = mysqli_query($db, $query);

        // Si la consulta se ejecuta con éxito, redirigimos al usuario a la página de administración.
        if ($resultado) {
            header("Location: /admin?resultado=1");
            exit;
        }
    }
}


incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Crear</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>
    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>
    <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Información General</legend>
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Título Propiedad" value="<?php echo htmlspecialchars($titulo); ?>">
            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo htmlspecialchars($precio); ?>">
            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpg, image/png" name="imagen">
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion"><?php echo htmlspecialchars($descripcion); ?></textarea>
        </fieldset>
        <fieldset>
            <legend>Información de la Propiedad</legend>
            <label for="habitaciones">Habitaciones:</label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 1" min="1" max="9" value="<?php echo htmlspecialchars($habitaciones); ?>">
            <label for="wc">Baños:</label>
            <input type="number" id="wc" name="wc" placeholder="Ej: 2" min="1" max="9" value="<?php echo htmlspecialchars($wc); ?>">
            <label for="estacionamiento">Estacionamientos:</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo htmlspecialchars($estacionamiento); ?>">
        </fieldset>
        <fieldset>
            <legend>Vendedor</legend>
            <select name="vendedor">
                <option value="">Elegir un Vendedor</option>
                <?php while ($vendedor = mysqli_fetch_assoc($resultado)): ?>
                    <option <?php echo $vendedores_id === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id']; ?>">
                        <?php echo htmlspecialchars($vendedor['nombre'] . " " . $vendedor['apellido']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </fieldset>
        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>
</main>

<?php incluirTemplate('footer'); ?>
