$(document).ready(function () 
{
    configureDataTableTypes();

    $('#teachersTables').DataTable({
        ...dataTableConfig,
        ajax: {
            url:'teachers/getteachers',
            dataSrc: ''
        },
        columns: [
            {data: 'teacher_ID'},
            {data: 'name'},
            {
                data: 'teacher_ID',
                render: function(data) {
                    return `
                        <a href="./teachers/teacher/${data}"
                            class="btn btn-sm btn-success">
                            <i class="bi bi-eye"></i>
                        </a>
                    `
                }
            }
        ]
    });

    const teacherId = document.getElementById("teacherId");
    id = teacherId.value;

    $('#teacherTable').DataTable({
        ...dataTableConfig,
        ajax: {
            url: '../../teachers/getInfoModalByTeacher/' + id,
            dataSrc: ''
        },
        responsive: {
            details: {
                type: 'column',
                target: 0
            }
        },
        columnDefs: [
            {
                className: 'dtr-control',
                oderable: false,
                targets: 0
            },
            {
                targets: -1,
                orderable: false
            },
            {
                targets: 2,
                className: "text-truncate-modal"
            }
        ],

        columns: [
            {data: null, defaultContent: ''},
            {data: 'modality_ID'},
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
            {data: 'role'},
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
            {
                data: 'modality_ID',
                render: function(data) {
                    return `
                        <a href="../../modalities/modality/${data}"
                            class="btn btn-sm btn-success">
                            <i class="bi bi-eye"></i>
                        </a>
                    `
                }
            }
        ],
        drawCallback: function () {
            initPopovers();
        }
        
    })
})