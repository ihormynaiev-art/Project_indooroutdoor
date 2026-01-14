@extends('layout.mainlayout_admin')
@section('content')
    <div class="toast top-25 end-0 position-fixed align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                sdfsdfdsf
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    <div class="page-wrapper page-settings">
        <div class="content">

            @component('admin.components.pageheader')
                @slot('title')
                    Contact Messages
                @endslot
            @endcomponent

            @component('admin.components.tabsets')
            @endcomponent
            <div class="row">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="col-12">
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <input type="text" id="nameFilter" class="form-control rounded-3 shadow-sm my-1" placeholder="Search by name">
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="dateFilter" class="form-control rounded-3 shadow-sm my-1" placeholder="Search by date">
                        </div>
                    </div>
                    <div class="table-resposnive table-div">
                        <table class="table w-100" id="contact-messages-data">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Message</th>
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

    <div class="modal fade" data-bs-focus="false" id="add-reply" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">REPLY CONTACT</h5>
                    <button type="button"  class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <form id="reply-form" action="{{ route('admin.contactMessages.reply') }}" method="post">
                    @csrf
                    <input name="email" hidden type="text" id="email">
                    <div class="modal-body py-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Content</label>
                                    <input name="text" id="editor"/>
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
