@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard') }}/assets/css/vendors/select2.css">
    @endpush
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <h5 class="card-header">{{ $title }}</h5>
            <form action="{{ aurl('categories/update/' . $category->id) }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="card-body">

                    <div class="form-group">
                        <label class="floating-label" for="name_ar">{{ trans('admin.Name Ar') }} <span
                                class="redStar">*</span></label>
                        <input type="text" value="{{ $category->name_ar }}" name="name_ar" class="form-control"
                            id="name_ar">
                    </div>

                    <div class="form-group">
                        <label class="floating-label" for="name_en">{{ trans('admin.Name En') }} <span
                                class="redStar">*</span></label>
                        <input type="text" value="{{ $category->name_en }}" name="name_en" class="form-control"
                            id="name_en">
                    </div>
                    <div class="form-group">
                        <label class="floating-label" for="status">{{ trans('admin.Status') }} <span
                            class="redStar">*</span></label>
                        <select name="status" class="form-select" id="status">
                            <option value="1" {{($category->status == 1)?'selected':''}}>{{trans('admin.Active')}}</option>
                            <option value="0" {{($category->status == 0)?'selected':''}}>{{trans('admin.DeActive')}}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="floating-label" for="name_en">{{ trans('admin.Order') }} <span
                            class="redStar">*</span></label>
                        <select name="order" class="form-select" id="order">
                            @foreach ($categories as $key => $cate)
                                <option value="{{$key+1}}" {{($category->order == $cate->order)?'selected':''}}>{{$key+1}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="file" name="image" id="imageInput"
                            class="custom-file-container__custom-file__custom-file-input" accept="image/*"
                            style="display: none">
                        <button type="button" class="btn btn-pill btn-outline-primary btn-air-primary"
                            id="selectImage"><i class="fas fa-image"></i>
                            {{ trans('admin.Upload Image') }} <span class="redStar">*</span></button>
                            <div class="imgPreview" style="position: relative">
                                <p style="position: absolute">Size: W120px * H120px</p>
                            <img src="{{ ($category->image()->exists())?$category->image->url : asset('dashboard/assets/images/placeholder-image.png') }}"
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
                $("#user").on('change', function() {
                    $("#typeValue").val($(this).find(':selected').attr('data-typeid'))
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
