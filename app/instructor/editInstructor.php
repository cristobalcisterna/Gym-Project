<?php

// Inicia la sesión para poder usar variables de sesión
session_start();

// Incluye el archivo de configuración de la base de datos
require '../config/database.php';

// Obtiene y escapa los valores del formulario para prevenir inyecciones SQL
$id = $conn->real_escape_string($_POST['id']);
$name = $conn->real_escape_string($_POST['name']);
$rut = $conn->real_escape_string($_POST['rut']);
// Construye la consulta SQL para actualizar el registro en la base de datos
// Esta consulta actualiza los valores en la tabla donde el 'id' coincide con el valor proporcionado
$sql = "UPDATE instructors SET name ='$name', rut = '$rut' WHERE id=$id";

if ($conn->query($sql)) {

    $_SESSION['color'] = "success";
    $_SESSION['msg'] = "Registro actualizado";

} else {
    $_SESSION['color'] = "danger";
    $_SESSION['msg'] = "Error al actualizar registro";
}


header('Location: index.php');
?>