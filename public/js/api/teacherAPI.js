document.addEventListener("DOMContentLoaded", () => {
    const app = document.getElementById("app");
    const view = app.dataset.view;

    switch(view){
        case "teacher-detail":
            const teacherId = document.getElementById("teacherId");
            getTeacher(teacherId.value);
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