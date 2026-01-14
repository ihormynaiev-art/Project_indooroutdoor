@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">

            @component('admin.components.pageheader')
                @slot('title')
                    All Logos
                @endslot
                @slot('text')
                    Create Logo
                @endslot
            @endcomponent

            @component('admin.components.tabsets')
            @endcomponent
            <div class="row">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="col-12">
                    <div class="table-resposnive table-div">
                        <table class="table w-100" id="logos-data">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Slug</th>
                                    <th>Priority</th>
                                    <th>Active</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        if ( $.fn.dataTable.isDataTable( '#logos-data' ) ) {
            table = $('#logos-data').DataTable();
        }
        else {
            var table = $('#logos-data').DataTable({
                ordering: true,
                order: [[1, 'asc']],
                ajax: 'logos',
                columnDefs: [
                    { width: '20%', targets: 0 },
                    { orderable: false, targets: [0, 4] }
                ],
                columns: [
                    {
                        data: 'file',
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
                    { data: 'slug' },
                    { data: 'prio' },
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
                        data: 'id',
                        render: function (data, type, row) {
                            var imageHtml = `
                                <div class="action-language">
                                    <a class="table-show" href="/admin/logos/${data}">
                                        <i class="fa-regular fa-eye"></i><span>Show</span>
                                    </a>
                                    <a class="table-edit" href="logos/${data}/edit">
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
                title: "Delete request logo",
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
                        url: 'logos/' + id,
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
            var val = $(this).prop('checked');
            var attribute = this.id

            var data = {};
            data['_method'] = 'PATCH';
            data['_token'] = $('#token').val();
            data[attribute] = val;

            $.ajax({
                type: 'PATCH',
                url: '/admin/logos/' + id + '/updateIsActive',
                data: data,
                success: function(response) {
                    if (response.status === "success") {
                    }
                }
            });
        });
    </script>
@endsection
