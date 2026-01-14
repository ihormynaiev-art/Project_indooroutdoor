if ( $.fn.dataTable.isDataTable( '#users-data' ) ) {
    table = $('#users-data').DataTable();
}
else {
    var table = $('#users-data').DataTable({
        order: [[ '3', "asc" ]],
        ordering: true,
        ajax: 'users',
        columnDefs: [{ width: '20%', targets: 0 }],
        columns: [
            { data: 'name' },
            { data: 'email' },
            {
                data: 'is_verified',
                type: "boolean",
                render: function (data, type, row) {
                    return data ?
                        `<i class="text-success fa-solid fa-circle-check fa-xl"></i>` :
                        `<i class="text-danger fa-solid fa-circle-xmark fa-xl"></i>`
                }
            },
            {
                data: 'roles',
                render: function (data, type, row) {
                    if (data.length > 0) {
                        return data[0].name[0].toUpperCase() + data[0].name.slice(1);
                    }
                    return 'User'
                }
            },
            {
                data: 'provider_detail',
                render: function (data, type, row) {
                    if (data && data.plan) {
                        return `<span class="badge bg-${data.plan.name === 'premium' ? 'primary' : 'secondary'}">${data.plan.display_name}</span>`;
                    }
                    return '<span class="text-muted">-</span>';
                }
            },
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
                        <a class="table-show" href="users/${data}">
                            <i class="fa-regular fa-eye"></i><span>Show</span>
                        </a>
                        <a
                            data-id="${data}"
                            data-role="${role}"
                            class="table-role me-1"
                            href="javascript:void(0);"
                            data-bs-toggle="modal"
                            data-bs-target="#change-role"
                        >
                            <i class="fa-regular fa-user"></i>
                            <span>Role</span>
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
            info: 'Showing _START_ - _END_ of _TOTAL_ items', // Customize the show info text
            infoFiltered: '', // Remove filtered info
            infoEmpty: '', // Remove empty info
        },
        // scrollX: false,
        // scrollY: false
    });
}

$('#change-role').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget);
    let role = button.data('role')
    let roleSelect = $('#role')
    $(this).find('#id').val(button.data('id'));
    roleSelect.val(role).trigger('change');
    if (role === 'super admin') {
        roleSelect.attr('disabled', 'disabled');
    } else {
        roleSelect.attr('disabled', false);
    }
});

$('#reply-form').on('submit', function(event) {
    event.preventDefault();
    var form = $(this);
    var formData = form.serialize();
    let id = $('#id').val()
    $.ajax({
        url: `/admin/users/${id}/changeRole`,
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
                url: 'users/' + id,
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
