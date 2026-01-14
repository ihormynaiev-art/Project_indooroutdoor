<div class="form-group">
    <label class="col-form-label">Add Documents</label>
    <button type="button"
            class="d-block site-button site-button-primary"
            id="{{ $uploadBtnId }}">Upload</button>
    <input type="file"
           id="{{ $inputId }}"
           multiple
           name="documents[]"
           @if($accept) accept="{{ $accept }}" @endif
           class="form-control d-none"/>
    <span class="text-danger" id="{{ $errorId }}"></span>
    <div class="mt-2 file-requirements">
        <small class="text-muted">
            {!! $fileRequirements !!}
        </small>
    </div>
</div>
<div class="{{ $previewClass }} row"></div>

<script>
    (function() {
        // Initialize managed files array in global scope
        window.{{ $variableName }} = window.{{ $variableName }} || [];

        const uploadBtn = document.getElementById('{{ $uploadBtnId }}');
        const fileInput = document.getElementById('{{ $inputId }}');
        const previewContainer = document.querySelector('.{{ $previewClass }}');

        // Upload button click handler
        if (uploadBtn) {
            uploadBtn.addEventListener('click', function() {
                fileInput.click();
            });
        }

        // File input change handler
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                const newFiles = Array.from(this.files);

                newFiles.forEach(file => {
                    if (!window.{{ $variableName }}.some(existingFile => existingFile.name === file.name)) {
                        window.{{ $variableName }}.push(file);
                    }
                });

                renderPreviews_{{ $variableName }}();
            });
        }

        // Render previews function
        function renderPreviews_{{ $variableName }}() {
            if (!previewContainer) return;

            previewContainer.innerHTML = '';

            window.{{ $variableName }}.forEach(file => {
                let reader = new FileReader();

                reader.onload = function(e) {
                    let previewImg = '../assets/img/file-icon.png';

                    if (file.type.startsWith('image/')) {
                        previewImg = e.target.result;
                    }

                    let html = `
                        <div class="col-md-4 col-sm-6" id="document-preview">
                            <img src="${previewImg}" alt="Service Image">
                            <span class="d-flex justify-content-center mb-2">${file.name.slice(0, 15)}</span>
                            <a href="javascript:void(0);" data-name="${file.name}" class="remove-document-{{ $variableName }}"><i class="feather-trash-2"></i></a>
                        </div>
                    `;
                    previewContainer.insertAdjacentHTML('beforeend', html);
                };

                reader.readAsDataURL(file);
            });
        }

        // Remove document handler
        if (previewContainer) {
            previewContainer.addEventListener('click', function(e) {
                const removeBtn = e.target.closest('.remove-document-{{ $variableName }}');
                if (removeBtn) {
                    const fileNameToRemove = removeBtn.dataset.name;
                    window.{{ $variableName }} = window.{{ $variableName }}.filter(file =>
                        file.name.toLowerCase() !== fileNameToRemove.toLowerCase()
                    );
                    renderPreviews_{{ $variableName }}();
                }
            });
        }

        // Expose clear function globally for form reset
        window.clearFiles_{{ $variableName }} = function() {
            window.{{ $variableName }} = [];
            if (previewContainer) {
                previewContainer.innerHTML = '';
            }
        };
    })();
</script>
