<?php echo $this->extend('layout/main'); ?>
<?php echo $this->section('content'); ?>
    
    <div class="container text-center pt-0">
        
        <div class="row justify-content-center g-2 pt-4">
            <div class="col-md-4 col-sm-6">
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
            <div class="col-md-4 col-sm-6">
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
            <div class="col-md-4 col-sm-6">
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
        <hr>
        <div class="row mt-2 table-responsive">
            <div class="col">
                <h4><b>MODALIDADES DE GRADO</b></h4>
                <table class="table table-responsive display" id="modalityTable">
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
                                    <td
                                    class="text-truncate-modal" 
                                    data-bs-toggle="popover" 
                                    data-bs-title="Título"
                                    data-bs-trigger="hover"
                                    data-bs-content="<?= esc($modality['name_modalitie']) ?>"
                                    data-bs-placement="right"
                                    role="button"
                                    style="cursor: pointer;"
                                    >
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
        </div>
    </div>
<?php echo $this->endSection(); ?>