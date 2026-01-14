@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">

            <div class="content-page-header content-page-headersplit">
                <h5>Sms Message</h5>
            </div>

            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Phone:</label>
                        <input
                            type="text"
                            name="message"
                            class="form-control"
                            value="{{ $smsMessage->phone }}"
                            disabled
                        >
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Message:</label>
                        <textarea
                            disabled
                            type="text"
                            name="message"
                            class="form-control"
                        >{{ $smsMessage->message }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Created At:</label>
                        <p><span class="text-black">{{ $smsMessage->created_at?->format('F d, Y h:i A') ?? 'N/A' }}</span></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Sent At:</label>
                        <p><span class="text-black">{{ $smsMessage->sent_at?->format('F d, Y h:i A') ?? 'N/A' }}</span></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status:</label>
                        <p><span>{{ $smsMessage->status }}</span></p>
                    </div>
                    @if($smsMessage->error_message)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Error Message:</label>
                            <p class="text-danger">{{ $smsMessage->error_message }}</p>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label fw-bold">Template:</label>
                        <p>
                            <a href="{{ route('admin.sms-templates.edit', ['sms_template' => $smsMessage->smsTemplate]) }}"
                            >{{ $smsMessage->smsTemplate->label }}</a>
                        </p>
                    </div>
                    @if($smsMessage->providerDetail)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Provider</label>
                            <p>
                                <a href="{{ route('provider.details.show', ['providerDetail' => $smsMessage->providerDetail]) }}"
                                >{{ $smsMessage->providerDetail->business_name }}</a>
                            </p>
                        </div>
                    @endif
                </div>
                <div>
                    <a class="btn btn-secondary" href="{{ route('admin.sms-messages.index') }}">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
