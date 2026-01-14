@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">

            <div class="content-page-header content-page-headersplit">
                <h5> Request Quote </h5>
            </div>

            <form action="{{ route('provider.request-quotes.update', ['request_quote' => $requestQuote]) }}"
                  method="post"
                  class="row">
                @csrf
                @method('PUT')
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="col-lg-4 col-sm-12 m-auto">
                    <div class="mb-3">
                        <label class="form-label" for="status"> Status </label>
                        <select class="select" name="status" id="status">
                            @foreach(\App\Enums\RequestQuote\RequestQuoteStatusEnum::cases() as $status)
                                <option
                                    @selected($status->value === $requestQuote->status->value)
                                    value="{{ $status->value }}">{{ $status->name() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"> Internal Note </label>
                        <textarea class="form-control" name="internal_note" id="internal-note-input" cols="30" rows="10"
                        >{{ $requestQuote->internal_note }}</textarea>
                        <span class="validation-error" id="internal-note-error"></span>
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
                        <label class="form-label"> Sub Category </label>
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
                <div class="acc-submit pt-3">
                    <button id="submit" type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
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
        });

        $(function () {
            const internalNoteInput = $("#internal-note-input");
            const internalNoteError = $("#internal-note-error");
            const form = $("form");

            if (!internalNoteInput.length || !internalNoteError.length || !form.length) {
                return;
            }

            function validateInternalNote() {
                const value = internalNoteInput.val();

                if (value.length > 4000) {
                    internalNoteError.html("Internal note must not exceed 4000 characters.");
                    return false;
                } else {
                    internalNoteError.html("");
                    return true;
                }
            }

            internalNoteInput.on("input", validateInternalNote);

            // Перехватываем submit формы
            form.on("submit", function (e) {
                const isValid = validateInternalNote();

                if (!isValid) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();

                    internalNoteInput[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                    internalNoteInput.focus();

                    return false;
                }
            });
        });
    </script>
@endsection
