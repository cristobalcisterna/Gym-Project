<div class="modal fade" id="editModalEquipment" tabindex="-1" aria-labelledby="editModalEquipmentLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalEquipmentLabel">Editar registro</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="editEquipment.php" method="post" enctype="multipart/form-data">

                    <input type="hidden" id="id" name="id">

                    <div class="mb-2">
                        <label for="description" class="form-label">Nombre:</label>
                        <input type="text" name="description" id="description" class="form-control form-control-sm" required>
                    </div>

                    <div class="mb-2">
                        <label for="brand" class="form-label">Marca:</label>
                        <input type="text" name="brand" id="brand" class="form-control form-control-sm" required>
                    </div>

                    <div class="mb-2">
                        <label for="model" class="form-label">Modelo:</label>
                        <input type="text" name="model" id="model" class="form-control form-control-sm" required>
                    </div>

                    <div class="mb-2">
                        <label for="serial_number" class="form-label">Numero de serie:</label>
                        <input type="text" name="serial_number" id="serial_number" class="form-control form-control-sm" required>
                    </div>

                    <div class="mb-2">
                        <label for="category" class="form-label">Categoria:</label>
                        <select name="category" id="category" class="form-select  form-select-sm" required>
                            <option value="">Seleccionar...</option>
                            <?php while ($row_category = $categorys->fetch_assoc()) { ?>
                                <option value="<?php echo $row_category["id"]; ?>"><?= $row_category["name"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="location" class="form-label">Categoria:</label>
                        <select name="location" id="location" class="form-select  form-select-sm" required>
                            <option value="">Seleccionar...</option>
                            <?php while ($row_location = $locations->fetch_assoc()) { ?>
                                <option value="<?php echo $row_location["id"]; ?>"><?= $row_location["name"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="instructor" class="form-label">Encargado:</label>
                        <select name="instructor" id="instructor" class="form-select  form-select-sm" required>
                            <option value="">Seleccionar...</option>
                            <?php while ($row_instructor = $instructors->fetch_assoc()) { ?>
                                <option value="<?php echo $row_instructor["id"]; ?>"><?= $row_instructor["name"] ?></option>
                            <?php } ?>
                        </select>
                    </div>



                    <div class="d-flex justify-content-end pt2">
                        <button type="button" class="btn btn-secondary me-1" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary ms-1"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>