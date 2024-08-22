<?php

function conectarBD() {
    $db = mysqli_connect('localhost', 'root', 'Salgado0845', 'bienes_crud');

    if(!$db) {  // Cambiamos la condición para verificar si la conexión falló
        echo "Error: No se pudo conectar a la base de datos";
        exit;
    }
    return $db;
}
?>