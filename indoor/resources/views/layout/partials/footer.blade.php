<footer class="footer">

    <!-- Footer Top -->
    <div class="footer-top aos" data-aos="fade-up">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <!-- Footer Widget -->
                    <div class="footer-widget">
                        <div class="footer-logo">
                            <a href="{{ url('/') }}"><img src="{{ URL::asset('/assets/img/logo_white.png') }}"
                                    alt="logo"></a>
                        </div>
                        <div class="footer-content">
                            <p>Michigan Independently Owned and Operated with Pride. </p>
                        </div>
                    </div>
                    <!-- /Footer Widget -->
                </div>
                <div class="col-lg-4 col-md-6">
                    <!-- Footer Widget -->
                    <div class="footer-widget footer-menu">
                        <h2 class="footer-title">Quick Links</h2>
                        <ul>
                            <li>
                                <a href="{{ url('/') }}">Home</a>
                            </li>
                            <li>
                                <a href="{{ route('edition.show') }}">E-dition</a>
                            </li>
                            <li>
                                <a href="{{ route('catalog.index') }}">Services</a>
                            </li>
                            <li>
                                <a href="{{ route('home-pro') }}" class="d-flex align-items-center gap-2">
                                    Are you a Qualified Contractor?
                                    <img class="footer-user-icon" src="{{ asset('assets/img/user2.png') }}" alt="user-icon">
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('contact-us') }}">Contact Us</a>
                            </li>
                            <li>
                                <a href="{{ url('about-us') }}">About Us</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /Footer Widget -->
                </div>
                <div class="col-lg-4 col-md-6">
                    <!-- Footer Widget -->
                    <div class="footer-widget footer-contact">
                        <h2 class="footer-title">Contact Us</h2>
                        <div class="footer-contact-info">
                            <p><span><i class="feather-phone"></i></span><a href="tel:7344536900"> 734.453.6900</a></p>
                            <p class="mb-0"><span><i class="feather-mail"></i></span>
                                <a id="copyEmailButton" href="mailto:info@indooroutdoor.com">info@indooroutdoor.com</a>
                            </p>
                            <div class="copy-notification" id="copyNotification">Copied!</div>
                        </div>
                    </div>
                    <!-- /Footer Widget -->
                </div>
            </div>
        </div>
    </div>
    <!-- /Footer Top -->

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <!-- Copyright -->
            <div class="copyright">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="copyright-text">
                            <p class="mb-0">Copyright &copy;
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>. All Rights Reserved.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <!-- Copyright Menu -->
                        <div class="copyright-menu">
                            <ul class="policy-menu">
                                <li>
                                    <a href="{{ url('privacy-policy') }}">Privacy Policy</a>
                                </li>
                                <li>
                                    <a href="{{ url('terms-condition') }}">Terms & Conditions</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /Copyright Menu -->
                    </div>
                </div>
            </div>
            <!-- /Copyright -->
        </div>
    </div>
    <!-- /Footer Bottom -->
</footer>

