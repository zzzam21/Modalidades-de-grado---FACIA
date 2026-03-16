$(document).ready(function () {
    configureDataTableTypes();
    
    $('#modalityTable').DataTable( {
        ...dataTableConfig,
        columnDefs: [
            {
                targets: 1,
                width: "230px",
                className: "text-truncate-modal"
            }
        ],
        ajax : {
            url: 'modalities/getmodalities',
            dataSrc: ''
        },
        columns: [
            { data: "modality_ID" },
            {
                data: "name_modalitie",
                render: function(data) {
                    return `
                        <span class="text-truncate-modal"
                            data-bs-toggle="popoverDataTable"
                            data-bs-placement="left"
                            data-bs-trigger="hover focus"
                            data-bs-content="${data}">
                            ${data}
                        </span>
                    `;
                }
            },
            { data: "type_modality" },
            {
                data: "status",
                render: function(data, type) {
                    // Si DataTables está pidiendo el dato para mostrar en pantalla (display)
                    if (type === 'display') {
                        // Diccionario de clases
                        const statusClases = {
                            'aprobada': 'badge-aprobado',
                            'En curso': 'badge-en-curso',
                            'Cancelado': 'badge-cancelado',
                            'Finalizado': 'badge-finalizado'
                        };

                        // Obtenemos la clase o usamos la por defecto
                        const claseCss = statusClases[data] || 'badge-default';
                        
                        // Retornamos el span con la clase dinámica
                        return `<span class="badge-custom ${claseCss}">${data}</span>`;
                    }
                    // Si es para ordenamiento o búsqueda (filter/sort), retornamos el texto puro
                    return data;
                }
            },
            { data: "date_approved" },
            { data: "duration" },
            { data: "date_end" },
            {
                data: "modality_ID",
                render: function(data) {
                    return `<a href="./modalities/modality/${data}" id="idGetModality" class="btn btn-sm btn-success">
                                <i class="bi bi-eye"></i>
                            </a>`;
                }
            }
            // onclick="getModality(${data})"
        ],
        drawCallback: function() {
            initPopovers();
        }
    });

    $('#otherTables').DataTable();
})