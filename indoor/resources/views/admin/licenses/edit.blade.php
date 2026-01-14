@extends('layout.mainlayout_admin')
<style>

</style>
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">
            <div class="content-page-header content-page-headersplit">
                <h5>Edit Provider Licenses</h5>
            </div>

            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.licenses.update', ['license' => $providerDetail->id]) }}"
                  method="post"
                  class="row">
                @csrf
                @method('PUT')
                <div class="form-group col-md-3">
                    <label for="status">Status</label>
                    <select class="select" name="status" id="">
                        @foreach(\App\Enums\License\LicenseStatusEnum::cases() as $status)
                            <option
                                    @selected($files->first()?->status === $status->value)
                                    value="{{ $status->value }}">{{ $status->name() }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="content container-fluid">
                    <div class="widget-title">
                        <h4>Documents</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="linked-item">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>File</th>
                                                <th>Type</th>
                                                <th>Uploaded At</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($files as $file)
                                                <tr>
                                                    <td>
                                                        <a target="_blank" href="{{ url('storage/' . $file->path) }}">
                                                            {{ $file->name }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @if($file->type === 'certificate')
                                                            @if($loop->first)
                                                                <input type="hidden" name="file_id" value="{{ $file->id }}">
                                                            @endif
                                                            <div class="form-check">
                                                                <input class="form-check-input document-type-radio" type="radio"
                                                                       name="document_type_{{ $file->id }}"
                                                                       id="certificate-type-{{ $file->id }}"
                                                                       value="certificate"
                                                                       data-file-id="{{ $file->id }}"
                                                                    {{ $file->type === 'certificate' ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                       for="certificate-type-{{ $file->id }}">
                                                                    Certificate
                                                                </label>
                                                            </div>
                                                        @endif
                                                        @if($file->type === 'insurance')
                                                            <div class="form-check">
                                                                <input class="form-check-input document-type-radio" type="radio"
                                                                       name="document_type_{{ $file->id }}"
                                                                       id="insurance-type-{{ $file->id }}"
                                                                       value="insurance"
                                                                       data-file-id="{{ $file->id }}"
                                                                    {{ $file->type === 'insurance' ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                       for="insurance-type-{{ $file->id }}">
                                                                    Insurance
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $file->created_at?->format('m/d/Y H:i') ?? '-' }}
                                                    </td>
                                                    <td class="text-end">
                                                        <a href="javascript:void(0);"
                                                           class="delete-certificate"
                                                           data-id="{{ $file->id }}">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="widget-title my-4">
                                <h4>Categories</h4>
                            </div>
                            <div class="linked-item">
                                <div class="row">
                                    <div class="col-md-3 fw-bold text-site-blue">
                                        NAME
                                    </div>
                                    <div class="col-md-2 fw-bold text-site-blue text-center">
                                        LICENSE REQUIRED
                                    </div>
                                    <div class="col-md-3 fw-bold text-site-blue text-center">
                                        LICENSE VERIFIED AT
                                    </div>
                                    <div class="col-md-3 fw-bold text-site-blue text-center">
                                        LICENSE EXPIRED ON
                                    </div>
                                </div>
                                @foreach($categories as $category)
                                    <div class="row mx-1">
                                        <b>{{ $category->name }}</b>
                                        @foreach($category->subCategories as $subcategory)
                                            <div class="row" @if($loop->index % 2 == 0) style="background-color: #00c6ff30" @endif>
                                                <div class="col-md-3 d-flex justify-content-center flex-column" style="min-height: 42px;">
                                                    {{ $subcategory->name }}
                                                </div>
                                                <div class="col-md-2 text-center d-flex justify-content-center flex-column" style="min-height: 42px;">
                                                    {!! $subcategory->is_license_required ? '<i class="text-success fa-solid fa-circle-check fa-xl"></i>' : '-' !!}
                                                </div>
                                                @if($subcategory->is_license_required)
                                                    <input type="hidden" name="licenses[{{ $loop->index }}][id]"
                                                           value="{{ $subcategory->pivot_id }}">
                                                @endif
                                                <div class="col-md-3 d-flex justify-content-center">
                                                    @if($subcategory->is_license_required)
                                                        <div class="row justify-content-center">
                                                            <div style="width: 150px;">
                                                                <input class="form-control datepicker-fl-va"
                                                                       name="licenses[{{ $loop->index }}][license_verified_at]"
                                                                       value="{{ $subcategory->license_verified_at }}"
                                                                       type="text" />
                                                                <span id="startDateSelected"></span>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="d-flex justify-content-center flex-column">-</div>
                                                    @endif
                                                </div>
                                                <div class="col-md-3 d-flex justify-content-center">
                                                    @if($subcategory->is_license_required)
                                                        <div class="row justify-content-center">
                                                            <div style="width: 150px;">
                                                                <input class="form-control datepicker-fl-vt"
                                                                       name="licenses[{{ $loop->index }}][license_expires_on]"
                                                                       value="{{ $subcategory->license_expires_on }}"
                                                                       type="text" />
                                                                <span id="startDateSelected"></span>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="d-flex justify-content-center flex-column">-</div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="acc-submit pt-3">
                            <a href="{{ route('admin.licenses.index') }}"
                               class="btn btn-secondary">Cancel</a>
                            <button id="submit" type="submit" class="btn btn-primary">Save Changes</button>
                            <a href="{{ route('provider.details.show', $providerDetail->slug) }}"
                               target="_blank"
                               class="btn btn-success">Contractor Page</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).on("click", ".delete-certificate", function () {
            var text = 'Are you sure want to delete?'
            var id = $(this).data('id')
            var row = $(this).closest('tr');

            Swal.fire({
                title: "Delete document",
                text: text,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: "delete",
                cancelButtonText: "close",
                customClass: {
                    confirmButton: 'btn btn-primary mr-3',
                    cancelButton: 'btn btn-secondary'
                },
                showClass: {
                    popup: 'swal2-noanimation',
                    backdrop: 'swal2-noanimation'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/admin/certificates/' + id,
                        data: {
                            '_method': 'DELETE',
                            "_token": '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === "success") {
                                row.fadeOut(300, function() {
                                    $(this).remove();
                                });

                                Swal.fire({
                                    toast: true,
                                    icon: 'success',
                                    title: 'Document deleted successfully',
                                    animation: false,
                                    position: 'top-right',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                toast: true,
                                icon: 'error',
                                title: 'Failed to delete document',
                                animation: false,
                                position: 'top-right',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        flatpickr(".datepicker-fl-va", {
            locale: "en",
            dateFormat: "m/d/Y",
            allowInput: true,
            monthSelectorType: "dropdown",
            minDate: "today",
        });

        flatpickr(".datepicker-fl-vt", {
            locale: "en",
            dateFormat: "m/d/Y",
            allowInput: true,
            monthSelectorType: "dropdown",
            minDate: "today",
        });
    });
</script>
