$(document).ready(function () {
    configureDataTableTypes();

    $.ajax({
        url: 'alerts/getAlertas',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            const vencidas = response.vencidas || [];
            const proximas = response.proximas || [];

            $('#countVencidas').text(vencidas.length);
            $('#countProximas').text(proximas.length);

            if (vencidas.length === 0 && proximas.length === 0) {
                $('#emptyState').removeClass('d-none');
                $('#vencidasSection').addClass('d-none');
                $('#proximasSection').addClass('d-none');
                return;
            }

            if (vencidas.length > 0) {
                initVencidasTable(vencidas);
            } else {
                $('#vencidasSection').addClass('d-none');
            }

            if (proximas.length > 0) {
                initProximasTable(proximas);
            } else {
                $('#proximasSection').addClass('d-none');
            }
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudieron cargar las alertas.',
                confirmButtonColor: '#dc3545'
            });
        }
    });

    function initVencidasTable(data) {
        $('#vencidasTable').DataTable({
            ...dataTableConfig,
            autoWidth: false,
            data: data,
            columns: [
                { data: "modality_ID" },
                {
                    data: "name_modalitie",
                    render: function (data) {
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
                { data: "program_name" },
                {
                    data: null,
                    render: function (data) {
                        return data.date_sustentacion
                            ? data.date_sustentacion.substring(0, 10)
                            : data.date_end;
                    }
                },
                {
                    data: "status",
                    render: function (data, type) {
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
                    }
                },
                {
                    data: "dias_retraso",
                    render: function (data) {
                        return `<span class="fw-bold text-danger">${data} días</span>`;
                    }
                },
                {
                    data: "modality_ID",
                    orderable: false,
                    render: function (data) {
                        return `
                            <a href="./modalities/modality/${data}"
                               class="btn btn-sm btn-outline-secondary">
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
    }

    function initProximasTable(data) {
        $('#proximasTable').DataTable({
            ...dataTableConfig,
            autoWidth: false,
            data: data,
            columns: [
                { data: "modality_ID" },
                {
                    data: "name_modalitie",
                    render: function (data) {
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
                { data: "program_name" },
                {
                    data: null,
                    render: function (data) {
                        return data.date_sustentacion
                            ? data.date_sustentacion.substring(0, 10)
                            : data.date_end;
                    }
                },
                {
                    data: "status",
                    render: function (data, type) {
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
                    }
                },
                {
                    data: "dias_restantes",
                    render: function (data) {
                        return `<span class="fw-bold text-warning">${data} días</span>`;
                    }
                },
                {
                    data: "modality_ID",
                    orderable: false,
                    render: function (data) {
                        return `
                            <a href="./modalities/modality/${data}"
                               class="btn btn-sm btn-outline-secondary">
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
    }
});
