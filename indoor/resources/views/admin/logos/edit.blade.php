@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <form method="post" action="{{ route('admin.logos.update', $logo->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-7 col-sm-12 m-auto">
                        <div class="content-page-header">
                            <h5>Edit Logo</h5>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Slug</label>
                            <input
                                name="slug"
                                type="text"
                                required
                                class="form-control"
                                value="{{ $logo->slug }}"
                            >
                            <x-input-error class="mt-2" :messages="$errors->get('slug')" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Priority</label>
                            <input name="prio" value="{{ $logo->prio }}" type="number" class="form-control">
                        </div>
                        <div class="form-groupheads d-flex mb-4">
                            <h2>Active</h2>
                            <div class="mx-2 active-switch">
                                <label class="switch">
                                    <input name="is_active" @checked($logo->is_active) value="1" type="checkbox">
                                    <span class="sliders round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">File</label>
                            <div class="form-uploads-path">
                                <img src="{{ URL::asset('admin_assets/img/icons/upload.svg') }}" alt="img">
                                <div class="file-browse">
                                    <h6>Drag & drop file or </h6>
                                    <div class="file-browse-path">
                                        <input id="image-input" accept="image/*"  name="file" type="file">
                                        <a href="javascript:void(0);"> Browse</a>
                                    </div>
                                </div>
                                <h5>Supported formats: SVG, PNG, JPEG/JPG</h5>
                                <x-input-error class="mt-2" :messages="$errors->get('file')" />
                            </div>
                        </div>
                        <div class="btn-path">
                            <a href="{{ url()->previous() }}" class="btn btn-cancel me-3">Cancel</a>
                            <button type="submit" class="btn btn-primary">Edit Logo</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
