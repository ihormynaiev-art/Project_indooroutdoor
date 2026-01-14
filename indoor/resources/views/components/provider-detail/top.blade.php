<div class="row align-items-center px-3">
    <div class="col-md-5">
        <div class="provider-img">
            <img src="{{ $providerDetail->logo_path }}" class="img-fluid w-100" alt="img">
        </div>
    </div>
    <div class="col-md-7">
        <div class="row provider-description p-2 mb-4">
            <div class="col-6">
                <div class="row">
                    @if($providerDetail->phone)
                        <div class="col-md-12 my-2">
                            <a class="d-flex" href="tel:{{ $providerDetail->phone }}">
                                <img src="{{ asset('assets/img/icons/phone.svg') }}"
                                     width="36"
                                     class="svg-site-blue"
                                     alt="phone">
                                <div class="provide-info mx-2 d-flex flex-column justify-content-center">
                                    <b class="text-site-blue">{{ $providerDetail->phone }}</b>
                                </div>
                            </a>
                        </div>
                    @endif
                    <div class="col-md-12 my-2">
                        <a class="d-flex" href="mailto:{{ $providerDetail->user->email }}">
                            <img src="{{ asset('assets/img/icons/mail.svg') }}"
                                 width="36" class="svg-site-blue" alt="mail">
                            <div class="provide-info mx-2">
                                <b class="text-site-blue">{{ $providerDetail->user->email }}</b>
                            </div>
                        </a>
                    </div>
                    @if($providerDetail->website_url)
                        <div class="col-md-12 my-2">
                            <a class="d-flex" target="_blank"
                               href="{{ $providerDetail->short_website_url }}"
                               rel="{{ $providerDetail->plan?->getFeature('seo_follow') ? '' : 'nofollow' }}">
                                <img src="{{ asset('assets/img/icons/website.svg') }}"
                                     width="36" class="svg-site-blue" alt="website">
                                <div class="provide-info mx-2">
                                    <b class="text-site-blue">{{ $providerDetail->short_website_url }}</b>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if($providerDetail->instagram_url)
                        <div class="col-md-12 my-2">
                            <a class="d-flex" target="_blank" href="{{ $providerDetail->instagram_url }}"
                               rel="{{ $providerDetail->plan?->getFeature('seo_follow') ? '' : 'nofollow' }}">
                                <img src="{{ asset('assets/img/icons/instagram.svg') }}"
                                     width="36" class="svg-site-blue" alt="instagram">
                                <div class="provide-info mx-2">
                                    <b class="text-site-blue">{{ $providerDetail->instagram_url }}</b>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if($providerDetail->x_url)
                        <div class="col-md-12 my-2">
                            <a class="d-flex" target="_blank" href="{{ $providerDetail->x_url }}"
                               rel="{{ $providerDetail->plan?->getFeature('seo_follow') ? '' : 'nofollow' }}">
                                <img src="{{ asset('assets/img/icons/x-logo.png') }}"
                                     width="36" height="36" class="svg-site-blue" alt="instagram">
                                <div class="provide-info mx-2">
                                    <b class="text-site-blue">{{ $providerDetail->x_url }}</b>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if($providerDetail->youtube_url)
                        <div class="col-md-12 my-2">
                            <a class="d-flex" target="_blank" href="{{ $providerDetail->youtube_url }}"
                               rel="{{ $providerDetail->plan?->getFeature('seo_follow') ? '' : 'nofollow' }}">
                                <img src="{{ asset('assets/img/icons/youtube.svg') }}"
                                     width="36" class="svg-site-blue" alt="instagram">
                                <div class="provide-info mx-2">
                                    <b class="text-site-blue">{{ $providerDetail->youtube_url }}</b>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if($providerDetail->facebook_url)
                        <div class="col-md-12 my-2">
                            <a class="d-flex" target="_blank" href="{{ $providerDetail->facebook_url }}"
                               rel="{{ $providerDetail->plan?->getFeature('seo_follow') ? '' : 'nofollow' }}">
                                <img src="{{ asset('assets/img/icons/facebook.svg') }}"
                                     width="36" class="svg-site-blue" alt="instagram">
                                <div class="provide-info mx-2">
                                    <b class="text-site-blue">{{ $providerDetail->facebook_url }}</b>
                                </div>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                @if($providerDetail->certificates->contains('type', 'certificate'))
                    <div class="col-md-12">
                        <div class="provide-box justify-content-end align-items-end">
                            <p class="fw-bold mb-0 mx-2 text-site-blue">
                                Licensed
                            </p>
                            <img src="{{ asset('assets/img/license.png') }}"
                                 class="provider-info-icon img-fluid" alt="licensed">
                        </div>
                    </div>
                @endif
                @if($providerDetail->certificates->contains('type', 'insurance'))
                    <div class="col-md-12">
                        <div class="provide-box justify-content-end align-items-end">
                            <p class="fw-bold mb-0 mx-2 text-site-blue">
                                Insured
                            </p>
                            <img src="{{ asset('assets/img/insurance.png') }}"
                                 class="provider-info-icon img-fluid" alt="licensed">
                        </div>
                    </div>
                @endif
            </div>
            <div class="d-flex justify-content-center justify-content-md-between flex-wrap">
                @if($providerDetail->plan?->hasContactButton('message_provider'))
                    <button
                        data-bs-toggle="modal"
                        data-bs-target="#message-to-provider"
                        class="site-button site-button-secondary site-button-mw-big m-2"
                    >
                        <img class="mx-2" style="margin-bottom: 3px;"
                             src="{{ asset('assets/img/icons/message.png') }}"
                             height="15" alt="Share Profile">Message Provider
                    </button>
                @endif
                @if(count($subcategoriesIds))
                    <button
                        data-bs-toggle="modal"
                        data-bs-title="QUOTATION FORM"
                        data-bs-target="#request-quote"
                        data-provider-id="{{ $providerDetail->id }}"
                        data-provider-allowed-categories-list='{!! json_encode($categoriesIds) !!}'
                        data-provider-allowed-subcategories-list='{!! json_encode($subcategoriesIds) !!}'
                        class="site-button site-button-secondary m-2 site-button-mw-big"
                    >
                        <img class="mx-2" style="margin-bottom: 3px;"
                             src="{{ asset('assets/img/icons/quote.png') }}"
                             height="15" alt="Request Quote">Request Quote
                    </button>
                @endif
                @if($providerDetail->plan?->hasContactButton('share_profile'))
                    <button
                        data-bs-toggle="modal"
                        data-bs-target="#share-profile"
                        class="site-button site-button-secondary site-button-mw-big m-2"
                    >
                        <img class="mx-2" style="margin-bottom: 3px;"
                             src="{{ asset('assets/img/icons/share.png') }}"
                             height="15" alt="Share Profile">Share Profile
                    </button>
                @endif
            </div>
            <div class="d-flex justify-content-center justify-content-md-between justify-content-xxl-end flex-wrap">
                <div class="d-none d-xxl-block" style="min-width: 217px; margin: 0.5rem;"></div>
                @if($providerDetail->hasAdButton('view_ad'))
                    @if($providerDetail->adImages->isNotEmpty())
                        <button
                            data-bs-toggle="modal"
                            data-bs-target="#ad-modal"
                            class="site-button site-button-primary m-2 site-button-mw-big"
                        >
                            <img class="mx-2" style="margin-bottom: 3px;"
                                 src="{{ asset('assets/img/icons/ad.png') }}"
                                 height="15" alt="View Ad">View Ad
                        </button>
                    @endif
                @endif
                @if($providerDetail->hasAdButton('view_magazine'))
                    <a href="{{ route('edition.show') }}"
                       target="_blank"
                       class="site-button site-button-primary site-button-mw-big m-2"
                    >
                        <img class="mx-2" style="margin-bottom: 3px;"
                             src="{{ asset('assets/img/icons/magazine.png') }}"
                             height="15" alt="View Magazine">View Magazine
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
