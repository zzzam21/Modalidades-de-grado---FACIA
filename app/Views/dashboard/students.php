<?php echo $this->extend('layout/main'); ?>
<?php echo $this->section('content'); ?>

<div id="app" data-view="students">
    <div class="mt-4">
        <table class="table responsive" id="studentTables">
            <h4 class="text-center"><b>ESTUDIANTES</b></h4>
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