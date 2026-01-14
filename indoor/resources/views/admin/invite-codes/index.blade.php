@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">

            @component('admin.components.pageheader')
                @slot('title')
                    Invite Codes
                @endslot
                @slot('text')
                    Create Code
                @endslot
            @endcomponent

            <div class="row mb-3">
                <div class="col-12">
                    <div class="alert alert-info" role="alert">
                        <h5 class="alert-heading"><i class="fe fe-info me-2"></i>How Invite Codes Work</h5>
                        <p class="mb-2">Invite codes allow contractors to register with premium features and auto-approval:</p>
                        <ul class="mb-0">
                            <li><strong>Create Code:</strong> Generate a unique code linked to a plan (default: Premium)</li>
                            <li><strong>Share Link:</strong> Copy the registration link and send it to the contractor</li>
                            <li><strong>Auto-Approval:</strong> When a contractor registers with a valid code, they are automatically verified and can immediately build their profile</li>
                            <li><strong>Premium Benefits:</strong> Contractors get all premium plan features instantly</li>
                            <li><strong>One-Time Use:</strong> Each code can only be used once and expires when used or after the expiration date</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="col-12">
                    <div class="table-resposnive table-div">
                        <table class="table w-100" id="invite-codes-data">
                            <thead>
                            <tr>
                                <th>Code</th>
                                <th>Plan</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Expires</th>
                                <th>Used At</th>
                                <th>Used By</th>
                                <th style="text-align:right;">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Code Modal -->
    <div class="modal fade" id="create-code-modal" tabindex="-1" aria-labelledby="createCodeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCodeModalLabel">Create Invite Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="create-code-form">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="code" class="form-label">Code <span class="text-danger">*</span></label>
                            <div class="input-group has-validation">
                                <input type="text" class="form-control text-uppercase"
                                       id="code" name="code"
                                       required placeholder="Enter code"
                                       maxlength="20">
                                <button type="button" class="btn btn-outline-secondary"
                                        id="generate-code-btn"
                                        title="Generate random code">
                                    <i class="fa fa-random"></i>
                                </button>
                                <div class="invalid-feedback"></div>
                            </div>
                            <small class="text-muted">Enter a unique code or click the button to generate one</small>
                        </div>
                        <div class="mb-3">
                            <label for="plan_id" class="form-label">Plan <span class="text-danger">*</span></label>
                            <select class="form-select select" id="plan_id" name="plan_id" required>
                                @foreach($plans as $plan)
                                    <option value="{{ $plan->id }}" @selected($plan->name === 'premium')>{{ $plan->display_name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="expires_at" class="form-label">Expiration Date (Optional)</label>
                            <input type="text" class="form-control datepicker-expires" id="expires_at" name="expires_at" placeholder="mm/dd/yyyy">
                            <small class="text-muted">Leave empty for no expiration</small>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Code</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Code Generated Success Modal -->
    <div class="modal fade" id="code-success-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Code Created Successfully!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Registration Link:</label>
                        <div class="alert alert-light mb-0 p-3">
                            <code id="registration-url" style="font-size: 13px; word-break: break-all;"></code>
                        </div>
                    </div>
                    <p class="text-muted mb-3">Share this link with the contractor to enable their paid registration.</p>
                    <button type="button" class="btn btn-primary w-100" id="copy-link-btn">
                        <i class="fa fa-copy me-2"></i>Copy Registration Link
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @vite(['resources/js/admin/invite-codes.js'])
    <script>
        $(function() {
            // Initialize flatpickr when modal is shown
            $('#create-code-modal').on('shown.bs.modal', function () {
                if (!document.querySelector('.datepicker-expires')._flatpickr) {
                    flatpickr(".datepicker-expires", {
                        locale: "en",
                        dateFormat: "m/d/Y",
                        allowInput: true,
                        monthSelectorType: "dropdown",
                        minDate: "today",
                    });
                }
            });

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
        })
    </script>
@endsection
