<?php
    require 'includes/funciones.php';
   
    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar seccion</h1>

        <form action="" class="formulario">
        <fieldset>
                <legend>Datos del Usuario</legend>

                <label for="email">E-mail</label>
                <input type="email" placeholder="Tu Email" id="email">

                <label for="password">Password</label>
                <input type="password" placeholder="Tu Password" id="password">

                <!-- <label for="mensaje">Mensaje:</label>
                <textarea id="mensaje"></textarea> -->
            </fieldset>
            <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
        </form>
    </main>

    <?php
     incluirTemplate('footer');
?> 