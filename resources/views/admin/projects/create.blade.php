@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard') }}/assets/css/vendors/select2.css">
    @endpush
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <h5 class="card-header">{{ $title }}</h5>
            <form action="{{ aurl('projects/create') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="card-body">

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
                        <label class="floating-label" for="description_ar">{{ trans('admin.Description Ar') }} <span
                                class="redStar">*</span></label>
                        <input type="text" value="{{ old('description_ar') }}" name="description_ar" class="form-control"
                            id="description_ar">
                    </div>

                    <div class="form-group">
                        <label class="floating-label" for="description_en">{{ trans('admin.Description En') }} <span
                                class="redStar">*</span></label>
                        <input type="text" value="{{ old('description_en') }}" name="description_en" class="form-control"
                            id="description_en">
                    </div>

                    <div class="form-group">
                        <label class="floating-label" for="order">{{ trans('admin.Order') }} <span
                                class="redStar">*</span></label>
                        <input type="text" value="{{ old('order') }}" name="order" class="form-control"
                            id="order">
                    </div>

                    <div class="form-group">
                        <label class="floating-label" for="url">{{ trans('admin.URL') }} <span
                                class="redStar">*</span></label>
                        <input type="url" value="{{ old('url') }}" name="url" class="form-control"
                            id="url">
                    </div>

                    <div class="form-group">
                        <label class="floating-label" for="status">{{ trans('admin.Status') }} <span
                            class="redStar">*</span></label>
                        <select name="status" class="form-select" id="status">
                            <option value="1">{{trans('admin.Active')}}</option>
                            <option value="0">{{trans('admin.DeActive')}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="file" name="image[]" multiple id="imageInput"
                            class="custom-file-container__custom-file__custom-file-input" accept="image/*"
                            style="display: none">
                        <button type="button" class="btn btn-pill btn-outline-primary btn-air-primary"
                            id="selectImage"><i class="fas fa-image"></i>
                            {{ trans('admin.Upload Image') }} <span class="redStar">*</span></button>
                            <div class="imgPreview" style="position: relative">
                                <p style="position: absolute">Size: W120px * H120px</p>
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
                $("#type").on('change', function() {
                    $("#userValue").val($(this).find(':selected').attr('data-userid'))
                })
            });
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
