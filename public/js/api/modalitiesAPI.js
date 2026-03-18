document.addEventListener("DOMContentLoaded", () => {
    const path = window.location.pathname;

    if (path.includes('addmodalitie')){
        const button = document.getElementById("saveModality");
        button.addEventListener("click", postModalitie);
    }
});

document.addEventListener("DOMContentLoaded", () => {
    const app = document.getElementById("app");
    const view = app.dataset.view;

    switch(view){
        case "modality-detail":
                const modalityId = document.getElementById("modalityId")
                if (modalityId.value) {
                    getModality(modalityId.value);
                }
            break;
    }
})

async function postModalitie() {

    const spinner = document.getElementById("loadingModality");
    spinner.classList.remove('d-none');

    const file = document.getElementById("formFile");
    const formData = new FormData();
    formData.append("formFile",file.files[0]);

    try {
        const response = await fetch("modalities/add", {
            method: "POST",
            body: formData
        });

        const result = await response.json();

        if (result.success) {

            const save = await fetch("modalities/process", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(result.data)
            });

            const saveResult = await save.json();
            $("#addmodalitie").modal("hide");
            spinner.classList.add('d-none');

            if (saveResult.success) {    
                Swal.fire({
                    title: "Modalidad Agregada Correctamente!",
                    icon: "success",
                    draggable: true
                });

                $('#modalityTable').DataTable().ajax.reload();
            }else{
                Swal.fire({
                    title: "Error agregando modalidad!",
                    icon: "error",
                    draggable: true
                });
            }
            
        } else {
            $("#addmodalitie").modal("hide");
            spinner.classList.add('d-none');
            Swal.fire({
                title: "Error Procesando PDF!",
                icon: "error",
                draggable: true
            });
        }
    } catch (error) {
        $("#addmodalitie").modal("hide");
        spinner.classList.add('d-none');
        console.error(error);
        Swal.fire({
            title: "Error del Servidor!",
            icon: "error",
            draggable: true
        });
    }
}

async function getModality(id) {
    try {

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
            renderParticipantes(result.estudiante);
            console.log(result)
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

function renderParticipantes(data) {
    // ===== ESTUDIANTES =====
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

    // // ===== ASESOR =====
    // const asesor = document.getElementById("det_asesor");
    // asesor.innerHTML = data.asesor 
    //     ? `<p class="mb-1 fw-semibold">${data.asesor.nombre}</p>
    //        <small class="text-muted">${data.asesor.area}</small>`
    //     : `<span class="text-muted">No asignado</span>`;

    // // ===== COASESOR =====
    // const coasesor = document.getElementById("det_coasesor");
    // coasesor.innerHTML = data.coasesor 
    //     ? `<p class="mb-1 fw-semibold">${data.coasesor.nombre}</p>
    //        <small class="text-muted">${data.coasesor.area}</small>`
    //     : `<span class="text-muted">No asignado</span>`;

    // // ===== JURADOS =====
    // const listaJurados = document.getElementById("listaJurados");
    // listaJurados.innerHTML = "";

    // if (data.jurados.length === 0) {
    //     listaJurados.innerHTML = `<li class="list-group-item text-muted">Sin jurados</li>`;
    // } else {
    //     data.jurados.forEach(j => {
    //         listaJurados.innerHTML += `
    //             <li class="list-group-item">
    //                 ${j.nombre}
    //             </li>
    //         `;
    //     });
    // }
}