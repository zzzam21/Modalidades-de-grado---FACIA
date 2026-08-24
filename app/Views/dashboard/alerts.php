<?php echo $this->extend('layout/main'); ?>
<?php echo $this->section('content'); ?>

<div id="app" data-view="alerts">

    <!-- CARDS RESUMEN -->
    <div class="row justify-content-center g-3 pt-3">
        <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-danger h-100">
                <div class="inner">
                    <h3 id="countVencidas">-</h3>
                    <p class="mb-0">Vencidas</p>
                </div>
                <div class="icon">
                    <i class="bi bi-exclamation-octagon"></i>
                </div>
                <a href="#vencidasSection" class="small-box-footer">
                    Ver detalle <i class="bi bi-arrow-right-circle-fill"></i>
                </a>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-warning h-100">
                <div class="inner">
                    <h3 id="countProximas">-</h3>
                    <p class="mb-0">Próximas a terminar (7 días)</p>
                </div>
                <div class="icon">
                    <i class="bi bi-clock-history"></i>
                </div>
                <a href="#proximasSection" class="small-box-footer">
                    Ver detalle <i class="bi bi-arrow-right-circle-fill"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- SECCION: VENCIDAS -->
    <div id="vencidasSection" class="mt-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3 gap-2">
            <h4 class="mb-0 text-center text-md-start fw-bold text-danger">
                <i class="bi bi-exclamation-octagon"></i> VENCIDAS
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
            <h4 class="mb-0 text-center text-md-start fw-bold" style="color: #b58100;">
                <i class="bi bi-clock-history"></i> PRÓXIMAS A TERMINAR (7 DÍAS)
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
