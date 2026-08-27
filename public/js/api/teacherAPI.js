document.addEventListener("DOMContentLoaded", () => {
    const app = document.getElementById("app");
    const view = app.dataset.view;

    switch(view){
        case "teacher-detail":
            const teacherId = document.getElementById("teacherId");
            getTeacher(teacherId.value);
            break;
        case "teachers":
            document.getElementById("editTeacherModal").addEventListener("show.bs.modal", (e) => {
                const btn = e.relatedTarget;
                document.getElementById("editTeacherId").value = btn.dataset.id;
                document.getElementById("editTeacherName").value = btn.dataset.name;
            });

            document.getElementById("saveTeacher").addEventListener("click", saveTeacher);
            break;
        default:
            break;
    }
})

async function getTeacher(id) {
    const res = await fetch(`../getteacher/${id}`,
        {
            method : 'GET',
            headers: {
                "Content-Type": "application/json"
            }
        }
    );
    const data = await res.json();
    
    document.getElementById("kpi_asesor").innerText = data.asesor;
    document.getElementById("kpi_coasesor").innerText = data.coasesor;
    document.getElementById("kpi_jurado").innerText = data.jurado;

    document.getElementById("kpi_proceso").innerText = data.proceso;
    document.getElementById("kpi_finalizadas").innerText = data.finalizadas;

    document.getElementById("nombre-docente").innerHTML = data.teacher.name;
    
}

async function saveTeacher() {
    const id = document.getElementById("editTeacherId").value;
    const name = document.getElementById("editTeacherName").value;

    const response = await fetch(`./teachers/updateTeacher/${id}`, {
        method: 'PUT',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            name: name
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

    $('#editTeacherModal').modal("hide");
    Swal.fire({
        title: data.message,
        icon: 'success',
        draggable: true
    });

    $('#teachersTables').DataTable().ajax.reload();
}