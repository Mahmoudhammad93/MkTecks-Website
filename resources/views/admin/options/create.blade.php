@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard') }}/assets/css/vendors/select2.css">
    @endpush
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <h5 class="card-header">{{ $title }}</h5>
            <form action="{{ aurl('options/store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="card-body">

                    <div class="form-group">
                        <label class="floating-label" for="name_ar">{{ trans('admin.Name Ar') }} <span
                                class="redStar">*</span></label>
                        <input type="text" value="{{ old('name_ar') }}" name="name_ar" class="form-control"
                            id="name_ar">
                    </div>

                    <div class="form-group">
                        <label class="floating-label" for="name_en">{{ trans('admin.Name En') }} <span
                                class="redStar">*</span></label>
                        <input type="text" value="{{ old('name_en') }}" name="name_en" class="form-control"
                            id="name_en">
                    </div>
                    <div class="form-group">
                        <label class="floating-label" for="status">{{ trans('admin.Status') }} <span
                            class="redStar">*</span></label>
                        <select name="status" class="form-select" id="status">
                            <option value="1">{{trans('admin.Active')}}</option>
                            <option value="0">{{trans('admin.DeActive')}}</option>
                        </select>
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
