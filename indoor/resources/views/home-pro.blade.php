@extends('layout.mainlayout')
@section('title', 'Become a Qualified Contractor | IndoorOutdoor')
@section('description', "Join IndoorOutdoor as a qualified contractor. Fill out our application form to connect with clients and grow your business.")
@section('content')
    <div class="content p-0">
        <!-- About -->
        <div>
            <div class="container">
                <div class="request-section">
                    <div class="banner-overlay">
                    </div>
                    <div class="request-text">
                        <h3>Don’t count the people you reach,</h3>
                        <h4>reach the people that count</h4>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-2">
                        <div class="pro-section-box">
                            <h4 class="animate-value" data-value="550000"  data-text="" data-symbol="$">0</h4>
                            <h6>Median Home Value</h6>
                        </div>
                    </div>
                    <div class="col-md-2 left-border">
                        <div class="pro-section-box middle">
                            <h4 class="animate-value" data-value="168000"  data-text="" data-symbol="$">0</h4>
                            <h6>Median Household Income</h6>
                        </div>
                    </div>
                    <div class="col-md-2 left-border">
                        <div class="pro-section-box middle">
                            <h4 class="animate-value" data-value="33" data-symbol="" data-text=" years">0</h4>
                            <h6>Median Age Of House</h6>
                        </div>
                    </div>
                    <div class="col-md-2 left-border">
                        <div class="pro-section-box middle">
                            <h4 class="animate-value" data-value="54" data-symbol="" data-text=" years">0</h4>
                            <h6>Homeowner Median Age</h6>
                        </div>
                    </div>
                    <div class="col-md-4 left-border">
                        <div class="pro-section-box middle">
                            <h4 class="animate-value" data-value="46" data-symbol="" data-text="% Greater Home Value">0</h4>
                            <h6>Than The Average In Targeted ZIP Codes</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="home-pro-sub-heading">
                <h1 >MARKETING THAT HITS HOME!</h1>
                <h4>
                    TARGETING HOMEOWNERS WHO HAVE BOTH THE NEED AND <br>
                    THE MEANS FOR YOUR PRODUCTS AND SERVICES.
                </h4>
            </div>
            <div class="container">
                <div class="why-indooroutdoor">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="why-indooroutdoor-box">
                                <h4>
                                    TRANSACT WITH TRUST
                                </h4>
                                <p>
                                    Entrust your ad dollars with SE Michigan’s
                                    <span>
                                        ONLY
                                    </span>
                                    Mass Mailed Publication with an
                                    <span>
                                        Audited & Verified Circulation.
                                    </span>
                                </p>
                                <img src="{{ asset('assets/img/home-pro/tagline-logo.png') }}" alt="">
                                <p>
                                    Our media metrics are audited by the Alliance for Audited Media to provide
                                    our advertising partners with the highest level of media assurance.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="home-video">
                                <iframe src="{{ asset('/assets/video/trust.mp4') }}"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="why-heading">
                    <h4>
                        Over Two Decades of Home Improvement Direct Mail–DONE RIGHT.
                    </h4>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="why-box">
                            <img style="margin-bottom: 8px" src="{{ asset('assets/img/home-pro/23-years.png') }}" alt="A 23 YEAR TRACK RECORD">
                            <h6> A 23 YEAR TRACK RECORD </h6>
                            <p>
                                With over two decades of proven success, we boast a 94% re-sign rate — demonstrating
                                that our clients stay with us because we consistently deliver exceptional service and
                                tangible results. Accept no imitations.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="why-box">
                            <img src="{{ asset('assets/img/home-pro/targeting-your-audience.svg') }}" alt="TARGETING YOUR AUDIENCE">
                            <h6> TARGETING YOUR AUDIENCE </h6>
                            <p>
                                We reach homeowners with a median home value of $550,000 and a median household
                                income of $168,000. Our mailing list targets
                                individuals who take pride in homeownership and have both the need and discretionary
                                income for your products and services.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="why-box">
                            <img src="{{ asset('assets/img/home-pro/we-do-what-we-say.svg') }}" alt="WE DO WHAT WE SAY">
                            <h6> WE DO WHAT WE SAY </h6>
                            <p>
                                Our circulation is audited and verified by the
                                Alliance for Audited Media, the recognized leader in media assurance since 1914,
                                ensuring transparency and reliability.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="why-box">
                            <img src="{{ asset('assets/img/home-pro/mailed-to-homeowners-only.svg') }}" alt="MAILED TO HOMEOWNERS ONLY">
                            <h6> MAILED TO HOMEOWNERS ONLY </h6>
                            <p>
                                NO apartments. NO businesses. NO trailer parks. Unlike coupon and shopper
                                publications, you never pay for wasted distribution to
                                consumers who have no need for your
                                products and services.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="why-box">
                            <img src="{{ asset('assets/img/home-pro/mailbox.png') }}" alt="STANDALONE SOLO MAILED">
                            <h6> STANDALONE, STAND OUT </h6>
                            <p>
                                We're a standalone, solo-mailed
                                publication—unlike others that co-mingle
                                with multiple inserts, risking your message
                                getting lost in the clutter.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="why-box">
                            <img src="{{ asset('assets/img/home-pro/we-are-local.svg') }}" alt="WE ARE LOCAL">
                            <h6> WE ARE LOCAL </h6>
                            <p>
                                Our highly curated mailing list works because we are local. We continually refine it using
                                up-to-date, verified data and a thorough “boots on the ground” understanding of
                                Southeast Michigan communities, ensuring precision
                                targeting for maximum impact.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="why-box">
                            <img src="{{ asset('assets/img/home-pro/award-winning.svg') }}" alt="AWARD WINNING">
                            <h6> AWARD WINNING </h6>
                            <p>
                                Designed for home goods and service
                                providers, our large-format glossy magazine extends shelf life with professionally
                                crafted, call-to-action advertising.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="why-box">
                            <img src="{{ asset('assets/img/home-pro/its-all-in-the-timing.svg') }}" alt="IT'S ALL IN THE TIMING">
                            <h6> IT'S ALL IN THE TIMING </h6>
                            <p>
                                We arrive in homeowners' mailboxes as a standalone, solo-mailed publication. Mailing
                                in-home dates are strategically planned to avoid the Post Office’s “junk mail” delivery
                                days, ensuring your message stands out.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="why-box">
                            <img src="{{ asset('assets/img/home-pro/desirable-established-audience.svg') }}" alt="DESIRABLE & ESTABLISHED AUDIENCE">
                            <h6> DESIRABLE & ESTABLISHED AUDIENCE </h6>
                            <p>
                                For over twenty years, Michigan’s discerning homeowners have trusted and utilized our
                                publication when products and services are needed for their home.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="why-box">
                            <img src="{{ asset('assets/img/home-pro/money-bag.png') }}" alt="THE MOST BANG FOR YOUR BUCK">
                            <h6> THE MOST BANG FOR YOUR BUCK </h6>
                            <p>
                                We offer the lowest rates of any mass-mailed publication in Southeast Michigan. Shop
                                and compare. We provide the most value for your marketing dollar, backed by a 20+ year
                                track record of delivering results.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="why-heading">
                    <h4> Start Growing Your Business Today! </h4>
                    <h4> Introduce Your Business to Michigan’s High-End Homeowners </h4>
                    <p> Reach our online audience and create your profile for free today. </p>
                    <a href="{{ route('contact-us') }}" class="btn btn-green">Request information</a>
                </div>
                <div class="home-pro-service-section">
                    <div class="service-heading">
                        <h5> Advertiser's Testimonials </h5>
                    </div>
                    <div class="col-md-6 text-md-end aos" data-aos="fade-up">
                        <div class="owl-nav mynav1"></div>
                    </div>
                    <div class="owl-carousel testimonials-slider aos " data-aos="fade-up">
                        <div class="testimonials-box">
                            <a>
                                <img src="{{ asset('assets/img/home-pro/aria.jpg') }}" alt="">
                                <h5> Outperforms all other publications! </h5>
                                <p>
                                    The IndoorOutdoor Resource outperforms all the other publications we advertise in. We saw immediate
                                    response from The IO Resource. Our ROI with IndoorOutdoor has been 2x that of any other ad media.”
                                    ­– Mike Eller, Owner –
                                </p>
                                <h6> Aria </h6>
                            </a>
                        </div>
                        <div class="testimonials-box">
                            <a>
                                <img src="{{ asset('assets/img/home-pro/mcLaughlin’s-home.jpg') }}" alt="">
                                <h5> A SOLID MARKETING DECISION. </h5>
                                <p>
                                    We have been a consistent advertiser since The IndoorOutdoor Resource’s first issue was published
                                    15 years ago – It was and is a solid marketing decision. They understand our customer and reach the
                                    people who appreciate and can afford quality home furnishings. – Don McLaughlin, McLaughlin’s Home Furnishing Designs –
                                </p>
                                <h6> McLaughlin’s Home Furnishing Designs </h6>
                            </a>
                        </div>
                        <div class="testimonials-box">
                            <a>
                                <img src="{{ asset('assets/img/home-pro/all_about.jpg') }}" alt="">
                                <h5> Our results are outstanding. </h5>
                                <p>
                                    Just a note to thank you for the professional magazine you publish. Our results are outstanding. Your help in laying
                                    out my business format, to the consumer, is excellent. I get calls from the more high end clientele that appreciate
                                    the talents of our company; along with the referrals after we make the sale and deliver what we promise. Thanks again
                                    for being our partner to success.
                                </p>
                                <h6> All About Blinds and Shades, Inc. </h6>
                            </a>
                        </div>
                        <div class="testimonials-box">
                            <a>
                                <img src="{{ asset('assets/img/home-pro/premium-tree.jpg') }}" alt="">
                                <h5> The Top Performing Print Publication!! </h5>
                                <p>
                                    In our 30 years in business, the IndoorOutdoor Resource has outperformed every publication we’ve advertised in.
                                    The phone rings off the hook! – Joe Hodges, Premium Tree –
                                </p>
                                <h6> Premium Tree </h6>
                            </a>
                        </div>
                        <div class="testimonials-box">
                            <a>
                                <img src="{{ asset('assets/img/home-pro/monster-tree.jpg') }}" alt="">
                                <h5> Your ad is killing it for us! </h5>
                                <p>
                                    I’m getting leads from this ad…good solid leads. I don’t even care about the price of the ad.
                                    Your ad is killing it for us! Liz Snoblen, Owner Monster Tree Service of West Bloomfield
                                </p>
                                <h6> Monster Tree Service </h6>
                            </a>
                        </div>
                        <div class="testimonials-box">
                            <a>
                                <img src="{{ asset('assets/img/home-pro/blue-sky.jpg') }}" alt="">
                                <h5>
                                    I've been advertising with IndoorOutdoor for 15 years straight. It's been a great advertising
                                    choice for my business. The phones been ringing for 15 years with new business!
                                </h5>
                                <p>
                                    Tim C.
                                </p>
                                <h6> BlueSky Painting </h6>
                            </a>
                        </div>
                        <div class="testimonials-box">
                            <a>
                                <img src="{{ asset('assets/img/home-pro/nhance.jpg') }}" alt="">
                                <h5>
                                    The magazine is first class…
                                </h5>
                                <p>
                                    We highly recommend using IndoorOutdoor for your advertising needs. The magazine is first
                                    class and it will help you get into homes in residential areas that are more apt to need
                                    remodeling services. – Anna and Bob Exner, Owners –
                                </p>
                                <h6> Nhance </h6>
                            </a>
                        </div>
                        <div class="testimonials-box">
                            <a>
                                <img src="{{ asset('assets/img/home-pro/midwest.jpg') }}" alt="">
                                <h5>
                                    The only mail driven marketing tool that has been such a success for us.
                                </h5>
                                <p>
                                    Midwest Lightacapes IndoorOutdoor Magazine has out performed for our company over Home Advisor
                                    and Angie’s List. We have a five star rating with these companies but most of our sterling leads
                                    are from IndoorOutdoor magazine. We have been with them for five years. Their customer service
                                    give us a sense of our own Marketing Team. We highly recommend Indoor Outdoor Magazine for your
                                    company. It’s the only mail driven marketing tool that has been such a success for us.
                                    – Bud and Jane Freed, Owners Midwest Lightscapes Metro Detroit Area –
                                </p>
                                <h6> Midwest Lightacapes </h6>
                            </a>
                        </div>
                        <div class="testimonials-box">
                            <a>
                                <img src="{{ asset('assets/img/home-pro/viking.jpg') }}" alt="">
                                <h5>
                                    “Response from the ad is fantastic.”
                                </h5>
                                <p>
                                    To all the great staff at Indoor Outdoor Magazine. Our customers often compliment our
                                    ad and….the magazine itself. Response from the ad is fantastic. It is not over – sold
                                    and cluttered. All the advertising clients are presented in a class-act format. Thank
                                    you for creating an unique platform in a world laden with clutter.
                                </p>
                                <h6> Viking Power Wash </h6>
                            </a>
                        </div>
                        <div class="testimonials-box">
                            <a>
                                <img src="{{ asset('assets/img/home-pro/elite.png') }}" alt="">
                                <h5>
                                    A great increase in leads being generated
                                </h5>
                                <p>
                                    I began using the Indoor Outdoor publication for advertising for our business in late
                                    Spring 2022.  As a result, I saw a great increase in leads being generated from the type
                                    of clients that our business caters to. This publication has been a great resource for
                                    advertising for our business and I would highly recommend it to others.
                                </p>
                                <h6> Elite Awnings & Sun Shades </h6>
                            </a>
                        </div>
                        <div class="testimonials-box">
                            <a>
                                <img src="{{ asset('assets/img/home-pro/old-world.jpg') }}" alt="">
                                <h5>
                                    “It delivers real results.”
                                </h5>
                                <p>
                                    A must advertising resource for upscale home improvement providers.”  – Steve S.
                                    Old World Refinishing, Ltd. Serving the Metro Detroit community for over 35 Years. –
                                </p>
                                <h6> Old World Refinishing, Ltd </h6>
                            </a>
                        </div>
                        <div class="testimonials-box">
                            <a>
                                <img src="{{ asset('assets/img/home-pro/grout-doctor.jpg') }}" alt="">
                                <h5>
                                    With all the direct mail options, IndoorOutdoor stands out among the rest.
                                </h5>
                                <p>
                                    The high quality of the magazine is like looking through the Wish Book. People
                                    will hold onto something of value, my ad is seen several times over the month. I
                                    also like being displayed with other quality contractors. – David Wegener, Owner –
                                </p>
                                <h6> The Grout Doctor </h6>
                            </a>
                        </div>
                        <div class="testimonials-box">
                            <a>
                                <img src="{{ asset('assets/img/home-pro/rml.jpg') }}" alt="">
                                <h5>
                                    Leads that Produce!
                                </h5>
                                <p>
                                    “The IndoorOutdoor Resource consistently produces high quality leads for my business.
                                    One of those leads, in Northville, produced our largest residential job ever! Over $57,000!!”
                                    – Rick Luth, Owner –
                                </p>
                                <h6> RML </h6>
                            </a>
                        </div>
                        <div class="testimonials-box">
                            <a>
                                <img src="{{ asset('assets/img/home-pro/ron-jackson.jpg') }}" alt="">
                                <h5>
                                    Thank You!
                                </h5>
                                <p>
                                    After 54 Years in Business, Ron is finally retiring. Thank you for such great advertising over
                                    the years. It helped make our business what it was. – Ron &amp; Carol Jackson –
                                </p>
                                <h6> Ron Jackson </h6>
                            </a>
                        </div>
                        <div class="testimonials-box">
                            <a>
                                <img src="{{ asset('assets/img/home-pro/ugly.jpg') }}" alt="">
                                <h5>
                                    The IndoorOutdoor Resource has grown our business substantially!
                                </h5>
                                <p>
                                    We are able to directly focus on key specifics using tools only available through Indoor/Outdoor.
                                    Their full-color, elegant publication is a GREAT resource for businesses and customer alike.
                                    – Steve VanOast, Owner –
                                </p>
                                <h6> Ugly Shingles, LLC </h6>
                            </a>
                        </div>
                        <div class="testimonials-box">
                            <a>
                                <img src="{{ asset('assets/img/home-pro/rhino.jpg') }}" alt="">
                                <h5>
                                    Consistently brings in quality leads every year.
                                </h5>
                                <p>
                                    We have advertised with IndoorOutdoor since 2011. It consistently brings in quality leads every
                                    year by reaching our target market and the right customers. Thanks for helping our business grow.
                                    I would highly recommend advertising in the IndoorOutdoor Magazine.
                                </p>
                                <h6> Rhino Shield </h6>
                            </a>
                        </div>
                        <div class="testimonials-box">
                            <a>
                                <img src="{{ asset('assets/img/home-pro/mr-enclosure.jpg') }}" alt="">
                                <h5>
                                    “The ONLY direct mail program that works…”
                                </h5>
                                <p>
                                    I’ve been in this business for a very long time and the IndoorOutdoor Resource is the ONLY direct
                                    mail program that works. It’s consistent and my brand continues to grow. – Jim McVeigh, Mr. Enclosure Sunrooms –
                                </p>
                                <h6> Mr. Enclosure Sunrooms </h6>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.animate-value').each(function() {
                var $this = $(this);
                var finalValue = parseInt($this.data('value'));
                var symbol = $this.data('symbol')
                var text = $this.data('text')

                $({ Counter: 0 }).animate({ Counter: finalValue }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function() {
                        var formattedValue = Math.ceil(this.Counter).toString();
                        formattedValue = formattedValue.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        $this.text(symbol + formattedValue + text);
                    },
                    complete: function() {
                        var formattedValue = finalValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        $this.text(symbol + formattedValue + text);
                    }
                });
            });
        });
    </script>
@endsection
