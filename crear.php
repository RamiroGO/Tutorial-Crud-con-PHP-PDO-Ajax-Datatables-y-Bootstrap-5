<?php
include('conexion.php');
include('funciones.php');

// Si se establece que se ha presionado el botón de Crear y
//  ya se han ingresado los datos de la nueva persona en la ventana
//  del Modals de la página
//  => se procederá a generar una consulta para insertar los datos en la base de datos. 
if ($_POST['operacion'] == 'Crear') {
    $imagen = '';
    if ( $_FILES[ 'imagen_usuario' ][ 'name' ] != '' ) {
        $imagen = subir_imagen();
    }
    $stmt = $conexion -> prepare(
        "INSERT INTO usuarios
			(nombre, 	apellidos,		imagen,		telefono,	email)
			VALUES
			(:nombre, 	:apellidos,		:imagen,	:telefono,	:email)"
    );

    // Realizamos la consulta a la Base de Datos estableciendo las variables
    // que corresponden con cada uno de los parámetros de la consulta.
    $resultado = $stmt -> execute(
        array(
            ':nombre'		=> $_POST['nombre'],
            ':apellidos'	=> $_POST['apellidos'],
            ':telefono'		=> $_POST['telefono'],
            ':email'		=> $_POST['email'],
            ':imagen'		=> $imagen
        )
    );
    
    // Validamos que el resultado no esté vacio
    if (!empty($resultado)) {
        echo 'Registro Creado';
    }
}
