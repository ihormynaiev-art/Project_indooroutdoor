@extends('layout.mainlayout')
@section('title', 'Privacy Policy | IndoorOutdoor')
@section('description', "Learn how IndoorOutdoor collects, uses, and protects your personal data. Read our Privacy Policy for more details.")
@section('content')
    @component('components.backgroundimage')
    @endcomponent
    @component('components.breadcrumb')
        @slot('title')
            Data Deletion
        @endslot
        @slot('li_1')
            Home
        @endslot
        @slot('li_2')
            Data Deletion
        @endslot
    @endcomponent

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="terms-content privacy-cont">
                        <h5>
                            User Data Deletion Instructions
                        </h5>
                        <p>
                            This app does not collect, store, or process any personal user data.
                            It is used solely to display public Facebook content via Meta’s API.
                        </p>
                        <p>
                            If you have any concerns, or wish to request deletion of any data that may have been collected through our app,
                            please contact us at <b>info@indooroutdoor.com</b>
                            with your Facebook ID or username.
                        </p>
                        <p>
                            Your data will be permanently deleted within 48 hours of receiving your request.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
