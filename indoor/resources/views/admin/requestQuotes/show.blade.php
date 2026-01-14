@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">

            <div class="content-page-header content-page-headersplit">
                <h5> Request Quote </h5>
            </div>

            @if(is_null($requestQuote->provider_id))
                <form action="{{ route('admin.requestQuotes.update', compact('requestQuote')) }}"
                    method="post"
                    class="row mb-3">
                    @csrf
                    @method('put')
                    <div class="col-md-6">
                        <label for="provider">Provider</label>
                        <select name="provider_id" id="provider" class="select">
                            @foreach($providers as $providerDetail)
                                <option value="{{ $providerDetail->id }}"
                                >{{ $providerDetail->business_name . ' - ' . $providerDetail->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="my-3">
                        <button class="table-save">Save</button>
                    </div>
                </form>
            @endif

            <div class="row">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="col-lg-4 col-sm-12 m-auto">
                    <div class="mb-3">
                        <b class="text-black">Created At</b>
                        <p>{{ $requestQuote->created_at?->format('m/d/Y H:i A') }}</p>
                    </div>
                    <div class="mb-3">
                        <b class="text-black">Read At</b>
                        <p>{{ $requestQuote->read_at?->format('m/d/Y H:i A') ?: 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <b class="text-black">Status</b>
                        <p>{{ $requestQuote->status->name() }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"> Full Name </label>
                        <input
                            required
                            name="name"
                            disabled
                            type="text"
                            class="form-control"
                            value="{{ $requestQuote->full_name }}"
                        >
                    </div>
                    <div class="mb-3">
                        <label class="form-label"> Email </label>
                        <input
                            name="slug"
                            type="text"
                            required
                            disabled
                            class="form-control"
                            value="{{ $requestQuote->email }}"
                        >
                    </div>
                    <div class="mb-3">
                        <label class="form-label"> Number </label>
                        <input
                            name="slug"
                            type="text"
                            required
                            disabled
                            class="form-control"
                            value="{{ $requestQuote->contact_number }}"
                        >
                    </div>
                    <div class="mb-3">
                        <label class="form-label"> Category </label>
                        <input
                            name="slug"
                            type="text"
                            required
                            disabled
                            class="form-control"
                            value="{{ $requestQuote->category?->name }}"
                        >
                    </div>
                    <div class="mb-3">
                        <label class="form-label"> Category </label>
                        <input
                            name="slug"
                            type="text"
                            required
                            disabled
                            class="form-control"
                            value="{{ $requestQuote->subCategory?->name }}"
                        >
                    </div>
                    <div class="mb-3">
                        <label class="form-label"> Area/City/Town </label>
                        <input
                            name="slug"
                            type="text"
                            required
                            disabled
                            class="form-control"
                            value="{{ $requestQuote->city }}"
                        >
                    </div>
                    <div class="mb-3">
                        <label class="form-label"> State </label>
                        <input
                            name="slug"
                            type="text"
                            required
                            disabled
                            class="form-control"
                            value="{{ $requestQuote->state }}"
                        >
                    </div>
                    <div class="mb-3">
                        <label class="form-label"> Zipcode </label>
                        <input
                            name="slug"
                            type="text"
                            required
                            disabled
                            class="form-control"
                            value="{{ $requestQuote->zipcode }}"
                        >
                    </div>
                    <div class="mb-3">
                        <label class="form-label"> Provider </label>
                        @if($requestQuote->provider)
                            <div>
                                <b class="text-black">Page:</b>
                                <a href="{{ route('provider.details.show', $requestQuote->provider->slug) }}">
                                    {{ $requestQuote->provider->business_name }}
                                </a>
                            </div>
                            <div>
                                <b class="text-black">Edit:</b>
                                <a href="{{ route('admin.details.editById', $requestQuote->provider->user->id) }}">
                                    {{ $requestQuote->provider->business_name }}
                                </a>
                            </div>
                            <div>
                                <b class="text-black">User:</b>
                                <a href="{{ route('admin.homeowners.show', $requestQuote->provider->user->id) }}">
                                    {{ $requestQuote->provider->user->name }}
                                </a>
                            </div>
                        @else
                            <input
                                type="text"
                                disabled
                                class="form-control"
                                value="No provider"
                            >
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label"> Available At </label>
                        <input
                            type="text"
                            disabled
                            class="form-control"
                            value="{{ $requestQuote->available_at ? $requestQuote->available_at->format('m/d/Y H:i') : 'Immediately' }}"
                        >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Processed Status</label>
                        <div class="status-toggle d-flex justify-content-between align-items-center">
                            <input type="checkbox" id="processed-toggle"
                                   class="check" {{ $requestQuote->processed ? 'checked' : '' }}>
                            <label for="processed-toggle" class="checktoggle">checkbox</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"> Details </label>
                        <textarea
                            name="slug"
                            type="text"
                            required
                            disabled
                            class="form-control"
                        >{{ $requestQuote->details }}
                        </textarea>
                    </div>
                    <label class="form-label"> Documents </label>
                    @foreach($requestQuote->documents as $document)
                        <div class="user-files">
                            <a target="_blank" href="{{ url('storage/' . $document->path) }}">
                                <img src="{{ URL::asset('/assets/img/icons/file-pdf.svg') }}" class="img-fluid"
                                     alt="Pdf">
                                {{ $document->name }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div>
                <a class="btn btn-secondary" href="{{ route('admin.requestQuotes.index') }}">
                    Back
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#processed-toggle').on('change', function () {
                var isProcessed = $(this).prop('checked');

                $.ajax({
                    url: '{{ route("admin.requestQuotes.toggleProcessed", $requestQuote->id) }}',
                    type: 'PATCH',
                    data: {
                        _token: $('#token').val()
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            // Show success notification
                            Swal.fire({
                                title: "Status Updated",
                                text: "Request quote processed status has been updated.",
                                icon: "success",
                                confirmButtonText: "OK",
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            });
                        }
                    },
                    error: function () {
                        // Revert the toggle if there was an error
                        $('#processed-toggle').prop('checked', !isProcessed);

                        // Show error notification
                        Swal.fire({
                            title: "Error",
                            text: "There was an error updating the processed status.",
                            icon: "error",
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        });
                    }
                });
            });
        });
    </script>
@endsection
