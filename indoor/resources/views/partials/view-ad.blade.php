<div class="modal modal-lg fade custom-modal" id="ad-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content doctor-profile">
            <div class="modal-header border-bottom-0 justify-content-between pb-2">
                <h5 class="modal-title">ADVERTISEMENT</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                        class="feather-x"></i></button>
            </div>
            <div class="modal-body pt-0">
                <div class="owl-carousel ad-gallery-slider">
                    @foreach($providerDetail->adImages ?? [] as $certificate)
                        <div class="service-widget aos" data-aos="fade-up">
                            <div>
                                <a target="_blank" href="{{ url('storage/' . $certificate->path) }}">
                                    <img class="img-fluid serv-img" alt="Service Image"
                                         src="{{ url('storage/' . $certificate->path) }}">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

