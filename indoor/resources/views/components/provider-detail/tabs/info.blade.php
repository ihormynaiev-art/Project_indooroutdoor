<div class="tab-pane fade show active" id="provider-details"
     role="tabpanel" aria-labelledby="provider-details-tab" tabindex="0">
    <div class="d-sm-none w-100 h5-service-details-blue mb-4 provider-details text-center">
        <h5 class="h5-service-details-blue py-2">Provider Details</h5>
    </div>
    @if($providerDetail->description)
        <div class="provider-details mb-4 provider-description p-2 text-site-blue">
            {{ $providerDetail->description }}
        </div>
    @endif
    @if(count($providerDetail->certificates) > 0)
        <div class="provider-details">
            <div class="text-center text-sm-start">
                <h5 class="h5-service-details-blue py-2">License</h5>
            </div>
            <div class="d-flex provider-description p-2 flex-wrap">
                @foreach($providerDetail->certificates as $certificate)
                    <div class="document-upload-file my-0">
                        @if($certificate->type === 'certificate')
                            <a target="_blank"
                               class="d-flex text-black"
                               href="{{ url('storage/' . $certificate->path) }}">
                                <img src="{{ asset('assets/img/icons/license.png') }}"
                                     height="70"
                                     alt="Pdf">
                                <p class="mx-2">{{ $certificate->name }}</p>
                            </a>
                        @endif
                        @if($certificate->type === 'insurance')
                            <a target="_blank"
                               class="d-flex text-black"
                               href="{{ url('storage/' . $certificate->path) }}">
                                <img src="{{ asset('assets/img/insurance.png') }}"
                                     height="70"
                                     alt="Pdf">
                                <p class="mx-2">{{ $certificate->name }}</p>
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
