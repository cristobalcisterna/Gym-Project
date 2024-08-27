<?php

session_start();

// Incluye el archivo de configuración de la base de datos
require '../config/database.php';

// Consulta SQL para obtener los datos de la tabla
$sqlEquipments = "SELECT e.id, e.description, e.brand, e.model, e.serial_number, 
                         c.name AS category, l.name AS location, i.name AS instructor
                  FROM equipments AS e
                  INNER JOIN categorys AS c ON e.category_id = c.id
                  INNER JOIN locations AS l ON e.location_id = l.id
                  INNER JOIN instructors AS i ON e.instructor_id = i.id";

// Ejecuta la consulta SQL
$equipmentsData = $conn->query($sqlEquipments);

?>

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Modal</title>

<!-- Incluye el CSS de Bootstrap -->
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
<!-- Incluye el CSS de FontAwesome para iconos -->
    <link href="../../assets/css/all.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

    <div class="container py-3">

        <h2 class="text-center">Web práctica gym inventario</h2>

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
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newModalEquipment"><i class="fa-solid fa-circle-plus"></i> Nuevo registro</a>
            </div>
            
        </div>

        <table class="table table-sm table-striped table-hover mt-4">
            <thead class="table-dark">
                <tr>
                <th>#</th>
                <th>Implemento</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Número de serie</th>
                <th>Categoría</th>
                <th>Ubicación</th>
                <th>Encargado</th>
                <th>Acción</th>
                </tr>
            </thead>

            <tbody>
                <!-- Itera sobre los datos obtenidos de la base de datos y los muestra en la tabla -->
                <?php while ($row = $equipmentsData->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= $row['description']; ?></td>
                        <td><?= $row['brand']; ?></td>
                        <td><?= $row['model']; ?></td>
                        <td><?= $row['serial_number']; ?></td>
                        <td><?= $row['category']; ?></td>
                        <td><?= $row['location']; ?></td>
                        <td><?= $row['instructor']; ?></td>
                        <td>
                            <!-- Botón para abrir el modal de edición -->
                            <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModalEquipment" data-bs-id="<?= $row['id']; ?>"><i class="fa-solid fa-pen-to-square"></i> Editar</a>
                            <!-- Botón para abrir el modal de eliminación -->
                            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModalEquipment" data-bs-id="<?= $row['id']; ?>"><i class="fa-solid fa-trash"></i></i> Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

<!-- Consultas SQL para obtener datos para los select en el modal -->
    <?php 
    $sqlCategory = "SELECT id, name FROM categorys"; // Consulta para obtener la tabla
    $categorys = $conn->query($sqlCategory); //Ejecuta la consulta de la tabla
    ?>
    <?php 
    $sqlLocation = "SELECT id, name FROM locations";
    $locations = $conn->query($sqlLocation);
    ?>
    <?php
    $sqlInstructor = "SELECT id, name FROM instructors";
    $instructors = $conn->query($sqlInstructor);
    ?>

    <?php include 'newModalEquipment.php'; ?> <!-- Incluye el modal para nuevo registro -->
<!-- Resetea los punteros de los resultados para reutilizarlos en el modal de edición -->
    <?php $categorys->data_seek(0); ?>
    <?php $locations->data_seek(0); ?>
    <?php $instructors->data_seek(0); ?>

    <?php include 'editModalEquipment.php'; ?> <!-- Incluye el modal de edición -->
    <?php include 'deleteModalEquipment.php'; ?> <!-- Incluye el modal de eliminación -->

    <script>
// Obtiene referencias a los modales
        let newModalEquipment = document.getElementById('newModalEquipment')
        let editModalEquipment = document.getElementById('editModalEquipment')
        let deleteModalEquipment = document.getElementById('deleteModalEquipment')

// Foco en el campo de descripción cuando se abre el modal de nuevo registro
        newModalEquipment.addEventListener('shown.bs.modal', event => {
            newModalEquipment.querySelector('.modal-body #description').focus()
        })
// Limpia los campos del modal de nuevo registro al cerrarlo
        newModalEquipment.addEventListener('hide.bs.modal', event => {
            newModalEquipment.querySelector('.modal-body #description').value = ""
            newModalEquipment.querySelector('.modal-body #brand').value = ""
            newModalEquipment.querySelector('.modal-body #model').value = ""
            newModalEquipment.querySelector('.modal-body #serial_number').value = ""
            newModalEquipment.querySelector('.modal-body #category').value = ""
            newModalEquipment.querySelector('.modal-body #location').value = ""
            newModalEquipment.querySelector('.modal-body #instructor').value = ""
        })
// Limpia los campos del modal de edición al cerrarlo
        editModalEquipment.addEventListener('hide.bs.modal', event => {
            editModalEquipment.querySelector('.modal-body #description').value = ""
            editModalEquipment.querySelector('.modal-body #brand').value = ""
            editModalEquipment.querySelector('.modal-body #model').value = ""
            editModalEquipment.querySelector('.modal-body #serial_number').value = ""
            editModalEquipment.querySelector('.modal-body #category').value = ""
            editModalEquipment.querySelector('.modal-body #location').value = ""
            editModalEquipment.querySelector('.modal-body #instructor').value = ""
        })

// Carga los datos del equipo en el modal de edición al abrirlo
        editModalEquipment.addEventListener('shown.bs.modal', event => {
            let button = event.relatedTarget // Botón que abrió el modal
            let id = button.getAttribute('data-bs-id') // Obtiene el id del equipo

            let inputId = editModalEquipment.querySelector('.modal-body #id')
            let inputDescription = editModalEquipment.querySelector('.modal-body #description')
            let inputBrand = editModalEquipment.querySelector('.modal-body #brand')
            let inputModel = editModalEquipment.querySelector('.modal-body #model')
            let inputSerialNumber = editModalEquipment.querySelector('.modal-body #serial_number')
            let inputCategory = editModalEquipment.querySelector('.modal-body #category')
            let inputLocation = editModalEquipment.querySelector('.modal-body #location')
            let inputInstructor = editModalEquipment.querySelector('.modal-body #instructor')

            let url = "getEquipment.php" // URL para obtener los datos de la tabla
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
                    inputDescription.value = data.description
                    inputBrand.value = data.brand
                    inputModel.value = data.model
                    inputSerialNumber.value = data.serial_number
                    inputCategory.value = data.category_id
                    inputLocation.value = data.location_id
                    inputInstructor.value = data.instructor_id
                }).catch(err => console.log(err))

        })
// Llena el campo oculto del modal de eliminación con el id del equipo
        deleteModalEquipment.addEventListener('shown.bs.modal', event => {
            let button = event.relatedTarget // Botón que abrió el modal
            let id = button.getAttribute('data-bs-id') // Obtiene el id del equipo
            deleteModalEquipment.querySelector('.modal-footer #id').value = id
        })
    </script>

<!-- Incluye el JS de Bootstrap -->
    <script src="../../assets/js/bootstrap.bundle.min.js"></script>

    

</body>

</html>