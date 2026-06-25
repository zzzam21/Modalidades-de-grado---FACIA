<?php echo $this->extend('layout/main'); ?>
<?php echo $this->section('content'); ?>
    
<div id="app" data-view="dashboard">

    <!-- CARDS -->
    <div class="row justify-content-center g-3 pt-3">

        <!-- Estudiantes -->
        <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-info h-100">
                <div class="inner">
                    <h3><?= $countStudents ?></h3>
                    <p class="mb-0">Estudiantes Activos</p>
                </div>
                <div class="icon">
                    <i class="bi bi-backpack3-fill"></i>
                </div>  
                <a href="<?= base_url("students") ?>" class="small-box-footer">
                    Ver Estudiantes <i class="bi bi-arrow-right-circle-fill"></i>
                </a>
            </div>
        </div>

        <!-- Modalidades -->
        <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-info h-100">
                <div class="inner">
                    <h3><?= $countModalities ?></h3>
                    <p class="mb-0">Modalidades Vigentes</p>
                </div>
                <div class="icon icon-fluid">
                    <i class="bi bi-mortarboard"></i>
                </div>  
                <a href="<?= base_url("modalities") ?>" class="small-box-footer">
                    Ver Modalidades <i class="bi bi-arrow-right-circle-fill"></i>
                </a>
            </div>
        </div>

        <!-- Docentes -->
        <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-info h-100">
                <div class="inner">
                    <h3><?= $countTeachers ?></h3>
                    <p class="mb-0">Docentes Asignados</p>
                </div>
                <div class="icon">
                    <i class="bi bi-clipboard-check"></i>
                </div>  
                <a href="<?= base_url("teachers") ?>" class="small-box-footer">
                    Ver Docentes <i class="bi bi-arrow-right-circle-fill"></i>
                </a>
            </div>
        </div>

    </div>

    <div class="mt-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3 gap-2">
            <h4 class="mb-0 text-center text-md-start fw-bold">
                MODALIDADES DE GRADO
            </h4>
        </div>
        
        <div class="table-responsive">
            <table class="table w-100" id="modalityTable">
                <thead class="table-light">
                    <tr>
                        <th></th>
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