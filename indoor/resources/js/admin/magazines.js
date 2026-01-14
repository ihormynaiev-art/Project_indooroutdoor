if ( $.fn.dataTable.isDataTable( '#magazines-data' ) ) {
    table = $('#magazines-data').DataTable();
}
else {
    var table = $('#magazines-data').DataTable({
        ordering: true,
        ajax: 'magazines',
        columnDefs: [{ width: '20%', targets: 0 }],
        columns: [
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            { data: 'prio', name: 'priority' },
            { data: 'is_active', name: 'active' },
            {
                data: 'id',
                render: function (data, type, row) {
                    var imageHtml = `
                    <div class="action-language">
                        <a class="table-show" href="/admin/magazineImages/${data}">
                            <i class="fa-regular fa-eye"></i><span>Show</span>
                        </a>
                        <a class="table-edit" href="magazines/${data}/edit">
                            <i class="fa-regular fa-pen-to-square"></i><span>Edit</span>
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
        info: false,
        dom: '<"custom-datatable"t><"custom-datatable"ilp>', // Customize the DataTable layout
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
        title: "Delete Magazine",
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
                url: 'magazines/' + id + "/",
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
