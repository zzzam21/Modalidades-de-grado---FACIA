<?php echo $this->extend('layout/main'); ?>
<?php echo $this->section('content'); ?>

<input type="hidden" id="studentId" value="<?= $id ?? null ?>">

<div class="d-grip gap-1 d-md-flex justify-content-md-start mb-4">
    <a href="<?= base_url('/students') ?>" class="btn btn-light">
        <i class="bi bi-arrow-left me-2"></i> Estudiantes
    </a>
</div>

<div class="card shadow-sm border-0 mb-4" id="app" data-view="student-detail">

    <div class="card-body d-flex align-items-center">
        <div class="p-2 flex-grow-1">
            <h4 id="est_nombre" class="fw-bold mb-1">--</h4>
            <small id="est_codigo" class="text-muted">--</small>
        </div>

        <div class="p-2">
            <i class="bi bi-mortarboard fs-1 text-success"></i>
        </div>
    </div>

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">
            <div class="d-flex align-items-center">
                <div class="p-2 flex-grow-1 align-self-end">
                    <h5 id="mod-type" class="fw-bold mb-0">Modalidad de Grado</h5>
                </div>
                <div class="p-2">
                    <div id="badge-custom" class="mt-2"></div>
                </div>
            </div>
        </div>

        <div class="card-body">

            <!-- Título -->
            <h4 id="mod_titulo" class="fw-bold mb-3">--</h4>

            <!-- Info -->
            <div class="row g-3 mb-3">

                <div class="col-md-6">
                    <small class="text-muted">Asesor</small>
                    <p id="mod_asesor" class="fw-semibold mb-0">--</p>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Coasesor</small>
                    <p id="mod_coasesor" class="fw-semibold mb-0">--</p>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Fecha inicio</small>
                    <p id="mod_inicio" class="mb-0">--</p>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Duración</small>
                    <p id="mod_duracion" class="mb-0">--</p>
                </div>

            </div>


            <div class="text-end">
                <a id="btn_ver_modalidad" href="./" class="btn btn-success">
                    <i class="bi bi-eye"></i> Ver detalle completo
                </a>
            </div>

        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>