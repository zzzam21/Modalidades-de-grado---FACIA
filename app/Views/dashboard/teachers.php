<?php echo $this->extend('layout/main'); ?>
<?php echo $this->section('content'); ?>

<div id="app" data-view="teachers">
    <div class="pt-4 pb-3">
        <h4 class="section-title mb-0">Docentes</h4>
    </div>
    <div class="table-responsive">
        <table class="table w-100" id="teachersTables">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
</div>


<?php echo $this->endSection(); ?>
