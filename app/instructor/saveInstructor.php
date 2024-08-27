<?php


// Inicia la sesión para poder usar variables de sesión
session_start();

// Incluye el archivo de configuración de la base de datos, donde se establece la conexión a la base de datos
require '../config/database.php';

// Obtiene y escapa los valores del formulario para prevenir inyecciones SQL
$name = $conn->real_escape_string($_POST['name']);
$rut = $conn->real_escape_string($_POST['rut']);
// Consulta SQL para insertar datos en la tabla 
// La consulta utiliza parámetros nombrados para prevenir inyecciones SQL
$sql = "INSERT INTO instructors (name, rut)
VALUES ('$name', '$rut')";

if ($conn->query($sql)) {
    $id = $conn->insert_id;

    $_SESSION['color'] = "success";
    $_SESSION['msg'] = "Registro guardado";
} 
// Redirige al usuario de vuelta a la página principal
header('Location: index.php');


//real_escape_string() garantiza que cualquier intento de inyección SQL sea neutralizado, convirtiendo caracteres especiales en secuencias seguras que no pueden alterar la consulta SQL. 
?>

