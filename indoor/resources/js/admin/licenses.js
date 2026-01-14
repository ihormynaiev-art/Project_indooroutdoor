if ( $.fn.dataTable.isDataTable( '#licenses-data' ) ) {
    table = $('#licenses-data').DataTable();
}
else {
    var table = $('#licenses-data').DataTable({
        ordering: true,
        ajax: 'licenses',
        order: [[2, 'desc']],
        columns: [
            {
                data: null,
                render: function (data, type, row) {
                    return data.provider_detail.business_name + "<br>" + data.name
                }
            },
            { data: 'email' },
            { data: 'last_cert' },
            { data: 'last_cert_status',
                render: function (data, type, row) {
                    if(!data) {
                        return 'Empty'
                    }

                    return data.replace(/_/g, ' ')
                            .replace(/\b\w/g, c => c.toUpperCase());
                }},
            {
                data: 'id',
                orderable: false,
                render: function (data, type, row) {
                    let editButton = `<a class="table-edit" href="licenses/${data}/edit">
                            <i class="fa-regular fa-pen-to-square"></i><span>Edit</span>
                        </a>`;
                    return editButton;
                }
            }
        ],
        paging: true,
        searching: true,
        info: true,
        dom: 'rtip',
        language: {
            paginate: {
                first: '',
                last: '',
                next: '',
                previous: ''
            },
            info: 'Showing _START_ - _END_ of _TOTAL_ items', // Customize the show info text
            infoFiltered: '', // Remove filtered info
            infoEmpty: '', // Remove empty info
        },
        // scrollX: false,
        // scrollY: false
    });
}


$(document).ready(function () {
    $('#nameFilter').on('keyup change', function () {
        table.column(0).search(this.value).draw();
    });

    $('#emailFilter').on('keyup change', function () {
        table.column(1).search(this.value).draw();
    });
});
