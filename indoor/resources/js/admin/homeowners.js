if ( $.fn.dataTable.isDataTable( '#homeowners-data' ) ) {
    table = $('#homeowners-data').DataTable();
}
else {
    var table = $('#homeowners-data').DataTable({
        ordering: true,
        order: [[3, 'desc']],
        ajax: 'homeowners',
        // serverSide: true,
        columnDefs: [
            { width: '20%', targets: 0 },
            { orderable: false, targets: 4 }
        ],
        columns: [
            { data: 'name' },
            { data: 'email' },
            {
                data: 'email_verified_at',
                type: "boolean",
                render: function (data, type, row) {
                    return data ?
                        `<i class="text-success fa-solid fa-circle-check fa-xl"></i>` :
                        `<i class="text-danger fa-solid fa-circle-xmark fa-xl"></i>`
                }
            },
            { data: 'created_at' },
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
                        <a class="table-show" href="homeowners/${data}">
                            <i class="fa-regular fa-eye"></i><span>Show</span>
                        </a>
                        <a class="table-edit" href="homeowners/${data}/edit">
                            <i class="fa-regular fa-pen-to-square"></i><span>Edit</span>
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
                url: 'homeowners/' + id,
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
