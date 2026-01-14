@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">

            @component('admin.components.pageheader')
                @slot('title')
                    All Request Quotes
                @endslot
            @endcomponent

            @component('admin.components.tabsets')
            @endcomponent
            <div class="row mb-3">
                <div class="col-md-3">
                    <div class="form-group pt-4">
                        <label for="provider-filter">Provider</label>
                        <select id="provider-filter" class="form-control select">
                            <option value="all">All</option>
                            <option value="with_provider">With Provider</option>
                            <option value="without_provider">Without Provider</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="col-12">
                    <div class="table-resposnive table-div">
                        <table class="table w-100" id="request-quotes-data">
                            <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Provider</th>
                                <th>Date</th>
                                <th>Available At</th>
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
        function loadDataTable(providerFilter = 'all') {
            if ($.fn.dataTable.isDataTable('#request-quotes-data')) {
                $('#request-quotes-data').DataTable().destroy();
            }

            var table = $('#request-quotes-data').DataTable({
                ordering: true,
                order: [5, 'desc'],
                ajax: {
                    url: 'requestQuotes',
                    data: function(d) {
                        d.provider_filter = providerFilter;
                    }
                },
                columnDefs: [{ width: '20%', targets: 0 }],
                createdRow: function(row, data, dataIndex) {
                    // Add gray background to rows without a provider
                    if (!data.provider && !data.processed) {
                        $(row).addClass('bg-light');
                    }
                },
                columns: [
                    { data: 'full_name' },
                    { data: 'email' },
                    { data: 'city' },
                    { data: 'state' },
                    {
                        data: 'provider',
                        render: function (data, type, row) {
                            if (data) {
                                return `<a href="/provider-details/${data.slug}">${data.business_name}</a>`;
                            }
                            return '';
                        }
                    },
                    { data: 'created_at' },
                    {
                        data: 'available_at',
                        render: function (data, type, row) {
                            if (data) {
                                // Format the date if needed
                                return data;
                            }
                            return '<span class="text-muted">Immediately</span>';
                        }
                    },
                    {
                        data: 'id',
                        render: function (data, type, row) {
                            var imageHtml = `
                                <div class="action-language">
                                    <a class="table-show" href="/admin/requestQuotes/${data}">
                                        <i class="fa-regular fa-eye"></i><span>Show</span>
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

            return table;
        }

        var table = loadDataTable();

        // Handle filter change
        $('#provider-filter').on('change', function() {
            var filterValue = $(this).val();
            table = loadDataTable(filterValue);
        });
        $(document).on("click", ".table-resposnive .table-delete", function () {
            var id = $(this).data('id')
            Swal.fire({
                title: "Delete request quote",
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
                        url: 'requestQuotes/' + id,
                        data: {
                            '_method': 'DELETE',
                            "_token": $('#token').val()
                        },
                        success: function(response) {
                            if (response.status === "success") {
                                // Reload the table with the current filter
                                var currentFilter = $('#provider-filter').val();
                                table = loadDataTable(currentFilter);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
