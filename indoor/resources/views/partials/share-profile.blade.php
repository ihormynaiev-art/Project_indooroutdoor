<div class="modal modal-sm fade custom-modal" id="share-profile">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content doctor-profile">
            <div class="modal-header border-bottom-0 justify-content-between pb-2">
                <h5 class="modal-title">SHARE PROFILE</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                        class="feather-x"></i></button>
            </div>
            <div class="modal-body pt-0">
                <div id="copy-link"
                     class="fw-bold mb-0 mx-2 theme-text my-4 cursor-pointer d-inline-flex align-items-center w-100"
                     data-link="{{ url()->current() }}">
                    <img class="mx-2" src="{{ asset('assets/img/icons/copy.png') }}" height="20" alt="Copy">
                    <span class="copy-text">Copy Share Link</span>
                </div>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="fw-bold mb-0 mx-2 theme-text my-4 cursor-pointer d-inline-flex align-items-center text-decoration-none w-100">
                    <img class="mx-2" src="{{ asset('assets/img/icons/fb-small.png') }}" height="20" alt="FB">
                    <span>Repost To Facebook</span>
                </a>
                <a href="https://x.com/intent/tweet?text={{ urlencode('Check out this profile on Indoor Outdoor: ' . url()->current()) }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="fw-bold mb-0 mx-2 theme-text my-4 cursor-pointer d-inline-flex align-items-center text-decoration-none w-100">
                    <img class="mx-2" src="{{ asset('assets/img/icons/x-small.png') }}" height="20" alt="X">
                    <span>Repost To X</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>

</script>

