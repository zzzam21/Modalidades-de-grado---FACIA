document.addEventListener('DOMContentLoaded', function () {
    const app = document.getElementById('app');
    if (!app || app.dataset.view !== 'alerts') return;

    configureDataTableTypes();

    fetch('alerts/getAlertas')
        .then(function (response) {
            if (!response.ok) throw new Error('Error de red');
            return response.json();
        })
        .then(function (response) {
            const vencidas = response.vencidas || [];
            const proximas = response.proximas || [];

            document.getElementById('countVencidas').textContent = vencidas.length;
            document.getElementById('countProximas').textContent = proximas.length;

            if (vencidas.length === 0 && proximas.length === 0) {
                document.getElementById('emptyState').classList.remove('d-none');
                document.getElementById('vencidasSection').classList.add('d-none');
                document.getElementById('proximasSection').classList.add('d-none');
                return;
            }

            if (vencidas.length > 0) {
                initVencidasTable(vencidas);
            } else {
                document.getElementById('vencidasSection').classList.add('d-none');
            }

            if (proximas.length > 0) {
                initProximasTable(proximas);
            } else {
                document.getElementById('proximasSection').classList.add('d-none');
            }
        })
        .catch(function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudieron cargar las alertas.',
                confirmButtonColor: '#dc2626'
            });
        });

    function initVencidasTable(data) {
        $('#vencidasTable').DataTable({
            ...dataTableConfig,
            autoWidth: false,
            data: data,
            columnDefs: [
                {
                    targets: 1,
                    className: "text-truncate-modal"
                },
            ],
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
                            return '<span class="badge-custom ' + claseCss + '">' + data + '</span>';
                        }
                        return data;
                    }
                },
                {
                    data: "dias_retraso",
                    render: function (data) {
                        return '<span class="fw-bold text-danger">' + data + ' días</span>';
                    }
                },
                {
                    data: "modality_ID",
                    orderable: false,
                    render: function (data) {
                        return '<a href="./modalities/modality/' + data + '" class="btn btn-sm btn-success"><i class="bi bi-eye"></i></a>';
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
            columnDefs: [
                {
                    targets: 1,
                    className: "text-truncate-modal"
                },
            ],
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
                            return '<span class="badge-custom ' + claseCss + '">' + data + '</span>';
                        }
                        return data;
                    }
                },
                {
                    data: "dias_restantes",
                    render: function (data) {
                        return '<span class="fw-bold text-warning">' + data + ' días</span>';
                    }
                },
                {
                    data: "modality_ID",
                    orderable: false,
                    render: function (data) {
                        return '<a href="./modalities/modality/' + data + '" class="btn btn-sm btn-success"><i class="bi bi-eye"></i></a>';
                    }
                }
            ],
            drawCallback: function () {
                initPopovers();
            }
        });
    }
});