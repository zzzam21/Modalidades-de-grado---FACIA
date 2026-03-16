<?php echo $this->extend('layout/main'); ?>
<?php echo $this->section('content'); ?>
    
    <div class="pt-3">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 fw-bold">Detalle de Modalidad de Grado</h4>
                    <div id="det_estado">--</div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-12">
                        <label class="text-muted small text-uppercase fw-semibold mb-1">Título del Proyecto</label>
                        <h4 id="det_titulo" class="fw-bold lh-base">--</h4>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <label class="text-muted small d-block mb-1">Tipo de Modalidad</label>
                        <span id="det_tipo" class="badge bg-light text-dark border p-2 w-100 text-truncate">--</span>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <label class="text-muted small d-block mb-1">Fecha Inicio</label>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-event me-2 text-secondary"></i>
                            <p id="det_inicio" class="mb-0 fw-medium">--</p>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <label class="text-muted small d-block mb-1">Duración</label>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-clock me-2 text-secondary"></i>
                            <p id="det_duracion" class="mb-0 fw-medium">--</p>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3">
                        <label class="text-muted small d-block mb-1">Fecha Finalización</label>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-check me-2 text-secondary"></i>
                            <p id="det_fin" class="mb-0 fw-medium">--</p>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <div class="accordion accordion-flush border rounded" id="accordionObjetivos">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEspecificos">
                                        <i class="bi bi-list-check me-2"></i> Objetivos
                                    </button>
                                </h2>
                                <div id="collapseEspecificos" class="accordion-collapse collapse" data-bs-parent="#accordionObjetivos">
                                    <ul class="list-group" id="listaObjetivos"></ul>
                                    <!-- <div class="accordion-body text-secondary" id="det_obj_especificos">
                                        No se han definido objetivos.
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script>
    const modalityId = "<?php echo $target_id ?? ''; ?>";
    
    if (modalityId) {
        getModality(modalityId);
    } else {
        alert.warn("No se detectó ID en la vista.");
    }

    async function getModality(id) {
    try {
        console.log(id);
        const response = await fetch(
            `../getmodality/${id}`,
            {
                method : 'GET',
                headers: {
                    "Content-Type": "application/json"
                }
            }
        )

        if (!response.ok) {
            alert('Error de solicitud') 
            return;
        }
        else
        {
            const result = await response.json();
            const mod = result.data;  

            // Datos básicos
            document.getElementById('det_titulo').innerText = mod.name_modalitie;
            document.getElementById('det_tipo').innerText = mod.type_modality;
            document.getElementById('det_inicio').innerText = mod.date_approved;
            document.getElementById('det_fin').innerText = mod.date_end;
            document.getElementById('det_duracion').innerText = mod.duration;

            // Objetivos (Suponiendo que vienen en el JSON)
            const objetivos = JSON.parse(mod.goal);
            document.getElementById("listaObjetivos").innerHTML =
                objetivos.map(o => `<li class="list-group-item">${o}</li>`).join("");

            // Estado con clase dinámica
            const statusClasses = {
                'aprobada': 'badge-aprobado',
                'En curso': 'badge-en-curso',
                'Cancelado': 'badge-cancelado',
                'Finalizado': 'badge-finalizado'
            };
            const estadoElt = document.getElementById('det_estado');
            const badgeClass = statusClasses[mod.status] || "bg-seconday";
            estadoElt.innerHTML = `<span class="badge-custom ${badgeClass} p-2">${mod.status}</span>`;

        }
    }catch(e) {
        console.error("Fetch error:", e);
        serverError();
    }
}

function serverError(){
    Swal.fire({
        title: "Error del servidor!",
        icon: "error",
        draggable: true
    })
}

</script>
<?php echo $this->endSection();?>