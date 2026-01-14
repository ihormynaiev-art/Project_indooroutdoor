@extends('layout.mainlayout')
@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Testimonials</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <div class="page-wrapper">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mx-auto">
                        <!-- /Service List -->
                        <form method="post" enctype="multipart/form-data" action="{{ route('provider.testimonials.update', $testimonial->id) }}">
                            @method('patch')
                            @csrf
                            <div class="profile-upload mb-3">
                                <h6 class="user-title">Image</h6>
                                <div class="pro-picture">
                                    <div class="pro-img">
                                        <img
                                            id="preview-image"
                                            src="{{ $testimonial->image?->url ?? url()->asset('/assets/img/profiles/avatar-02.jpg') }}"
                                            alt="user"
                                        >
                                    </div>
                                    <div class="pro-info">
                                        <div class="d-flex">
                                            <div class="img-upload">
                                                <i class="feather-upload-cloud me-1"></i>Upload
                                                <input id="image" name="image" type="file">
                                            </div>
                                            <a href="javascript:;" id="remove-image" class="btn btn-remove">Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Name *</label>
                                <input required value="{{ $testimonial->name }}" name="name" type="text" class="form-control">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Job Title</label>
                                <input value="{{ $testimonial->job_title }}" name="job_title" type="text" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Content *</label>
                                <textarea required name="content" class="form-control">{{ $testimonial->content }}</textarea>
                                <x-input-error :messages="$errors->get('content')" class="mt-2" />
                            </div>

                            <div class="form-groupheads d-flex d-flex mb-4">
                                <h6 class="user-title">Status</h6>
                                <div class="active-switch ms-2">
                                    <label class="switch">
                                        <input name="is_active" @checked($testimonial->is_active) value="1" type="checkbox">
                                        <span class="sliders round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="field-bottom-btns">
                                <div class="field-btns">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#image').change(function (){
                let reader = new FileReader();
                reader.onload = (e) => {
                    $("#preview-image").attr('src', e.target.result);
                }
                reader.readAsDataURL($(this)[0].files[0]);
            })

            $('#remove-image').on('click', function () {
                let id = {{ $testimonial->id }};

                Swal.fire({
                    title: "Remove Image",
                    text: "Are you sure want to remove image?",
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
                            url: `/provider/testimonials/${id}/image`,
                            type: 'DELETE',
                            data: {
                                '_method': 'DELETE',
                                "_token": $("input[name='_token']").val()
                            },
                            success: function(response) {
                                $("#preview-image").attr('src', response.imgSrc);
                            }
                        });
                    }
                });
            })
        });
    </script>
@endsection
