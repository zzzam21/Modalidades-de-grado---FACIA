<?php echo $this->extend('layout/main'); ?>
<?php echo $this->section('content'); ?>

<input type="hidden" id="modalityId" value="<?= $id ?>">

<div class="pt-3" id="app" data-view="modality-detail">

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3">
            <div class="d-flex align-items-center justify-content-between">
                <h4 class="mb-0 fw-bold">Detalle de Modalidad de Grado</h4>
                <div id="det_estado">--</div>
            </div>
        </div>
        
        <div class="card-body">
            <div class="row g-4">
                <div class="col-12">
                    <label class="text-muted small text-uppercase fw-semibold mb-1">Título del Proyecto</label>
                    <h4 id="det_titulo" class="fw-bold lh-base">--</h4>
                </div>

                <div class="col-sm-6 col-md-3">
                    <label class="text-muted small d-block mb-1">Tipo de Modalidad</label>
                    <span id="det_tipo" class="badge bg-light text-dark border p-2 w-100 text-truncate">--</span>
                </div>

                <div class="col-sm-6 col-md-3">
                    <label class="text-muted small d-block mb-1">Fecha Inicio</label>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-calendar-event me-2 text-secondary"></i>
                        <p id="det_inicio" class="mb-0 fw-medium">--</p>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <label class="text-muted small d-block mb-1">Duración</label>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-clock me-2 text-secondary"></i>
                        <p id="det_duracion" class="mb-0 fw-medium">--</p>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <label class="text-muted small d-block mb-1">Fecha Finalización</label>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-calendar-check me-2 text-secondary"></i>
                        <p id="det_fin" class="mb-0 fw-medium">--</p>
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <div class="accordion accordion-flush border rounded" id="accordionObjetivos">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEspecificos">
                                    <i class="bi bi-list-check me-2"></i> Objetivos
                                </button>
                            </h2>
                            <div id="collapseEspecificos" class="accordion-collapse collapse" data-bs-parent="#accordionObjetivos">
                                <ul class="list-group" id="listaObjetivos"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Participantes de la Modalidad</h5>
        </div>

        <div class="card-body">
            <div class="accordion accordion-flush border rounded" id="accordionParticipantes">

                <!-- ESTUDIANTES -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseEstudiantes">
                            <i class="bi bi-people me-2"></i> Estudiantes
                        </button>
                    </h2>
                    <div id="collapseEstudiantes" class="accordion-collapse collapse"
                        data-bs-parent="#accordionParticipantes">

                        <ul class="list-group list-group-flush" id="listaEstudiantes">
                            <!-- JS dinámico -->
                            <!-- Ejemplo:
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Juan Pérez
                                <span class="badge bg-secondary">Código: 12345</span>
                            </li>
                            -->
                        </ul>

                    </div>
                </div>

                <!-- ASESOR -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseAsesor">
                            <i class="bi bi-person-badge me-2"></i> Asesor
                        </button>
                    </h2>
                    <div id="collapseAsesor" class="accordion-collapse collapse"
                        data-bs-parent="#accordionParticipantes">

                        <div class="p-3" id="det_asesor">
                            <!-- JS dinámico -->
                            <!-- Ejemplo:
                            <p class="mb-1 fw-semibold">Dr. Carlos Gómez</p>
                            <small class="text-muted">Ingeniería de Sistemas</small>
                            -->
                        </div>

                    </div>
                </div>

                <!-- COASESOR -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseCoasesor">
                            <i class="bi bi-person-plus me-2"></i> Coasesor
                        </button>
                    </h2>
                    <div id="collapseCoasesor" class="accordion-collapse collapse"
                        data-bs-parent="#accordionParticipantes">

                        <div class="p-3" id="det_coasesor">
                            <!-- JS dinámico -->
                        </div>

                    </div>
                </div>

                <!-- JURADOS -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseJurados">
                            <i class="bi bi-person-check me-2"></i> Jurados
                        </button>
                    </h2>
                    <div id="collapseJurados" class="accordion-collapse collapse"
                        data-bs-parent="#accordionParticipantes">

                        <ul class="list-group list-group-flush" id="listaJurados">
                            <!-- JS dinámico -->
                        </ul>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection();?>