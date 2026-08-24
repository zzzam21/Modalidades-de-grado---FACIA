<?php echo $this->extend('layout/main'); ?>
<?php echo $this->section('content'); ?>

<div id="app" data-view="modalities">
    <div class="container text-center pt-0">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 pt-4 pb-3">
            <h4 class="section-title mb-0">Modalidades de grado</h4>
            <div class="col-auto d-flex gap-2 ms-auto">
                <button type="button" class="btn btn-sm btn-outline-success" id="addModalityManual">
                    <i class="bi bi-pencil-square"></i> Agregar Manual
                </button>
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addmodalitie">
                    <i class="bi bi-plus-lg"></i> Agregar
                </button>
            </div>
        </div>

        <div class="table-responsive text-start">
            <table class="table w-100" id="modalityTable">
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
                </table>
            </div>
    </div>
</div>

<!-- Modal para agregar modalidades -->
<div class="modal fade" id="addmodalitie" tabindex="-1" aria-labelledby="addmodalitie" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addmodalitie">Agregar Modalidad</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="formFile" class="form-label">Agregar acuerdo</label>
                    <input type="file" required class="form-control" name="formFile" id="formFile">
                </div>
                <div class="text-center">

                </div>
            </div>
            <div class="modal-footer">
                <div class="spinner-grow spinner-grow-sm text-success d-none" id="loadingModality">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button class="btn btn-success" id="saveModality" type="button">Guardar </button>
            </div>

        </div>
    </div>
</div>
<!-- Modal de Verificación de Datos Extraídos -->
<?= $this->include('dashboard/Modules/_verify_modal') ?>
<!-- Modal para editar modalidades -->
<div class="modal fade" id="editmodalitie" tabindex="-1" aria-labelledby="editmodalitie" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editmodalitie">Editar Modalidad</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="formFile" class="form-label">Agregar acuerdo</label>
                    <input type="file" required class="form-control" name="formFile" id="formFile">
                </div>
                <div class="text-center">

                </div>
            </div>
            <div class="modal-footer">
                <div class="spinner-grow spinner-grow-sm text-success d-none" id="loadingModality">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button class="btn btn-success" id="saveModality" type="button">Guardar </button>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>