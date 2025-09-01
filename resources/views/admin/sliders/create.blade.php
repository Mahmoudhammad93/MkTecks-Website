@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard') }}/assets/css/vendors/select2.css">
    @endpush
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <h5 class="card-header">{{ $title }}</h5>
            <form action="{{ aurl('sliders/create') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="card-body">

                    <div class="form-group">
                        <label class="floating-label" for="link">{{ trans('admin.Link') }} <span
                                class="redStar">*</span></label>
                        <input type="url" value="{{ old('link') }}" name="url" class="form-control"
                            id="link">
                    </div>

                    <div class="form-group mb-3">
                        <label class="floating-label" for="status">{{ trans('admin.Status') }} <span
                            class="redStar">*</span></label>
                        <select name="status" class="form-select" id="status">
                            <option value="1">{{trans('admin.Active')}}</option>
                            <option value="0">{{trans('admin.DeActive')}}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="floating-label" for="type">{{ trans('admin.Type') }}</label>
                        <select class="form-control" name="type" id="type">
                            <option value="image">{{ trans('admin.Image') }}</option>
                            <option value="video">{{ trans('admin.Video') }}</option>
                        </select>
                    </div>
                    

                    <div class="form-group" id="image">
                        <input type="file" name="image" id="imageInput"
                            class="custom-file-container__custom-file__custom-file-input" accept="image/*"
                            style="display: none">
                        <button type="button" class="btn btn-pill btn-outline-primary btn-air-primary" id="selectImage"><i
                                class="fas fa-image"></i>
                            {{ trans('admin.Upload Image') }} <span class="redStar">*</span></button>
                            <div class="imgPreview" style="position: relative">
                                <p style="position: absolute">Size: W120px * H120px</p>
                            <img src="{{ asset('dashboard/assets/images/placeholder-image.png') }}"
                                style="max-height: 100%" id="targetImage" alt="">
                        </div>
                    </div>

                    <div class="form-group" id="video" style="display: none">
                        <input type="file" name="video" id="videoInput" accept="video/*"
                            class="custom-file-container__custom-file__custom-file-input" style="display: none">
                        <button type="button" class="btn btn-pill btn-outline-primary btn-air-primary" id="selectvideo"><i
                                class="fas fa-image"></i>
                            {{ trans('admin.Upload Video') }}</button>
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
            $("#selectvideo").click(function() {
                $("#videoInput").click();
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

                $("#type").on('change', function() {
                    var type = $(this).val();
                    if (type == 'image') {
                        $("#image").show(500)
                        $("#video").hide(500)
                    } else {
                        $("#image").hide(500)
                        $("#video").show(500)
                    }
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
