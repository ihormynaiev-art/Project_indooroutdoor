@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">

            <div class="content-page-header content-page-headersplit">
                <h5> Edit Landing </h5>
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-primary" id="generate-qr-btn">
                        <i class="fa fa-qrcode me-2"></i>Generate QR Code
                    </button>
                </div>
            </div>
            <div id="qr-warning" class="alert alert-warning" style="display: none;">
                <i class="fa fa-exclamation-triangle me-2"></i>Please save your changes before generating QR code
            </div>

            <div class="row">
                <x-admin.landing-form
                    :landing="$landing"
                    :providerDetail="$providerDetail"
                    :action="route('admin.landings.update', $landing)"
                    method="PUT"
                />
            </div>
        </div>
    </div>

    <!-- QR Code Modal -->
    <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Landing Page QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div id="qr-code-container" class="mb-3 d-flex justify-content-center"></div>
                    <p class="text-muted small mb-0" id="qr-url"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-qr-btn">
                        <i class="fa fa-download me-2"></i>Save QR Code
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <script>
        $(function() {
            @if(session('status'))
            Swal.fire({
                toast: true,
                icon: 'success',
                title: @json(session('status')),
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
            @endif

            // QR Code functionality
            const originalSlug = @json($landing->slug);
            const providerSlug = @json($providerDetail->slug);
            let slugChanged = false;
            let qrCodeInstance = null;

            // Track slug changes
            $('#slug-input').on('input', function() {
                const currentSlug = $(this).val();
                slugChanged = currentSlug !== originalSlug;
                updateQRButtonState();
            });

            // Update QR button state
            function updateQRButtonState() {
                const $btn = $('#generate-qr-btn');
                const $warning = $('#qr-warning');

                if (slugChanged) {
                    $btn.prop('disabled', true).addClass('disabled');
                    $warning.slideDown();
                } else {
                    $btn.prop('disabled', false).removeClass('disabled');
                    $warning.slideUp();
                }
            }

            // Generate QR Code
            $('#generate-qr-btn').on('click', function() {
                if (slugChanged) {
                    return;
                }

                const currentSlug = $('#slug-input').val();
                const landingUrl = `${window.location.origin}/provider-details/${providerSlug}/${currentSlug}`;

                // Clear previous QR code
                $('#qr-code-container').empty();

                // Generate new QR code
                qrCodeInstance = new QRCode(document.getElementById('qr-code-container'), {
                    text: landingUrl,
                    width: 256,
                    height: 256,
                    colorDark: '#000000',
                    colorLight: '#ffffff',
                    correctLevel: QRCode.CorrectLevel.H
                });

                // Update URL display
                $('#qr-url').text(landingUrl);

                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('qrCodeModal'));
                modal.show();
            });

            // Save QR Code
            $('#save-qr-btn').on('click', function() {
                const canvas = $('#qr-code-container canvas')[0];
                if (canvas) {
                    const url = canvas.toDataURL('image/png');
                    const link = document.createElement('a');
                    link.download = `landing-qr-${$('#slug-input').val()}.png`;
                    link.href = url;
                    link.click();
                }
            });

            // Reset slug tracking after form submit
            $('form').on('submit', function() {
                slugChanged = false;
            });
        })
    </script>
@endsection
