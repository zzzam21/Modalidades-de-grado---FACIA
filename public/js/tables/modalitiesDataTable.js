$(document).ready(function () {
    configureDataTableTypes();

    $('#modalityTable').DataTable({
        ...dataTableConfig,
        responsive: {
            details: {
                type: 'column',
                target: 0
            }
        }, 
        autoWidth: false,
        columnDefs: [
            {
                className: 'dtr-control',
                orderable: false,
                targets: 0
            },
            {
                targets: 2,
                className: "text-truncate-modal"
            },
        ],

        ajax: {
            url: 'modalities/getmodalities',
            dataSrc: ''
        },

        columns: [
            { data: null, defaultContent: '' },
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
                    if (type === 'display') {
                        const statusClases = {
                            'aprobada': 'badge-aprobado',
                            'En curso': 'badge-en-curso',
                            'Cancelado': 'badge-cancelado',
                            'Finalizado': 'badge-finalizado'
                        };

                        const claseCss = statusClases[data] || 'badge-default';

                        return `<span class="badge-custom ${claseCss}">${data}</span>`;
                    }
                    return data;
                },
                className: 'string'
            },

            { data: "date_approved" },
            { data: "duration" },
            { data: "date_end" },

            {
                data: "modality_ID",
                orderable: false,
                render: function(data) {
                    return `
                        <a href="./modalities/modality/${data}"
                           class="btn btn-sm btn-success">
                            <i class="bi bi-eye"></i>
                        </a>
                    `;
                }
            }
        ],

        drawCallback: function () {
            initPopovers();
        }
    });

});