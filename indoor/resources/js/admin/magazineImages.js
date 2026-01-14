var url = window.location.href;
var parts = url.split('/');
var id = parts[parts.length - 1];

if ( $.fn.dataTable.isDataTable( '#magazine-images-data' ) ) {
    table = $('#magazine-images-data').DataTable();
}
else {
    var table = $('#magazine-images-data').DataTable({
        ordering: true,
        ajax: id,
        columnDefs: [{ width: '20%', targets: 0 }],
        columns: [
            {
                data: null,
                render: function (data, type, row) {
                    var imageHtml = `
                        <div class="table-imgname">
                            <a href="#">
                                <img src="/storage/${data.path}" class="me-2" alt="img">
                            </a>
                        </div>`;
                    return imageHtml;
                }
            },
            { data: 'url', name: 'url' ,
                render: function (data, type, row) {
                    if (!data){
                        data = ''
                    }
                    return `<input class="form-control" id="url" data-id=${row.id} name="url" type="text"  value = ${data}  >`;
                }
            },
            {
                data: 'is_active', name: 'active',
                render: function (data, type, row) {
                    var isChecked = data ? 'checked' : '';
                    var html = `
                        <div class="mx-2 active-switch">
                            <label class="switch">
                                <input name="is_active" id="is_active" value="1" ${isChecked} data-id=${row.id} type="checkbox">
                                <span class="sliders round"></span>
                            </label>
                        </div>`;

                    return html;
                }
            },
            {
                data: 'id',
                render: function (data, type, row) {
                    var imageHtml = `
                    <div class="action-language">
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
        title: "Delete Image",
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
                url: id,
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

$(document).on("change", ".table-resposnive input", function () {
    var id = $(this).data('id')
    var val = $(this).val()
    var attribute = this.id

    if (attribute === 'is_active') {
        val = $(this).prop('checked');
    }

    var data = {};
    data['_method'] = 'PATCH';
    data['_token'] = $('#token').val();
    data[attribute] = val;

    $.ajax({
        type: 'PATCH',
        url: id,
        data: data,
        success: function(response) {
            if (response.status === "success") {
                console.log(response.status)
            }
        }
    });
});
