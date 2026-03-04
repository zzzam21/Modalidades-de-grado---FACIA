<?php echo $this->extend('layout/main'); ?>
<?php echo $this->section('content'); ?>
    
    <div class="container text-center pt-0">
        
        <div class="row justify-content-center g-2 pt-4">
            <div class="col-md-4 col-sm-4">
                <div class="small-box bg-info" >
                    <div class="inner">
                        <h3><?= $countStudents ?></h3>
                        <h5>Estudiantes Activos</h5>
                    </div>
                    <div class="icon">
                        <i class="bi bi-backpack3-fill"></i>
                    </div>  
                    <a href="<?= base_url("students") ?>" class="small-box-footer">
                        Mirar Estudiantes <i class="bi bi-arrow-right-circle-fill"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="small-box bg-info" >
                    <div class="inner">
                        <h3><?= $countModalities ?></h3>
                        <h5>Modalidades Vigentes</h5>
                    </div>
                    <div class="icon">
                        <i class="bi bi-mortarboard"></i>
                    </div>  
                    <a href="<?= base_url("modalities") ?>" class="small-box-footer">
                        Mirar Modalidades <i class="bi bi-arrow-right-circle-fill"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="small-box bg-info" >
                    <div class="inner">
                        <h3><?= $countTeachers ?></h3>
                        <h5>Docentes Asignados</h5>
                    </div>
                    <div class="icon">
                        <i class="bi bi-clipboard-check"></i>
                    </div>  
                    <a href="<?= base_url("teachers") ?>" class="small-box-footer">
                        Mirar Docentes <i class="bi bi-arrow-right-circle-fill"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <h4 class="text-center"><b>MODALIDADES DE GRADO</b></h4>
            <table class="table display responsive" id="modalityTable">
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
    
<?php echo $this->endSection(); ?>