<?php echo $this->extend('layout/main'); ?>
<?php echo $this->section('content'); ?>

<input type="hidden" id="teacherId" value="<?= $id ?>">

<div class="row g-3 mb-4" id="app" data-view="teacher-detail">

    <!-- ASESOR -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">Como Asesor</small>
                    <h3 id="kpi_asesor" class="fw-bold mb-0">0</h3>
                </div>
                <i class="bi bi-person-check fs-2 text-success"></i>
            </div>
        </div>
    </div>

    <!-- COASESOR -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">Como Coasesor</small>
                    <h3 id="kpi_coasesor" class="fw-bold mb-0">0</h3>
                </div>
                <i class="bi bi-person-plus fs-2 text-warning"></i>
            </div>
        </div>
    </div>

    <!-- JURADO -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">Como Jurado</small>
                    <h3 id="kpi_jurado" class="fw-bold mb-0">0</h3>
                </div>
                <i class="bi bi-person-badge fs-2 text-primary"></i>
            </div>
        </div>
    </div>

</div>

<div class="row g-3 mb-4">

    <!-- EN PROCESO -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">En proceso</small>
                    <h3 id="kpi_proceso" class="fw-bold mb-0">0</h3>
                </div>
                <i class="bi bi-hourglass-split fs-2 text-warning"></i>
            </div>
        </div>
    </div>

    <!-- FINALIZADAS -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">Finalizadas</small>
                    <h3 id="kpi_finalizadas" class="fw-bold mb-0">0</h3>
                </div>
                <i class="bi bi-flag fs-2 text-success"></i>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white">
        <h5 class="mb-0 fw-bold">Modalidades asignadas</h5>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="teacherTable" class="table table-hover align-middle nowrap w-100">
                <thead class="table-light">
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th class="text-center">Acción</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>

<?php echo $this->endSection();?>