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

    
    console.log(formData);
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