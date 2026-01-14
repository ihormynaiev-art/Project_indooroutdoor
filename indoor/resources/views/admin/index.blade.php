@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-12 d-flex widget-path widget-service">
                    <div class="card">
                        <div class="card-body">
                            <div class="home-user">
                                <div class="home-userhead">
                                    <div class="home-usercount">
                                        <span><img src="{{ URL::asset('admin_assets/img/icons/user.svg') }}"
                                                alt="img"></span>
                                        <h6>User</h6>
                                    </div>
                                </div>
                                <div class="home-usercontent">
                                    <div class="home-usercontents">
                                        <div class="home-usercontentcount">
                                            <img src="{{ URL::asset('admin_assets/img/icons/arrow-up.svg') }}"
                                                alt="img" class="me-2">
                                            <span class="counters" data-count="{{ $homeownersCount }}">{{ $homeownersCount }}</span>
                                        </div>
                                        <h5>All Time</h5>
                                    </div>
                                    <div class="homegraph">
                                        <img src="{{ URL::asset('admin_assets/img/graph/graph1.png') }}" alt="img">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12 d-flex widget-path widget-service">
                    <div class="card">
                        <div class="card-body">
                            <div class="home-user home-provider">
                                <div class="home-userhead">
                                    <div class="home-usercount">
                                        <span><img src="{{ URL::asset('admin_assets/img/icons/user-circle.svg') }}"
                                                alt="img"></span>
                                        <h6>Providers</h6>
                                    </div>
                                </div>
                                <div class="home-usercontent">
                                    <div class="home-usercontents">
                                        <div class="home-usercontentcount">
                                            <img src="{{ URL::asset('admin_assets/img/icons/arrow-up.svg') }}"
                                                alt="img" class="me-2">
                                            <span class="counters" data-count="{{ $providersCount }}">{{ $providersCount }}</span>
                                        </div>
                                        <h5>All Time</h5>
                                    </div>
                                    <div class="homegraph">
                                        <img src="{{ URL::asset('admin_assets/img/graph/graph2.png') }}" alt="img">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12 d-flex widget-path widget-service">
                    <div class="card">
                        <div class="card-body">
                            <div class="home-user home-subscription">
                                <div class="home-userhead">
                                    <div class="home-usercount">
                                        <span><img src="{{ URL::asset('admin_assets/img/icons/eye.svg') }}"
                                                   alt="img"></span>
                                        <h6>Visitors</h6>
                                    </div>
                                </div>
                                <div class="home-usercontent">
                                    <div class="home-usercontents">
                                        <div class="home-usercontentcount">
                                            <img src="{{ URL::asset('admin_assets/img/icons/arrow-up.svg') }}"
                                                 alt="img" class="me-2">
                                            <span class="counters" data-count="{{ $visitors }}">{{ $visitors }}</span>
                                        </div>
                                        <h5>All Time</h5>
                                    </div>
                                    <div class="homegraph">
                                        <img src="{{ URL::asset('admin_assets/img/graph/graph3.png') }}" alt="img">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-12 d-flex widget-path">
                    <div class="card">
                        <div class="card-body">
                            <div class="home-user">
                                <div class="home-head-user home-graph-header">
                                    <h2>Categories</h2>
                                </div>
                                <div class="table-responsive datatable-nofooter">
                                    <table class="table datatable" id="index-data">
                                        <thead>
                                            <tr>
                                                <th>Category</th>
                                                <th>Provider Amount</th>
                                                <th>Views</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 d-flex widget-path">
                    <div class="card">
                        <div class="card-body">
                            <div class="home-user">
                                <div class="home-head-user home-graph-header">
                                    <h2>Top Providers</h2>
                                </div>
                                <div class="table-responsive datatable-nofooter">
                                    <table class="table datatable" id="index-provider-data">
                                        <thead>
                                            <tr>
                                                <th>Business Name</th>
                                                <th>Views</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var categoriesData = @json($categoriesData);
        var providersData = @json($providersData);
        if ($.fn.DataTable.isDataTable('#index-data')) {
            $('#index-data').DataTable().destroy();
        }
        $('#index-data').DataTable({
            ordering: true,
            data: categoriesData,
            columns: [
                { data: 'name' },
                { data: 'provider_details_count' },
                { data: 'selections' },
            ],
            paging: true,
            searching: false,
            info: false,
            order: [
                [1, 'desc'],
            ],
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
        });

        if ($.fn.DataTable.isDataTable('#index-provider-data')) {
            $('#index-provider-data').DataTable().destroy();
        }
        $('#index-provider-data').DataTable({
            ordering: true,
            data: providersData,
            columns: [
                { data: 'business_name' },
                { data: 'views' },
            ],
            paging: true,
            searching: false,
            info: false,
            order: [
                [1, 'desc'],
            ],
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
        });
    });
</script>
@endsection
