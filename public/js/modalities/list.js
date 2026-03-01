document.addEventListener('DOMContentLoaded', () => {
    loadModalities();
});

function loadModalities() {
    fetch(BASE_URL + '/modalities/list')
        .then(response => response.json())
        .then(data => {
            let tbody = document.querySelector("#modalityTable tbody");
            tbody.innerHTML = "";
            
            data.forEach(mod => {
                tbody.innerHTML += `
                    <tr>
                        <td>${mod.modality_ID}</td> 
                        <td>${mod.name_modalitie}</td>
                        <td>${mod.type_modality}</td>
                        <td>${mod.status}</td>
                        <td>${mod.date_approved}</td>
                        <td>${mod.duration}</td>
                        <td>${mod.date_end}</td>
                    </tr>
                `;
            });
        })
        .catch(error => {
            console.error('Error loading modalities:', error);
        });
}