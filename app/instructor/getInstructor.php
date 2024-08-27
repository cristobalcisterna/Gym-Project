<?php

require '../config/database.php';
// Obtiene y escapa el valor del 'id' enviado vía POST para prevenir inyecciones SQL
$id = $conn->real_escape_string($_POST['id']);
// Construye la consulta SQL para seleccionar el registro de la tabla donde el 'id' coincide con el valor proporcionado
$sql = "SELECT id, name, rut FROM instructors WHERE id=$id LIMIT 1";
// Ejecuta la consulta SQL
$resultado = $conn->query($sql);
// Obtiene el número de filas devueltas por la consulta
$rows = $resultado->num_rows;
// Inicializa un array vacío para almacenar los datos de la tabla
$instructor = [];

// Si la consulta devuelve al menos una fila
if ($rows > 0) {
    // Obtiene la fila de resultados como un array asociativo
    $instructor = $resultado->fetch_array();
}
// Codifica los datos del equipo en formato JSON y los envía al cliente
// JSON_UNESCAPED_UNICODE se utiliza para evitar el escape de caracteres Unicode
echo json_encode($instructor, JSON_UNESCAPED_UNICODE);
?>