$(document).ready(function () 
{
    configureDataTableTypes();

    $('#studentTables').DataTable({
        ...dataTableConfig,
        ajax: {
            url:'students/getstudents',
            dataSrc: ''
        },
        columns: [
            {data: 'code'},
            {data: 'name_student'},
            {data: 'program_name'},
            {data: 'sede'},
            {data: 'type_modalitie'},
            {data: 'status',
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
                data: 'student_ID',
                oderable: false,
                render: function(data, type, row) {
                    return `
                        <a href="./students/student/${data}"
                           class="btn btn-sm btn-success">
                            <i class="bi bi-eye"></i>
                        </a>
                        <button type="button"
                                class="btn btn-sm btn-warning btn-edit-student"
                                data-bs-toggle="modal"
                                data-bs-target="#editStudentModal"
                                data-id="${data}"
                                data-name="${row.name_student}"
                                data-code="${row.code}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        `
                }
            }
        ]
    })
})