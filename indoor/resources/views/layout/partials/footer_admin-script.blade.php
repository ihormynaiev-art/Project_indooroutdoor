<!-- jQuery -->
<script src="{{ URL::asset('/admin_assets/js/jquery-3.7.1.min.js') }}"></script>

<!-- Select 2 JS-->
<script src="{{ URL::asset('/admin_assets/js/select2.min.js') }}"></script>

<!-- Chart JS -->
<script src="{{ URL::asset('/admin_assets/plugins/apexchart/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('/admin_assets/plugins/apexchart/chart-data.js') }}"></script>

<!-- Bootstrap Core JS -->
<script src="{{ URL::asset('/admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Bootstrap Tagsinput JS -->
<script src="{{ URL::asset('/admin_assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js') }}"></script>

<!-- Feather Icon JS -->
<script src="{{ URL::asset('/admin_assets/js/feather.min.js') }}"></script>

@if (Route::is(['calendar-settings']))
    <!-- Datetimepicker JS -->
    <script src="{{ URL::asset('/admin_assets/plugins/moment/moment.min.js') }}"></script>

    <!-- Full Calendar JS -->
    <script src="{{ URL::asset('/admin_assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ URL::asset('/admin_assets/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
    <script src="{{ URL::asset('/admin_assets/plugins/fullcalendar/jquery.fullcalendar.js') }}"></script>
@endif

@if (Route::is(['security']))
    <!-- Mobile Input -->
    <script src="{{ URL::asset('/admin_assets/plugins/intltelinput/js/intlTelInput.js') }}"></script>
    <script src="{{ URL::asset('/admin_assets/plugins/intltelinput/js/utils.js') }}"></script>
@endif

<!-- Datatable JS -->
<script src="{{ URL::asset('/admin_assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('/admin_assets/js/dataTables.bootstrap4.min.js') }}"></script>

<!-- Ck Editor JS -->
<script src="{{ URL::asset('admin_assets/js/ckeditor.js') }}"></script>

<!-- Slimscroll JS -->
<script src="{{ URL::asset('/admin_assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Map JS -->
<script src="{{ URL::asset('/admin_assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Sweetalert 2 -->
<script src="{{ URL::asset('/admin_assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
<script src="{{ URL::asset('/admin_assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>

<!-- Datetimepicker JS -->
<script src="{{ URL::asset('/admin_assets/js/moment.min.js') }}"></script>
<script src="{{ URL::asset('/admin_assets/js/bootstrap-datetimepicker.min.js') }}"></script>


@if (Route::is(['admin.contractors.edit',]))
    <!-- Owl Carousel JS -->
    <script src="{{ URL::asset('/admin_assets/js/owl.carousel.min.js') }}"></script>
    <!-- Sortable JS -->
    <script src="{{ URL::asset('/assets/plugins/sortable/Sortable.min.js') }}"></script>
@endif

@if (Route::is(['view-service']))
    <!-- Fancybox JS -->
    <script src="{{ URL::asset('assets/plugins/fancybox/jquery.fancybox.min.js') }}"></script>
@endif
<!-- Validation-->
<script src="{{ URL::asset('admin_assets/js/validation.js')}}"></script>

@if (Route::is(['admin.magazines.index']))
    @vite(['resources/js/admin/magazines.js'])
@endif

@if (Route::is(['admin.magazineImages.index']))
    @vite(['resources/js/admin/magazineImages.js'])
@endif

@if (Route::is(['admin.users.index']))
    @vite(['resources/js/admin/users.js'])
@endif

@if (Route::is(['admin.categories.index']))
    @vite(['resources/js/admin/categories.js'])
@endif

@if (Route::is(['admin.licenses.index']))
    @vite(['resources/js/admin/licenses.js'])
@endif

@if (Route::is(['admin.licenses.edit', 'admin.invite-codes.index']))
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endif

@if (Route::is(['admin.contactMessages.index']))
    @vite(['resources/js/admin/contact-messages.js'])
@endif

@if (Route::is(['sub-categories']))
    <script src="{{ URL::asset('/admin_assets/js/sub-categories.js') }}"></script>
@endif

@if (Route::is(['review']))
    <script src="{{ URL::asset('/admin_assets/js/review.js') }}"></script>
@endif
@yield('scripts')
@stack('scripts')
@vite(['resources/js/admin.js'])
