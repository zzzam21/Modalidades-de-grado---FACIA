<?php echo $this->extend('layout/main'); ?>
<?php echo $this->section('content'); ?>
    
<div id="app" data-view="dashboard">

    <!-- CARDS -->
    <div class="row justify-content-center g-3 pt-2">

        <!-- Estudiantes -->
        <div class="col-12 col-sm-6 col-md-4">
            <a href="<?= base_url("students") ?>" class="stat-card">
                <span class="stat-icon"><i class="bi bi-backpack3-fill"></i></span>
                <span class="stat-body">
                    <span class="stat-value"><?= $countStudents ?></span>
                    <span class="stat-label">Estudiantes activos</span>
                </span>
                <i class="bi bi-chevron-right stat-arrow"></i>
            </a>
        </div>

        <!-- Modalidades -->
        <div class="col-12 col-sm-6 col-md-4">
            <a href="<?= base_url("modalities") ?>" class="stat-card">
                <span class="stat-icon"><i class="bi bi-mortarboard"></i></span>
                <span class="stat-body">
                    <span class="stat-value"><?= $countModalities ?></span>
                    <span class="stat-label">Modalidades vigentes</span>
                </span>
                <i class="bi bi-chevron-right stat-arrow"></i>
            </a>
        </div>

        <!-- Docentes -->
        <div class="col-12 col-sm-6 col-md-4">
            <a href="<?= base_url("teachers") ?>" class="stat-card">
                <span class="stat-icon"><i class="bi bi-clipboard-check"></i></span>
                <span class="stat-body">
                    <span class="stat-value"><?= $countTeachers ?></span>
                    <span class="stat-label">Docentes asignados</span>
                </span>
                <i class="bi bi-chevron-right stat-arrow"></i>
            </a>
        </div>

    </div>

    <div class="mt-4 pt-2">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3 gap-2">
            <h4 class="section-title mb-0">Modalidades de grado</h4>
        </div>
        
        <div class="table-responsive">
            <table class="table w-100" id="modalityTable">
                <thead class="table-light">
                    <tr>
                        <th># Acuerdo</th>
                        <th>Nombre Modalidad</th>
                        <th>Modalidad</th>
                        <th>Estado</th>
                        <th>Fecha Inicio</th>
                        <th>Duración</th>
                        <th>Final Estimado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>
    
<?php echo $this->endSection(); ?>