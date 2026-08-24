<?php echo $this->extend('layout/main'); ?>
<?php echo $this->section('content'); ?>

<div id="app" data-view="alerts">

    <!-- CARDS RESUMEN -->
    <div class="row justify-content-center g-3 pt-2">
        <div class="col-12 col-sm-6 col-md-4">
            <a href="#vencidasSection" class="stat-card danger">
                <span class="stat-icon"><i class="bi bi-exclamation-octagon"></i></span>
                <span class="stat-body">
                    <span class="stat-value" id="countVencidas">-</span>
                    <span class="stat-label">Vencidas</span>
                </span>
                <i class="bi bi-chevron-right stat-arrow"></i>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-md-4">
            <a href="#proximasSection" class="stat-card warning">
                <span class="stat-icon"><i class="bi bi-clock-history"></i></span>
                <span class="stat-body">
                    <span class="stat-value" id="countProximas">-</span>
                    <span class="stat-label">Próximas a terminar (7 días)</span>
                </span>
                <i class="bi bi-chevron-right stat-arrow"></i>
            </a>
        </div>
    </div>

    <!-- SECCION: VENCIDAS -->
    <div id="vencidasSection" class="mt-4 pt-2">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3 gap-2">
            <h4 class="section-title danger mb-0 text-center text-md-start">
                <i class="bi bi-exclamation-octagon me-1"></i> Vencidas
            </h4>
        </div>
<!-- kd -->
        <div class="table-responsive">
            <table class="table w-100" id="vencidasTable">
                <thead class="table-light">
                    <tr>
                        <th># Acuerdo</th>
                        <th>Nombre Modalidad</th>
                        <th>Programa</th>
                        <th>Fecha Límite</th>
                        <th>Estado</th>
                        <th>Días de Retraso</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <!-- SECCION: PRÓXIMAS A VENCER -->
    <div id="proximasSection" class="mt-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3 gap-2">
            <h4 class="section-title warning mb-0 text-center text-md-start">
                <i class="bi bi-clock-history me-1"></i> Próximas a terminar (7 días)
            </h4>
        </div>

        <div class="table-responsive">
            <table class="table w-100" id="proximasTable">
                <thead class="table-light">
                    <tr>
                        <th># Acuerdo</th>
                        <th>Nombre Modalidad</th>
                        <th>Programa</th>
                        <th>Fecha Límite</th>
                        <th>Estado</th>
                        <th>Días Restantes</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <!-- ESTADO VACÍO -->
    <div id="emptyState" class="text-center py-5 d-none">
        <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
        <h5 class="mt-3 fw-bold">Todo en orden</h5>
        <p class="text-muted">No hay modalidades con alertas en este momento.</p>
    </div>

</div>

<?php echo $this->endSection(); ?>
