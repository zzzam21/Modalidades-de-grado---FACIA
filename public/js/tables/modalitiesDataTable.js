$(document).ready(function () {
    configureDataTableTypes();
    
    $('#modalityTable').DataTable( {
        ...dataTableConfig,
        'pagingType': 'full_numbers', 
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
            { data: "status" },
            { data: "date_approved" },
            { data: "duration" },
            { data: "date_end" },
            {
                data: null,
                render: function() {
                    return `<button class="btn btn-sm btn-success">
                                <i class="bi bi-eye"></i>
                            </button>`;
                }
            }
        ],
        drawCallback: function() {
            initPopovers();
        }
    });

    $('#otherTables').DataTable( {
        scrollX: true,
        language: {
            "paginate": {
                "first": "<<",
                "last": ">>",
                "next": ">",
                "previous": "<"
            },
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
        }
    });
})