if ( $.fn.dataTable.isDataTable( '#categories-data' ) ) {
    table = $('#categories-data').DataTable();
}
else {
    var table = $('#categories-data').DataTable({
        ordering: true,
        ajax: 'categories',
        columnDefs: [{ width: '20%', targets: 0 }],
        columns: [
            {
                data: null,
                render: function (data, type, row) {
                    if (type === 'sort' || type === 'type') {
                        return data.image_path ? 1 : 0;
                    }

                    let src = data.image_path ? "/storage/" + data.image_path : "/assets/img/not-found.jpg"
                    return `
                        <div class="table-imgname">
                            <a href="/admin/categories/${data.id}/edit">
                                <img src="${src}" class="me-2" alt="img">
                            </a>
                        </div>`;
                }
            },
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            {
                data: 'parent_id', name: 'parent',
                render: function (data, type, row) {
                    if (row.parent) {
                        return row.parent.name
                    }
                    return '-'
                }
            },
            { data: 'prio', name: 'priority' },
            {
                data: 'is_active', name: 'active',
                render: function (data, type, row) {
                    if (type === 'sort' || type === 'type') {
                        return data ? 1 : 0;
                    }
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
                data: 'show_in_home_top_slider', name: 'show_in_home_top_slider',
                render: function (data, type, row) {
                    if (type === 'sort' || type === 'type') {
                        return data ? 1 : 0;
                    }
                    var isChecked = data ? 'checked' : '';
                    var html = `
                        <div class="mx-2 active-switch">
                            <label class="switch">
                                <input name="show_in_home_top_slider" id="show_in_home_top_slider" value="1" ${isChecked} data-id=${row.id} type="checkbox">
                                <span class="sliders round"></span>
                            </label>
                        </div>`;

                    return html;
                }
            },
            {
                data: 'id',
                orderable: false,
                render: function (data, type, row) {
                    var imageHtml = `
                    <div class="action-language">
                        <a class="table-edit" href="/admin/categories/${data}/edit">
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
        title: "Delete Category",
        text: "Are you sure want to delete? All its subcategories will be deleted",
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
                url: '/admin/categories/' + id + "/",
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

$('#search').on('keyup', function() {
    table.search(this.value).draw();
});

$(document).on("change", ".table-resposnive input[name=is_active]", function () {
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
        url: '/admin/categories/' + id + '/updateIsActive',
        data: data,
        success: function(response) {
            if (response.status === "success") {
                console.log(response.status)
            }
        }
    });
});

$(document).on("change", ".table-resposnive input[name=show_in_home_top_slider]", function () {
    var id = $(this).data('id')
    var val = $(this).val()
    var attribute = this.id

    if (attribute === 'show_in_home_top_slider') {
        val = $(this).prop('checked');
    }

    var data = {};
    data['_method'] = 'PATCH';
    data['_token'] = $('#token').val();
    data[attribute] = val;

    $.ajax({
        type: 'PATCH',
        url: '/admin/categories/' + id + '/updateShowInHomeTopSlider',
        data: data,
        success: function(response) {
            if (response.status === "success") {
                console.log(response.status)
            }
        }
    });
});
