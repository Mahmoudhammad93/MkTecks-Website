@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard') }}/assets/css/vendors/select2.css">
    @endpush
    <form action="{{ aurl('settings/update') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12 col-xl-12">
                <div class="card">
                    <h5 class="card-header">{{ $title }}</h5>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="floating-label" for="about_ar">{{ trans('admin.Terms Ar') }}</label>
                            <textarea class="form-control" name="about_ar" id="about_ar" rows="10">{{ $setting->about_ar }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="floating-label" for="about_en">{{ trans('admin.Terms En') }}</label>
                            <textarea class="form-control" name="about_en" id="about_en" rows="10">{{ $setting->about_en }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-pill btn-outline-primary btn-air-primary"><i
                                class="fas fa-save"></i>&nbsp;{{ trans('admin.Save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @push('script')
        <script src="{{ asset('dashboard') }}/assets/js/select2/select2.full.min.js"></script>
        <script src="{{ asset('dashboard') }}/assets/js/select2/select2-custom.js"></script>
        <script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>

        <script>
            $(function() {
                CKEDITOR.replace('about_ar', {
                    height: 450
                });
                CKEDITOR.replace('about_en', {
                    height: 450
                });
            });
        </script>
    @endpush
@else
<div class="alert alert-danger">
    No Have Permission
</div>
@endif
@endsection
