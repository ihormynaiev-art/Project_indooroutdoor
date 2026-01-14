@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper page-settings">
        <div class="content">

            <div class="content-page-header content-page-headersplit">
                <h5> Advertisement Photos </h5>
            </div>

            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row mb-3">
                <div class="col-12">
                    <div class="alert alert-info" role="alert">
                        <i class="fa-solid fa-circle-info me-2"></i>
                        <strong>Tip:</strong> You can drag and drop images to change their order.
                    </div>
                </div>
            </div>

            <div class="row">
                <form method="POST" id="ad-photos-form" enctype="multipart/form-data"
                      action="{{ route('admin.contractors.update', $user->id) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <div class="general-info">
                        <div class="row">
                            <div id="gallery" class="form-uploads-path">
                                <div class="file-upload drag-file-area">
                                    <img src="{{ asset('assets/img/icons/upload-icon.svg') }}" alt="image">
                                    <h6>Drag & drop files or <span>Browse</span></h6>
                                    <p>Supported formats: JPEG, PNG, JPG</p>
                                    @foreach($errors->get('files.*') as $fileErrors)
                                        @foreach($fileErrors as $error)
                                            <x-input-error class="file-error" class="mt-2" :messages="$error"/>
                                        @endforeach
                                    @endforeach
                                    <input accept="image/png, image/jpeg, image/jpg, image/webp" id="file-input" multiple
                                           name="files[]" type="file">
                                </div>
                                <div class="file-preview">
                                    <ul class="gallery-selected-img">
                                        @foreach($user->providerDetail->adImages ?? [] as $image)
                                            <li class="images-prio">
                                                <div class="img-preview">
                                                    <img src="{{ url('storage/' . $image->path) }}"
                                                         alt="Service Image">
                                                    <a
                                                        href="javascript:void(0);"
                                                        onclick="removeElementFromHiddenArray({{ $image->id }})"
                                                        data-name=""
                                                        data-id="{{ $image->id }}"
                                                        class="remove-gallery"
                                                    >
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </a>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <input type="hidden" name="images" id="images" value="{{ $imagesIdsJson }}">
                                    <input type="hidden" name="order" id="orderInput">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="acc-submit pt-3">
                        <a href="{{ route('admin.contractors.index') }}" class="btn btn-secondary">Cancel</a>
                        <button id="submit" type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="{{ route('provider.details.show', $user->providerDetail->slug) }}"
                           target="_blank"
                           class="btn btn-success">Contractor Page</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            // Инициализация Sortable для галереи изображений
            var el = document.querySelector('.gallery-selected-img');
            if (el) {
                var sortable = new Sortable(el, {
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    dragClass: 'sortable-drag',
                    forceFallback: false,
                    onEnd: function (evt) {
                        updateOrderInput();
                    }
                });
            }

            // Функция для обновления порядка изображений
            function updateOrderInput() {
                var order = [];
                $('.gallery-selected-img li .img-preview a').each(function (index, element) {
                    var id = $(element).data('id');
                    if (id) {
                        order.push(id);
                    }
                });
                if (order.length > 0) {
                    $('#orderInput').val(order.join(','));
                } else {
                    $('#orderInput').val('');
                }
            }

            // Функция для переупорядочивания файлов в input согласно порядку в DOM
            function reorderFiles() {
                var fileInput = document.getElementById('file-input');
                if (!fileInput || !window.fileIdMap) {
                    return;
                }

                // Собираем порядок ID из DOM
                var orderedIds = [];
                $('.gallery-selected-img li .img-preview a').each(function (index, element) {
                    var id = $(element).data('id');
                    if (id && id.toString().startsWith('new-')) {
                        orderedIds.push(id);
                    }
                });

                if (orderedIds.length === 0) {
                    return;
                }

                // Переупорядочиваем файлы согласно порядку в DOM, используя fileIdMap
                var reorderedFiles = [];
                orderedIds.forEach(function(id) {
                    if (window.fileIdMap.has(id)) {
                        reorderedFiles.push(window.fileIdMap.get(id));
                    }
                });

                // Обновляем input с переупорядоченными файлами
                if (reorderedFiles.length > 0) {
                    var dataTransfer = new DataTransfer();
                    reorderedFiles.forEach(function(file) {
                        dataTransfer.items.add(file);
                    });
                    fileInput.files = dataTransfer.files;
                }
            }

            // Обработчик на кнопку submit - обновляем порядок перед отправкой
            $('#submit').on('click', function (e) {
                updateOrderInput();
                reorderFiles();
            });

            // Обработчик для формы - предотвращение отправки по Enter
            $('form').on('keypress', function (e) {
                if (e.which === 13) {
                    e.preventDefault();
                    return false;
                }
            });
        });

        // Функция для удаления элемента из скрытого массива изображений
        function removeElementFromHiddenArray(id) {
            const hiddenInput = document.getElementById('images');

            let array = JSON.parse(hiddenInput.value);
            array = array.filter(item => item !== id);
            hiddenInput.value = JSON.stringify(array);
        }
    </script>
@endsection
