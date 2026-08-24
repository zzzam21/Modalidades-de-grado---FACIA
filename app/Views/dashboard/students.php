<?php echo $this->extend('layout/main'); ?>
<?php echo $this->section('content'); ?>

<div id="app" data-view="students">
    <div class="pt-4 pb-3">
        <h4 class="section-title mb-0">Estudiantes</h4>
    </div>
    <div class="table-responsive">
        <table class="table w-100" id="studentTables">
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Nombres y Apellidos</th>
                    <th>Programa</th>
                    <th>Sede</th>
                    <th>Modalidad</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<?php echo $this->endSection(); ?>
