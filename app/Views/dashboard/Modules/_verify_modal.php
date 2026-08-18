<!-- Modal de Verificación de Datos Extraídos -->
<div class="modal fade" id="verifyModal" tabindex="-1" aria-labelledby="verifyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verifyModalLabel">
                    <i class="bi bi-eye me-2"></i><span id="verifyModalTitle">Verificar Datos Extraídos</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info py-2 small" role="alert" id="verifyInfoAlert">
                    <i class="bi bi-info-circle me-1"></i> Revise cuidadosamente los datos extraídos del PDF. Corrija cualquier campo incorrecto antes de confirmar.
                </div>
                <div class="accordion" id="verifyAccordion">
                    <!-- Datos de la Modalidad -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseModality">
                                <i class="bi bi-mortarboard me-2"></i> Datos de la Modalidad
                            </button>
                        </h2>
                        <div id="collapseModality" class="accordion-collapse collapse show" data-bs-parent="#verifyAccordion">
                            <div class="accordion-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Nombre del Trabajo</label>
                                        <input type="text" class="form-control" id="v_name_trabajo">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tipo de Modalidad</label>
                                        <select class="form-select" id="v_tipo_modalidad">
                                            <option value="">-- Seleccione --</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">No. Acuerdo</label>
                                        <input type="text" class="form-control" id="v_no_acuerdo">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Estado</label>
                                        <select class="form-select" id="v_estado">
                                            <option value="">-- Seleccione --</option>
                                            <option value="aprobada">Aprobada</option>
                                            <option value="En curso">En curso</option>
                                            <option value="Cancelado">Cancelado</option>
                                            <option value="Finalizado">Finalizado</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Fecha Inicio</label>
                                        <input type="date" class="form-control" id="v_fecha_inicio">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Duración</label>
                                        <input type="text" class="form-control" id="v_duracion">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Fin Estimado</label>
                                        <input type="date" class="form-control" id="v_fin_estimado">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Estudiantes -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStudents">
                                <i class="bi bi-people me-2"></i> Estudiantes
                            </button>
                        </h2>
                        <div id="collapseStudents" class="accordion-collapse collapse" data-bs-parent="#verifyAccordion">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered mb-2">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Código</th>
                                                <th>Documento</th>
                                                <th>Nombre</th>
                                                <th>Programa</th>
                                                <th>Sede</th>
                                                <th style="width:40px"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="v_students_tbody">
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="addStudentRow">
                                    <i class="bi bi-plus-lg"></i> Agregar Estudiante
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Asesores / Coasesores / Jurados -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRoles">
                                <i class="bi bi-person-badge me-2"></i> Asesores, Coasesores y Jurados
                            </button>
                        </h2>
                        <div id="collapseRoles" class="accordion-collapse collapse" data-bs-parent="#verifyAccordion">
                            <div class="accordion-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="fw-semibold mb-2">Asesor <small class="text-muted">(máx. 1)</small></label>
                                        <div id="v_asesores_container"></div>
                                        <button type="button" class="btn btn-sm btn-outline-primary mt-1" id="addAsesorBtn">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fw-semibold mb-2">Coasesor <small class="text-muted">(máx. 1)</small></label>
                                        <div id="v_coasesores_container"></div>
                                        <button type="button" class="btn btn-sm btn-outline-primary mt-1" id="addCoasesorBtn">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fw-semibold mb-2">Jurados <small class="text-muted">(máx. 2)</small></label>
                                        <div id="v_jurados_container"></div>
                                        <button type="button" class="btn btn-sm btn-outline-primary mt-1" id="addJuradoBtn">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Objetivos -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseObjetivos">
                                <i class="bi bi-list-check me-2"></i> Objetivos
                            </button>
                        </h2>
                        <div id="collapseObjetivos" class="accordion-collapse collapse" data-bs-parent="#verifyAccordion">
                            <div class="accordion-body">
                                <label class="form-label">Objetivos (uno por línea)</label>
                                <textarea class="form-control" id="v_objetivos" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="spinner-grow spinner-grow-sm text-success d-none" id="loadingVerify">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="confirmSaveModality">
                    <i class="bi bi-check-lg me-1"></i>Confirmar y Guardar
                </button>
            </div>
        </div>
    </div>
</div>
