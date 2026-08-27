$(document).ready(function () {
    configureDataTableTypes();

    $('#modalityTable').DataTable({
        ...dataTableConfig,
        autoWidth: false,
        columnDefs: [
            {
                targets: 1,
                className: "text-truncate-modal"
            },
        ],

        ajax: {
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
            { data: "date_end" },
            { data: "duration", render: function(data, type, row) {
                if (type === 'display') {
                    const remmaining_days = row.date_end ? Math.ceil((new Date(row.date_end) - new Date()) / (1000 * 60 * 60 * 24)) : null;
                    if (remmaining_days !== null && remmaining_days < 0) {
                        return ` Finalizó hace ${Math.abs(remmaining_days)} días`;
                    }
                    return ` Faltan ${remmaining_days} días`;
                }   
                return data;
            } },
            
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