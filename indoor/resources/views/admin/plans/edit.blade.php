@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">

            <div class="content-page-header content-page-headersplit">
                <h5>Plan Settings - {{ $plan->display_name }}</h5>
            </div>

            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.plans.update', ['plan' => $plan]) }}"
                  method="post">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Basic Settings --}}
                    <div class="col-lg-6 col-sm-12">
                        <h6 class="user-title mb-3">Basic Settings</h6>

                        <div class="mb-3">
                            <label class="form-label">Name (Read-only)</label>
                            <input type="text" class="form-control" value="{{ $plan->name }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Display Name</label>
                            <input type="text"
                                   name="display_name"
                                   class="form-control"
                                   value="{{ old('display_name', $plan->display_name) }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sort Order</label>
                            <input type="number"
                                   name="sort_order"
                                   class="form-control"
                                   value="{{ old('sort_order', $plan->sort_order) }}">
                        </div>

                        <div class="form-groupheads">
                            <h6 class="user-title">Active</h6>
                            <div class="mx-2 active-switch">
                                <label class="switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input name="is_active"
                                           @checked(old('is_active', $plan->is_active))
                                           value="1"
                                           type="checkbox">
                                    <span class="sliders round"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Features --}}
                    <div class="col-lg-6 col-sm-12">
                        <h6 class="user-title mb-3">Features</h6>

                        <div class="mb-3">
                            <label class="form-label">Max Portfolio Photos</label>
                            <input type="number"
                                   name="config[features][max_portfolio_photos]"
                                   class="form-control"
                                   value="{{ old('config.features.max_portfolio_photos', $plan->getFeature('max_portfolio_photos', 3)) }}"
                                   min="1"
                                   max="100"
                                   required>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="hidden" name="config[features][show_map]" value="0">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="config[features][show_map]"
                                       value="1"
                                       id="showMap"
                                       @checked(old('config.features.show_map', $plan->getFeature('show_map', false)))>
                                <label class="form-check-label" for="showMap">
                                    Show Map
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="hidden" name="config[features][show_promo_block]" value="0">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="config[features][show_promo_block]"
                                       value="1"
                                       id="showPromoBlock"
                                       @checked(old('config.features.show_promo_block', $plan->getFeature('show_promo_block', false)))>
                                <label class="form-check-label" for="showPromoBlock">
                                    Show Promo Block
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="hidden" name="config[features][seo_follow]" value="0">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="config[features][seo_follow]"
                                       value="1"
                                       id="seoFollow"
                                       @checked(old('config.features.seo_follow', $plan->getFeature('seo_follow', false)))>
                                <label class="form-check-label" for="seoFollow">
                                    SEO Follow (dofollow links)
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="hidden" name="config[features][search_priority]" value="0">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="config[features][search_priority]"
                                       value="1"
                                       id="searchPriority"
                                       @checked(old('config.features.search_priority', $plan->getFeature('search_priority', false)))>
                                <label class="form-check-label" for="searchPriority">
                                    Search Priority
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="hidden" name="config[features][landing]" value="0">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="config[features][landing]"
                                       value="1"
                                       id="landing"
                                       @checked(old('config.features.landing', $plan->getFeature('landing', false)))>
                                <label class="form-check-label" for="landing">
                                    Landing Page Access
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Reviews --}}
                    <div class="col-lg-6 col-sm-12 mt-4">
                        <h6 class="user-title mb-3">Reviews</h6>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="hidden" name="config[reviews][indooroutdoor]" value="0">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="config[reviews][indooroutdoor]"
                                       value="1"
                                       id="reviewIndoorOutdoor"
                                       @checked(old('config.reviews.indooroutdoor', $plan->getReviewSetting('indooroutdoor', false)))>
                                <label class="form-check-label" for="reviewIndoorOutdoor">
                                    IndoorOutdoor Reviews
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="hidden" name="config[reviews][google]" value="0">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="config[reviews][google]"
                                       value="1"
                                       id="reviewGoogle"
                                       @checked(old('config.reviews.google', $plan->getReviewSetting('google', false)))>
                                <label class="form-check-label" for="reviewGoogle">
                                    Google Reviews
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="hidden" name="config[reviews][facebook]" value="0">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="config[reviews][facebook]"
                                       value="1"
                                       id="reviewFacebook"
                                       @checked(old('config.reviews.facebook', $plan->getReviewSetting('facebook', false)))>
                                <label class="form-check-label" for="reviewFacebook">
                                    Facebook Reviews
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Contact Buttons --}}
                    <div class="col-lg-6 col-sm-12 mt-4">
                        <h6 class="user-title mb-3">Contact Buttons</h6>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="hidden" name="config[contact_buttons][message_provider]" value="0">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="config[contact_buttons][message_provider]"
                                       value="1"
                                       id="btnMessageProvider"
                                       @checked(old('config.contact_buttons.message_provider', $plan->getContactButton('message_provider', false)))>
                                <label class="form-check-label" for="btnMessageProvider">
                                    Message Provider
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="hidden" name="config[contact_buttons][share_profile]" value="0">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="config[contact_buttons][share_profile]"
                                       value="1"
                                       id="btnShareProfile"
                                       @checked(old('config.contact_buttons.share_profile', $plan->getContactButton('share_profile', false)))>
                                <label class="form-check-label" for="btnShareProfile">
                                    Share Profile
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Ad Buttons --}}
                    <div class="col-lg-6 col-sm-12 mt-4">
                        <h6 class="user-title mb-3">Advertisement Buttons</h6>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="hidden" name="config[ad_buttons][view_ad]" value="0">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="config[ad_buttons][view_ad]"
                                       value="1"
                                       id="btnViewAd"
                                       @checked(old('config.ad_buttons.view_ad', $plan->getAdButton('view_ad', false)))>
                                <label class="form-check-label" for="btnViewAd">
                                    View Ad (work when images uploaded)
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="hidden" name="config[ad_buttons][view_magazine]" value="0">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="config[ad_buttons][view_magazine]"
                                       value="1"
                                       id="btnViewMagazine"
                                       @checked(old('config.ad_buttons.request_quote', $plan->getAdButton('view_magazine', false)))>
                                <label class="form-check-label" for="btnViewMagazine">
                                    View Magazine
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Limits --}}
                    <div class="col-lg-6 col-sm-12 mt-4">
                        <h6 class="user-title mb-3">Limits</h6>

                        <div class="mb-3">
                            <label class="form-label">Lead Delay (hours)</label>
                            <input type="number"
                                   name="config[limits][lead_delay_hours]"
                                   class="form-control"
                                   value="{{ old('config.limits.lead_delay_hours', $plan->getLimit('lead_delay_hours', 0)) }}"
                                   min="0"
                                   max="168"
                                   required>
                            <small class="text-muted">0 = instant delivery, 48 = 2 days delay</small>
                        </div>
                    </div>

                    {{-- Admin Settings --}}
                    <div class="col-lg-6 col-sm-12 mt-4">
                        <h6 class="user-title mb-3">Admin Settings</h6>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="hidden" name="config[admin][auto_publish]" value="0">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="config[admin][auto_publish]"
                                       value="1"
                                       id="autoPublish"
                                       @checked(old('config.admin.auto_publish', $plan->getAdminSetting('auto_publish', false)))>
                                <label class="form-check-label" for="autoPublish">
                                    Auto Publish
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="acc-submit pt-3">
                    <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
