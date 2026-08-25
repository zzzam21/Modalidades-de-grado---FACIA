document.addEventListener("DOMContentLoaded", () => {
    const app = document.getElementById("app");
    const view = app.dataset.view;

    switch(view){
        case "student-detail":
                const studentId = document.getElementById("studentId")
                if (studentId.value) {
                    loadStudentData(studentId.value);
                }
            break;
        case "students":
            document.getElementById("editStudentModal").addEventListener("show.bs.modal", (e) => {
                const btn = e.relatedTarget;
                document.getElementById("editStudentId").value = btn.dataset.id;
                document.getElementById("editStudentName").value = btn.dataset.name;
                document.getElementById("editStudentCode").value = btn.dataset.code;
            });

            document.getElementById("saveStudent").addEventListener("click", saveStudent);
            break;
        default:
            break;
    }
})

async function saveStudent() {
    const id = document.getElementById("editStudentId").value;
    const nameStudent = document.getElementById("editStudentName").value;
    const code = document.getElementById("editStudentCode").value;

    const response = await fetch(`./students/updateStudent/${id}`, {
        method: 'PUT',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            name_student: nameStudent,
            code: code
        })
    });

    const data = await response.json();

    if (!response.ok) {
        Swal.fire({
            title: data.message,
            icon: 'error',
            draggable: true
        });
        return;
    }

    $('#editStudentModal').modal("hide");
    Swal.fire({
        title: data.message,
        icon: 'success',
        draggable: true
    });

    $('#studentTables').DataTable().ajax.reload();
}


async function loadStudentData(id) {
    
    const res = await fetch(`../getstudent/${id}`,
        {
            method : 'GET',
            headers: {
                "Content-Type": "application/json"
            }
        }
    );
    const data = await res.json();
    
    const est = data.student;
    const mod = data.modality;
    console.log(mod);

    // Estudiante
    document.getElementById("est_nombre").textContent = est.name_student;
    document.getElementById("est_codigo").textContent = est.code;
    
    // Modalidad
    document.getElementById("mod_titulo").textContent = mod[0].name_modalitie;
    document.getElementById("mod_inicio").textContent = mod[0].date_approved;
    document.getElementById("mod_duracion").textContent = mod[0].duration;
    document.getElementById("mod-type").textContent = mod[0].type_modality;

    for (let i = 0; i < mod.length; i++) {
        if (mod[i].role === "Asesor") {
            document.getElementById("mod_asesor").textContent = mod[i].name ?? "No asignado";
        }else if (mod[i].role === "Coasesor") {
            document.getElementById("mod_coasesor").textContent = mod[i].name ?? "No asignado";
        }
    }
    // Estado
    const statusClasses = {
        'aprobada': 'badge-aprobado',
        'En curso': 'badge-en-curso',
        'Cancelado': 'badge-cancelado',
        'Finalizado': 'badge-finalizado'
    };

    const estadoBadge = document.getElementById("badge-custom");
    estadoBadge.textContent = mod[0].status;
    estadoBadge.innerHTML = `<span class="badge-custom ${statusClasses[mod[0].status] || "bg-secondary"} p-2">${mod[0].status}</span>`;

    document.getElementById("btn_ver_modalidad").href = `../../modalities/modality/${mod[0].modality_ID}`;
}