@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="row">
                <div class="col-md-12 text-black">
                    <h4 class="justify-content-center">
                        ✅ You're Verified! Now Let’s Get Your Page Ready.
                    </h4>
                    <ul class="explanation-list">
                        <li>
                            <a href="{{ route('provider.verification') }}">To be published on the site, we may need to verify certain documents like certifications or insurance, if required for your trade.</a>
                        </li>
                        <li>
                            In the meantime, you can start building your contractor page by uploading your logo, service categories, adding photos, and more.
                        </li>
                        <li>
                            Start now - your page goes live as soon as you're approved!
                        </li>
                    </ul>

                    <h4 class="justify-content-center mt-2">
                        Business Location & Google Reviews :
                    </h4>

                    <ul class="explanation-list">
                        <li>
                            Select your business location on the <a href="{{ route('provider.details.edit') }}#map">map</a>. This connects your Google Business Profile and allows your Google Reviews (if available) to automatically display on your contractor page.
                        </li>
                    </ul>
                    ✅ Tip: Make sure the location matches your Google Business listing for the best results.
                </div>
            </div>
        </div>
    </div>
@endsection

