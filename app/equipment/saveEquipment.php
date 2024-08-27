<?php


// Inicia la sesión para poder usar variables de sesión
session_start();

// Incluye el archivo de configuración de la base de datos, donde se establece la conexión a la base de datos
require '../config/database.php';

// Obtiene y escapa los valores del formulario para prevenir inyecciones SQL
$description = $conn->real_escape_string($_POST['description']);
$brand = $conn->real_escape_string($_POST['brand']);
$model = $conn->real_escape_string($_POST['model']);
$serial_number = $conn->real_escape_string($_POST['serial_number']);
$category = $conn->real_escape_string($_POST['category']);
$location = $conn->real_escape_string($_POST['location']);
$instructor = $conn->real_escape_string($_POST['instructor']);

// Consulta SQL para insertar datos en la tabla 'equipments'
// La consulta utiliza parámetros nombrados para prevenir inyecciones SQL
$sql = "INSERT INTO equipments (description, brand, model, serial_number, category_id, location_id, instructor_id)
VALUES ('$description', '$brand', '$model', '$serial_number', $category, $location, $instructor)";

if ($conn->query($sql)) {
    $id = $conn->insert_id;

    $_SESSION['color'] = "success";
    $_SESSION['msg'] = "Registro guardado";
} 
// Redirige al usuario de vuelta a la página principal
header('Location: index.php');


//real_escape_string() garantiza que cualquier intento de inyección SQL sea neutralizado, convirtiendo caracteres especiales en secuencias seguras que no pueden alterar la consulta SQL. 
?>

