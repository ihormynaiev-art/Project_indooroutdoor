if ( $.fn.dataTable.isDataTable( '#testimonials-data' ) ) {
    $('#testimonials-data').DataTable().destroy();
}

var table = $('#testimonials-data').DataTable({
    ordering: true,
    ajax: 'testimonials',
    columns: [
        { data: 'nickname' },
        { data: 'email' },
        { data: 'title' },
        {
            data: 'rating',
            render: function (data, type, row) {
                var stars = ''
                for (let i = 0; i < data; i++) {
                    stars = stars + `<i class="fas fa-star filled"></i>`
                }
                return `
                <div class="rating">
                    ${stars}
                </div>`;
            }
        },
        {
            data: 'id',
            render: function (data, type, row) {
                return `
                    <div class="table-actions d-flex">
                        <a class="btn delete-table me-2" type="button" href="/provider/testimonials/${data}">
                           <i class="feather-eye"></i>
                        </a>
                    </div>`;
            }
        },
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
