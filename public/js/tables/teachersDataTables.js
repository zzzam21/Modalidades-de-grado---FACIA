$(document).ready(function () 
{
    configureDataTableTypes();

    $('#teachersTables').DataTable({
        ...dataTableConfig,
        ajax: {
            url:'teachers/getteacher',
            dataSrc: ''
        },
        columns: [
            {data: 'teacher_ID'},
            {data: 'name'},
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