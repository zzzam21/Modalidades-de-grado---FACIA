document.addEventListener("DOMContentLoaded", () => {
    const app = document.getElementById("app");
    const view = app.dataset.view;

    switch (view) {
        case "modality-detail":
            const modalityId = document.getElementById("modalityId")
            if (modalityId.value) {
                getModality(modalityId.value);
            }
            break;
        case "modalities":
            document.getElementById("saveModality").addEventListener("click", postModalitie);
            document.getElementById("confirmSaveModality").addEventListener("click", confirmSaveModality);
            document.getElementById("addStudentRow").addEventListener("click", () => addStudentRow());
        default:
            break;
    }
})

async function postModalitie() {

    const spinner = document.getElementById("loadingModality");
    spinner.classList.remove('d-none');

    try {
        const file = document.getElementById("formFile");

        if (!file.files.length) {
            spinner.classList.add('d-none');
            Swal.fire({
                title: "Por favor, selecciona un archivo PDF!",
                text: "No se ha seleccionado ningún archivo.",
                icon: "warning",
                confirmButtonText: "Aceptar",
                draggable: true
            });
            return;
        }

        const formData = new FormData();
        formData.append("formFile", file.files[0]);

        const response = await fetch("modalities/add", {
            method: "POST",
            body: formData
        });

        const result = await response.json();

        if (!response.ok) {
            throw new Error("Error en la solicitud: " + result.message);
        }

        if (result.success) {
            window.verificationData = result.data;
            populateVerificationModal(result.data);
            $("#addmodalitie").modal("hide");
            spinner.classList.add('d-none');
            $("#verifyModal").modal("show");
        } else {
            $("#addmodalitie").modal("hide");
            spinner.classList.add('d-none');

            Swal.fire({
                title: "Error Procesando PDF!",
                text: result.message || "Ocurrió un error al procesar el PDF.",
                icon: "error",
                draggable: true,
                confirmButtonText: "Aceptar"
            });
        }
    } catch (error) {
        $("#addmodalitie").modal("hide");
        spinner.classList.add('d-none');
        console.error(error);
        serverError();
    }
}

function populateVerificationModal(data) {
    const m = data.modalidad;

    document.getElementById("v_name_trabajo").value = m.nombre_trabajo || "";
    document.getElementById("v_tipo_modalidad").value = m.tipo_modalidad || "";
    document.getElementById("v_id_modalidad").value = m.id_modalidad ?? "";
    document.getElementById("v_no_acuerdo").value = m.No_acuerdo ?? "";
    document.getElementById("v_estado").value = m.estado_modalidad || "";
    document.getElementById("v_fecha_inicio").value = m.fecha_inicio_modalidad || "";
    document.getElementById("v_duracion").value = m.duracion_modalidad || "";
    document.getElementById("v_fin_estimado").value = m.fin_estimado_modalidad || "";

    document.getElementById("v_objetivos").value = (m.objetivos_modalidad || []).join("\n");

    const tbody = document.getElementById("v_students_tbody");
    tbody.innerHTML = "";
    (data.estudiantes || []).forEach(s => addStudentRow(s));

    renderRoles("asesores", data.asesores || []);
    renderRoles("coasesores", data.coasesores || []);
    renderRoles("jurados", data.jurados || []);
}

function renderRoles(role, items) {
    const container = document.getElementById(`v_${role}_container`);
    container.innerHTML = "";
    if (items.length === 0) {
        items.push({ nombre: "" });
    }
    items.forEach(item => addRoleRow(role, item.nombre || ""));
}

function addStudentRow(data) {
    data = data || {};
    const tbody = document.getElementById("v_students_tbody");
    const row = document.createElement("tr");
    row.innerHTML = `
        <td><input type="text" class="form-control form-control-sm v-student-code" value="${escapeHtml(data.codigo_estudiantil || "")}"></td>
        <td><input type="text" class="form-control form-control-sm v-student-doc" value="${escapeHtml(data.documento_identidad || "")}"></td>
        <td><input type="text" class="form-control form-control-sm v-student-name" value="${escapeHtml(data.nombre || "")}"></td>
        <td><input type="text" class="form-control form-control-sm v-student-program" value="${escapeHtml(data.programa || "")}"></td>
        <td><input type="text" class="form-control form-control-sm v-student-sede" value="${escapeHtml(data.nombre_sede || "")}"></td>
        <td><input type="text" class="form-control form-control-sm v-student-sede-code" value="${escapeHtml(data.sede_codigo || "")}"></td>
        <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove()"><i class="bi bi-x"></i></button></td>
    `;
    tbody.appendChild(row);
}

function addRoleRow(role, nombre) {
    nombre = nombre || "";
    const container = document.getElementById(`v_${role}_container`);
    const div = document.createElement("div");
    div.className = "input-group input-group-sm mb-1";
    div.innerHTML = `
        <input type="text" class="form-control v-${role}-name" value="${escapeHtml(nombre)}" placeholder="Nombre">
        <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()"><i class="bi bi-x"></i></button>
    `;
    container.appendChild(div);
}

function collectVerificationData() {
    const estudiantes = [];
    document.querySelectorAll("#v_students_tbody tr").forEach(row => {
        estudiantes.push({
            codigo_estudiantil: row.querySelector(".v-student-code").value || null,
            documento_identidad: row.querySelector(".v-student-doc").value || null,
            nombre: row.querySelector(".v-student-name").value || null,
            programa: row.querySelector(".v-student-program").value || null,
            nombre_sede: row.querySelector(".v-student-sede").value || null,
            sede_codigo: row.querySelector(".v-student-sede-code").value || null
        });
    });

    const objetivosText = document.getElementById("v_objetivos").value;
    const objetivos = objetivosText
        .split("\n")
        .map(l => l.trim())
        .filter(l => l.length > 0);

    return {
        estudiantes: estudiantes,
        asesores: collectRoleNames("asesores"),
        coasesores: collectRoleNames("coasesores"),
        jurados: collectRoleNames("jurados"),
        modalidad: {
            No_acuerdo: document.getElementById("v_no_acuerdo").value || null,
            nombre_trabajo: document.getElementById("v_name_trabajo").value || null,
            tipo_modalidad: document.getElementById("v_tipo_modalidad").value || null,
            id_modalidad: document.getElementById("v_id_modalidad").value || null,
            estado_modalidad: document.getElementById("v_estado").value || null,
            fecha_inicio_modalidad: document.getElementById("v_fecha_inicio").value || null,
            objetivos_modalidad: objetivos,
            duracion_modalidad: document.getElementById("v_duracion").value || null,
            fin_estimado_modalidad: document.getElementById("v_fin_estimado").value || null
        }
    };
}

function collectRoleNames(role) {
    const names = [];
    document.querySelectorAll(`#v_${role}_container .v-${role}-name`).forEach(input => {
        const val = input.value.trim();
        if (val) {
            names.push({ nombre: val });
        }
    });
    return names.length > 0 ? names : [{ nombre: null }];
}

async function confirmSaveModality() {
    const spinner = document.getElementById("loadingVerify");
    spinner.classList.remove('d-none');

    try {
        const data = collectVerificationData();

        if (!data.modalidad.nombre_trabajo || !data.modalidad.id_modalidad) {
            spinner.classList.add('d-none');
            Swal.fire({
                title: "Datos incompletos",
                text: "El nombre del trabajo y el tipo de modalidad son obligatorios.",
                icon: "warning",
                confirmButtonText: "Aceptar",
                draggable: true
            });
            return;
        }

        const response = await fetch("modalities/process", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        });

        const result = await response.json();
        $("#verifyModal").modal("hide");
        spinner.classList.add('d-none');

        if (result.success) {
            Swal.fire({
                title: "Modalidad Agregada Correctamente!",
                icon: "success",
                draggable: true
            });
            $('#modalityTable').DataTable().ajax.reload();
        } else {
            Swal.fire({
                title: "Error agregando modalidad!",
                icon: "error",
                draggable: true
            });
        }
    } catch (error) {
        $("#verifyModal").modal("hide");
        spinner.classList.add('d-none');
        console.error(error);
        serverError();
    }
}

function escapeHtml(str) {
    const div = document.createElement("div");
    div.textContent = str;
    return div.innerHTML;
}

// -----------------------------------------------------------------------
// Funciones existentes (sin cambios)
// -----------------------------------------------------------------------

async function getModality(id) {
    try {
        const response = await fetch(
            `../getmodality/${id}`,
            {
                method: 'GET',
                headers: {
                    "Content-Type": "application/json"
                }
            }
        )

        if (!response.ok) {
            alert('Error de solicitud')
            return;
        }
        else {
            const result = await response.json();
            const mod = result.data;

            document.getElementById('det_titulo').innerText = mod.name_modalitie;
            document.getElementById('det_tipo').innerText = mod.type_modality;
            document.getElementById('det_inicio').innerText = mod.date_approved;
            document.getElementById('det_fin').innerText = mod.date_end;
            document.getElementById('det_duracion').innerText = mod.duration;

            const objetivos = JSON.parse(mod.goal);
            document.getElementById("listaObjetivos").innerHTML =
                objetivos.map(o => `<li class="list-group-item">${o}</li>`).join("");

            const statusClasses = {
                'aprobada': 'badge-aprobado',
                'En curso': 'badge-en-curso',
                'Cancelado': 'badge-cancelado',
                'Finalizado': 'badge-finalizado'
            };

            const estadoElt = document.getElementById('det_estado');
            const badgeClass = statusClasses[mod.status] || "bg-seconday";
            estadoElt.innerHTML = `<span class="badge-custom ${badgeClass} p-2">${mod.status}</span>`;
            renderStudents(result.student);
            renderAsesor(result.asesor);
            renderCoAsesor(result.coasesor);
            renderJurado(result.jurado);
        }
    } catch (e) {
        console.error("Fetch error:", e);
        serverError();
    }
}

async function deleteModality(id) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: "¿Estas seguro?",
        text: "No podras revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Eliminar Modalidad!",
        cancelButtonText: "No, cancelar!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(
                `../deleteModality/${id}`,
                {
                    method: 'DELETE',
                    headers: {
                        "Content-Type": "application/json"
                    }
                }
            );
            window.location.href = '../';
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire({
                title: "Cancelado",
                text: "No has eliminado la modalidad :)",
                icon: "error"
            });
        }
    });
}

function serverError() {
    Swal.fire({
        title: "Error del servidor!",
        icon: "error",
        draggable: true
    })
}

function renderStudents(data) {

    const listaEstudiantes = document.getElementById("listaEstudiantes");
    listaEstudiantes.innerHTML = "";

    if (data.length === 0) {
        listaEstudiantes.innerHTML = `<li class="list-group-item text-muted">Sin estudiantes</li>`;
    } else {
        data.forEach(est => {
            listaEstudiantes.innerHTML += `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    ${est.name_student}
                    <span class="badge bg-secondary">${est.code}</span>
                </li>
            `;
        });
    }
}

function renderAsesor(data) {
    const asesor = document.getElementById("det_asesor");

    asesor.innerHTML = data
        ? `<p class="mb-1 fw-semibold">${data.name}</p>
           <small class="text-muted">${data.role}</small>`
        : `<span class="text-muted">No asignado</span>`;
}

function renderCoAsesor(data) {
    const coasesor = document.getElementById("det_coasesor");
    coasesor.innerHTML = data
        ? `<p class="mb-1 fw-semibold">${data.name}</p>
           <small class="text-muted">${data.role}</small>`
        : `<span class="text-muted">No asignado</span>`;
}

function renderJurado(data) {
    const listaJurados = document.getElementById('listaJurados');
    listaJurados.innerHTML = "";

    if (data.length === 0) {
        listaJurados.innerHTML = `<li class="list-group-item text-muted">Sin jurados</li>`;
    } else {
        data.forEach(j => {
            listaJurados.innerHTML += `
                <li class="list-group-item">
                    ${j.name}
                </li>
            `;
        });
    }
}