<div>
    <select class="form-control select">
        @foreach ($items as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" {{ $optionValue == 2 ? 'selected' : '' }}>{{ $optionLabel }}
            </option>
        @endforeach
    </select>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#select2').select2();
        });
    </script>
@endpush
