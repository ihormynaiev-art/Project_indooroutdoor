@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" id="form" enctype="multipart/form-data"
                          action="{{ route('provider.reviews.settings.update', $providerDetail->id) }}">
                        @csrf
                        @method('patch')
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <div class="widget-title">
                            <h4>Reviews Settings</h4>
                        </div>

                        @if($providerDetail->plan?->canShowIndoorOutdoorReviews())
                            <div class="alert alert-success mt-3">
                                <h5 class="user-title">Indoor Outdoor Reviews</h5>
                                <p>Indoor Outdoor Reviews are enabled for your {{ $providerDetail->plan->display_name }} plan. You can collect and display customer reviews directly on your profile.</p>
                                <a href="{{ route('provider.testimonials.index') }}" class="btn btn-sm btn-primary">Manage Reviews</a>
                            </div>
                        @else
                            <div class="alert alert-info mt-3">
                                <h5 class="user-title">Indoor Outdoor Reviews</h5>
                                <p>Indoor Outdoor Reviews feature is not available with your current plan. Please upgrade to collect and display customer reviews.</p>
                                <p class="mb-0"><strong>Contact us at <a href="mailto:info@indooroutdoor.com">info@indooroutdoor.com</a> to upgrade your plan.</strong></p>
                            </div>
                        @endif

                        @if(config('services.google.api_key'))
                            @if($providerDetail->plan?->canShowGoogleReviews())
                                <input
                                    type="hidden"
                                    name="google_place_id"
                                    id="place-id-input"
                                    value="{{ $providerDetail->google_place_id }}"
                                    class="form-control"
                                    placeholder=""
                                />
                                <input
                                    type="hidden"
                                    name="google_formatted_address"
                                    id="formatted_address-input"
                                    value="{{ $providerDetail->google_formatted_address }}"
                                    class="form-control"
                                    placeholder=""
                                />
                                <h5 class="user-title mt-3">Google</h5>
                                <span>Link your Google Reviews to your profile by entering your business location below. This will display your reviews directly on your showcase page, helping homeowners trust your services.</span>
                            @else
                                <div class="alert alert-info mt-3">
                                    <h5 class="user-title">Google Reviews</h5>
                                    <p>Google Reviews integration is available with the <strong>Premium</strong> plan. Upgrade your plan to sync and display Google reviews on your profile.</p>
                                    <p class="mb-0"><strong>Contact us at <a href="mailto:info@indooroutdoor.com">info@indooroutdoor.com</a> to upgrade your plan.</strong></p>
                                </div>
                            @endif
                            @if($providerDetail->plan?->canShowGoogleReviews())
                                <div class="general-info">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-12">
                                            <div class="mx-2 my-4 d-flex">
                                                <button class="btn btn-primary" disabled type="button" id="remove-marker">
                                                    Remove
                                                    Marker
                                                </button>
                                                <button class="btn btn-primary mx-2" type="submit" form="syncGoogleReviews"
                                                        @disabled(!$providerDetail->canFetchGoogleReviews())
                                                        id="sync-reviews">Sync Reviews
                                                </button>
                                                <div class="info-icon-container d-flex justify-content-center flex-column">
                                                    <img src="{{ asset('assets/img/icons/info-sign.png') }}" alt="Info">
                                                    <div class="info-tooltip">
                                                        <p>To include reviews from Google Maps, please follow these
                                                            steps:</p>
                                                        <ol>
                                                            <li>Search for your location by entering the address or
                                                                selecting
                                                                the correct point on the map.
                                                            </li>
                                                            <li>Click on the correct place from the search results.</li>
                                                            <li>Click Save Changes to confirm.</li>
                                                            <li>Click Sync Reviews.</li>
                                                        </ol>
                                                        <p><em>*Please do not delete the location if reviews don't appear
                                                                immediately. Reviews will be visible on your page at
                                                                midnight
                                                                the following day. You can synchronize reviews manually once
                                                                a day.</em></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <input id="searchInput" class="controls mt-2 w-50" type="text"
                                                   placeholder="Enter your business name or address (e.g., '123 Main St, Detroit, MI').">
                                            <div id="map"></div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <h5 class="user-title mt-3">Google API key is not set</h5>
                        @endif
                        @if(config('services.facebook.client_secret') && config('services.facebook.client_id'))
                            @if($providerDetail->plan?->canShowFacebookReviews())
                                <h6 class="user-title my-3">Facebook</h6>
                                <div>
                                    @if($providerDetail->facebook_token)
                                        <p class="mx-2">Facebook <br>Connected</p>
                                    @else
                                        <a href="{{ route('facebook.redirect') }}" class="btn btn-primary">
                                            Connect Facebook
                                        </a>
                                    @endif
                                    @if($providerDetail->facebook_token && !$providerDetail->facebook_page_id)
                                        <div class="w-100 px-1 my-2">
                                            <select id="facebook-page-select"
                                                    onchange="setFacebookPageData(this)"
                                                    name="facebook_page_id" class="select">
                                                <option value="">-- Choose page --</option>
                                                @foreach($facebookPages as $page)
                                                    <option
                                                        value="{{ $page['id'] }}"
                                                        data-token="{{ $page['access_token'] }}"
                                                        data-name="{{ $page['name'] }}"
                                                        @selected($providerDetail->facebook_page_id == $page['id'])
                                                    >
                                                        {{ $page['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <input type="hidden" name="facebook_page_token" id="facebook-page-token">
                                        <input type="hidden" name="facebook_page_name" id="facebook-page-name">
                                    @endif
                                    @if($providerDetail->facebook_page_id)
                                        <div class="mx-2 my-2">
                                            <p class="my-0"><b>Selected page:</b></p>
                                            <div>{{ $providerDetail->facebook_page_name }}</div>
                                        </div>
                                    @endif
                                </div>
                                <div class="d-flex">
                                    @if($providerDetail->facebook_token)
                                        <div class="mx-1">
                                            <button class="btn btn-primary" type="submit" form="disconnectFacebook"
                                                    id="disconnect-facebook">Disconnect
                                            </button>
                                        </div>
                                    @endif
                                    @if($providerDetail->facebook_token && $providerDetail->facebook_page_id)
                                        <div class="mx-1">
                                            <button class="btn btn-primary" type="submit" form="syncFacebookReviews"
                                                    @disabled(!$providerDetail->canFetchFacebookReviews())
                                                    id="sync-facebook-reviews">Sync Reviews
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="alert alert-info mt-3">
                                    <h5 class="user-title">Facebook Reviews</h5>
                                    <p>Facebook Reviews integration is available with the <strong>Premium</strong> plan. Upgrade your plan to sync and display Facebook reviews on your profile.</p>
                                    <p class="mb-0"><strong>Contact us at <a href="mailto:info@indooroutdoor.com">info@indooroutdoor.com</a> to upgrade your plan.</strong></p>
                                </div>
                            @endif
                        @else
                            <h5 class="user-title mt-3">Facebook API keys are not set</h5>
                        @endif
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
    <form id="syncGoogleReviews"
          method="post"
          action="{{ route('provider.sync-google-reviews', compact('providerDetail')) }}">
        @csrf
    </form>
    <form id="syncFacebookReviews"
          method="post"
          action="{{ route('provider.sync-facebook-reviews', compact('providerDetail')) }}">
        @csrf
    </form>
    <form id="disconnectFacebook"
          method="post"
          action="{{ route('facebook.disconnect', compact('providerDetail')) }}">
        @csrf
    </form>
    @component('components.model-popup')
    @endcomponent
@endsection

@section('scripts')
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key={{config('services.google.api_key')}}&libraries=places&callback=initMap"></script>
    <script>
        function setFacebookPageData(select) {
            const selected = select.options[select.selectedIndex];
            const token = selected.getAttribute('data-token');
            const name = selected.getAttribute('data-name');

            document.getElementById('facebook-page-token').value = token || '';
            document.getElementById('facebook-page-name').value = name || '';
        }

        $(function () {
            $('.info-icon-container img').hover(
                function () {
                    $(this).siblings('.info-tooltip').fadeIn(200);
                },
                function () {
                    $(this).siblings('.info-tooltip').fadeOut(200);
                }
            );


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

            $('#logo').change(function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $("#preview-logo").attr('src', e.target.result);
                }
                reader.readAsDataURL($(this)[0].files[$(this)[0].files.length - 1]);
            })
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
