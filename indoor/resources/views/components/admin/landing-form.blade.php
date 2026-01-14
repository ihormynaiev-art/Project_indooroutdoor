@props(['landing' => null, 'providerDetail' => null, 'action', 'method' => 'POST'])

<form method="POST" id="ad-photos-form" enctype="multipart/form-data" action="{{ $action }}">
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    @if($providerDetail)
        <input type="hidden" name="provider_detail_id" value="{{ $providerDetail->id }}">
    @endif

    <div class="mb-3 col-md-6">
        <h6 class="form-label">Title<sup>*</sup></h6>
        <input type="text"
               name="title"
               class="form-control"
               value="{{ old('title', $landing?->title) }}"
               maxlength="100"
               required>
        <small class="text-muted">Max 100 characters.</small>
    </div>

    <div class="mb-3 col-md-6">
        <h6 class="form-label">Slug<sup>*</sup></h6>
        <input type="text"
               name="slug"
               id="slug-input"
               class="form-control"
               value="{{ old('slug', $landing?->slug) }}"
               maxlength="50"
               pattern="[a-z0-9\-_]+"
               title="Only lowercase letters, numbers, hyphens and underscores are allowed"
               required>
        <small class="text-muted">Only lowercase letters, numbers, hyphens (-) and underscores (_). Max 50
            characters.</small>
    </div>

    <div class="form-groupheads">
        <h6 class="user-title">Is Published</h6>
        <div class="mx-2 active-switch">
            <label class="switch">
                <input type="hidden" name="is_published" value="0">
                <input name="is_published"
                       @checked(old('is_published', $landing?->is_published))
                       value="1"
                       type="checkbox">
                <span class="sliders round"></span>
            </label>
        </div>
    </div>

    <!-- Hero Image Upload -->
    <div class="general-info mb-4 col-md-6">
        <h6 class="user-title mb-3">Hero Image</h6>
        <p class="text-muted small mb-2">Recommended resolution: 1920 × 700 px</p>

        <div class="row">
            <div id="hero-gallery" class="form-uploads-path">
                <div class="file-upload drag-file-area drag-file-area-hero">
                    <img src="{{ asset('assets/img/icons/upload-icon.svg') }}" alt="image">
                    <h6>Drag & drop file or <span>Browse</span></h6>
                    <p>Supported formats: JPEG, PNG, JPG</p>
                    @error('hero_image')
                    <x-input-error class="file-error mt-2" :messages="$message"/>
                    @enderror
                    <input accept="image/png, image/jpeg, image/jpg, image/webp"
                           id="hero-image-input"
                           name="hero_image"
                           type="file">
                </div>
                <div class="file-preview">
                    <ul class="gallery-selected-img hero-gallery-selected-img">
                        @if($landing?->heroImage)
                            <li class="images-prio">
                                <div class="img-preview">
                                    <img src="{{ asset('storage/' . $landing->heroImage->path) }}" alt="Hero Image">
                                    <a href="javascript:void(0);"
                                       onclick="removeHeroImage({{ $landing->heroImage->id }})"
                                       data-id="{{ $landing->heroImage->id }}"
                                       class="remove-gallery">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </div>
                            </li>
                        @endif
                    </ul>
                    <input type="hidden" name="delete_hero_image" id="delete-hero-image" value="">
                </div>
            </div>
        </div>
    </div>

    <!-- Offer Image Upload -->
    <div class="general-info mb-4 col-md-6">
        <h6 class="user-title mb-3">Offer Image</h6>
        <p class="text-muted small mb-2">Recommended resolution: 1200 × 800 px</p>

        <div class="row">
            <div id="offer-gallery" class="form-uploads-path">
                <div class="file-upload drag-file-area drag-file-area-offer">
                    <img src="{{ asset('assets/img/icons/upload-icon.svg') }}" alt="image">
                    <h6>Drag & drop file or <span>Browse</span></h6>
                    <p>Supported formats: JPEG, PNG, JPG</p>
                    @error('offer_image')
                    <x-input-error class="file-error mt-2" :messages="$message"/>
                    @enderror
                    <input accept="image/png, image/jpeg, image/jpg, image/webp"
                           id="offer-image-input"
                           name="offer_image"
                           type="file">
                </div>
                <div class="file-preview">
                    <ul class="gallery-selected-img offer-gallery-selected-img">
                        @if($landing?->offerImage)
                            <li class="images-prio">
                                <div class="img-preview">
                                    <img src="{{ asset('storage/' . $landing->offerImage->path) }}" alt="Offer Image">
                                    <a href="javascript:void(0);"
                                       onclick="removeOfferImage({{ $landing->offerImage->id }})"
                                       data-id="{{ $landing->offerImage->id }}"
                                       class="remove-gallery">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </div>
                            </li>
                        @endif
                    </ul>
                    <input type="hidden" name="delete_offer_image" id="delete-offer-image" value="">
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3 col-md-6">
        <h6>Contractor description:</h6>
        @if($providerDetail->description)
            <p>{{ $providerDetail->description }}</p>
        @else
            <p>Empty</p>
        @endif
    </div>

    <div class="form-check">
        <input type="hidden" name="use_custom_description" value="0">
        <input class="form-check-input"
               type="checkbox"
               name="use_custom_description"
               value="1"
               id="showMap"
            @checked(old('use_custom_description', $landing?->use_custom_description))>
        <label class="form-check-label" for="showMap">
            Custom Description
        </label>
    </div>

    <div class="mb-3 col-md-6">
        <label class="form-label" for="customDescription">Custom Description</label>
        <textarea class="form-control"
                  id="customDescription"
                  name="custom_description"
                  rows="5"
                  {{ old('use_custom_description', $landing?->use_custom_description) ? '' : 'disabled' }}>{{ old('custom_description', $landing?->custom_description) }}</textarea>
    </div>

    <div class="mb-3 col-md-12">
        <h6>Contractor Portfolio Images:</h6>
        @if($providerDetail?->portfolioImages && $providerDetail->portfolioImages->count() > 0)
            <div class="d-flex flex-wrap gap-2 mb-3">
                @foreach($providerDetail->portfolioImages as $image)
                    <img src="{{ asset('storage/' . $image->path) }}"
                         alt="Portfolio Image"
                         class="img-thumbnail"
                         style="max-width: 150px; height: 150px; object-fit: cover;">
                @endforeach
            </div>
        @else
            <p class="text-muted">No portfolio images available</p>
        @endif
    </div>

    <div class="form-check">
        <input type="hidden" name="use_custom_portfolio" value="0">
        <input class="form-check-input"
               type="checkbox"
               name="use_custom_portfolio"
               value="1"
               id="customPortfolio"
            @checked(old('use_custom_portfolio', $landing?->use_custom_portfolio))>
        <label class="form-check-label" for="customPortfolio">
            Custom Portfolio
        </label>
    </div>

    <!-- Portfolio Images Upload -->
    <div class="general-info mb-4 col-md-6"
         style="{{ old('use_custom_portfolio', $landing?->use_custom_portfolio) ? '' : 'display: none;' }}">
        <h6 class="user-title mb-3">Custom Portfolio Images</h6>

        <div class="row">
            <div id="portfolio-gallery" class="form-uploads-path">
                <div class="file-upload drag-file-area drag-file-area-portfolio">
                    <img src="{{ asset('assets/img/icons/upload-icon.svg') }}" alt="image">
                    <h6>Drag & drop files or <span>Browse</span></h6>
                    <p>Supported formats: JPEG, PNG, JPG (multiple files allowed)</p>
                    @error('portfolio_images')
                    <x-input-error class="file-error mt-2" :messages="$message"/>
                    @enderror
                    @error('portfolio_images.*')
                    <x-input-error class="file-error mt-2" :messages="$message"/>
                    @enderror
                    <input accept="image/png, image/jpeg, image/jpg, image/webp"
                           id="portfolio-images-input"
                           name="portfolio_images[]"
                           type="file"
                           multiple
                        {{ old('use_custom_portfolio', $landing?->use_custom_portfolio) ? '' : 'disabled' }}>
                </div>
                <div class="file-preview">
                    <ul class="gallery-selected-img portfolio-gallery-selected-img">
                        @if($landing?->portfolioImages)
                            @foreach($landing->portfolioImages as $image)
                                <li class="images-prio">
                                    <div class="img-preview">
                                        <img src="{{ asset('storage/' . $image->path) }}" alt="Portfolio Image">
                                        <a href="javascript:void(0);"
                                           onclick="removePortfolioImage({{ $image->id }})"
                                           data-id="{{ $image->id }}"
                                           class="remove-gallery">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                    <input type="hidden" name="portfolio_images_ids" id="portfolio-images-ids"
                           value="{{ $landing?->portfolioImages ? json_encode($landing->portfolioImages->pluck('id')->toArray()) : '[]' }}">
                </div>
            </div>
        </div>
    </div>

    <div class="acc-submit pt-3">
        <a href="{{ route('admin.landings.index') }}" class="btn btn-secondary">Cancel</a>
        <button id="submit" type="submit" class="btn btn-primary">
            {{ $landing ? 'Update Landing' : 'Create Landing' }}
        </button>
        @if($landing ?? false)
            <a href="{{ route('landings.show', ['providerDetail' => $providerDetail,
                        'landing' => $landing->slug
                    ]) }}"
               target="_blank"
               class="btn btn-success">Landing Page</a>
        @endif
    </div>
</form>

@push('scripts')
    <script>
        // Функции для удаления существующих изображений
        function removeHeroImage(id) {
            $('#delete-hero-image').val(id);
            $('.hero-gallery-selected-img').find(`a[data-id="${id}"]`).closest('li').remove();
        }

        function removeOfferImage(id) {
            $('#delete-offer-image').val(id);
            $('.offer-gallery-selected-img').find(`a[data-id="${id}"]`).closest('li').remove();
        }

        function removePortfolioImage(id) {
            const hiddenInput = document.getElementById('portfolio-images-ids');
            let array = JSON.parse(hiddenInput.value);
            array = array.filter(item => item !== id);
            hiddenInput.value = JSON.stringify(array);
            $('.portfolio-gallery-selected-img').find(`a[data-id="${id}"]`).closest('li').remove();
        }

        $(function () {
            // Массив для хранения portfolio файлов
            window.portfolioFiles = window.portfolioFiles || [];

            // Проверка поддержки drag-and-drop
            var isAdvancedUpload = function () {
                var div = document.createElement('div');
                return (('draggable' in div) || ('ondragstart' in div && 'ondrop' in div)) && 'FormData' in window && 'FileReader' in window;
            }();

            // Функция для инициализации загрузки изображений
            function initImageUpload(dragAreaSelector, inputSelector, gallerySelector) {
                let draggableFileArea = document.querySelector(dragAreaSelector);
                let fileInput = document.querySelector(inputSelector);

                if (!draggableFileArea || !fileInput) {
                    return;
                }

                // Обработчик изменения input
                $(inputSelector).on('change', function () {
                    const files = Array.from(this.files);
                    if (files.length > 0) {
                        // Берем только первый файл
                        const file = files[0];
                        displayImagePreview(file, inputSelector, gallerySelector);
                    }
                });

                // Drag-and-drop обработчики
                if (isAdvancedUpload) {
                    ["drag", "dragstart", "dragend", "dragover", "dragenter", "dragleave", "drop"].forEach(evt =>
                        draggableFileArea.addEventListener(evt, e => {
                            e.preventDefault();
                            e.stopPropagation();
                        })
                    );

                    ["dragover", "dragenter"].forEach(evt => {
                        draggableFileArea.addEventListener(evt, e => {
                            e.preventDefault();
                            e.stopPropagation();
                            draggableFileArea.classList.add('is-dragover');
                        });
                    });

                    ["dragleave", "dragend", "drop"].forEach(evt => {
                        draggableFileArea.addEventListener(evt, e => {
                            e.preventDefault();
                            e.stopPropagation();
                            draggableFileArea.classList.remove('is-dragover');
                        });
                    });

                    draggableFileArea.addEventListener("drop", e => {
                        let files = e.dataTransfer.files;
                        if (files.length > 0) {
                            // Берем только первый файл
                            const file = files[0];

                            // Создаем новый DataTransfer с одним файлом
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);
                            fileInput.files = dataTransfer.files;

                            displayImagePreview(file, inputSelector, gallerySelector);
                        }
                    });
                }
            }

            // Функция для отображения превью изображения
            function displayImagePreview(file, inputSelector, gallerySelector) {
                // Очищаем предыдущее изображение
                $(gallerySelector).empty();

                let reader = new FileReader();
                reader.onload = (e) => {
                    let html = `
                            <li class="images-prio">
                                <div class="img-preview">
                                    <img src="${e.target.result}" alt="Service Image">
                                    <a href="javascript:void(0);"
                                       data-input="${inputSelector}"
                                       data-gallery="${gallerySelector}"
                                       class="remove-single-image">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </div>
                            </li>
                        `;
                    $(gallerySelector).append(html);
                };
                reader.readAsDataURL(file);
            }

            // Функция для инициализации загрузки множественных изображений
            function initMultipleImageUpload(dragAreaSelector, inputSelector, gallerySelector) {
                let draggableFileArea = document.querySelector(dragAreaSelector);
                let fileInput = document.querySelector(inputSelector);

                if (!draggableFileArea || !fileInput) {
                    return;
                }

                // Обработчик изменения input
                $(inputSelector).on('change', function () {
                    const newFiles = Array.from(this.files);

                    // Добавляем новые файлы в глобальный массив, если их там еще нет
                    newFiles.forEach(file => {
                        if (!window.portfolioFiles.some(existingFile => existingFile.name === file.name)) {
                            window.portfolioFiles.push(file);
                        }
                    });

                    // Обновляем input.files из массива
                    updateInputFiles(fileInput);

                    // Перерисовываем превью
                    displayMultipleImagePreviews(gallerySelector);
                });

                // Drag-and-drop обработчики
                if (isAdvancedUpload) {
                    ["drag", "dragstart", "dragend", "dragover", "dragenter", "dragleave", "drop"].forEach(evt =>
                        draggableFileArea.addEventListener(evt, e => {
                            e.preventDefault();
                            e.stopPropagation();
                        })
                    );

                    ["dragover", "dragenter"].forEach(evt => {
                        draggableFileArea.addEventListener(evt, e => {
                            e.preventDefault();
                            e.stopPropagation();
                            draggableFileArea.classList.add('is-dragover');
                        });
                    });

                    ["dragleave", "dragend", "drop"].forEach(evt => {
                        draggableFileArea.addEventListener(evt, e => {
                            e.preventDefault();
                            e.stopPropagation();
                            draggableFileArea.classList.remove('is-dragover');
                        });
                    });

                    draggableFileArea.addEventListener("drop", e => {
                        let newFiles = Array.from(e.dataTransfer.files);
                        if (newFiles.length > 0) {
                            // Добавляем новые файлы в глобальный массив
                            newFiles.forEach(file => {
                                if (!window.portfolioFiles.some(existingFile => existingFile.name === file.name)) {
                                    window.portfolioFiles.push(file);
                                }
                            });

                            // Обновляем input.files из массива
                            updateInputFiles(fileInput);

                            // Перерисовываем превью
                            displayMultipleImagePreviews(gallerySelector);
                        }
                    });
                }
            }

            // Функция для обновления input.files из глобального массива
            function updateInputFiles(fileInput) {
                const dataTransfer = new DataTransfer();
                window.portfolioFiles.forEach(file => dataTransfer.items.add(file));
                fileInput.files = dataTransfer.files;
            }

            // Функция для отображения превью множественных изображений
            function displayMultipleImagePreviews(gallerySelector) {
                // Очищаем предыдущие изображения
                $(gallerySelector).empty();

                window.portfolioFiles.forEach((file, index) => {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        let html = `
                                <li class="images-prio" data-index="${index}" data-filename="${file.name}">
                                    <div class="img-preview">
                                        <img src="${e.target.result}" alt="Portfolio Image">
                                        <a href="javascript:void(0);"
                                           data-filename="${file.name}"
                                           class="remove-multiple-image">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </div>
                                </li>
                            `;
                        $(gallerySelector).append(html);
                    };
                    reader.readAsDataURL(file);
                });
            }

            // Обработчик удаления изображения
            $(document).on('click', '.remove-single-image', function () {
                const inputSelector = $(this).data('input');
                const gallerySelector = $(this).data('gallery');

                // Очищаем input
                $(inputSelector).val('');

                // Удаляем превью
                $(gallerySelector).empty();
            });

            // Обработчик удаления множественных изображений
            $(document).on('click', '.remove-multiple-image', function () {
                const filenameToRemove = $(this).data('filename');
                const fileInput = document.querySelector('#portfolio-images-input');

                if (!fileInput) return;

                // Удаляем файл из глобального массива по имени
                window.portfolioFiles = window.portfolioFiles.filter(file => file.name !== filenameToRemove);

                // Обновляем input.files из массива
                updateInputFiles(fileInput);

                // Перерисовываем превью
                displayMultipleImagePreviews('.portfolio-gallery-selected-img');
            });

            // Инициализация для Hero Image
            initImageUpload('.drag-file-area-hero', '#hero-image-input', '.hero-gallery-selected-img');

            // Инициализация для Offer Image
            initImageUpload('.drag-file-area-offer', '#offer-image-input', '.offer-gallery-selected-img');

            // Инициализация для Portfolio Images
            initMultipleImageUpload('.drag-file-area-portfolio', '#portfolio-images-input', '.portfolio-gallery-selected-img');

            // Обработчик для формы - предотвращение отправки по Enter
            $('form').on('keypress', function (e) {
                if (e.which === 13) {
                    e.preventDefault();
                    return false;
                }
            });

            // Обработчик submit формы - синхронизируем файлы перед отправкой
            $('form').on('submit', function (e) {
                const fileInput = document.querySelector('#portfolio-images-input');
                if (fileInput && window.portfolioFiles && window.portfolioFiles.length > 0) {
                    updateInputFiles(fileInput);
                }
            });

            // Управление состоянием textarea Custom Description
            function toggleCustomDescription() {
                const checkbox = $('#showMap');
                const textarea = $('#customDescription');

                if (checkbox.is(':checked')) {
                    textarea.prop('disabled', false);
                } else {
                    textarea.prop('disabled', true);
                }
            }

            // Управление состоянием Portfolio Images
            function toggleCustomPortfolio() {
                const checkbox = $('#customPortfolio');
                const portfolioSection = $('#portfolio-gallery').closest('.general-info');
                const portfolioInput = $('#portfolio-images-input');

                if (checkbox.is(':checked')) {
                    portfolioSection.show();
                    portfolioInput.prop('disabled', false);
                } else {
                    portfolioSection.hide();
                    portfolioInput.prop('disabled', true);
                    // Очищаем выбранные файлы
                    window.portfolioFiles = [];
                    portfolioInput.val('');
                    // Очищаем все превью (и существующие, и новые)
                    $('.portfolio-gallery-selected-img li').each(function () {
                        const imageId = $(this).find('a').data('id');
                        if (imageId) {
                            // Если это существующее изображение, помечаем на удаление
                            removePortfolioImage(imageId);
                        }
                    });
                    $('.portfolio-gallery-selected-img').empty();
                    // Очищаем скрытое поле с ID
                    $('#portfolio-images-ids').val('[]');
                }
            }

            // Устанавливаем начальное состояние
            toggleCustomDescription();
            toggleCustomPortfolio();

            // Обработчик изменения чекбокса Custom Description
            $('#showMap').on('change', toggleCustomDescription);

            // Обработчик изменения чекбокса Custom Portfolio
            $('#customPortfolio').on('change', toggleCustomPortfolio);

            // Обработчик для slug input - автоматическое преобразование и валидация
            $('#slug-input').on('input', function () {
                let value = $(this).val();

                // Преобразуем в нижний регистр
                value = value.toLowerCase();

                // Удаляем все символы, кроме латинских букв, цифр, дефисов и подчеркиваний
                value = value.replace(/[^a-z0-9\-_]/g, '');

                // Обновляем значение
                $(this).val(value);
            });
        });
    </script>
@endpush
