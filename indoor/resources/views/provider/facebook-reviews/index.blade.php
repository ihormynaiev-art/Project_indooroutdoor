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
								<h6>Facebook Reviews</h6>
							</div>
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				@if($providerDetail->plan && !$providerDetail->plan->canShowFacebookReviews())
					<div class="alert alert-info">
						<h5>Facebook Reviews</h5>
						<p>Facebook Reviews integration is available with the <strong>Premium</strong> plan. Upgrade your plan to sync and display Facebook reviews on your profile.</p>
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
										<th>Rating</th>
										<th>Date</th>
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
    <script src="{{ URL::asset('/assets/js/facebook-reviews.js') }}"></script>
@endsection
