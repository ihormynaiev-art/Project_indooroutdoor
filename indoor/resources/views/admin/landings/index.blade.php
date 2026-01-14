@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">

            @component('admin.components.pageheader')
                @slot('title')
                    Landings
                @endslot
            @endcomponent

            @component('admin.components.tabsets')
            @endcomponent
            <div class="row">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <input type="hidden" name="user_id" id="auth-user" value="{{ request()->user()->id }}">
                <div class="col-12">
                    <div class="table-resposnive table-div">
                        <table class="table w-100" id="contractors-data">
                            <thead>
                            <tr>
                                <th>Contractor</th>
                                <th>Registered At</th>
                                <th>Plan</th>
                                <th>Is Published</th>
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
    @vite(['resources/js/admin/landings.js'])
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
