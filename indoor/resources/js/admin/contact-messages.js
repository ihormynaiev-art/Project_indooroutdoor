if ( $.fn.dataTable.isDataTable( '#contact-messages-data' ) ) {
    table = $('#contact-messages-data').DataTable();
}
else {
    var table = $('#contact-messages-data').DataTable({
        ordering: true,
        order: [4, 'desc'],
        ajax: 'contactMessages',
        columnDefs: [{ "width": "40%", "targets": 3 }],
        columns: [
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone' },
            { data: 'message' },
            { data: 'created_at' },
            {
                data: 'id',
                orderable: false,
                render: function (data, type, row) {
                    var imageHtml = `
                    <div class="action-language">
                        <a
                            data-email="${row.email}"
                            class="table-show"
                            href="javascript:void(0);"
                            data-bs-toggle="modal"
                            data-bs-target="#add-reply"
                        >
                                <i class="fa-regular fa-pen-to-square"></i>
                            <span>Reply</span>
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
        searching: true,
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
        title: "Delete Messages",
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
                url: '/admin/contactMessages/' + id + "/",
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

$('#add-reply').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var email = button.data('email');
    var modal = $(this);
    modal.find('#email').val(email);
});

$('#reply-form').on('submit', function(event) {
    event.preventDefault();
    $('input[name="text"]').val((editor.getData()))
    editor.setData('')
    var form = $(this);
    var formData = form.serialize();

    $.ajax({
        url: '/admin/contactMessages/reply',
        method: 'POST',
        data: formData,
        success: function(response) {
            $('#add-reply').modal('hide');

            Swal.fire({
                toast: true,
                icon: 'success',
                title: 'Send successfully',
                animation: false,
                position: 'top-right',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
        },
        error: function(xhr, status, error) {
            $('#add-reply').modal('hide');
        }
    });
});

$(document).ready(function () {
    $('#nameFilter').on('keyup change', function () {
        table.column(0).search(this.value).draw();
    });

    $('#dateFilter').on('keyup change', function () {
        table.column(4).search(this.value).draw();
    });
});
