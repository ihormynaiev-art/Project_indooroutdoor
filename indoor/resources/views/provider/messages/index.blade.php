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
								<h6>Messages</h6>
							</div>
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				@if($providerDetail->plan && !$providerDetail->plan->hasContactButton('message_provider'))
					<div class="alert alert-info">
						<h5>Provider Messages</h5>
						<p>Provider messaging feature is available with the <strong>Premium</strong> plan. Upgrade your plan to receive and respond to messages from customers.</p>
						<p class="mb-0"><strong>Contact us at <a href="mailto:info@indooroutdoor.com">info@indooroutdoor.com</a> to upgrade your plan.</strong></p>
					</div>
				@else
					<div class="row">
						<div class="col-12 ">
							<div class="table-resposnive">
								<table class="table datatable" id="testimonials-data">
									<thead>
									<tr>
										<th>Contact</th>
										<th>Message</th>
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
    <script src="{{ asset('assets/js/provider-messages.js') }}"></script>
@endsection
