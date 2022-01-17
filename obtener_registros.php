<?php
include("conexion.php");
include("funciones.php");

$query = "";
$salida = array();
$query = "SELECT * FROM usuarios";

// Si se hace uso de la función del buscador de palabras, sea nombre o apellido, en la tabla del DataTable
// Concatenar el string '$query' con la filtración dada por el usuario 
if (isset($_POST["search"]["value"])) {
	$query .= ' WHERE nombre LIKE "%' . $_POST["search"]["value"] . '%"';
	$query .= ' OR apellidos LIKE "%' . $_POST["search"]["value"] . '%"';
}

// Además, concatenar en la cadena la orden ascendente o descendente establecida.
if (isset($_POST["order"])) {
	// Concatenar el string '$query' con la especificaciónde ordenamiento dada por el usuario.
	$query .= ' ORDER BY' . $_POST["order"]['0']["column"] . ' ' .	$_POST["order"]['0']['dir'] . ' ';
} else {
	$query .= ' ORDER BY id DESC';
}

// Establecer el límite de elementos rows en la tabla
if ($_POST["length"] != -1) {
	$query .= ' LIMIT ' . $_POST["start"] . ', ' . $_POST["length"];
}

// Preparar mensaje '$query' en el mensajero '$stmt' para recibir datos del servidor.
$stmt = $conexion -> prepare($query);
$stmt -> execute();
$resultado = $stmt -> fetchAll();

// Creamos arreglo como variable '$datos':
$datos = array();

// limitamos la cantidad de datos a mostrar en la tabla.
$filtered_rows = $stmt -> rowCount();

// Generamos el HTML con los datos de la tabla.
foreach ($resultado as $fila) {
	// Inicializamos la imagen
	$imagen = '';
	if ($fila["imagen"] != '') {
		$imagen = '<img src="img/' . $fila["imagen"] . '"class="img-thumbnail" width="50" height="35" />';
	}
	else{
		$imagen = '';
	}
	
	// Definimos cada uno de los datos que se verán en las celdas en la fila de la tabla del HTML.
	// incluyendo los botones
	$sub_array = array();
	$sub_array[] = $fila["id"];
	$sub_array[] = $fila["nombre"];
	$sub_array[] = $fila["apellidos"];
	$sub_array[] = $fila["telefono"];
	$sub_array[] = $fila["email"];
	$sub_array[] = $imagen;
	$sub_array[] = $fila["fecha_creacion"];
	$sub_array[] = '<button type="button" name="editar" id="' . $fila["id"] . '" class="btn btn-warning btn-xs editar">Editar</button>';
	$sub_array[] = '<button type="button" name="borrar" id="' . $fila["id"] . '" class="btn btn-danger btn-xs borrar">Borrar</button>';
	
	// Exportamos la información
	$datos[] = $sub_array;
}

$salida = array(
	"draw"				=> intval($_POST["draw"]),
	"recordsTotal"		=> $filtered_rows,
	"recordsFiltered"	=> obtener_todos_registros(),
	"data"				=> $datos
);

echo json_encode($salida, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
