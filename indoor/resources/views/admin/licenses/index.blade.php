@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">

            @component('admin.components.pageheader')
                @slot('title')
                    Licenses
                @endslot
            @endcomponent

            @component('admin.components.tabsets')
            @endcomponent
            <div class="row">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <input type="hidden" name="user_id" id="auth-user" value="{{ request()->user()->id }}">
                <div class="col-12">
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <input type="text" id="nameFilter" class="form-control rounded-3 shadow-sm my-1" placeholder="Search by name">
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="emailFilter" class="form-control rounded-3 shadow-sm my-1" placeholder="Search by email">
                        </div>
                    </div>
                    <div class="table-resposnive table-div">
                        <table class="table w-100" id="licenses-data">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Uploaded</th>
                                <th>Status</th>
                                <th style="text-align:right;">Action</th>
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
    $(function() {
        @if(session('status'))
        Swal.fire({
            toast: true,
            icon: 'success',
            title: @json(session('status')),
            animation: false,
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        @endif
    })
</script>
@endsection
