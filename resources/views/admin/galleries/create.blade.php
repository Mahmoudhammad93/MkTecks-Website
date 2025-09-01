@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard') }}/assets/css/vendors/select2.css">
    @endpush
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <h5 class="card-header">{{ $title }}</h5>
            <form action="{{ aurl('galleries/create') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="icon">{{ trans('admin.Type') }} <span class="redStar">*</span></label>
                        <select
                            class="js-example-placeholder-multiple col-sm-12 {{ lang() == 'ar' ? 'js-example-rtl' : '' }}"
                            name="icon" id="icon">
                            <option value="fas fa-link">{{ trans('admin.Link') }}</option>
                            <option value="fab fa-instagram-square">{{ trans('admin.Instagram') }}</option>
                            <option value="fab fa-facebook-square">{{ trans('admin.Facebook') }}</option>
                            <option value="fab fa-twitter-square">{{ trans('admin.Twitter') }}</option>
                            <option value="fab fa-youtube">{{ trans('admin.Youtube') }}</option>
                            <option value="fab fa-linkedin">{{ trans('admin.Linkedin') }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="floating-label" for="title_ar">{{ trans('admin.Title Ar') }} <span
                                class="redStar">*</span></label>
                        <input type="text" value="{{ old('title_ar') }}" name="title_ar" class="form-control"
                            id="title_ar">
                    </div>

                    <div class="form-group">
                        <label class="floating-label" for="title_en">{{ trans('admin.Title En') }} <span
                                class="redStar">*</span></label>
                        <input type="text" value="{{ old('title_en') }}" name="title_en" class="form-control"
                            id="title_en">
                    </div>

                    <div class="form-group">
                        <label class="floating-label" for="link">{{ trans('admin.Link') }} <span
                                class="redStar">*</span></label>
                        <input type="text" value="{{ old('link') }}" name="link" class="form-control"
                            id="link">
                    </div>

                    <div class="form-group" id="image">
                        <input type="file" name="image" id="imageInput"
                            class="custom-file-container__custom-file__custom-file-input" accept="image/*"
                            style="display: none">
                        <button type="button" class="btn btn-pill btn-outline-primary btn-air-primary" id="selectImage"><i
                                class="fas fa-image"></i>
                            {{ trans('admin.Upload Image') }} <span class="redStar">*</span></button>
                        <div class="imgPreview">
                            <img src="{{ asset('dashboard/assets/images/placeholder-image.png') }}"
                                style="max-height: 100%" id="targetImage" alt="">
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-pill btn-outline-primary btn-air-primary"><i
                            class="fas fa-save"></i>&nbsp;{{ trans('admin.Save') }}</button>
                </div>
            </form>
        </div>
    </div>


    @push('script')
        <script src="{{ asset('dashboard') }}/assets/js/select2/select2.full.min.js"></script>
        <script src="{{ asset('dashboard') }}/assets/js/select2/select2-custom.js"></script>
        <script>
            $(document).ready(function() {
                $("#selectImage").click(function() {
                    $("#imageInput").click();
                });
            });

            $(function() {
                // Multiple images preview in browser
                var imagesPreview = function(input, placeToInsertImagePreview) {
                    if (input.files) {
                        var filesAmount = input.files.length;
                        for (i = 0; i < filesAmount; i++) {
                            var reader = new FileReader();
                            reader.onload = function(event) {
                                $($.parseHTML('<img>')).attr('src', event.target.result).addClass(
                                    "img-thumbnail").appendTo(
                                    placeToInsertImagePreview);
                            }
                            reader.readAsDataURL(input.files[i]);

                        }
                    }
                };

                $('#imageInput').on('change', function() {
                    $("div.imgPreview").empty();
                    imagesPreview(this, 'div.imgPreview');
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
