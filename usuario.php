<?php 
    // IMportamos conexion

    require 'includes/app.php';
    $db = conectarBD();

    // creamos un email y usuario
    $email = "correo@admin.com";
    $password = "123456";

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);



    // Query para crear el usuario
    $query = "INSERT INTO usuarios (email, password) VALUES ('{$email}', '{$passwordHash}');";
    // echo $query;

    mysqli_query($db, $query);

    
    // Agregarlo al usuario

    



?>