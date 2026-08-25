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

    <!-- Modal Editar Estudiante -->
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editStudentModalLabel">Editar Estudiante</h1>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editStudentId">
                    <div class="mb-3">
                        <label class="form-label">Nombres y Apellidos</label>
                        <input type="text" class="form-control" id="editStudentName">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Código</label>
                        <input type="text" class="form-control" id="editStudentCode">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button id="saveStudent" class="btn btn-success">
                        <i class="bi bi-check-lg me-1"></i>Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>
