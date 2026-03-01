<?php echo $this->extend('layout/main'); ?>
<?php echo $this->section('content'); ?>
    
    <div class="table-responsive mt-4">
        <h4 class="text-center"><b>DOCENTES</b></h4>
        <table class="table" id="otherTables">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($teachers as $teacher): ?>
                <tr>
                    <td><?= $teacher['teacher_ID'] ?></td>
                    <td><?= $teacher['name'] ?></td>
                    <td style="text-align: center;"><button type="button" class="btn btn-sm btn-success"><span><i class="bi bi-eye"></i></span></button></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php echo $this->endSection(); ?>