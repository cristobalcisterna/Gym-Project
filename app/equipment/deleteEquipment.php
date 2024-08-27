<?php

session_start();

require '../config/database.php';
// Obtiene y escapa el valor del 'id' enviado vía POST para prevenir inyecciones SQL
$id = $conn->real_escape_string($_POST['id']);
// Construye la consulta SQL para eliminar el registro de la tabla donde el 'id' coincide con el valor proporcionado
$sql = "DELETE FROM equipments WHERE id=$id";
// Ejecuta la consulta SQL y verifica si se realizó correctamente
if ($conn->query($sql)) {
    $_SESSION['color'] = "success";
    $_SESSION['msg'] = "Registro eliminado";
} else {
    $_SESSION['color'] = "danger";
    $_SESSION['msg'] = "Error al eliminar registro";
}

header('Location: index.php');
?>
