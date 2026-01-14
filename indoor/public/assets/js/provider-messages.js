if ($.fn.dataTable.isDataTable('#testimonials-data')) {
    $('#testimonials-data').DataTable().destroy();
}

let table = $('#testimonials-data').DataTable({
    ordering: true,
    ajax: 'provider-messages',
    serverSide: true,
    columns: [
        {data: 'contact'},
        {
            data: 'message',
            render: function (data) {
                if (!data) return '';
                return data.length > 50 ? data.substring(0, 50) + '...' : data;
            }
        },
        {data: 'created_at'},
        {
            data: 'id',
            orderable: false,
            render: function (data, type, row) {
                const checked = row.is_hide ? '' : 'checked'
                return `
                    <div class="table-actions d-flex">
                        <a class="btn delete-table me-2" type="button" href="/provider/provider-messages/${data}">
                           <i class="feather-eye"></i>
                        </a>
                    </div>`;
            }
        },
    ],
    createdRow: function (row, data) {
        if (data.is_read === 0) {
            row.classList.add("unread-row");
        }
    },
    columnDefs: [
        {orderable: false, targets: 3}
    ],
    paging: true,
    searching: false,
    info: true,
    dom: 'rtip', // Customize the DataTable layout
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
