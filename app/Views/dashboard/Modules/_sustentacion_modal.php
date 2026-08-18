<!-- Modal para definir la Fecha de Sustentación -->
<div class="modal fade" id="sustentacionModal" tabindex="-1" aria-labelledby="sustentacionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sustentacionModalLabel">
                    <i class="bi bi-calendar2-check me-2"></i>Fecha de Sustentación
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label class="form-label">Fecha y hora de sustentación del trabajo de grado</label>
                <input type="datetime-local" class="form-control" id="v_fecha_sustentacion">
                <div class="form-text">Déjelo vacío para eliminar la fecha registrada.</div>
            </div>
            <div class="modal-footer">
                <div class="spinner-grow spinner-grow-sm text-primary d-none" id="loadingSustentacion">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveSustentacionBtn">
                    <i class="bi bi-check-lg me-1"></i>Guardar
                </button>
            </div>
        </div>
    </div>
</div>