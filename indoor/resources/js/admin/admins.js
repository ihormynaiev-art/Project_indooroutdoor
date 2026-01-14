if ( $.fn.dataTable.isDataTable( '#admins-data' ) ) {
    table = $('#admins-data').DataTable();
}
else {
    var table = $('#admins-data').DataTable({
        ordering: true,
        ajax: 'admins',
        columnDefs: [{ width: '20%', targets: 0 }],
        columns: [
            { data: 'name' },
            { data: 'email' },
            {
                data: 'id',
                orderable: false,
                render: function (data, type, row) {
                    let role = row.roles.length > 0 ? row.roles[0].name : '';
                    let editButton = role === 'provider' ? `<a class="table-edit" href="providerDetail/${data}">
                            <i class="fa-regular fa-pen-to-square"></i><span>Edit</span>
                        </a>` : '';
                    var html = `
                    <div class="action-language">
                        ${editButton}
                        <a class="table-show" href="admins/${data}">
                            <i class="fa-regular fa-eye"></i><span>Show</span>
                        </a>
                        <a class="table-delete" href="javascript:void(0);" data-id="${data}">
                            <i class="fa-solid fa-trash-can"></i><span>Delete</span>
                        </a>
                    </div>`;

                    return html;
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
            info: 'Showing _START_ - _END_ of _TOTAL_ items',
            infoFiltered: '',
            infoEmpty: '',
        },
    });
}

$('#reply-form').on('submit', function(event) {
    event.preventDefault();
    var form = $(this);
    var formData = form.serialize();
    let id = $('#id').val()
    $.ajax({
        url: `/admin/admins/${id}/changeRole`,
        method: 'PATCH',
        data: formData,
        success: function(response) {
            table.ajax.reload();
            $('#change-role').modal('hide');
        },
        error: function(xhr, status, error) {
            $('#change-role').modal('hide');
        }
    });
});
$(document).on("click", ".table-resposnive .table-delete", function () {
    var text = 'Are you sure want to delete?'
    var id = $(this).data('id')
    var authUserId = $('#auth-user').val()
    if (id == authUserId) {
        text = text + ` After deleting your own account, you will be logged out`;
    }
    Swal.fire({
        title: "Delete user",
        text: text,
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
                url: 'admins/' + id,
                data: {
                    '_method': 'DELETE',
                    "_token": $('#token').val()
                },
                success: function(response) {
                    if (id == authUserId) {
                        window.location.href = '/'
                    }
                    if (response.status === "success") {
                        table.ajax.reload();
                    }
                }
            });
        }
    });
});

$(document).ready(function () {
    $('#nameFilter').on('keyup change', function () {
        table.column(0).search(this.value).draw();
    });

    $('#emailFilter').on('keyup change', function () {
        table.column(1).search(this.value).draw();
    });
});
