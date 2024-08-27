<?php

// Inicia la sesión para poder usar variables de sesión
session_start();

// Incluye el archivo de configuración de la base de datos
require '../config/database.php';

// Obtiene y escapa los valores del formulario para prevenir inyecciones SQL
$id = $conn->real_escape_string($_POST['id']);
$description = $conn->real_escape_string($_POST['description']);
$brand = $conn->real_escape_string($_POST['brand']);
$model = $conn->real_escape_string($_POST['model']);
$serial_number = $conn->real_escape_string($_POST['serial_number']);
$category = $conn->real_escape_string($_POST['category']);
$location = $conn->real_escape_string($_POST['location']);
$instructor = $conn->real_escape_string($_POST['instructor']);


// Construye la consulta SQL para actualizar el registro en la base de datos
// Esta consulta actualiza los valores en la tabla donde el 'id' coincide con el valor proporcionado
$sql = "UPDATE equipments SET description ='$description', brand = '$brand', model = '$model', serial_number = '$serial_number', category_id=$category, location_id=$location, instructor_id=$instructor WHERE id=$id";

if ($conn->query($sql)) {

    $_SESSION['color'] = "success";
    $_SESSION['msg'] = "Registro actualizado";

} else {
    $_SESSION['color'] = "danger";
    $_SESSION['msg'] = "Error al actualizar registro";
}


header('Location: index.php');
?>