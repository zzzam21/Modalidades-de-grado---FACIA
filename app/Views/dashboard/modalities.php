<?php echo $this->extend('layout/main'); ?>
<?php echo $this->section('content'); ?>    

    <div class="row justify-content-between pt-4">
        <div class="col-auto me-auto">
            <div class="row g-2 align-items-center">
                <div class="col-auto">
                    <label for="dropdownButton" class="col-form-label fs-6">Filtrar por:</label>
                </div>
                <div class="col-auto">
                    <div class="dropdown">
                        <button class="btn-sm btn border border-success-subtle dropdown-toggle" id="dropdownButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Tipo de modalidad
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="dropdown-item">Investigación</a></li>
                            <li><a href="#" class="dropdown-item">Profundización</a></li>
                            <li><a href="#" class="dropdown-item">Interacción social</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addmodalitie">
                <i class="bi bi-plus-lg"></i> Agregar
            </button>
        </div>
    </div>

    <div class="table-responsive mt-4">
        <h4 class="text-center"><b>MODALIDADES DE GRADO</b></h4>
        <table class="table" id="modalityTable">
                <thead>
                    <tr>
                        <th># Acuerdo</th>
                        <th>Nombre Modalidad</th>
                        <th>Modalidad</th>
                        <th>Estado</th>
                        <th>Fecha Inicio</th>
                        <th>Duración</th>
                        <th>Final Estimado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($modalities)): ?>
                        <?php foreach ($modalities as $modality): ?>
                            <tr>
                                <td><?= esc($modality['modality_ID']) ?></td>
                                <td class="text-truncate-modal" 
                                data-bs-toggle="popover"
                                data-bs-trigger="hover"
                                data-bs-title="Título"
                                data-bs-content="<?= esc($modality['name_modalitie']) ?>"
                                data-bs-placement="right"
                                role="button"
                                style="cursor: pointer;">
                                    <?= esc($modality['name_modalitie']) ?>
                                </td>
                                <td><?= esc($modality['type_modality']) ?></td>
                                <td><?= esc($modality['status']) ?></td>
                                <td><?= esc($modality['date_approved']) ?></td>
                                <td><?= esc($modality['duration']) ?></td>
                                <td><?= esc($modality['date_end']) ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver detalles">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    <!-- Modal para agregar modalidades -->
     <div class="modal fade" id="addmodalitie" tabindex="-1" aria-labelledby="addmodalitie" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addmodalitie">Agregar Modalidad</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" enctype="multipart/form-data" action="<?= base_url("modalities/add") ?>">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Agregar acuerdo</label>
                            <input type="file" required class="form-control" name="formFile" id="formFile">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button class="btn btn-success" type="submit">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php echo $this->endSection(); ?>