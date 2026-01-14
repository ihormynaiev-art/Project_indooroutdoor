@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" id="form" enctype="multipart/form-data"
                          action="{{ route('provider.details.update', $providerDetail->id) }}">
                        @csrf
                        @method('patch')
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <div class="widget-title">
                            <h4>Contractor Profile Setup</h4>
                        </div>
                        @if(auth()->user()->hasRole(['admin', 'super admin']))
                            <div class="row w-100">
                                <div class="col-md-6 my-2">
                                    <div class="form-groupheads">
                                        <h6 class="user-title">Verification</h6>
                                        <div class="mx-2 active-switch">
                                            <label class="switch">
                                                <input name="is_verified" data-id="{{ $providerDetail->user->id }}"
                                                       id="is-verified"
                                                       @checked($providerDetail->user->is_verified) value="1"
                                                       type="checkbox">
                                                <span class="sliders round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="form-groupheads mt-3">
                                        <h6 class="user-title">Plan</h6>
                                        <div class="mx-2">
                                            <select name="plan_id" class="form-control select">
                                                @foreach(\App\Models\Plan::active()->orderBy('sort_order')->get() as $plan)
                                                    <option value="{{ $plan->id }}"
                                                        @selected($providerDetail->plan_id == $plan->id)>
                                                        {{ $plan->display_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                        @endif
                        <div class="pro-picture d-flex justify-content-between align-items-center">
                            <div class="row w-100">
                                <div class="col-md-6 my-2">
                                    <h6 class="user-title">Business Logo</h6>
                                    <div class="d-flex">
                                    <div class="pro-img">
                                        <img id="preview-logo" src="{{ $logoPath }}" alt="logo">
                                    </div>
                                    <div class="pro-info">
                                        <div class="d-flex">
                                            <div class="img-upload">
                                                <i class="feather-upload-cloud me-1"></i>Upload
                                                <input id="logo" name="logo" type="file">
                                            </div>
                                            <a href="javascript:;" id="remove-logo" class="btn btn-remove">Remove</a>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                @if($providerDetail->plan?->canUploadBackground())
                                    <div class="col-md-6 my-2">
                                        <h6 class="user-title">Background Image</h6>
                                        <div class="d-flex">
                                            <div class="pro-back-img">
                                                <img id="preview-background" src="{{ $backgroundPath }}" alt="background">
                                            </div>
                                            <div class="pro-info">
                                                <div class="d-flex">
                                                    <div class="img-upload">
                                                        <i class="feather-upload-cloud me-1"></i>Upload
                                                        <input id="background" name="background" type="file">
                                                    </div>
                                                    <a href="javascript:;" id="remove-background"
                                                       class="btn btn-remove m-0 mt-3 mx-2">Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-6 my-2">
                                        <div class="alert alert-info">
                                            <h6>Background Image</h6>
                                            <p>Background image upload is available with the <strong>Premium</strong> plan. Upgrade to customize your profile with a background image.</p>
                                            <p class="mb-0"><strong>Contact us at <a href="mailto:info@indooroutdoor.com">info@indooroutdoor.com</a> to upgrade your plan.</strong></p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <h6 class="user-title">General Information</h6>
                        <div class="general-info">
                            <div class="form-groupheads d-flex">
                                <div class="mx-2 active-switch">
                                    <label class="switch">
                                        <input name="is_sms_enabled" data-id="{{ $providerDetail->id }}"
                                               id="is-sms-enabled"
                                               @checked($providerDetail->is_sms_enabled) value="1"
                                               type="checkbox">
                                        <span class="sliders round"></span>
                                    </label>
                                </div>
                                <p class="text-site-blue">SMS Notifications</p>
                            </div>
                            @if(auth()->user()->hasRole(['admin', 'super admin']))
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Email*</label>
                                            <input class="form-control" required type="email" name="email"
                                                   value="{{ $providerDetail->user->email }}"
                                                   maxlength="200"/>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Business Name*</label>
                                        <input class="form-control" required type="text" name="business_name"
                                               value="{{ $providerDetail->business_name }}"
                                               maxlength="200"/>
                                        <small class="text-muted">Max 200 characters.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Contact Phone Number*</label>
                                        <input class="form-control" required type="tel" name="phone"
                                               value="{{ $providerDetail->phone }}"
                                               maxlength="15"
                                               id="phone-input"
                                               pattern="[0-9]{1,15}"/>
                                        <small class="text-muted">Phone number must be in valid format (max 15 digits).</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Select all applicable subcategories*</label>
                                        <select id="sub-categories" name="sub_categories[]" required multiple class="select">
                                            @foreach($subCategories as $subCategory)
                                                <option
                                                    @selected(in_array($subCategory->id, $selectedSubCategories))
                                                    value="{{ $subCategory->id }}"
                                                    data-parent-id="{{$subCategory->parent->id}}"
                                                >
                                                    {{ $subCategory->name }} ({{ $subCategory->parent->name }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Selected categories of service</label>
                                        <select readonly disabled name="categories[]" id="categories" multiple
                                                class="select">
                                            @foreach($categories as $category)
                                                <option @selected(in_array($category->id, $selectedCategories))
                                                        value="{{ $category->id }}"
                                                >
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div id="categories-hidden-wrapper"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-form-label d-block">Business Overview</label>
                                        <textarea rows="6" name="description" class="form-control"
                                                  placeholder="Write an engaging summary of your services, specialties, and the areas you serve to attract homeowners searching for your expertise. Need help crafting an engaging summary for your business? Contact your account representative for assistance."
                                        >{{ $providerDetail->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h6 class="user-title">Social Profiles</h6>
                        <div class="general-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-form-label d-block">Website url</label>
                                    <input
                                        name="website_url"
                                        value="{{ $providerDetail->website_url }}"
                                        class="form-control"
                                        placeholder="Ex. www.socialmedia.com"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label d-block">Facebook url</label>
                                    <input
                                        name="facebook_url"
                                        value="{{ $providerDetail->facebook_url }}"
                                        class="form-control"
                                        placeholder="Ex. www.socialmedia.com"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label d-block">X url</label>
                                    <input
                                        name="x_url"
                                        value="{{ $providerDetail->x_url }}"
                                        class="form-control"
                                        placeholder="Ex. www.socialmedia.com"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label d-block">Instagram url</label>
                                    <input
                                        name="instagram_url"
                                        value="{{ $providerDetail->instagram_url }}"
                                        class="form-control"
                                        placeholder="Ex. www.socialmedia.com"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label d-block">Youtube url</label>
                                    <input
                                        name="youtube_url"
                                        value="{{ $providerDetail->youtube_url }}"
                                        class="form-control"
                                        placeholder="Ex. www.socialmedia.com"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="general-info">
                            <div class="row">
                                <div id="gallery" class="">
                                    <div class="sub-title">
                                        <h6 class="mt-3 mb-1">Project Gallery</h6>
                                        <span>Upload photos to showcase your completed projects. This is a great way to help homeowners see the quality of your work!</span>
                                        @if($providerDetail->plan)
                                            @php
                                                $maxVisiblePhotos = $providerDetail->plan->getFeature('max_portfolio_photos');
                                                $currentPhotosCount = $providerDetail->portfolioImages->count();
                                            @endphp
                                            <div class="alert alert-{{ $currentPhotosCount > $maxVisiblePhotos ? 'warning' : 'info' }} mt-2">
                                                <strong>Photo Display Limit:</strong> Your {{ $providerDetail->plan->display_name }} plan displays up to {{ $maxVisiblePhotos }} photos on your public profile.
                                                @if($currentPhotosCount > $maxVisiblePhotos)
                                                    You have {{ $currentPhotosCount }} photos, but only the first {{ $maxVisiblePhotos }} will be visible to visitors.
                                                @endif
                                                @if($providerDetail->plan->isLite())
                                                    @php
                                                        $premiumPlan = \App\Models\Plan::where('name', 'premium')->first();
                                                        $premiumPhotoLimit = $premiumPlan?->getFeature('max_portfolio_photos', 20);
                                                    @endphp
                                                    <br><strong>Upgrade to Premium</strong> to display up to {{ $premiumPhotoLimit }} photos!
                                                    <br>Contact us at <a href="mailto:info@indooroutdoor.com">info@indooroutdoor.com</a> to upgrade your plan.
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <div class="file-upload drag-file-area">
                                        <img src="{{ URL::asset('/assets/img/icons/upload-icon.svg') }}" alt="image">
                                        <h6>Drag & drop files or <span>Browse</span></h6>
                                        <p>Supported formats: JPEG, PNG, JPG</p>
                                        @foreach($errors->get('files.*') as $fileErrors)
                                            @foreach($fileErrors as $error)
                                                <x-input-error class="file-error" class="mt-2" :messages="$error"/>
                                            @endforeach
                                        @endforeach
                                        <input accept="image/png, image/jpeg, image/jpg" id="file-input" multiple
                                               name="files[]" type="file">
                                    </div>
                                    <div class="file-preview">
                                        <ul class="gallery-selected-img">
                                            @foreach($providerDetail->portfolioImages as $image)
                                                <li class="images-prio">
                                                    <div class="img-preview">
                                                        <img src="{{ url('storage/' . $image->path) }}"
                                                             alt="Service Image">
                                                        <a
                                                            href="javascript:void(0);"
                                                            onclick="removeElementFromHiddenArray({{ $image->id }})"
                                                            data-name=""
                                                            data-id="{{ $image->id }}"
                                                            class="remove-gallery"
                                                        >
                                                            <i class="feather-trash-2"></i>
                                                        </a>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <input type="hidden" name="images" id="images" value="{{ $imagesIdsJson }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="order" id="orderInput">
                        <div class="acc-submit pt-3">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                            <a href="{{ route('provider.details.show', $providerDetail?->slug) }}"
                               class="btn btn-primary">Preview</a>
                            <button id="submit" type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @component('components.model-popup')
    @endcomponent
@endsection

@section('scripts')
    <script>
        $(function () {
            // Restrict phone input to numbers only and max 15 digits
            $('#phone-input').on('input', function() {
                // Remove all non-digit characters
                let value = this.value.replace(/\D/g, '');
                // Limit to 15 digits
                if (value.length > 15) {
                    value = value.slice(0, 15);
                }
                this.value = value;
            });

            $('#is-verified').on('change', function () {
                let id = $(this).data('id')
                $.ajax({
                    type: 'PATCH',
                    url: '/admin/contractors/' + id + "/updateIsVerified",
                    data: {
                        '_method': 'PATCH',
                        "_token": $('#token').val(),
                        'is_verified': $(this).prop('checked')
                    },
                    success: function (response) {
                        if (response.status === "success") {
                            Swal.fire({
                                toast: true,
                                icon: 'success',
                                title: 'Verification status updated successfully',
                                animation: false,
                                position: 'top-right',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                        }
                    }
                });
            });


            $('#is-sms-enabled').on('change', function() {
                let id = $(this).data('id')
                $.ajax({
                    type: 'PATCH',
                    url: '/provider/' + id + "/updateIsSmsEnabled",
                    data: {
                        '_method': 'PATCH',
                        "_token": $('#token').val(),
                        'is_sms_enabled': $(this).prop('checked')
                    },
                    success: function(response) {
                        if (response.status === "success") {
                        }
                    }
                });
            })

            $('.info-icon-container img').hover(
                function () {
                    $(this).siblings('.info-tooltip').fadeIn(200);
                },
                function () {
                    $(this).siblings('.info-tooltip').fadeOut(200);
                }
            );

            var el = document.querySelector('.gallery-selected-img');
            var sortable = new Sortable(el, {
                animation: 150,
                onEnd: function (evt) {
                    updateOrderInput();
                }
            });

            $('#submit').on('click', function () {
                updateOrderInput();
            })

            $('form').on('keypress', function (e) {
                if (e.which === 13) {
                    e.preventDefault();
                    return false;
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

            function updateOrderInput() {
                var order = [];
                $('.gallery-selected-img .img-preview a').each(function (index, element) {
                    var id = $(element).data('id');
                    order.push(id);
                });
                $('#orderInput').val(order.join(','));
            }

            $('#background').change(function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $("#preview-background").attr('src', e.target.result);
                }
                reader.readAsDataURL($(this)[0].files[$(this)[0].files.length - 1]);
            })

            $('#logo').change(function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $("#preview-logo").attr('src', e.target.result);
                }
                reader.readAsDataURL($(this)[0].files[$(this)[0].files.length - 1]);
            })

            $('#remove-logo').on('click', function () {
                var id = {{ $providerDetail->id }};

                Swal.fire({
                    title: "Remove Logo",
                    text: "Are you sure want to remove logo?",
                    showCancelButton: true,
                    focusConfirm: false,
                    confirmButtonText: "Delete",
                    cancelButtonText: "Close",
                    customClass: {
                        confirmButton: 'btn btn-primary mr-3',
                        cancelButton: 'btn btn-secondary'
                    },
                    showClass: {
                        popup: 'swal2-noanimation',
                        backdrop: 'swal2-noanimation'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/provider/details/${id}/logo`,
                            type: 'DELETE',
                            data: {
                                '_method': 'DELETE',
                                "_token": $("input[name='_token']").val()
                            },
                            success: function (response) {
                                $("#preview-logo").attr('src', response.imgSrc);
                            }
                        });
                    }
                });
            })

            $('#remove-background').on('click', function () {
                var id = {{ $providerDetail->id }};

                Swal.fire({
                    title: "Remove Background",
                    text: "Are you sure want to remove background?",
                    showCancelButton: true,
                    focusConfirm: false,
                    confirmButtonText: "Delete",
                    cancelButtonText: "Close",
                    customClass: {
                        confirmButton: 'btn btn-primary mr-3',
                        cancelButton: 'btn btn-secondary'
                    },
                    showClass: {
                        popup: 'swal2-noanimation',
                        backdrop: 'swal2-noanimation'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/provider/details/${id}/background`,
                            type: 'DELETE',
                            data: {
                                '_method': 'DELETE',
                                "_token": $("input[name='_token']").val()
                            },
                            success: function (response) {
                                $("#preview-background").attr('src', response.imgSrc);
                            }
                        });
                    }
                });
            })

            function updateHiddenCategories() {
                var selectedValues = [];
                $('#categories option').each(function () {
                    if ($(this).is(':selected')) {
                        selectedValues.push($(this).val());
                    }
                });

                // очищаем старые скрытые input
                $('#categories-hidden-wrapper').html('');

                // создаём скрытые input для каждого значения
                selectedValues.forEach(function (val) {
                    $('#categories-hidden-wrapper').append(
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'categories[]',
                            value: val
                        })
                    );
                });
            }

// вызывать при изменении sub-categories
            $('#sub-categories').on('select2:select select2:unselect', updateHiddenCategories);

// и перед отправкой формы, чтобы точно обновить
            $('form').on('submit', updateHiddenCategories);

            $('#sub-categories').on('select2:select', function (e) {
                let parentId = e.params.data.element.dataset.parentId;
                var currentValues = $('#categories').val() || [];
                currentValues.push(parentId);
                $('#categories').val(currentValues).trigger('change');
            });
            $('#sub-categories').on('select2:unselect', function () {
                var selectedValues = $(this).val() || [];

                var parentIds = [];

                selectedValues.forEach(function (value) {
                    var $option = $('#sub-categories option[value="' + value + '"]');

                    var parentId = $option.data('parent-id');

                    if (parentId !== undefined) {
                        parentIds.push(parentId);
                    }
                });

                $('#categories').val(parentIds).trigger('change');
            });
        });

        function removeElementFromHiddenArray(id) {
            const hiddenInput = document.getElementById('images');

            let array = JSON.parse(hiddenInput.value);
            array = array.filter(item => item !== id);
            hiddenInput.value = JSON.stringify(array);
        }

        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -33.8688, lng: 151.2195},
                zoom: 13
            });
            var input = document.getElementById('searchInput');
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);

            var infowindow = new google.maps.InfoWindow();
            var marker = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -29)
            });

            $('#remove-marker').on('click', function () {
                removeMarker();
            });

            var service = new google.maps.places.PlacesService(map);
            let placeId = "{{ $providerDetail->google_place_id }}"

            if (placeId) {
                service.getDetails({
                    placeId: placeId
                }, function (result, status) {
                    if (status != google.maps.places.PlacesServiceStatus.OK) {
                        return;
                    }
                    map.setCenter(result.geometry.location);

                    addMarker(result)
                });
            }

            autocomplete.addListener('place_changed', function () {
                infowindow.close();
                marker.setVisible(false);
                var place = autocomplete.getPlace();

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }
                addMarker(place)
            });

            function addMarker(place) {
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

                if (place.place_id) {
                    $("#place-id-input").val(place.place_id)
                    $("#formatted_address-input").val(place.formatted_address)
                }
                $('#remove-marker').prop("disabled", false);

                var address = place.adr_address;
                var newAddr = address.split("</span>,");

                infowindow.setContent(place.name + "<br>" + newAddr[0] + "<br>" + newAddr[1] + "<br>" + newAddr[2]);
                infowindow.open(map, marker);
            }

            function removeMarker() {
                infowindow.close();
                marker.setVisible(false);
                $('#remove-marker').prop("disabled", true);
                $("#searchInput").val('')
                $("#place-id-input").val(null)
                $("#formatted_address-input").val(null)
            }

            $('form').on('submit', function () {
                $('#categories').prop('disabled', false);

                return true;
            });
        }
    </script>
@endsection
