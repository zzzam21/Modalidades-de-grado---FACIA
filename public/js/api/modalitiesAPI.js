const ROLE_LIMITS = { asesores: 1, coasesores: 1, jurados: 2 };
const SUSTENTACION_STATES = ['aprobada', 'En curso'];
let editingModalityId = null;
let currentModalityStatus = null;

document.addEventListener("DOMContentLoaded", () => {
    const app = document.getElementById("app");
    const view = app.dataset.view;

    switch (view) {
        case "modality-detail":
            const modalityId = document.getElementById("modalityId")
            if (modalityId.value) {
                getModality(modalityId.value);
            }
            wireVerifyModalControls();
            document.getElementById("editModalityBtn").addEventListener("click", () => openEditModality(modalityId.value));
            document.getElementById("setSustentacionBtn").addEventListener("click", openSustentacionModal);
            document.getElementById("saveSustentacionBtn").addEventListener("click", saveSustentacion);
            break;
        case "modalities":
            loadFormData();
            document.getElementById("saveModality").addEventListener("click", postModalitie);
            document.getElementById("addModalityManual").addEventListener("click", openManualModality);
            wireVerifyModalControls();
        default:
            break;
    }
})

function wireVerifyModalControls() {
    document.getElementById("confirmSaveModality").addEventListener("click", confirmSaveModality);
    document.getElementById("addStudentRow").addEventListener("click", () => addStudentRow());
    document.getElementById("addAsesorBtn").addEventListener("click", () => addRoleRow("asesores"));
    document.getElementById("addCoasesorBtn").addEventListener("click", () => addRoleRow("coasesores"));
    document.getElementById("addJuradoBtn").addEventListener("click", () => addRoleRow("jurados"));
}

function getApiUrl(path) {
    const parts = window.location.pathname.split('/').filter(Boolean);
    const idx = parts.indexOf('modalities');
    const base = parts.slice(0, idx + 1).join('/');
    return `${window.location.origin}/${base}/${path}`;
}

async function loadFormData() {
    try {
        const resp = await fetch(getApiUrl("getFormData"));
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

function normalizeStr(str) {
    if (!str) return '';
    return str.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "").trim();
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
            editingModalityId = null;
            setNoAcuerdoEditable(true);
            setVerifyModalTitle('pdf');
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

function setVerifyModalTitle(mode) {
    const title = document.getElementById("verifyModalTitle");
    const alert = document.getElementById("verifyInfoAlert");
    if (mode === 'manual') {
        title.textContent = "Agregar Modalidad Manualmente";
        if (alert) alert.classList.add("d-none");
    } else if (mode === 'edit') {
        title.textContent = "Editar Modalidad";
        if (alert) alert.classList.add("d-none");
    } else {
        title.textContent = "Verificar Datos Extraídos";
        if (alert) alert.classList.remove("d-none");
    }
}

function setNoAcuerdoEditable(editable) {
    const input = document.getElementById("v_no_acuerdo");
    if (editable) {
        input.removeAttribute("disabled");
    } else {
        input.setAttribute("disabled", "disabled");
    }
}

async function openManualModality() {
    if (!window.formData) {
        await loadFormData();
    }

    editingModalityId = null;

    document.getElementById("v_name_trabajo").value = "";
    document.getElementById("v_no_acuerdo").value = "";
    document.getElementById("v_fecha_inicio").value = "";
    document.getElementById("v_duracion").value = "";
    document.getElementById("v_fin_estimado").value = "";
    document.getElementById("v_tipo_modalidad").value = "";
    document.getElementById("v_estado").value = "";
    document.getElementById("v_objetivos").value = "";

    const tbody = document.getElementById("v_students_tbody");
    tbody.innerHTML = "";
    addStudentRow({}, (window.formData && window.formData.programs) || []);

    renderRoles("asesores", []);
    renderRoles("coasesores", []);
    renderRoles("jurados", []);

    setNoAcuerdoEditable(true);
    setVerifyModalTitle('manual');
    $("#verifyModal").modal("show");
}

async function openEditModality(id) {
    if (!window.formData) {
        await loadFormData();
    }

    try {
        const response = await fetch(`../getmodality/${id}`);
        if (!response.ok) {
            throw new Error('Error al cargar la modalidad');
        }
        const result = await response.json();
        const mod = result.data;
        const programs = (window.formData && window.formData.programs) || [];

        const estudiantes = (result.student || []).map(s => {
            const prog = programs.find(p => p.program_ID == s.program_ID) || null;
            return {
                codigo_estudiantil: s.code || "",
                documento_identidad: s.student_ID || "",
                nombre: s.name_student || "",
                programa: prog ? prog.program_name : "",
                nombre_sede: prog ? prog.sede : ""
            };
        });

        let objetivos = [];
        try {
            objetivos = JSON.parse(mod.goal) || [];
        } catch (e) {
            objetivos = [];
        }

        const mapped = {
            estudiantes: estudiantes,
            asesores: result.asesor ? [{ nombre: result.asesor.name }] : [],
            coasesores: result.coasesor ? [{ nombre: result.coasesor.name }] : [],
            jurados: (result.jurado || []).map(j => ({ nombre: j.name })),
            modalidad: {
                No_acuerdo: mod.modality_ID,
                nombre_trabajo: mod.name_modalitie,
                tipo_modalidad: mod.type_modality,
                id_modalidad: mod.id_type_mod,
                estado_modalidad: mod.status,
                fecha_inicio_modalidad: mod.date_approved,
                objetivos_modalidad: objetivos,
                duracion_modalidad: mod.duration,
                fin_estimado_modalidad: mod.date_end
            }
        };

        editingModalityId = id;
        setNoAcuerdoEditable(false);
        setVerifyModalTitle('edit');
        populateVerificationModal(mapped);
        $("#verifyModal").modal("show");
    } catch (e) {
        console.error("Error al abrir edición:", e);
        Swal.fire({
            title: "Error al cargar la modalidad",
            icon: "error"
        });
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
        if (data.programa && normalizeStr(data.programa) === normalizeStr(pn)) opt.selected = true;
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
        const match = programs.find(p => normalizeStr(p.program_name) === normalizeStr(data.programa));
        if (match) {
            programs.filter(p => p.program_name === match.program_name).map(p => p.sede).sort()
                .forEach(s => {
                    const opt = document.createElement("option");
                    opt.value = s;
                    opt.textContent = s;
                    if (data.nombre_sede && normalizeStr(data.nombre_sede) === normalizeStr(s)) opt.selected = true;
                    sedeSel.appendChild(opt);
                });
        }
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
        const errors = [];

        if (!data.modalidad.nombre_trabajo) errors.push("- Nombre del trabajo");
        if (!data.modalidad.id_modalidad) errors.push("- Tipo de modalidad");
        if (!data.modalidad.No_acuerdo) errors.push("- No. Acuerdo");
        if (!data.modalidad.estado_modalidad) errors.push("- Estado");

        if (!data.estudiantes || data.estudiantes.length === 0) {
            errors.push("- Debe haber al menos un estudiante");
        } else {
            data.estudiantes.forEach((s, i) => {
                if (!s.codigo_estudiantil) errors.push("- Est. #" + (i+1) + ": c\u00f3digo");
                if (!s.documento_identidad) errors.push("- Est. #" + (i+1) + ": documento");
                if (!s.nombre) errors.push("- Est. #" + (i+1) + ": nombre");
                if (!s.sede_codigo) errors.push("- Est. #" + (i+1) + ": programa/sede");
            });
        }

        if (errors.length) {
            spinner.classList.add('d-none');
            Swal.fire({
                title: "Campos requeridos",
                html: errors.join("<br>"),
                icon: "warning",
                confirmButtonText: "Aceptar"
            });
            return;
        }

        const isEdit = editingModalityId !== null;
        const url = isEdit ? `../updateModality/${editingModalityId}` : "modalities/process";

        const response = await fetch(url, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        });

        const result = await response.json();
        $("#verifyModal").modal("hide");
        spinner.classList.add('d-none');

        if (result.success) {
            if (isEdit) {
                Swal.fire({
                    title: "Modalidad Actualizada Correctamente!",
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                editingModalityId = null;
                getModality($('#modalityId').val());
            } else {
                Swal.fire({
                    title: "Modalidad Agregada Correctamente!",
                    icon: "success",
                    draggable: true
                });
                $('#modalityTable').DataTable().ajax.reload();
            }
        } else {
            Swal.fire({
                title: isEdit ? "Error actualizando modalidad!" : "Error agregando modalidad!",
                text: result.message || undefined,
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

function formatSustentacion(value) {
    if (!value) return "--";
    let date, time = "";
    if (value.includes(" ")) {
        [date, time] = value.split(" ");
    } else if (value.includes("T")) {
        [date, time] = value.split("T");
    } else {
        date = value;
    }
    const parts = date.split("-");
    const formatted = `${parts[2]}/${parts[1]}/${parts[0]}`;
    return time ? `${formatted} ${time.slice(0, 5)}` : formatted;
}

function toDatetimeLocal(value) {
    if (!value) return "";
    return value.includes("T") ? value.slice(0, 16) : value.replace(" ", "T").slice(0, 16);
}

function toggleEditButton(status) {
    const btn = document.getElementById('editModalityBtn');
    if (btn) btn.classList.toggle('d-none', status === 'Cancelado');
}

const STATUS_SELECT_CLASSES = {
    'aprobada': 'status-select-aprobado',
    'En curso': 'status-select-en-curso',
    'Cancelado': 'status-select-cancelado',
    'Finalizado': 'status-select-finalizado'
};

function applyStatusSelectStyle(select, status) {
    Object.values(STATUS_SELECT_CLASSES).forEach(cls => select.classList.remove(cls));
    const cls = STATUS_SELECT_CLASSES[status];
    if (cls) select.classList.add(cls);
}

function refreshSustentacionControls(status, dateValue) {
    const value = dateValue || "";
    document.getElementById("det_sustentacion").innerText = formatSustentacion(value);
    document.getElementById("det_sustentacion").dataset.value = value;
    document.getElementById("setSustentacionBtn").classList.toggle("d-none", !SUSTENTACION_STATES.includes(status));
}

function openSustentacionModal() {
    const current = document.getElementById("det_sustentacion").dataset.value || "";
    document.getElementById("v_fecha_sustentacion").value = toDatetimeLocal(current);
    $("#sustentacionModal").modal("show");
}

async function saveSustentacion() {
    const modalityId = document.getElementById("modalityId").value;
    const date = document.getElementById("v_fecha_sustentacion").value;
    const todayDate = new Date().toISOString().split("T")[0];
    if (date && date.split("T")[0] < todayDate) {
        Swal.fire({
            title: 'Fecha inválida',
            text: 'La fecha de sustentación no puede ser anterior a la fecha actual.',
            icon: 'warning'
        });
        return;
    }

    const btn = document.getElementById("saveSustentacionBtn");
    const spinner = document.getElementById("loadingSustentacion");
    btn.disabled = true;
    spinner.classList.remove("d-none");
    try {
        const resp = await fetch(`../updateSustentacion/${modalityId}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ date_sustentacion: date })
        });
        const result = await resp.json();
        if (!resp.ok || !result.success) {
            throw new Error(result.message || 'Error al guardar');
        }
        refreshSustentacionControls(currentModalityStatus, date);
        $("#sustentacionModal").modal("hide");
        Swal.fire({
            title: 'Fecha de sustentación guardada',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
        });
    } catch (e) {
        Swal.fire({
            title: 'Error al guardar',
            text: e.message,
            icon: 'error'
        });
    } finally {
        btn.disabled = false;
        spinner.classList.add("d-none");
    }
}

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

            currentModalityStatus = mod.status;
            refreshSustentacionControls(mod.status, mod.date_sustentacion);

            const objetivos = JSON.parse(mod.goal);
            document.getElementById("listaObjetivos").innerHTML =
                objetivos.map(o => `<li class="list-group-item">${o}</li>`).join("");

            const statusClasses = {
                'aprobada': 'badge-aprobado',
                'En curso': 'badge-en-curso',
                'Cancelado': 'badge-cancelado',
                'Finalizado': 'badge-finalizado'
            };

            const statusLabels = {
                'aprobada': 'Aprobada',
                'En curso': 'En curso',
                'Cancelado': 'Cancelado',
                'Finalizado': 'Finalizado'
            };

            const estadoElt = document.getElementById('det_estado');
            const originalStatus = mod.status;

            estadoElt.innerHTML = '';
            const statusSelect = document.createElement('select');
            statusSelect.className = 'form-select form-select-sm w-auto fw-semibold';
            Object.keys(statusClasses).forEach(val => {
                const opt = document.createElement('option');
                opt.value = val;
                opt.textContent = statusLabels[val] || val;
                if (val === originalStatus) opt.selected = true;
                statusSelect.appendChild(opt);
            });
            estadoElt.appendChild(statusSelect);
            applyStatusSelectStyle(statusSelect, originalStatus);

            toggleEditButton(originalStatus);

            statusSelect.addEventListener('change', () => {
                const newStatus = statusSelect.value;
                applyStatusSelectStyle(statusSelect, newStatus);

                if (newStatus === 'Finalizado') {
                    const sustentacion = mod.date_sustentacion;
                    if (!sustentacion) {
                        statusSelect.value = originalStatus;
                        applyStatusSelectStyle(statusSelect, originalStatus);
                        Swal.fire({
                            title: 'No es posible finalizar',
                            text: 'Debe registrar una fecha de sustentación antes de finalizar.',
                            icon: 'warning'
                        });
                        return;
                    }
                    const hoy = new Date();
                    hoy.setHours(0, 0, 0, 0);
                    const fechaSust = new Date(sustentacion.substring(0, 10) + 'T00:00:00');
                    if (fechaSust > hoy) {
                        statusSelect.value = originalStatus;
                        applyStatusSelectStyle(statusSelect, originalStatus);
                        Swal.fire({
                            title: 'No es posible finalizar',
                            text: 'La fecha de sustentación aún no ha pasado.',
                            icon: 'warning'
                        });
                        return;
                    }
                }

                const isCancel = newStatus === 'Cancelado';

                Swal.fire({
                    title: isCancel ? '¿Cancelar modalidad?' : '¿Cambiar estado?',
                    html: isCancel
                        ? 'Una vez cancelada, <b>no podrá realizar modificaciones</b> a esta modalidad. Solo podrá eliminarla.'
                        : `Se actualizará el estado a "<b>${statusLabels[newStatus] || newStatus}</b>".`,
                    icon: isCancel ? 'warning' : 'question',
                    showCancelButton: true,
                    confirmButtonText: isCancel ? 'Sí, cancelar' : 'Sí, cambiar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: isCancel ? '#dc3545' : undefined
                }).then(async (res) => {
                    if (!res.isConfirmed) {
                        statusSelect.value = originalStatus;
                        return;
                    }
                    try {
                        const resp = await fetch(`../updateStatus/${mod.modality_ID}`, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ status: newStatus })
                        });
                        const result = await resp.json();
                        if (!resp.ok || !result.success) {
                            throw new Error(result.message || 'Error al actualizar');
                        }
                        Swal.fire({
                            title: 'Estado actualizado',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        currentModalityStatus = newStatus;
                        refreshSustentacionControls(newStatus, document.getElementById("det_sustentacion").dataset.value || "");
                        toggleEditButton(newStatus);
                    } catch (e) {
                        statusSelect.value = originalStatus;
                        Swal.fire({
                            title: 'Error al actualizar',
                            text: e.message,
                            icon: 'error'
                        });
                    }
                });
            });
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
                    <a href="../../students/student/${est.student_ID}" class="text-decoration-none">${est.name_student}</a>
                    <span class="badge bg-secondary">${est.code}</span>
                </li>
            `;
        });
    }
}

function renderAsesor(data) {
    const asesor = document.getElementById("det_asesor");

    asesor.innerHTML = data
        ? `<p class="mb-1"><a href="../../teachers/teacher/${data.teacher_ID}" class="text-decoration-none fw-semibold">${data.name}</a></p>
           <small class="text-muted">${data.role}</small>`
        : `<span class="text-muted">No asignado</span>`;
}

function renderCoAsesor(data) {
    const coasesor = document.getElementById("det_coasesor");
    coasesor.innerHTML = data
        ? `<p class="mb-1"><a href="../../teachers/teacher/${data.teacher_ID}" class="text-decoration-none fw-semibold">${data.name}</a></p>
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
                    <a href="../../teachers/teacher/${j.teacher_ID}" class="text-decoration-none">${j.name}</a>
                </li>
            `;
        });
    }
}