@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="provider-subtitle">
                            <h6>Request Quotes</h6>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="col-12">
                    <div class="table-resposnive table-div">
                        <table class="table w-100" id="request-quotes-data">
                            <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Date</th>
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
        function loadDataTable() {
            if ($.fn.dataTable.isDataTable('#request-quotes-data')) {
                $('#request-quotes-data').DataTable().destroy();
            }

            var table = $('#request-quotes-data').DataTable({
                ordering: true,
                ajax: {
                    url: '{{ route("provider.request-quotes.index") }}',
                },
                createdRow: function (row, data) {
                    if (data.is_read === 0) {
                        row.classList.add("unread-row");
                    }
                },
                columnDefs: [{ width: '20%', targets: 0 }],
                columns: [
                    { data: 'full_name' },
                    { data: 'email' },
                    { data: 'status' },
                    { data: 'created_at' },
                    {
                        data: 'id',
                        render: function (data, type, row) {
                            var actionHtml = `
                                <div class="table-actions d-flex">
                                    <a class="btn delete-table me-2" href="{{ route('provider.request-quotes.show', '') }}/${data}">
                                        <i class="feather-eye"></i>
                                    </a>
                                </div>`;
                            return actionHtml;
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
                    info: 'Showing _START_ - _END_ of _TOTAL_ items  ', // Customize the show info text
                    infoFiltered: '', // Remove filtered info
                    infoEmpty: '', // Remove empty info
                },
            });

            return table;
        }

        var table = loadDataTable();
    </script>
@endsection
