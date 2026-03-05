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
                data: null,
                render: function() {
                    return `
                        <button type="button" class="btn btn-sm btn-success"><span><i class="bi bi-pencil-square"></i></span></button>
                    `
                }
            }
        ]
    })
})