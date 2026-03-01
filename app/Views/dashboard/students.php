<?php echo $this->extend('layout/main'); ?>
<?php echo $this->section('content'); ?>
    
    <div class="table-responsive mt-4">
        <table class="table" id="otherTables">
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
            <tbody>
                <?php foreach ($students['Students'] as $student): ?>
                    <tr>
                        <td><?= $student['code'] ?></td>
                        <td><?= $student['name_student'] ?></td>
                        <td><?= $students['Program']['program_name'] ?></td>
                        <td><?= $students['Program']['sede'] ?></td>
                        <td><?= $student['type_modalitie'] ?></td>
                        <td><button type="button" class="btn btn-sm btn-success"><span><i class="bi bi-pencil-square"></i></span></button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php echo $this->endSection(); ?>