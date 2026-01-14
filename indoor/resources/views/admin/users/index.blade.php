@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">

            @component('admin.components.pageheader')
                @slot('title')
                    All Users
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
                        <table class="table w-100" id="users-data">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Verified</th>
                                <th>Role</th>
                                <th>Plan</th>
                                <th style="text-align:right;">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="change-role" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change Role</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <form id="reply-form" action="{{ route('admin.contactMessages.reply') }}" method="post">
                    @csrf
                    <input name="id" hidden type="text" id="id">
                    <div class="modal-body py-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="select" name="role" id="role">
                                        <option value="">User</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role }}">
                                                {{ ucfirst($role) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-0">
                        <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
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
