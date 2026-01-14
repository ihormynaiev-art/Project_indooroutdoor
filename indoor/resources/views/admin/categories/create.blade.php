@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <form method="post" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="row">
                    <div class="col-lg-7 col-sm-12 m-auto">
                        <div class="content-page-header">
                            <h5>Add Category</h5>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"> Name </label>
                            <input
                                required
                                name="name"
                                type="text"
                                class="form-control"
                                value="{{ old('name') }}"
                            >
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Slug</label>
                            <input
                                name="slug"
                                type="text"
                                required
                                class="form-control"
                                value="{{ old('slug') }}"
                            >
                            <x-input-error class="mt-2" :messages="$errors->get('slug')" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Parent Category</label>
                            <select name="parent_id" class="select">
                                <option></option>
                                @foreach($parentCategories as $parentCategory)
                                    <option value="{{ $parentCategory->id }}">{{ $parentCategory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Priority</label>
                            <input name="prio" value="{{ old('prio', 1) }}" type="number" class="form-control">
                        </div>
                        <div class="form-groupheads d-flex mb-4">
                            <h2>Active</h2>
                            <div class="mx-2 active-switch">
                                <label class="switch">
                                    <input name="is_active" @checked(old('is_active')) value="1" type="checkbox">
                                    <span class="sliders round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-groupheads d-flex mb-4">
                            <h2>Show In Home Top Slider</h2>
                            <div class="mx-2 active-switch">
                                <label class="switch">
                                    <input name="show_in_home_top_slider" @checked(old('show_in_home_top_slider')) value="1" type="checkbox">
                                    <span class="sliders round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <div class="form-uploads-path">
                                <img src="{{ URL::asset('admin_assets/img/icons/upload.svg') }}" alt="img">
                                <div class="file-browse">
                                    <h6>Drag & drop file or </h6>
                                    <div class="file-browse-path">
                                        <input id="image-input" name="image" type="file">
                                        <a href="javascript:void(0);"> Browse</a>
                                    </div>
                                </div>
                                <h5>Supported formats: JPEG, PNG, JPG</h5>
                                <x-input-error class="mt-2" :messages="$errors->get('image')" />
                            </div>
                        </div>
                        <div class="btn-path">
                            <a href="{{ url()->previous() }}" class="btn btn-cancel me-3">Cancel</a>
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
