if ( $.fn.dataTable.isDataTable( '#testimonials-data' ) ) {
    $('#testimonials-data').DataTable().destroy();
}

var table = $('#testimonials-data').DataTable({
    ordering: true,
    ajax: 'google-reviews',
    serverSide: true,
    columns: [
        { data: 'author_name' },
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
            data: 'date'
        },
        {
            data: 'id',
            render: function (data, type, row) {
                const checked = row.is_hide ? '' : 'checked'
                return `
                    <div class="table-actions d-flex">
                        <div class="siderbar-toggle mx-4" style="display: block!important">
                             <label class="switch">
                                 <input class="showReview" type="checkbox" ${checked}
                                    value="${row.id}">
                                 <span class="slider round"></span>
                             </label>
                        </div>
                        <a class="btn delete-table me-2" type="button" href="/provider/google-reviews/${data}">
                           <i class="feather-eye"></i>
                        </a>
                    </div>`;
            }
        },
    ],
    columnDefs: [
        { orderable: false, targets: 3 }
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

$('#testimonials-data').on('change', '.showReview', function() {
    const id = $(this).val();
    const isChecked = $(this).is(':checked');

    $.ajax({
        url: '/provider/google-reviews/toggle',
        type: 'POST',
        data: {
            id: id,
            show: isChecked ? 1 : 0,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log('Success:', response);
        },
        error: function() {
            alert('Error');
        }
    });
});
