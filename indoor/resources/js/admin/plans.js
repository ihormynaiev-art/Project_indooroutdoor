if ( $.fn.dataTable.isDataTable( '#plans-data' ) ) {
    table = $('#plans-data').DataTable();
}
else {
    let table = $('#plans-data').DataTable({
        ordering: true,
        ajax: 'plans',
        columns: [
            { data: 'display_name' },
            {
                data: 'config',
                render: function (data, type, row) {
                    return data?.features?.max_portfolio_photos || 'N/A';
                }
            },
            {
                data: 'config',
                render: function (data, type, row) {
                    return data?.limits?.lead_delay_hours || 0;
                }
            },
            {
                data: 'is_active',
                type: "boolean",
                render: function (data, type, row) {
                    return data ?
                        `<i class="text-success fa-solid fa-circle-check fa-xl"></i>` :
                        `<i class="text-danger fa-solid fa-circle-xmark fa-xl"></i>`;
                }
            },
            {
                data: 'id',
                orderable: false,
                render: function (data, type, row) {
                    return `
                        <div class="action-language">
                            <a class="table-edit" href="/admin/plans/${data}/edit">
                                <i class="fa-regular fa-pen-to-square"></i><span>Edit</span>
                            </a>
                        </div>`;
                }
            },
        ],
        paging: true,
        searching: false,
        info: true,
        dom: 'rtip',
        language: {
            paginate: {
                first: '',
                last: '',
                next: '',
                previous: ''
            },
            info: 'Showing _START_ - _END_ of _TOTAL_ items',
            infoFiltered: '',
            infoEmpty: '',
        },
    });
}
