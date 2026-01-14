if ($.fn.dataTable.isDataTable('#contractors-data')) {
    table = $('#contractors-data').DataTable();
} else {
    var table = $('#contractors-data').DataTable({
        ordering: true,
        order: [[2, 'desc']],
        ajax: 'landings',
        columnDefs: [{width: '20%', targets: 0}],
        columns: [
            {
                data: null,
                render: function (data, type, row) {
                    return `<a target="_blank" href="/admin/providerDetail/${data.id}">
                        <span>${data.provider_detail.business_name}</span>
                    </a>`
                }
            },
            {data: 'created_at'},
            {
                data: null,
                render: function (data, type, row) {
                    if (data.provider_detail && data.provider_detail.plan) {
                        return `<span class="badge bg-${data.provider_detail.plan.name === 'premium' ? 'primary' : 'secondary'}">${data.provider_detail.plan.display_name}</span>`;
                    }
                    return '<span class="text-muted">-</span>';
                }
            },
            {
                data: 'provider_detail.landing',
                type: "boolean",
                render: function (data, type, row) {
                    if (!data) {
                        return '';
                    }

                    return data.is_published
                        ? `<i class="text-success fa-solid fa-circle-check fa-xl"></i>`
                        : `<i class="text-danger fa-solid fa-circle-xmark fa-xl"></i>`;
                }
            },
            {
                data: null,
                orderable: false,
                render: function (data, type, row) {
                    const editButton = data.provider_detail.landing  ?
                        `<a class="table-edit" href="/admin/landings/${data.provider_detail.landing.id}/edit">
                            <i class="fa-regular fa-pen-to-square"></i><span>Edit</span>
                        </a>` :
                        `<a class="table-edit" href="/admin/landings/create/${data.provider_detail.id}">
                            <i class="fa-regular fa-plus-square"></i><span>Create</span>
                        </a>`

                    const linkButton = data.provider_detail.landing ?
                        `<a class="table-view" href="/provider-details/${data.provider_detail.slug}/${data.provider_detail.landing.slug}" target="_blank">
                            <i class="fa-solid fa-link"></i><span>Link</span>
                        </a>` : '';

                    const deleteButton = data.provider_detail.landing ?
                        `<a class="table-delete" href="javascript:void(0);" data-id="${data.provider_detail.landing.id}">
                            <i class="fa-solid fa-trash-can"></i><span>Delete</span>
                        </a>` : '';

                    return `
                    <div class="action-language mt-1 mx-1">
                        ${editButton}
                        ${linkButton}
                        ${deleteButton}
                    </div>`;
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
    var id = $(this).data('id')

    Swal.fire({
        title: "Delete Landing",
        text: "Are you sure you want to delete this landing page? This action cannot be undone.",
        icon: "warning",
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        customClass: {
            confirmButton: 'btn btn-danger mr-3',
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
                url: 'landings/' + id,
                data: {
                    '_method': 'DELETE',
                    "_token": $('#token').val()
                },
                success: function (response) {
                    if (response.status === "success") {
                        Swal.fire({
                            toast: true,
                            icon: 'success',
                            title: 'Landing deleted successfully',
                            animation: false,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                        table.ajax.reload();
                    }
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        toast: true,
                        icon: 'error',
                        title: 'Failed to delete landing',
                        animation: false,
                        position: 'top-right',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                }
            });
        }
    });
});
