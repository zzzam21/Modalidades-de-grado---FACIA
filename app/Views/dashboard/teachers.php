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

    <!-- Modal Editar Docente -->
    <div class="modal fade" id="editTeacherModal" tabindex="-1" aria-labelledby="editTeacherModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editTeacherModalLabel">Editar Docente</h1>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editTeacherId">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="editTeacherName">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button id="saveTeacher" class="btn btn-success">
                        <i class="bi bi-check-lg me-1"></i>Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>
