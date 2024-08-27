<?php

session_start();

// Incluye el archivo de configuración de la base de datos
require '../config/database.php';

// Consulta SQL para obtener los datos de la tabla
$sqlInstructors = "SELECT id, name, rut FROM instructors";

// Ejecuta la consulta SQL
$instructorsData = $conn->query($sqlInstructors);

?>

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal del gimnasio</title>

<!-- Incluye el CSS de Bootstrap -->
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
<!-- Incluye el CSS de FontAwesome para iconos -->
    <link href="../../assets/css/all.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

    <div class="container py-3">

        <h2 class="text-center">Personal del gimnasio</h2>

        <hr>
 <!-- Muestra mensajes de sesión si existen -->
        <?php if (isset($_SESSION['msg']) && isset($_SESSION['color'])) { ?>
            <div class="alert alert-<?= $_SESSION['color']; ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['msg']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            

        <?php
            unset($_SESSION['color']);
            unset($_SESSION['msg']);
        } ?>

        

        <div class="row justify-content-end">
            <div class="col-auto">
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newModalInstructor"><i class="fa-solid fa-circle-plus"></i> Nuevo registro</a>
            </div>
            
        </div>

        <table class="table table-sm table-striped table-hover mt-4">
            <thead class="table-dark">
                <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Rut</th>
                <th>Acción</th>
                </tr>
            </thead>

            <tbody>
                <!-- Itera sobre los datos obtenidos de la base de datos y los muestra en la tabla -->
                <?php while ($row = $instructorsData->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= $row['name']; ?></td>
                        <td><?= $row['rut']; ?></td>
                        <td>
                            <!-- Botón para abrir el modal de edición -->
                            <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModalInstructor" data-bs-id="<?= $row['id']; ?>"><i class="fa-solid fa-pen-to-square"></i> Editar</a>
                            <!-- Botón para abrir el modal de eliminación -->
                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModalInstructor" data-bs-id="<?= $row['id']; ?>"><i class="fa-solid fa-trash"></i></i> Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>


    <?php include 'newModalInstructor.php'; ?> <!-- Incluye el modal para nuevo registro -->
    <?php include 'editModalInstructor.php'; ?> <!-- Incluye el modal de edición -->
    <?php include 'deleteModalInstructor.php'; ?> <!-- Incluye el modal de eliminación -->

    <script>
// Obtiene referencias a los modales
        let newModalInstructor = document.getElementById('newModalInstructor')
        let editModalInstructor = document.getElementById('editModalInstructor')
        let deleteModalInstructor = document.getElementById('deleteModalInstructor')

// Foco en el campo de descripción cuando se abre el modal de nuevo registro
            newModalInstructor.addEventListener('shown.bs.modal', event => {
            newModalInstructor.querySelector('.modal-body #name').focus()
        })
// Limpia los campos del modal de nuevo registro al cerrarlo
        newModalInstructor.addEventListener('hide.bs.modal', event => {
            newModalInstructor.querySelector('.modal-body #name').value = ""
            newModalInstructor.querySelector('.modal-body #rut').value = ""
        })
// Limpia los campos del modal de edición al cerrarlo
        editModalInstructor.addEventListener('hide.bs.modal', event => {
            editModalInstructor.querySelector('.modal-body #name').value = ""
            editModalInstructor.querySelector('.modal-body #rut').value = ""
        })

// Carga los datos de la tabla en el modal de edición al abrirlo
        editModalInstructor.addEventListener('shown.bs.modal', event => {
            let button = event.relatedTarget // Botón que abrió el modal
            let id = button.getAttribute('data-bs-id') // Obtiene el id de la tabla

            let inputId = editModalInstructor.querySelector('.modal-body #id')
            let inputName = editModalInstructor.querySelector('.modal-body #name')
            let inputRut = editModalInstructor.querySelector('.modal-body #rut')

            let url = "getInstructor.php" // URL para obtener los datos de la tabla
            let formData = new FormData()
            formData.append('id', id)

// Realiza la solicitud para obtener los datos de la tabla
            fetch(url, {
                    method: "POST",
                    body: formData
                }).then(response => response.json())
                .then(data => {
 // Llena los campos del modal con los datos obtenidos
                    inputId.value = data.id
                    inputName.value = data.name
                    inputRut.value = data.rut
                }).catch(err => console.log(err))

        })
// Llena el campo oculto del modal de eliminación con el id la tabla
        deleteModalInstructor.addEventListener('shown.bs.modal', event => {
            let button = event.relatedTarget // Botón que abrió el modal
            let id = button.getAttribute('data-bs-id') // Obtiene el id la tabla
            deleteModalInstructor.querySelector('.modal-footer #id').value = id
        })
    </script>

<!-- Incluye el JS de Bootstrap -->
    <script src="../../assets/js/bootstrap.bundle.min.js"></script>

    

</body>

</html>