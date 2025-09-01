@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_settings') == 1)
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard') }}/assets/css/vendors/select2.css">
    @endpush
    <form action="{{ aurl('settings/update') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6 col-xl-6">
                <div class="card">
                    <h5 class="card-header">{{ $title }}</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="floating-label" for="name_ar">{{ trans('admin.Name Ar') }}</label>
                                    <input type="text" value="{{ $setting->name_ar }}" name="name_ar" class="form-control" id="name_ar">
                                </div>
                            </div>
                            <div class="col-md-3 mt-5">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="name_status" type="checkbox" role="switch" id="is_hide" {{($setting->name_status == 1)?'checked':''}}>
                                    <label class="form-check-label" for="is_hide">Name is hide</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="floating-label" for="name_en">{{ trans('admin.Name En') }}</label>
                            <input type="text" value="{{ $setting->name_en }}" name="name_en" class="form-control" id="name_en">
                        </div>
                        <div class="form-group">
                            <label class="floating-label" for="address_ar">{{ trans('admin.Address Ar') }}</label>
                            <input type="text" value="{{ $setting->address_ar }}" name="address_ar" class="form-control" id="address_ar">
                        </div>
                        <div class="form-group">
                            <label class="floating-label" for="address_en">{{ trans('admin.Address En') }}</label>
                            <input type="text" value="{{ $setting->address_en }}" name="address_en" class="form-control" id="address_en">
                        </div>
                        <div class="form-group">
                            <label class="floating-label" for="description_ar">{{ trans('admin.Description Ar') }}</label>
                            <input type="text" value="{{ $setting->description_ar }}" name="description_ar" class="form-control" id="description_ar">
                        </div>
                        <div class="form-group">
                            <label class="floating-label" for="description_en">{{ trans('admin.Description En') }}</label>
                            <input type="text" value="{{ $setting->description_en }}" name="description_en" class="form-control" id="description_en">
                        </div>
                        <div class="form-group">
                            <label class="floating-label" for="email">{{ trans('admin.Email') }}</label>
                            <input type="text" value="{{ $setting->email }}" name="email" class="form-control" id="email">
                        </div>
                        <div class="form-group">
                            <label class="floating-label" for="phone">{{ trans('admin.Phone') }}</label>
                            <input type="text" value="{{ $setting->phone }}" name="phone" class="form-control" id="phone">
                        </div>
                        <div class="form-group">
                            <label class="floating-label" for="whatsapp">{{ trans('admin.Whatsapp') }}</label>
                            <input type="text" value="{{ $setting->whatsapp }}" name="whatsapp" class="form-control" id="whatsapp">
                        </div>
                        <div class="form-group">
                            <label class="floating-label" for="facebook">{{ trans('admin.Facebook') }}</label>
                            <input type="text" value="{{ $setting->facebook }}" name="facebook" class="form-control" id="facebook">
                        </div>
                        <div class="form-group">
                            <label class="floating-label" for="instagram">{{ trans('admin.Instagram') }}</label>
                            <input type="text" value="{{ $setting->instagram }}" name="instagram" class="form-control" id="instagram">
                        </div>
                        <div class="form-group">
                            <label class="floating-label" for="twitter">{{ trans('admin.Twitter') }}</label>
                            <input type="text" value="{{ $setting->twitter }}" name="twitter" class="form-control" id="twitter">
                        </div>
                        <div class="form-group">
                            <label class="floating-label" for="snapchat">{{ trans('admin.Tiktok') }}</label>
                            <input type="text" value="{{ $setting->snapchat }}" name="snapchat" class="form-control" id="snapchat">
                        </div>
                        <div class="form-group">
                            <label class="floating-label" for="appstore">{{ trans('admin.App Store') }}</label>
                            <input type="text" value="{{ $setting->appstore }}" name="appstore" class="form-control" id="appstore">
                        </div>
                        <div class="form-group">
                            <label class="floating-label" for="playstore">{{ trans('admin.Play Store') }}</label>
                            <input type="text" value="{{ $setting->playstore }}" name="playstore" class="form-control" id="playstore">
                        </div>
                        <div class="form-group">
                            <label class="floating-label" for="color">{{ trans('admin.Text Color') }}</label>
                            <input type="color" value="{{ $setting->color }}" name="color" class="form-control" id="color">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-pill btn-outline-primary btn-air-primary"><i
                                class="fas fa-save"></i>&nbsp;{{ trans('admin.Save') }}</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-6">
                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <input type="file" name="logo" id="coverInput"
                                class="custom-file-container__custom-file__custom-file-input" accept="image/*"
                                style="display: none">
                            <button type="button" class="btn btn-pill btn-outline-primary btn-air-primary pull-right" id="selectCover"><i
                                    class="fas fa-image"></i>
                                {{ trans('admin.Upload Logo') }}</button>
                                <div class="coverImgPreview" style="position: relative">
                                    <p style="position: absolute">Size: W120px * H120px</p>
                                <img src="{{ $setting->logo }}"
                                    style="max-height: 100%" id="targetImage" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <h5 class="card-header">{{ trans('admin.Header Settings') }}</h5>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="floating-label" for="header_message_ar">{{ trans('admin.Header Message Ar') }}</label>
                            <input type="text" value="{{ $setting->header_message_ar }}" name="header_message_ar" class="form-control" id="header_message_ar">
                        </div>

                        <div class="form-group">
                            <label class="floating-label" for="header_message_en">{{ trans('admin.Header Message En') }}</label>
                            <input type="text" value="{{ $setting->header_message_en }}" name="header_message_en" class="form-control" id="header_message_en">
                        </div>

                        <div class="form-group">
                            <label class="floating-label" for="header_title_ar">{{ trans('admin.Header Title Ar') }}</label>
                            <input type="text" value="{{ $setting->header_title_ar }}" name="header_title_ar" class="form-control" id="header_title_ar">
                        </div>

                        <div class="form-group">
                            <label class="floating-label" for="header_title_en">{{ trans('admin.Header Title En') }}</label>
                            <input type="text" value="{{ $setting->header_title_en }}" name="header_title_en" class="form-control" id="header_title_en">
                        </div>

                        <div class="form-group">
                            <label class="floating-label" for="header_description_ar">{{ trans('admin.Header Description Ar') }}</label>
                            <input type="text" value="{{ $setting->header_description_ar }}" name="header_description_ar" class="form-control" id="header_description_ar">
                        </div>

                        <div class="form-group">
                            <label class="floating-label" for="header_description_en">{{ trans('admin.Header Description En') }}</label>
                            <input type="text" value="{{ $setting->header_description_en }}" name="header_description_en" class="form-control" id="header_description_en">
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </form>

    @push('script')
        <script src="{{ asset('dashboard') }}/assets/js/select2/select2.full.min.js"></script>
        <script src="{{ asset('dashboard') }}/assets/js/select2/select2-custom.js"></script>

        <script>
            $(function() {
                $("#selectCover").click(function() {
                    $("#coverInput").click();
                });

                // Multiple images preview in browser
                var coverImagesPreview = function(input, placeToInsertImagePreview) {
                    if (input.files) {
                        var filesAmount = input.files.length;
                        for (i = 0; i < filesAmount; i++) {
                            var reader = new FileReader();
                            reader.onload = function(event) {
                                $($.parseHTML('<img>')).attr('src', event.target.result).addClass("img-thumbnail").appendTo(
                                    placeToInsertImagePreview);
                            }
                            reader.readAsDataURL(input.files[i]);

                        }
                    }
                };

                $('#coverInput').on('change', function() {
                    $("div.coverImgPreview").empty();
                    coverImagesPreview(this, 'div.coverImgPreview');
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
