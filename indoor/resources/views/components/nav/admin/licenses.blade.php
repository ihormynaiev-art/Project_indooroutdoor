<li>
    <a href="{{ route('admin.licenses.index') }}"
       class="{{ Route::is('admin.licenses.index', 'admin.licenses.edit') ? 'active' : '' }}">
        <i class="fe fe-file-text"></i>
        <span>Licenses</span>@if($licensesInReview !== '0')<span class="green-number">{{ $licensesInReview }}</span>@endif
    </a>
</li>
