document.addEventListener("DOMContentLoaded", () => {

    const button = document.getElementById("saveModality");

    button.addEventListener("click", postModalitie);

});

async function postModalitie() {

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

            alert(saveResult.message);

            $('#modalityTable').DataTable().ajax.reload();

        } else {
            alert("Error procesando PDF");
        }

    } catch (error) {

        console.error(error);
        alert("Error del servidor");

    }

}