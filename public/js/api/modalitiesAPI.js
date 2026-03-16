document.addEventListener("DOMContentLoaded", () => {
    const button = document.getElementById("saveModality");
    button.addEventListener("click", postModalitie);
});

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
            `modalities/getmodality/?id=${id}`,
            {
                method : 'GET',
                headers: {
                    "Content-Type": "application/json"
                }
            }
        )

        if (!response.ok) {
            serverError() 
            return;
        }
        else
        {
            
            const result = await response.json();
            const mod = result.data;
            console.log(mod)

            // Datos básicos
            document.getElementById('det_titulo').innerText = mod.titulo;
            document.getElementById('det_tipo').innerText = mod.tipo_modalidad;
            document.getElementById('det_inicio').innerText = mod.fecha_inicio;
            document.getElementById('det_fin').innerText = mod.fecha_fin;
            document.getElementById('det_duracion').innerText = mod.duracion;

            // Objetivos (Suponiendo que vienen en el JSON)
            document.getElementById('det_obj_general').innerText = mod.objetivo_general || 'Sin descripción';
            document.getElementById('det_obj_especificos').innerHTML = mod.objetivos_especificos || 'Sin objetivos definidos';

            // Estado con clase dinámica
            const estadoElt = document.getElementById('det_estado');
            estadoElt.innerHTML = `<span class="badge ${mod.estado === 'En curso' ? 'bg-success' : 'bg-secondary'} p-2">${mod.estado}</span>`;
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