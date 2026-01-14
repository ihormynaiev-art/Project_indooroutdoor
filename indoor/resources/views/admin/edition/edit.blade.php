@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <form method="post" action="{{ route('admin.edition.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-lg-7 col-sm-12 m-auto">
                        <div class="content-page-header">
                            <h5>E-dition</h5>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input
                                required
                                name="name"
                                type="text"
                                class="form-control"
                                value="{{ $settings->edition_name }}"
                            >
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Code</label>
                            <textarea
                                rows="3"
                                name="code"
                                required
                                class="form-control"
                            >{{ $settings->edition_code }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('code')" />
                        </div>
                        <div class="mb-3">
                            <div id="gallery" class="">
                                <div class="sub-title">
                                    <h6 class="mt-3 mb-1">Images</h6>
                                </div>
                                <div class="file-upload drag-file-area">
                                    <img src="{{ URL::asset('/assets/img/icons/upload-icon.svg') }}" alt="image">
                                    <h6>Drag & drop files or <span>Browse</span></h6>
                                    <p>Supported formats: JPEG, PNG, JPG</p>
                                    @foreach($errors->get('files.*') as $fileErrors)
                                        @foreach($fileErrors as $error)
                                            <x-input-error class="file-error" class="mt-2" :messages="$error" />
                                        @endforeach
                                    @endforeach
                                    <input accept="image/png, image/jpeg, image/jpg" id="file-input" multiple name="files[]" type="file">
                                </div>
                                <input hidden id="imagePaths" name="image_paths" value='[]'>
                                <div class="file-preview">
                                    <ul class="gallery-selected-img">
                                        @foreach($settings->image_paths as $image)
                                            <li class="images-prio">
                                                <div class="img-preview">
                                                    <img src="{{ url('storage/' . $image) }}" alt="Service Image">
                                                    <a
                                                        href="javascript:void(0);"
                                                        data-path="{{ $image }}"
                                                        class="remove-gallery"
                                                    >
                                                        <i class="fe fe-trash-2"></i>
                                                    </a>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="btn-path">
                            <a href="{{ route('edition.show') }}"
                               target="_blank"
                               class="btn btn-success me-3">Edition Page</a>
                            <a href="{{ url()->previous() }}" class="btn btn-cancel me-3">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function() {
            $(".gallery-selected-img").on("click", '.remove-gallery', function () {
                let imagePaths = JSON.parse($('#imagePaths').val());
                imagePaths.push($(this).data('path'))
                $('#imagePaths').val(JSON.stringify(imagePaths))
            })

            let draggableFileArea = document.querySelector(".drag-file-area");
            let fileInput = document.querySelector("#file-input");
            var newFileIndex = 0;

            if (fileInput) {
                fileInput.addEventListener("change", e => {
                    addFilesInfo(fileInput.files)
                });
            }

            let uploadedFiles = [];

            $('input[type="file"]').change(function(e) {
                let newFiles = e.target.files;
                uploadedFiles.push(...newFiles);

                let dataTransfer = new DataTransfer();
                uploadedFiles.forEach(file => {
                    dataTransfer.items.add(file);
                });

                this.files = dataTransfer.files;
            });

            function addFilesInfo(files){
                $('.file-block').remove()
                $.each(files, function(index, file) {
                    index = newFileIndex++
                    var html  =   `
                <div class="file-block">
                    <div class="file-info justify-content-around">
                        <span class="material-icons-outlined file-icon"><i class="fa fa-file-text"></i></span>
                        <span class="file-name">` + file.name + `</span>
                    |   <span class="file-size">` + (file.size/1024).toFixed(1) + " KB" + `</span>
                        <span data-name="${file.name}" class="material-icons remove-file-icon"><i class="fa fa-remove"></i></span>
                    </div>
                </div>
                `
                    $(".form-uploads-path").append(html);
                    let reader = new FileReader();

                    reader.onload = (e) => {
                        let html = '';
                        if (file.type.startsWith('video/')) {
                            html = `
                                <li>
                                    <div class="img-preview">
                                        <video src="${e.target.result}" controls></video>
                                        <a href="javascript:void(0);" data-id="new-${index}" data-name="${file.name}" class="remove-gallery">
                                            <i class="fe-trash2"></i>
                                        </a>
                                    </div>
                                </li>
                            `;
                        } else if (file.type.startsWith('image/')) {
                            html = `
                           <li>
                                <div class="img-preview">
                                    <img src="${e.target.result}" alt="Service Image">
                                    <a href="javascript:void(0);" data-id="new-${index}" data-name="${file.name}" class="remove-gallery"><i class="fe fe-trash"></i></a>
                                </div>
                            </li>
                            `
                        }
                        $(".gallery-selected-img").append(html);
                    }

                    reader.readAsDataURL(file);
                })
            }

            var el = document.querySelector('.gallery-selected-img');
        })
    </script>
@endsection
