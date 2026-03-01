$(document).ready(function () {
    DataTable.type('num', 'className', 'dt-body-center');
    DataTable.type('num-fmt', 'className', 'dt-body-left');
    DataTable.type('date', 'className', 'dt-body-left');
    DataTable.type('string', 'className', 'dt-head-center');
    $('#modalityTable').DataTable( {
        language: {
            "paginate": {
                "first": "<<",
                "last": ">>",
                "next": ">",
                "previous": "<"
            },
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
        },

        'pagingType': 'full_numbers', 
        columnDefs: [
            {
                targets: 1,
                width: "230px",
                className: "text-truncate-modal"
            }
        ]
    });

    $('#otherTables').DataTable( {
        language: {
            "paginate": {
                "first": "<<",
                "last": ">>",
                "next": ">",
                "previous": "<"
            },
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
        }
    }); 

    

})
