<?php $page = 'add-service'; ?>
@extends('layout.mainlayout_admin')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-lg-12 m-auto">
                    <form method="post" action="{{ route('admin.settings.mail.update') }}">
                        @csrf
                        @method('patch')
                        <div class="container-service">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="additional">
                                        <div class="sub-title Service">
                                            <h6>Emails for registration notification</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="addservice-info">
                                @forelse($emails as $email)
                                    @if ($loop->first)
                                        <div class="row service-cont justify-content-center">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input required type="email" name="email[]" value="{{ $email }}" class="form-control" placeholder="Enter Email">
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row service-cont justify-content-center">
                                            <div class="col-md-4">
                                                <div class="d-flex">
                                                    <div class="form-group w-100">
                                                        <label>Addional Email</label>
                                                        <input name="email[]" type="email" class="form-control" value="{{ $email }}" placeholder="Enter Service Duration">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>&nbsp;</label>
                                                        <a href="#" class="btn btn-danger-outline trash"><i class="far fa-trash-alt"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @empty
                                    <div class="row service-cont justify-content-center">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input required type="email" name="email[]"  class="form-control" placeholder="Enter Email">
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                            <a href="javascript:void(0);" class="link-sets add-extra"><i class="fa fa-plus-circle me-2"
                                    aria-hidden="true"></i>Add Additional Email</a>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="bottom-btn">
                                    <div class="field-btns">
                                        <button class="btn btn-primary next_btn" type="submit">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @component('admin.components.model')
    @endcomponent
@endsection
