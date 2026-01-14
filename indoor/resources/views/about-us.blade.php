<?php
$page = 'about-us';
?>
@extends('layout.mainlayout')
@section('title', 'About Us | IndoorOutdoor Home Improvement Services')
@section('description', "Learn about IndoorOutdoor's mission, values, and team. Discover how our expertise and commitment to quality make us a trusted partner for your home improvement projects.")
@section('content')
    @component('components.breadcrumb')
        @slot('title')
            About Us
        @endslot
        @slot('li_1')
            Home
        @endslot
        @slot('li_2')
            About Us
        @endslot
    @endcomponent

    <div class="content p-0">
        <!-- About -->
        <div class="about-sec">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="about-content">
                            <h2>Our Story</h2>
                            <p>
                                Since 2003 The IndoorOutdoor Resource has been HELPING MAKE A HOUSE–YOUR HOME®. With
                                a simple mission from day one– matching Michigan’s Affluent Homeowner with Michigan
                                Home Goods and Service Providers. From routine maintenance and repairs to dream home
                                renovations, we can help with any project — big or small. For nearly two decades Michigan
                                homeowners have trusted this handy resource guide when goods and services are needed for their home.
                            </p>
                            <p>
                                It’s Fast, Easy, Local and Free! Unlike other companies, we never share or sell your information.
                                Your inquiry is transferred to the Home Goods and Service Providers that best match your service
                                request. Compare matched pros. Verify pro credentials, read reviews, ask questions, discuss availability,
                                and request project estimates. Hire the pro that's right for you and your budget. After the project
                                is complete, let your community know how it went.
                            </p>
                            <p>
                                Our family of Home Good and Service Providers Transact with Trust. The IndoorOutdoor Resource is SE
                                Michigan’s ONLY mass mailed publication with an Audited & Verified Circulation from the Alliance for
                                Audited Media. Since 1914, the recognized leader in media assurance. We do what we say.
                            </p>
                            <p>
                                The IndoorOutdoor Resource is Michigan Independently Owned and Operated with Pride.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
