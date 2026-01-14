<script src="{{ URL::asset('/assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/feather.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ URL::asset('/assets/plugins/select2/js/select2.min.js') }}"></script>
{{--<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>--}}
@if (Route::is(['reset-password','security-settings','provider-security-settings']))
    <!-- Validation-->
    <script src="{{ URL::asset('/assets/js/validation.js') }}"></script>
@endif


@if (Route::is([
        'profile.edit',
        'catalog.index'
    ]))
    <!-- Sticky Sidebar JS -->
    <script src="{{ URL::asset('/assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
    <script src="{{ URL::asset('/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>
@endif

@if (Route::is([
        'provider.details.edit',
        'provider.reviews.settings.edit',
        'admin.details.editById',
        'admin.contractors.edit'
    ]))
    <script src="{{ URL::asset('/assets/plugins/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ URL::asset('/assets/plugins/sortable/Sortable.min.js') }}"></script>
@endif

@if (Route::is([
        'provider.*',
        'profile.edit',
        'admin.details.editById'
    ]))
    <!-- Slimscroll JS -->
    <script src="{{ URL::asset('/assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
@endif

@if (Route::is([
        'provider.testimonials.index',
        'provider.google-reviews.index',
        'provider.facebook-reviews.index',
        'provider.request-quotes.index',
        'provider.provider-messages.index',
    ]))
    <!-- Datatables JS -->
    <script src="{{ URL::asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/plugins/datatables/datatables.min.js') }}"></script>
@endif

@yield('scripts')
@vite(['resources/js/app.js'])
