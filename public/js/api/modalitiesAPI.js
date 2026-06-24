const ROLE_LIMITS = { asesores: 1, coasesores: 1, jurados: 2 };

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
            loadFormData();
            document.getElementById("saveModality").addEventListener("click", postModalitie);
            document.getElementById("confirmSaveModality").addEventListener("click", confirmSaveModality);
            document.getElementById("addStudentRow").addEventListener("click", () => addStudentRow());
            document.getElementById("addAsesorBtn").addEventListener("click", () => addRoleRow("asesores"));
            document.getElementById("addCoasesorBtn").addEventListener("click", () => addRoleRow("coasesores"));
            document.getElementById("addJuradoBtn").addEventListener("click", () => addRoleRow("jurados"));
        default:
            break;
    }
})

async function loadFormData() {
    try {
        const resp = await fetch("modalities/getFormData");
        const data = await resp.json();
        window.formData = data;
        populateTypeSelect(data.type_modalities);
    } catch (e) {
        console.error("Error cargando datos del formulario", e);
    }
}

function populateTypeSelect(types) {
    const sel = document.getElementById("v_tipo_modalidad");
    sel.innerHTML = '<option value="">-- Seleccione --</option>';
    types.forEach(t => {
        const opt = document.createElement("option");
        opt.value = t.id_type_mod;
        opt.textContent = t.type_name;
        sel.appendChild(opt);
    });
}

function getUniquePrograms(programs) {
    const seen = {};
    programs.forEach(p => { seen[p.program_name] = true; });
    return Object.keys(seen).sort();
}

function getSedesForProgram(programs, programName) {
    return programs
        .filter(p => p.program_name === programName)
        .map(p => p.sede)
        .sort();
}

function getProgramId(programs, programName, sede) {
    const match = programs.find(p => p.program_name === programName && p.sede === sede);
    return match ? match.program_ID : null;
}

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
    const programs = (window.formData && window.formData.programs) || [];

    document.getElementById("v_name_trabajo").value = m.nombre_trabajo || "";
    document.getElementById("v_no_acuerdo").value = m.No_acuerdo ?? "";
    document.getElementById("v_fecha_inicio").value = m.fecha_inicio_modalidad || "";
    document.getElementById("v_duracion").value = m.duracion_modalidad || "";
    document.getElementById("v_fin_estimado").value = m.fin_estimado_modalidad || "";

    const tipoSel = document.getElementById("v_tipo_modalidad");
    if (m.tipo_modalidad) {
        for (const opt of tipoSel.options) {
            if (opt.textContent === m.tipo_modalidad) {
                opt.selected = true;
                break;
            }
        }
    }

    const estadoSel = document.getElementById("v_estado");
    if (m.estado_modalidad) {
        for (const opt of estadoSel.options) {
            if (opt.value === m.estado_modalidad) {
                opt.selected = true;
                break;
            }
        }
    }

    document.getElementById("v_objetivos").value = (m.objetivos_modalidad || []).join("\n");

    const tbody = document.getElementById("v_students_tbody");
    tbody.innerHTML = "";
    (data.estudiantes || []).forEach(s => addStudentRow(s, programs));

    renderRoles("asesores", data.asesores || []);
    renderRoles("coasesores", data.coasesores || []);
    renderRoles("jurados", data.jurados || []);
}

function renderRoles(role, items) {
    const container = document.getElementById(`v_${role}_container`);
    container.innerHTML = "";
    const limit = ROLE_LIMITS[role];
    const sliced = items.slice(0, limit);
    if (sliced.length === 0) {
        sliced.push({ nombre: "" });
    }
    sliced.forEach(item => addRoleRow(role, item.nombre || ""));
    updateRoleBtn(role);
}

function updateRoleBtn(role) {
    const container = document.getElementById(`v_${role}_container`);
    const count = container.children.length;
    const btn = document.getElementById(`add${role.charAt(0).toUpperCase() + role.slice(1)}Btn`);
    const limit = ROLE_LIMITS[role];
    if (btn) {
        btn.disabled = count >= limit;
        btn.classList.toggle("disabled", count >= limit);
    }
}

function addStudentRow(data, programs) {
    programs = programs || (window.formData && window.formData.programs) || [];
    data = data || {};
    const tbody = document.getElementById("v_students_tbody");
    const row = document.createElement("tr");

    const uniquePrograms = getUniquePrograms(programs);

    const codeTd = document.createElement("td");
    codeTd.innerHTML = `<input type="text" class="form-control form-control-sm v-student-code" value="${escapeHtml(data.codigo_estudiantil || "")}">`;

    const docTd = document.createElement("td");
    docTd.innerHTML = `<input type="text" class="form-control form-control-sm v-student-doc" value="${escapeHtml(data.documento_identidad || "")}">`;

    const nameTd = document.createElement("td");
    nameTd.innerHTML = `<input type="text" class="form-control form-control-sm v-student-name" value="${escapeHtml(data.nombre || "")}">`;

    const programTd = document.createElement("td");
    const programSel = document.createElement("select");
    programSel.className = "form-select form-select-sm v-student-program";
    const blankOpt = document.createElement("option");
    blankOpt.value = "";
    blankOpt.textContent = "-- Seleccione --";
    programSel.appendChild(blankOpt);
    uniquePrograms.forEach(pn => {
        const opt = document.createElement("option");
        opt.value = pn;
        opt.textContent = pn;
        if (data.programa === pn) opt.selected = true;
        programSel.appendChild(opt);
    });
    programTd.appendChild(programSel);

    const sedeTd = document.createElement("td");
    const sedeSel = document.createElement("select");
    sedeSel.className = "form-select form-select-sm v-student-sede";
    const blankSede = document.createElement("option");
    blankSede.value = "";
    blankSede.textContent = "-- Seleccione --";
    sedeSel.appendChild(blankSede);
    if (data.programa) {
        getSedesForProgram(programs, data.programa).forEach(s => {
            const opt = document.createElement("option");
            opt.value = s;
            opt.textContent = s;
            if (data.nombre_sede === s) opt.selected = true;
            sedeSel.appendChild(opt);
        });
    }
    sedeTd.appendChild(sedeSel);

    const removeTd = document.createElement("td");
    removeTd.className = "text-center";
    removeTd.innerHTML = `<button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove()"><i class="bi bi-x"></i></button>`;

    row.append(codeTd, docTd, nameTd, programTd, sedeTd, removeTd);
    tbody.appendChild(row);

    programSel.addEventListener("change", () => onStudentProgramChange(row, programs));
    sedeSel.addEventListener("change", () => onStudentSedeChange(row, programs));
}

function onStudentProgramChange(row, programs) {
    const programSel = row.querySelector(".v-student-program");
    const sedeSel = row.querySelector(".v-student-sede");
    const programName = programSel.value;

    sedeSel.innerHTML = '<option value="">-- Seleccione --</option>';
    if (programName) {
        getSedesForProgram(programs, programName).forEach(s => {
            const opt = document.createElement("option");
            opt.value = s;
            opt.textContent = s;
            sedeSel.appendChild(opt);
        });
    }
}

function onStudentSedeChange(row, programs) {
    const programSel = row.querySelector(".v-student-program");
    const sedeSel = row.querySelector(".v-student-sede");
    const programName = programSel.value;
    const sedeName = sedeSel.value;
}

function getStudentSedeCodigo(row, programs) {
    const programName = row.querySelector(".v-student-program").value;
    const sedeName = row.querySelector(".v-student-sede").value;
    if (programName && sedeName) {
        return getProgramId(programs, programName, sedeName);
    }
    return null;
}

function addRoleRow(role, nombre) {
    nombre = nombre || "";
    const container = document.getElementById(`v_${role}_container`);
    const limit = ROLE_LIMITS[role];

    if (container.children.length >= limit) {
        return;
    }

    const div = document.createElement("div");
    div.className = "input-group input-group-sm mb-1";
    div.innerHTML = `
        <input type="text" class="form-control v-${role}-name" value="${escapeHtml(nombre)}" placeholder="Nombre">
        <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove(); updateRoleBtn('${role}')"><i class="bi bi-x"></i></button>
    `;
    container.appendChild(div);
    updateRoleBtn(role);
}

function collectVerificationData() {
    const programs = (window.formData && window.formData.programs) || [];

    const estudiantes = [];
    document.querySelectorAll("#v_students_tbody tr").forEach(row => {
        const programSel = row.querySelector(".v-student-program");
        const sedeSel = row.querySelector(".v-student-sede");
        const programName = programSel ? programSel.value : null;
        const sedeName = sedeSel ? sedeSel.value : null;

        estudiantes.push({
            codigo_estudiantil: row.querySelector(".v-student-code").value || null,
            documento_identidad: row.querySelector(".v-student-doc").value || null,
            nombre: row.querySelector(".v-student-name").value || null,
            programa: programName || null,
            nombre_sede: sedeName || null,
            sede_codigo: (programName && sedeName) ? getProgramId(programs, programName, sedeName) : null
        });
    });

    const objetivosText = document.getElementById("v_objetivos").value;
    const objetivos = objetivosText
        .split("\n")
        .map(l => l.trim())
        .filter(l => l.length > 0);

    const tipoSel = document.getElementById("v_tipo_modalidad");
    const tipoText = tipoSel.options[tipoSel.selectedIndex] ? tipoSel.options[tipoSel.selectedIndex].text : "";
    const tipoValue = tipoSel.value;

    return {
        estudiantes: estudiantes,
        asesores: collectRoleNames("asesores"),
        coasesores: collectRoleNames("coasesores"),
        jurados: collectRoleNames("jurados"),
        modalidad: {
            No_acuerdo: document.getElementById("v_no_acuerdo").value || null,
            nombre_trabajo: document.getElementById("v_name_trabajo").value || null,
            tipo_modalidad: (tipoValue && tipoText !== "-- Seleccione --") ? tipoText : null,
            id_modalidad: tipoValue || null,
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