if ( $.fn.dataTable.isDataTable( '#testimonials-data' ) ) {
    table = $('#testimonials-data').DataTable();
}
else {
    let table = $('#testimonials-data').DataTable({
        ordering: true,
        ajax: {
            url: 'sms-messages',
        },
        columns: [
            { data: 'phone' },
            {
                data: 'sms_template',
                render: function (data, type, row) {
                    if (data) {
                        return `<a href="/admin/sms-templates/${data.id}/edit">${data.label}</a>`;
                    }
                    return 'dv';
                }
            },
            { data: 'sent_at' },
            { data: 'status' },
            {
                data: 'id',
                orderable: false,
                render: function (data, type, row) {
                    return `
                        <div class="action-language">
                            <a class="table-edit" href="/admin/sms-messages/${data}">
                                <i class="fa-regular fa-eye"></i><span>Show</span>
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
