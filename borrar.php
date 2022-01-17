<?php
include("conexion.php");
include("funciones.php");

// Eliminar Usuario de la Base de Datos
// Se requiere explícitamente el parámetro del id del usuario para eliminarlo
if(isset($_POST["id_usuario"])){
	// Además de la información, Eliminamos la imagen del usuario en el fichero de imagenes.
	$imagen = obtener_nombre_imagen($_POST["id_usuario"]);
	if($imagen != ""){
		// Eliminar archivo de imagen en la carpeta "img/" con comando Php
		unlink("img/" . $imagen);
	}
	
	// Planteamos el Query para la consulta de borrado.
	$stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = :id");
	
	// Enviamos la consulta a la Base de Datos, estableciendo las variables
    // que corresponden con cada uno de los parámetros de la consulta, solo el 'id'.
	$resultado = $stmt->execute(
		array(
			':id'	=> $_POST["id_usuario"]
		)
	);
	
	if(!empty($resultado)){
		echo 'Registro Borrado';
	}
}
