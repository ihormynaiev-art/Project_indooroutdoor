@extends('layout.mainlayout')
@section('title', 'Privacy Policy | IndoorOutdoor')
@section('description', "Learn how IndoorOutdoor collects, uses, and protects your personal data. Read our Privacy Policy for more details.")
@section('content')
    @component('components.backgroundimage')
    @endcomponent
    @component('components.breadcrumb')
        @slot('title')
            Privacy Policy
        @endslot
        @slot('li_1')
            Home
        @endslot
        @slot('li_2')
            Privacy Policy
        @endslot
    @endcomponent

    <div class="content">
        <div class="container">
            <div class="row">
                <!-- Terms & Conditions -->
                <div class="col-md-12">
                    <div class="terms-content privacy-cont">
                        <h5>
                            Our Commitment to Privacy
                        </h5>
                        <p>
                            The IndoorOutdoor Resource respects the privacy of our users and has developed this Privacy Policy to demonstrate
                            its commitment to protecting your privacy. First and foremost, we promise that we will never share information
                            about you to any outside companies. We encourage you to read this Privacy Policy carefully when using our website
                            or services or transacting business with us. By using our website, you are accepting the practices described in this Privacy Policy.
                        </p>

                        <h5>
                            Matching You to Service Professionals
                        </h5>
                        <p>
                            We match your submitted information and service request against our list of Service Professionals. When you submit a service
                            request through our website, you consent to our providing your personal information and request to the Service Professionals
                            we match with your request. Sharing this information with Service Professionals allows them to contact you using the e-mail
                            address or other contact information you provided. In addition, we have other approved contractual partners that fulfill service
                            requests, or that utilize their own Service Professionals to supplement our network, and we share your information with them in
                            order to attempt to provide the services requested
                        </p>
                        <p>
                            For Service Professionals, we may share your business contact information with homeowners requesting service in your category of
                            service. Including but not limited to, business name, address, telephone number, email address and name of owner or proprietor of the business.
                        </p>

                        <h5>
                            Information We Collect
                        </h5>
                        <p>
                            Privacy is important to us; therefore, other then matching your service request to Service professionals in our network, we will not sell, rent,
                            or give your name or address to anyone. We collect general usage data on how visitors use our website, like the IP address/URL from which our
                            website visitors originated, what pages our visitors view and how often, what browsers and OS they use, etc. This data is only collected on
                            an aggregate basis. By that we mean that we cannot see how you, specifically use our website. We collect and review such information so we
                            can understand how to improve the website to better serve you.
                        </p>

                        <h5>
                            Physical Mailing Address Removal
                        </h5>
                        <p>
                            If you wish to be removed from a physical mailing, we hate to see you go. However, we are happy to facilitate that process. Please visit
                            our contact us page and submit your address for removal. We will work as swiftly as possible with the mail house and printer to get your
                            address removed. Depending on the timing of your request, it may take an issue cycle or two, to get you fully removed. And again, we do
                            not sell, rent or give your address to anyone.
                        </p>

                        <h5>
                            Cookies
                        </h5>
                        <p>
                            We use cookies to store limited information and your preferences with the intention of making your use of our website easier.
                        </p>

                        <h5>
                            Security
                        </h5>
                        <p>
                            We have taken appropriate security measures to protect against loss, misuse or alteration of information that we have collected from you at our website.
                        </p>

                        <h5>
                            Change in Information Use
                        </h5>
                        <p>
                            We reserve the right to change the process of how we use and manage information obtained on our website. If we do change our process,
                            we will post this change on our website. If at anytime you would like to review information we have collected from you, or feel that
                            we have not followed this stated information policy, please contact us by email, letter or telephone.
                        </p>

                        <h5>
                            Trademark and Copyright notices
                        </h5>
                        <p>
                            The IndoorOutdoor Resource is Independently owned and operated by BlackBear Media LLC. © Copyright 2003 to Present. All rights reserved.
                            The magazine, its content and artwork created by The IndoorOutdoor Resource, may not be reproduced or utilized, in whole or in part, in
                            any form or by any form or by any means, electronic or mechanical, including photo-reproduction, recording or by any information storage
                            and retrieval system, without the prior written consent of The IndoorOutdoor Resource. The IndoorOutdoor Resource aims to accept reliable
                            advertising however, we cannot be held responsible by the public, for any advertising claims. All trademarks and logos featured within
                            are copyright of their respective owners.
                        </p>

                        <p>
                            The IndoorOutdoor Resource is Independently owned and operated by BlackBear Media LLC. © Copyright 2003 to Present. All rights reserved.
                            The magazine, its content and artwork created by The IndoorOutdoor Resource, may not be reproduced or utilized, in whole or in part, in
                            any form or by any form or by any means, electronic or mechanical, including photo-reproduction, recording or by any information storage
                            and retrieval system, without the prior written consent of The IndoorOutdoor Resource. The IndoorOutdoor Resource aims to accept reliable
                            advertising however, we cannot be held responsible by the public, for any advertising claims. All trademarks and logos featured within
                            are copyright of their respective owners.
                        </p>

                        <p>
                            The IndoorOutdoor Resource <b>Trademarks</b>
                        </p>

                        <p>
                            Trademark: <b>INDOOROUTDOOR</b> Marking: ® Registration Nos.: 4532110
                        </p>

                        <p>
                            Trademark: <b>HELPING MAKE A HOUSE</b> - YOUR HOME Marking: ® Registration Nos.: 4780270
                        </p>

                        <p>
                            Trademark: <b>INPRINT & ONLINE</b> | YOUR LOCAL HOME RESOURCE GUIDE Marking: ® Registration Nos.: 4788477
                        </p>

                        <p>
                            Trademark: FROM TO-DO TO DONE Marking: ® Registration Nos.: 5490410
                        </p>
                    </div>
                </div>
                <!-- /Terms & Conditions -->
            </div>
        </div>
    </div>
@endsection
