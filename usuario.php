<?php 
    // IMportamos conexion

    require 'includes/config/database.php';
    $db = conectarBD();

    // creamos un email y usuario
    $email = "correo@admin.com";
    $password = "123456";


    // Query para crear el usuario
    $query = "INSERT INTO usuarios (email, password) VALUES ('{$email}', '{$password}');";
    echo $query;

    mysqli_query($db, $query);

    
    // Agregarlo al usuario

    



?>