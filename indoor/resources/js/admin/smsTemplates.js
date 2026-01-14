if ( $.fn.dataTable.isDataTable( '#testimonials-data' ) ) {
    table = $('#testimonials-data').DataTable();
}
else {
    let table = $('#testimonials-data').DataTable({
        ordering: true,
        ajax: 'sms-templates',
        columns: [
            { data: 'label' },
            { data: 'message' },
            {
                data: 'is_enabled',
                type: "boolean",
                render: function (data, type, row) {
                    return data ?
                        `<i class="text-success fa-solid fa-circle-check fa-xl"></i>` :
                        `<i class="text-danger fa-solid fa-circle-xmark fa-xl"></i>`
                }
            },
            {
                data: 'id',
                orderable: false,
                render: function (data, type, row) {
                    return `
                        <div class="action-language">
                            <a class="table-edit" href="/admin/sms-templates/${data}/edit">
                                <i class="fa-regular fa-pen-to-square"></i><span>Edit</span>
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
