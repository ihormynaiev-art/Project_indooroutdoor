@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">

            <div class="content-page-header content-page-headersplit">
                <h5>Sms Template - {{ $smsTemplate->label }}</h5>
            </div>

            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.sms-templates.update', ['sms_template' => $smsTemplate]) }}"
                  method="post"
                  class="row">
                @csrf
                @method('PUT')
                <div class="col-lg-4 col-sm-12">
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        @if($smsTemplate->keys)
                        <p>Keys: {{ $smsTemplate->keys }}</p>
                        @endif
                        <textarea
                            required
                            type="text"
                            name="message"
                            class="form-control"
                        >{{ $smsTemplate->message }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea
                            required
                            type="text"
                            name="description"
                            class="form-control"
                        >{{ $smsTemplate->description }}</textarea>
                    </div>
                </div>
                <div class="form-groupheads">
                    <h6 class="user-title">Enable</h6>
                    <div class="mx-2 active-switch">
                        <label class="switch">
                            <input type="hidden" name="is_enabled" value="0">
                            <input name="is_enabled"
                                   id="is-enabled"
                                   @checked($smsTemplate->is_enabled) value="1"
                                   type="checkbox">
                            <span class="sliders round"></span>
                        </label>
                    </div>
                </div>
                <div class="acc-submit pt-3">
                    <a href="{{ route('admin.sms-templates.index') }}"
                       class="btn btn-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
