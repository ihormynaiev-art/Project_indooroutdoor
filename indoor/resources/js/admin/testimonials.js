if ( $.fn.dataTable.isDataTable( '#testimonials-data' ) ) {
    table = $('#testimonials-data').DataTable();
}
else {
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
                    if (type === 'sort' || type === 'type') {
                        return data;
                    }

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
                data: 'provider_detail',
                render: function (data, type, row) {
                    return data.business_name
                }
            },
            {
                data: 'id',
                orderable: false,
                render: function (data, type, row) {
                    var imageHtml = `
                        <div class="action-language">
                            <a class="table-show" href="/admin/testimonials/${data}">
                                <i class="fa-regular fa-eye"></i><span>Show</span>
                            </a>
                            <a class="table-delete" href="javascript:void(0);" data-id="${data}">
                                <i class="fa-solid fa-trash-can"></i><span>Delete</span>
                            </a>
                        </div>`;
                    return imageHtml;
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
}

$(document).on("click", ".table-resposnive .table-delete", function () {
    var id = $(this).data('id')
    Swal.fire({
        title: "Delete testimonial",
        text: "Are you sure want to delete?",
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: "delete",
        cancelButtonText: "close",
        customClass: {
            confirmButton: 'btn btn-primary mr-3',
            cancelButton: 'btn btn-secondary'
        },
        showClass: {
            popup: 'swal2-noanimation',
            backdrop: 'swal2-noanimation'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'DELETE',
                url: 'testimonials/' + id,
                data: {
                    '_method': 'DELETE',
                    "_token": $('#token').val()
                },
                success: function(response) {
                    if (response.status === "success") {
                        table.ajax.reload();
                    }
                }
            });
        }
    });
});
