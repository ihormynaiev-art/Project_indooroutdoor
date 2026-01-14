<div class="modal modal-lg fade custom-modal" id="request-quote">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content doctor-profile">
            <div class="modal-header border-bottom-0 justify-content-between">
                <h5 class="modal-title">QUOTATION FORM</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                        class="feather-x"></i></button>
            </div>
            <div class="modal-body pt-0">
                <form id="form" onsubmit="return false;" action="{{ route('request-quote.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="provider_id" id="provider_id" value="">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">Service Category</label>
                                <select required style="padding-bottom: 75px !important;" id="category" name="category_id" class="select">
                                    <option value="">Select Category</option>
                                    @foreach($menuCategories as $category)
                                        <option value="{{$category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="category_id-error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">Sub Category</label>
                                <select required style="padding-bottom: 75px !important;" id="sub-category" name="sub_category_id" class="select">
                                    <option value="" >Select a subcategory</option>
                                </select>
                                <span class="text-danger" id="sub_category_id-error"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label">Full Name</label>
                                <input required name="full_name" type="text" class="form-control" placeholder="">
                                <span class="text-danger" id="full_name-error"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label">Email</label>
                                <input required name="email" type="email" class="form-control" placeholder="">
                                <span class="text-danger" id="email-error"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label">Contact Number</label>
                                <input name="contact_number" type="number" class="form-control" placeholder="">
                                <span class="text-danger" id="contact_number-error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label">Area/City/Town</label>
                                <input required name="city" type="text" class="form-control" placeholder="">
                                <span class="text-danger" id="city-error"></span>
                            </div>
                        </div>
                        @php
                            $json = file_get_contents(public_path('../public/assets/json/states-array.json'));
                            $states = json_decode($json, true);
                        @endphp
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label">State</label>
                                <select required id="state" name="state" class="select">
                                    @foreach($states as $state)
                                        <option value="{{$state['name'] }}">{{ $state['name'] }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="state-error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label">Zipcode</label>
                                <input required name="zipcode" type="text" class="form-control" placeholder="">
                                <span class="text-danger" id="zipcode-error"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label">Details of the Project</label>
                                <textarea required rows="6" type="text" name="details" class="form-control"></textarea>
                                <span class="text-danger" id="details-error"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <x-file-upload-preview
                                inputId="documents"
                                previewClass="documents-preview"
                                uploadBtnId="upload-btn"
                                errorId="documents-error"
                                variableName="managedFiles"
                            />
                        </div>
                        <div class="col-md-12 mt-2">
                            <p>We NEVER share or sell your information. Your inquiry is directly forwarded to the most qualified service providers to handle your project. When they compete — you win!</p>
                        </div>
                        <div class="mt-2 d-flex">
                            {!! NoCaptcha::renderJs() !!}
                            {!! NoCaptcha::display() !!}
                        </div>
                        <span class="text-danger" id="g-recaptcha-response-error"></span>
                    </div>
                    <div class="row float-end">
                        <div class="col-md-5 coupon-submit">
                            <button type="submit" class="site-button site-button-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@section('scripts')
    <script>
        $('#request-quote').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const providerId = button.data('provider-id');
            const providerCategory = button.data('provider-categories');
            const providerSubcategory = button.data('provider-subcategories');

            if (providerId) {
                $('#provider_id').val(providerId);
            } else {
                $('#provider_id').val('');
            }

            if (providerCategory) {
                $('#category').val(providerCategory).trigger('change');
            }

            if (providerSubcategory) {
                setTimeout(function() {
                    $('#sub-category').val(providerSubcategory).trigger('change');
                }, 500);
            }

            // Pre-fill form fields if user is authenticated
            @auth
                $('input[name="full_name"]').val('{{ auth()->user()->name }}');
                $('input[name="email"]').val('{{ auth()->user()->email }}');
            @endauth
        });
        $('#categories').on('change', function() {
            $.ajax({
                url: '/categories/subcategories',
                type: 'GET',
                data: { categoriesIds : $(this).val() },
                dataType: 'json',
                success: function(response) {
                    $('#sub-categories').empty();
                    $.each(response.data, function(key, value) {
                        $('#sub-categories').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                    });
                }
            });
        });

        $('#form').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            // Add values from disabled select fields
            const categorySelect = document.getElementById('category');
            const subcategorySelect = document.getElementById('sub-category');

            if (categorySelect && categorySelect.disabled && categorySelect.value) {
                formData.set('category_id', categorySelect.value);
            }

            if (subcategorySelect && subcategorySelect.disabled && subcategorySelect.value) {
                formData.set('sub_category_id', subcategorySelect.value);
            }

            formData.delete('documents[]');

            window.managedFiles.forEach(file => {
                formData.append('documents[]', file);
            });

            $('.text-danger').html('');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function() {
                    Swal.fire({
                        title: "Your Request Has Been Submitted!",
                        html: "Your request is being sent to qualified contractors who specialize in exactly what you need. They will be contacting you shortly by your preferred method. <br><br> Sit back and relax — when they compete for your project, you win!",
                        icon: 'success',
                        animation: false,
                    })
                    $('#form').trigger('reset');
                    $('.select').val(null).trigger('change');
                    if (typeof window.clearFiles_managedFiles === 'function') {
                        window.clearFiles_managedFiles();
                    }
                    $('#request-quote').modal('hide');
                    grecaptcha.reset();
                },
                error: function(response) {
                    if (response.status === 422) {
                        var errors = response.responseJSON.errors;
                        $('.text-danger').html('');

                        var fileErrorDisplayed = false;

                        for (var key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                if (key.startsWith('documents.')) {
                                    if (!fileErrorDisplayed) {
                                        $('#documents-error').html(errors[key][0]);
                                        fileErrorDisplayed = true;
                                    }
                                } else {
                                    $('#' + key + '-error').html(errors[key][0]);
                                }
                            }
                        }

                        grecaptcha.reset();
                    }
                }
            });
        });

    </script>
    <script src="https://www.google.com/recaptcha/enterprise.js?render=6Le4i_spAAAAAMuWJrsbVPNHS2EfzIzBZfgdUn07"></script>
@endsection
