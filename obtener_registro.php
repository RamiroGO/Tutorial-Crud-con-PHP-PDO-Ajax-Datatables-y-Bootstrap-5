<?php
include("conexion.php");
include("funciones.php");

// Seleccionar un usuario a partir del id:
// Funcionalidad creada para editar los parámetros de ese usuario en el Models del HTML.
if (isset($_POST["id_usuario"])) {
	$salida= array();
	
	// Definir el mensajero '$stmt' entre el servidor y la base de datos, definiendo el Query de la consulta.
	$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = '" . $_POST["id_usuario"] . "' LIMIT 1");
	$stmt -> execute();
	$resultado = $stmt -> fetchAll();
	// Aunque solo exista un solo usuario, es mejor desarrollar el manejo de todos los usuarios que dispongan del mismo id.
	foreach ($resultado as $fila) {
		$salida["nombre"]		= $fila["nombre"];
		$salida["apellidos"]	= $fila["apellidos"];
		$salida["telefono"]		= $fila["telefono"];
		$salida["email"]		= $fila["email"];
		// Disponer de la posibilidad de editar la imagen que se tiene en el usuario.
		if ($fila["imagen"] != "") {
			$salida["imagen_usuario"] = '<img src="img/' . $fila["imagen"] . '" class = "img-thumbnail" width = "100" height = "50" /><input type="hidden" name="imagen_usuario_oculta" value="img/' . $fila["imagen"] . '" />';
		}
		else{
			$salida["imagen_usuario"] = '<input type="hidden" name="imagen_usuario_oculta" value="" />';
		}
	}
	
	// Exportar datos en formato JSON - String
	echo json_encode($salida, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
}
