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
            {
                data: 'student_ID',
                oderable: false,
                render: function(data) {
                    return `
                        <a href="./students/student/${data}"
                           class="btn btn-sm btn-success">
                            <i class="bi bi-eye"></i>
                        </a>
                        `
                }
            }
        ]
    })
})