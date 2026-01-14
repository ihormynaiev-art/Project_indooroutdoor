@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">

            @component('admin.components.pageheader')
                @slot('title')
                    All Magazines
                @endslot
                @slot('text')
                    Create Magazine
                @endslot
            @endcomponent

            @component('admin.components.tabsets')
            @endcomponent
            <div class="row">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="col-12">
                    <div class="table-resposnive table-div">
                        <table class="table w-100" id="magazines-data">
                            <thead>
                            <tr>
                                <th>Name</th>
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

