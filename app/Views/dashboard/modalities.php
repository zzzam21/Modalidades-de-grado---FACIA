<?php echo $this->extend('layout/main'); ?>
<?php echo $this->section('content'); ?>    

    <div class="container text-center pt-0">
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

        <div class="mt-4">
            <h4 class="text-center"><b>MODALIDADES DE GRADO</b></h4>
            <table class="table responsive" id="modalityTable">
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
                    <button class="btn btn-success" id="saveModality" type="button" >Guardar </button>
                </div>
                
            </div>
        </div>
    </div>

<?php echo $this->endSection(); ?>