<?php echo $this->extend('layout/main'); ?>
<?php echo $this->section('content'); ?>
    
    <div class="table-responsive mt-4">
        <h4 class="text-center"><b>DOCENTES</b></h4>
        <table class="table" id="teachersTables">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>

<?php echo $this->endSection(); ?>