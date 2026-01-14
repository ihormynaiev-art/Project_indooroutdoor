@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">

            @component('admin.components.pageheader')
                @slot('title')
                    All Testimonials
                @endslot
            @endcomponent
            <div class="row">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="col-12">
                    <div class="table-resposnive table-div">
                        <table class="table w-100" id="testimonials-data">
                            <thead>
                            <tr>
                                <th>Nickname</th>
                                <th>Email</th>
                                <th>Title</th>
                                <th>Rating</th>
                                <th>Contractor</th>
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
    @vite(['resources/js/admin/testimonials.js'])
@endsection
