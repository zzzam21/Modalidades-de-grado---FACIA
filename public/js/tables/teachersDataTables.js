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
                render: function(data, type, row) {
                    return `
                        <a href="./teachers/teacher/${data}"
                            class="btn btn-sm btn-success">
                            <i class="bi bi-eye"></i>
                        </a>
                        <button type="button"
                                class="btn btn-sm btn-warning btn-edit-teacher"
                                data-bs-toggle="modal"
                                data-bs-target="#editTeacherModal"
                                data-id="${data}"
                                data-name="${row.name}">
                            <i class="bi bi-pencil"></i>
                        </button>
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
        columnDefs: [
            {
                targets: -1,
                orderable: false
            },
            {
                targets: 1,
                className: "text-truncate-modal"
            }
        ],

        columns: [
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