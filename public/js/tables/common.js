const dataTableConfig = {
    language: {
        paginate: {
            first: "<<",
            last: ">>",
            next: ">",
            previous: "<"
        },
        url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
    },
    pagingType: 'full_numbers',
    responsive: true
};

function configureDataTableTypes() {
    DataTable.type('num', 'className', 'dt-body-center');
    DataTable.type('num-fmt', 'className', 'dt-body-left');
    DataTable.type('date', 'className', 'dt-body-left');
    DataTable.type('string', 'className', 'dt-head-center');
}

function initPopovers() {
    const popoverTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="popoverDataTable"]')
    );

    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
}