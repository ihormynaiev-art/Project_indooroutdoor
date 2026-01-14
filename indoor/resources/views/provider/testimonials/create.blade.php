@extends('layout.mainlayout')
@section('content')
    @if(session('status'))
        <div class="toast top-25 end-0 position-fixed align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('status') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif
    @component('components.breadcrumb')
        @slot('title')
            Review form
        @endslot
    @endcomponent

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 justify-content-center">
                    <div class="review">
                        <h3 class="text-center">Write a Review</h3>
                        <form id="testimonial-form" action="{{ route('testimonials.store', $reviewToken->token) }}" method="post">
                            @method('POST')
                            @csrf
                            <div class="row">
                                @if($providerDetail->user->is_verified)
                                    <a
                                        class="h3"
                                        target="_blank"
                                        href="{{ route('provider.details.show', $providerDetail->slug) }}"
                                    >
                                        {{ $providerDetail->business_name }}
                                    </a>
                                @else
                                    <span class="h3">{{ $providerDetail->business_name }}</span>
                                @endif
                                <input hidden type="text" name="provider_detail_id" value="{{ $providerDetail->id }}" />
                                <label class="col-form-label">Overall Rating*</label>
                                <div class="star-rating justify-content-end">
                                    <input type="radio" name="rating" value="5" id="5"><label for="5">&#9733;</label>
                                    <input type="radio" name="rating" value="4" id="4"><label for="4">&#9733;</label>
                                    <input type="radio" name="rating" value="3" id="3"><label for="3">&#9733;</label>
                                    <input type="radio" name="rating" value="2" id="2"><label for="2">&#9733;</label>
                                    <input type="radio" name="rating" value="1" id="1"><label for="1">&#9733;</label>
                                </div>
                                    <span class="text-danger" id="review-rating-error"></span>

                                <div class="col-md-6 justify-content-center review-form">
                                    <label class="col-form-label">Would you recommend this service to friend?(Optional)</label>
                                    <div class="form-group text-black">
                                        <input type="radio" name="would_recommend" value="1" id="yes"><label class="ps-1">Yes</label>
                                        <input type="radio" name="would_recommend" value="0" id="no"><label class="ps-1">No</label>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="title" type="text" placeholder="Review title (Optional)">
                                    </div>
                                    <div class="form-group">
                                        <textarea name="review" class="form-control" rows="4" placeholder="Your Review (Optional)"></textarea>
                                    </div>
                                    <div class="file-upload drag-file-area">
                                        <img src="{{ URL::asset('/assets/img/icons/upload-icon.svg') }}" alt="image">
                                        <h6>Drag & drop files or <span>Browse</span></h6>
                                        <p>Supported formats: JPEG, PNG, JPG, MP4</p>
                                        @foreach($errors->get('files.*') as $fileErrors)
                                            @foreach($fileErrors as $error)
                                                <x-input-error class="file-error" class="mt-2" :messages="$error" />
                                            @endforeach
                                        @endforeach
                                        <x-input-error :messages="$errors->get('files')" class="mt-2" />
                                        <input accept="image/png, image/jpeg, image/jpg,video/mp4,video/x-m4v,video/*" id="file-input" multiple name="files[]" type="file">
                                    </div>
                                    <div class="file-preview">
                                        <ul class="gallery-selected-img">

                                        </ul>
                                    </div>
                                    <label class="col-form-label">About you</label>
                                    <div class="form-group">
                                        <input class="form-control" name="nickname" type="text" placeholder="Your Nickname">
                                        <span class="text-danger" id="review-nickname-error"></span>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" name="email" type="email" placeholder="Your Email">
                                        <span class="text-danger" id="review-email-error"></span>
                                    </div>
                                </div>
                                <div class="row float-end">
                                    <div class="col-md-5 coupon-submit">
                                        <button type="submit" class="btn btn-primary">Submit Review</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Get In Touch -->
        </div>
    </div>
@endsection
@section('scripts')
    <script>
            $('#testimonial-form').on('submit', function (e) {
                e.preventDefault();
                let formData = new FormData(this);
                $('.text-danger').html('');

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        Swal.fire({
                            toast: true,
                            icon: 'success',
                            title: 'Send successfully',
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
                        $('#testimonial-form').trigger('reset');
                        $('li .img-preview').each(function () {
                            $(this).remove();
                        });
                    },
                    error: function (response) {
                        if (response.status === 422) {
                            var errors = response.responseJSON.errors;
                            for (var key in errors) {
                                if (errors.hasOwnProperty(key)) {
                                    $('#review-' + key + '-error').html(errors[key][0]);
                                }
                            }
                        }
                        if (response.responseJSON.message) {
                            Swal.fire({
                                toast: true,
                                icon: 'error',
                                title: response.responseJSON.message,
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
                        }
                    }
                });
            });
    </script>
@endsection

