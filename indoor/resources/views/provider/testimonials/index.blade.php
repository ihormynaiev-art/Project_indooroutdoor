@extends('layout.mainlayout')
@section('content')
		<div class="page-wrapper">
			<div class="content container-fluid">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col-md-8">
							<div class="provider-subtitle">
								<h6>Indoor Outdoor Reviews</h6>
							</div>
						</div>
                        @if(!$providerDetail->plan || $providerDetail->plan->canShowIndoorOutdoorReviews())
                            <div class="col-md-4 d-flex align-items-center justify-content-md-end flex-wrap">
                                <div class="d-flex generate-link-block align-items-center">
                                    <button id="generate-link" class="btn btn-primary add-set">Generate Link</button>
                                    <div class="info-icon-container ms-2">
                                        <img src="{{ asset('assets/img/icons/info-sign.png') }}" alt="Info">
                                        <div class="info-tooltip">
                                            <p>Send a Review Request to Your Customer</p>
                                            <ol>
                                                <li>Click Generate Link to create a personalized review request message.</li>
                                                <li>Click Copy to copy the full message with the link.</li>
                                                <li>Paste and send it to your customer by text, email, or however you prefer.</li>
                                            </ol>
                                            <p>Call the button "Generate Link"</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3 d-none" id="review-link-section">
                                    <div class="input-group-append m-auto pe-2">
                                        <button class="btn btn-outline-secondary" type="button" id="copyButton" title="Copy to clipboard">
                                            <i class="fa fa-copy"></i>
                                        </button>
                                    </div>
                                    <textarea rows="3" name="description" id="reviewLink" class="form-control" placeholder="Description...">{{ $providerDetail?->description }}</textarea>
                                </div>
                            </div>
                        @endif
					</div>
				</div>
				<!-- /Page Header -->

				@if($providerDetail->plan && !$providerDetail->plan->canShowIndoorOutdoorReviews())
					<div class="alert alert-info">
						<h5>Indoor Outdoor Reviews</h5>
						<p>Indoor Outdoor Reviews feature is not available with your current plan. Please upgrade to access this feature.</p>
						<p class="mb-0"><strong>Contact us at <a href="mailto:info@indooroutdoor.com">info@indooroutdoor.com</a> to upgrade your plan.</strong></p>
					</div>
				@else
					<div class="row">
						<div class="col-12 ">
							<div class="table-resposnive">
								<table class="table datatable" id="testimonials-data">
									<thead>
									<tr>
										<th>Nickname</th>
										<th>Email</th>
										<th>Title</th>
										<th>Rating</th>
										<th>Action</th>
									</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				@endif
			</div>
		</div>
@endsection

@section('scripts')
    <script src="{{ URL::asset('/assets/js/testimonials.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const copyButton = document.getElementById('copyButton');
            const reviewLinkInput = document.getElementById('reviewLink');

            if (copyButton && reviewLinkInput) {
                copyButton.addEventListener('click', function () {
                    reviewLinkInput.select();
                    reviewLinkInput.setSelectionRange(0, 99999); // Для мобільних пристроїв

                    try {
                        document.execCommand('copy');
                    } catch (err) {
                        console.error('Failed to copy text: ', err);
                    }
                });
            }

            // Info icon hover functionality
            $('.info-icon-container img').hover(
                function() {
                    $(this).siblings('.info-tooltip').fadeIn(200);
                },
                function() {
                    $(this).siblings('.info-tooltip').fadeOut(200);
                }
            );
        });

        $('#generate-link').on('click', function (){
            $.get({
                type: 'GET',
                url: "{{ route('provider.details.generate-review-link', $providerDetail->id) }}",
                data: {
                    '_method': 'GET',
                    "_token": "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response.status === "success") {
                        $('#reviewLink').val(response.message)
                        $('#review-link-section').removeClass('d-none');
                    }
                }
            });
        });
    </script>
@endsection
