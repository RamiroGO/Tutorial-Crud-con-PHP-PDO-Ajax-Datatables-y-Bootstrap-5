<?php

function subir_imagen()
 {
    if ( isset( $_FILES[ 'imagen_usuario' ] ) ) {
        $extension = explode( '.',  $_FILES[ 'imagen_usuario' ][ 'name' ] );
        $nuevo_nombre = rand() . '.' . $extension[ 1 ];
        $ubicacion = './img/' . $nuevo_nombre;
        move_uploaded_file( $_FILES[ 'imagen_usuario' ][ 'tmp_name' ], $ubicacion );
        return $nuevo_nombre;
    }
}

function obtener_nombre_imagen( $id_usuario )
 {
    include( 'conexion.php' );
    // Statement - Consulta - Query
    $stmt = $conexion->prepare( "SELECT imagen FROM usuarios WHERE id = '$id_usuario'" );
    $stmt->execute();

    // Recibir datos de la Base de Dato
    $resultado = $stmt->fetchAll();
    foreach ( $resultado as $fila ) {
        return $fila[ 'imagen' ];
    }
}

function obtener_todos_registros()
 {
    include( 'conexion.php' );
    // Statement - Consulta - Query
    $stmt = $conexion->prepare( 'SELECT * FROM usuarios' );
    $stmt->execute();

    // Recibir datos de la Base de Dato
    $resultado = $stmt->fetchAll();

    // Enviar todos los datos.
    return $stmt->rowCount();
}
