@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="row">
                <!-- Security Settings -->
                <div class="col-md-12">
                    <div class="widget-title">
                        <h4>Upload License & Insurance</h4>
                    </div>
                    <div class="linked-item">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="linked-acc">
                                    <span class="link-icon">
                                        <img src="{{ URL::asset('/assets/img/icons/document-pdf.svg') }}" alt="Icons">
                                    </span>
                                    <div class="linked-info">
                                        <h6>
                                            <a href="">
                                                Document Verification
                                            </a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <div class="verfification-modal-block">
                                    <a href="javascript:void(0);" class="btn btn-primary btn-connect" data-bs-toggle="modal"
                                        data-bs-target="#change-document">Change</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-12">
                    <div class="widget-title">
                        <h4>Categories</h4>
                    </div>
                    <div class="linked-item">
                        <div class="row">
                            <div class="col-md-3 fw-bold text-site-blue">
                                NAME
                            </div>
                            <div class="col-md-2 fw-bold text-site-blue text-center mx-4">
                                LICENSE REQUIRED
                            </div>
                            <div class="col-md-3 fw-bold text-site-blue text-center">
                                LICENSE VERIFIED AT
                            </div>
                            <div class="col-md-3 fw-bold text-site-blue text-center">
                                LICENSE EXPIRES ON
                            </div>
                        </div>
                        @foreach($categories as $category)
                        <div class="row mx-1">
                            <b>{{ $category->name }}</b>
                            @foreach($category->subCategories as $subcategory)
                                <div class="row" @if($loop->index % 2 == 0) style="background-color: #00c6ff30" @endif>
                                    <div class="col-md-3 mx-4">
                                        {{ $subcategory->name }}
                                    </div>
                                    <div class="col-md-2 text-center">
                                        {!! $subcategory->is_license_required ? '<i class="text-success fa-solid fa-circle-check fa-xl"></i>' : '-' !!}
                                    </div>
                                    <div class="col-md-3 text-center">
                                        {!! $subcategory->is_license_required ? $subcategory->license_verified_at ?: '<i class="text-danger fa-solid fa-circle-xmark fa-xl"></i>' : '-' !!}
                                    </div>
                                    <div class="col-md-3 text-center">
                                        @if($subcategory->is_license_required)
                                            <div @if(\Carbon\Carbon::create($subcategory->license_expires_on)->lt(now())) class="text-danger" @endif
                                                >{{ $subcategory->license_expires_on }}</div>
                                            @if($subcategory->license_expires_on)
                                            @if(\Carbon\Carbon::create($subcategory->license_expires_on)->lt(now()))
                                                <div class="text-danger">Expired</div>
                                            @endif
                                            @else
                                                <i class="text-danger fa-solid fa-circle-xmark fa-xl"></i>
                                                @endif
                                        @else
                                            <div>-</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>

                </div>
                <!-- /Security Settings -->
            </div>
        </div>
    </div>
    <div class="modal fade custom-modal verify-modal" id="change-document">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content doctor-profile">
                <div class="modal-header verfication-modal-head">
                    <h5 class="modal-title">Verify Your Identity</h5>
                    <p>Upload document</p>
                </div>
                <div class="modal-body">
                    <form action="provider-security-settings">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <input type="hidden" name="user_id" id="user-id" value="{{ $user->id }}">
                        <div class="wallet-add">
                            <div class="form-group">
                                <label>Document Name</label>
                                <input class="form-control" id="name" name="name" type="text">
                            </div>
                            <div class="file-uploaded-mail form-uploads-path">
                                <img src="{{ URL::asset('/assets/img/icons/upload-icon-02.svg') }}"
                                     class="img-fluid" alt="Upload">
                                <h4>Drag & drop files or <span> Browse </span></h4>
                                <p>Supported formats: PDF, JPEG, PNG, JPG</p>
                                <input type="file" id="file-input" class="image-upload">
                            </div>
                            <span class="text-danger" id="file-error"></span>
                            @if($files->isNotEmpty())
                                <div class="alert alert-info mt-3" role="alert">
                                    <i class="fa-solid fa-circle-info me-2"></i>
                                    To delete files, please contact us at <a href="mailto:info@indooroutdoor.com" class="alert-link">info@indooroutdoor.com</a>
                                </div>
                            @endif
                            @foreach($files as $file)
                                <div class="document-upload-file row">
                                    <div class="col-8">
                                        <a target="_blank" href="{{ url('storage/' . $file->path) }}">
                                            <img src="{{ $file->iconSrc }}" class="document-icon img-fluid"
                                                 alt="Pdf">
                                            {{ $file->name }}
                                        </a>
                                    </div>
                                    <div class="d-flex justify-content-between document-type-selection mt-2 col-12">
                                        <p class="mb-2 ms-0">Document type:</p>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input document-type-radio" type="radio"
                                                   name="document_type_{{ $file->id }}"
                                                   id="certificate-type-{{ $file->id }}"
                                                   value="certificate"
                                                   data-file-id="{{ $file->id }}"
                                                   {{ $file->type === 'certificate' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="certificate-type-{{ $file->id }}">
                                                Certificate
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input document-type-radio" type="radio"
                                                   name="document_type_{{ $file->id }}"
                                                   id="insurance-type-{{ $file->id }}"
                                                   value="insurance"
                                                   data-file-id="{{ $file->id }}"
                                                   {{ $file->type === 'insurance' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="insurance-type-{{ $file->id }}">
                                                Insurance
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="document-update-success d-none">
                                <p><i class="fa-regular fa-circle-check"></i> Document uploaded successfully </p>
                            </div>
                            <div class="mb-3 upload-file">
                                <a href="javascript:void(0);" class="btn btn-primary w-100">Upload</a>
                            </div>
                            <div class="modal-submit">
                                <a href="" class="btn btn-primary w-100" data-bs-toggle="modal"
                                   data-bs-target="#success-document">Continue</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
    var filePdfIconUrl = '{{ URL::asset('/assets/img/icons/certificate.png') }}'

    $(document).ready(function() {
        // Handle certificate deletion using event delegation
        $(document).on('click', '.delete-certificate', function() {
            var fileId = $(this).data('id');
            var certificateElement = $(this).closest('.document-upload-file');
            var isVerified = {{ $user->is_verified ? 'true' : 'false' }};

            // Function to perform the delete operation
            function performDelete() {
                $.ajax({
                    url: '{{ url("provider/certificates") }}/' + fileId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            certificateElement.fadeOut(300, function() {
                                $(this).remove();
                            });

                            // Update verification status UI
                            $('.linked-info p').text('Not Yet Verified');

                            // Replace check icon with X icon
                            $('.verfification-modal-block .link-close').attr('data-bs-title', 'Not Verified');
                            $('.verfification-modal-block .link-close i').removeClass('fa-circle-check').addClass('fa-circle-xmark');
                        }
                    }
                });
            }

            if (isVerified) {
                Swal.fire({
                    title: 'Warning',
                    text: 'Removing your certificate will hide your profile from the website. To restore it, upload a new certificate and wait for admin verification.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        performDelete();
                    }
                });
            } else {
                // If not verified, delete without warning
                performDelete();
            }
        });

        // Handle document type change for existing files
        $(document).on('change', '.document-type-radio', function() {
            var fileId = $(this).data('file-id');
            var documentType = $(this).val();

            // Show loading indicator or disable the radio buttons
            var radioButtons = $('input[name="document_type_' + fileId + '"]');
            radioButtons.prop('disabled', true);

            $.ajax({
                url: '{{ url("provider/certificates") }}/' + fileId + '/type',
                type: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}',
                    document_type: documentType
                },
                success: function(response) {
                    if (response.status === 'success') {
                        // Show success message
                        Swal.fire({
                            toast: true,
                            icon: 'success',
                            title: 'Document type updated successfully',
                            animation: false,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    }
                    // Re-enable radio buttons
                    radioButtons.prop('disabled', false);
                },
                error: function(response) {
                    // Show error message
                    Swal.fire({
                        toast: true,
                        icon: 'error',
                        title: 'Failed to update document type',
                        animation: false,
                        position: 'top-right',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });

                    // Revert to previous selection
                    if (documentType === 'certificate') {
                        $('#insurance-type-' + fileId).prop('checked', true);
                    } else {
                        $('#certificate-type-' + fileId).prop('checked', true);
                    }

                    // Re-enable radio buttons
                    radioButtons.prop('disabled', false);
                }
            });
        });
    });
</script>
@endsection
