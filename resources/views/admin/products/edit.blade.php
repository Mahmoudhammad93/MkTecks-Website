@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard') }}/assets/css/vendors/select2.css">
        <style>
            .extra_is_required_input,
            .drink_is_required_input,
            .option_is_required_input{
                display: none
            }

            .extra_is_required_input.show,
            .drink_is_required_input.show,
            .option_is_required_input.show{
                display: inline-block
            }
        </style>
    @endpush
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <h5 class="card-header">{{ $title }}</h5>
            <form action="{{ aurl('products/update/'.$product->id) }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="categories">{{ trans('admin.Categories') }} <span class="redStar">*</span></label>
                        <select
                            class="js-example-placeholder-multiple col-sm-12 {{ lang() == 'ar' ? 'js-example-rtl' : '' }}"
                            name="category_id" id="categories">
                            @foreach ($categories as $category)
                                <option {{ ($category->id == $product->category_id)?"selected":"" }} value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="floating-label" for="name_ar">{{ trans('admin.Name Ar') }} <span
                                class="redStar">*</span></label>
                        <input type="text" value="{{ $product->name_ar }}" name="name_ar" class="form-control"
                            id="name_ar">
                    </div>

                    <div class="form-group">
                        <label class="floating-label" for="name_en">{{ trans('admin.Name En') }} <span
                                class="redStar">*</span></label>
                        <input type="text" value="{{ $product->name_en }}" name="name_en" class="form-control"
                            id="name_en">
                    </div>
                    
                    <div class="form-group">
                        <label class="floating-label" for="price">{{ trans('admin.Price') }} <span
                                class="redStar">*</span></label>
                        <input type="number" value="{{ $product->price }}" name="price" class="form-control"
                            id="price">
                    </div>

                    <div class="form-group">
                        <label class="floating-label" for="description_ar">{{ trans('admin.Description Ar') }}</label>
                        <textarea rows="6" name="description_ar" id="description_ar" class="form-control">{{ $product->description_ar }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="floating-label" for="description_en">{{ trans('admin.Description En') }}</label>
                        <textarea rows="6" name="description_en" id="description_en" class="form-control">{{ $product->description_en }}</textarea>
                    </div>

                    {{-- <div class="form-group">
                        <label class="floating-label" for="component">{{ trans('admin.Components') }} <span
                                class="redStar">*</span></label>
                        <div class="card">
                            <div class="card-body components">
                                @if(count($product->components) > 0)
                                @foreach ($product->components as $key => $component)
                                    <div class="row" id="row_{{$key}}">
                                        <div class="col-md-10">
                                            <input type="text" name="components[{{$key}}]" class="form-control"
                                            id="components[{{$key}}]" value="{{$component->name}}">
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-success add_component">+</button>
                                            <button class="btn btn-danger delete_component" data-id="{{$key}}">-</button>
                                        </div>
                                    </div>
                                @endforeach
                                @else
                                <div class="row" id="row_0">
                                    <div class="col-md-11">
                                        <input type="text" value="{{ old('name_ar') }}" name="components[0]" class="form-control"
                                        id="components[0]">
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-success add_component">+</button>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="form-group">
                        <div class="row">
                            <div class="col-md-9">
                                <label class="floating-label" for="component">{{ trans('admin.Extras') }} <span
                                    class="redStar">*</span></label>
                                <select class="js-example-basic-multiple" name="extras[]" multiple="multiple">
                                    @foreach ($products as $product)
                                        <option value="{{$product->id}}" {{(in_array($product->id, $extras))?'selected':''}}>{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1 mt-5">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input check_required" name="extra_is_required" id="extra_is_required" {{($product->min_extras > 0)?'checked':''}}>
                                    <label class="form-check-label" for="extra_is_required">Is Required</label>
                                </div>
                            </div>
                            <div class="col-md-2 mt-4 extra_is_required_input {{($product->min_extras > 0)?'show':''}}">
                                <input type="number" class="form-control" name="extra_min_required" placeholder="Min Extras" value="{{$product->min_extras}}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-9">
                                <label class="floating-label" for="component">{{ trans('admin.Drinks') }} <span
                                    class="redStar">*</span></label>
                                <select class="js-example-basic-multiple" name="drinks[]" multiple="multiple">
                                    @foreach ($products as $product)
                                        <option value="{{$product->id}}" {{(in_array($product->id, $drinks))?'selected':''}}>{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1 mt-5">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input check_required" name="drink_is_required" id="drink_is_required" {{($product->min_drinks > 0)?'checked':''}}>
                                    <label class="form-check-label" for="drink_is_required">Is Required</label>
                                </div>
                            </div>
                            <div class="col-md-2 mt-4 drink_is_required_input {{($product->min_drinks > 0)?'show':''}}">
                                <input type="number" class="form-control" name="drink_min_required" placeholder="Min Drinks" value="{{$product->min_drinks}}">
                            </div>
                        </div>
                    </div> --}}

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-9">
                                <label class="floating-label" for="component">{{ trans('admin.Options') }} <span
                                    class="redStar">*</span></label>
                                <select class="js-example-basic-multiple" name="options[]" multiple="multiple">
                                    @foreach ($options as $option)
                                        <option value="{{$option->id}}" {{(in_array($option->id, $product_options))?'selected':''}}>{{$option->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1 mt-5">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input check_required" name="option_is_required" id="option_is_required" {{($product->min_options > 0)?'checked':''}}>
                                    <label class="form-check-label" for="option_is_required">Is Required</label>
                                </div>
                            </div>
                            <div class="col-md-2 mt-4 option_is_required_input {{($product->min_options > 0)?'show':''}}">
                                <input type="number" class="form-control" name="option_min_required" placeholder="Min Options" value="{{$product->min_options}}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="file" name="images[]" id="coverInput" multiple
                            class="custom-file-container__custom-file__custom-file-input" accept="image/*"
                            style="display: none">
                        <button type="button" class="btn btn-pill btn-outline-primary btn-air-primary" id="selectCover"><i
                                class="fas fa-image"></i>
                            {{ trans('admin.Upload Images') }} <span class="redStar">*</span></button>
                            <div class="coverImgPreview" style="position: relative">
                                <p style="position: absolute">Size: W120px * H120px</p>
                            <img src="{{ asset('dashboard/assets/images/placeholder-image.png') }}"
                                style="max-height: 100%" id="targetImage" alt="">
                        </div>
                        <div class="dimgPreview">
                            @foreach ($product->images as $image)
                                <div>
                                    <img src="{{ $image->url }}" style="max-height: 100% ; max-width: 100% !important;"
                                        id="targetImage" alt="">
                                    <button type="button" data-id="{{ $image->id }}"
                                        class="btn btn-pill btn-outline-danger btn-air-danger btn-sm" id="delete"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            @endforeach
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
                                $($.parseHTML('<img>')).attr('src', event.target.result).addClass(
                                    "img-thumbnail").appendTo(
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
                $("#delete ").click(function() {
                    var id = $(this).attr('data-id');
                    $("form").append('<input type="hidden" name="delete_images[]" value="' + id + '">');
                    $(this).prev().remove();
                    $(this).remove();
                });
            });

            $(document).on('click', '.add_component', function(){
                var count = $('.components .row').length;
                var HTML = '';
                HTML += `
                <div class="row" id="row_${count}">
                    <div class="col-md-10">
                        <input type="text" value="{{ old('name_ar') }}" name="components[${count}]" class="form-control"
                        id="components[${count}]">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-success add_component">+</button>
                        <button class="btn btn-danger delete_component">-</button>
                    </div>
                </div>
                `;

                $('.components').append(HTML)
                return false;
            });

            $(document).on('click', '.delete_component', function(){
                var id = $(this).data('id');
                $('row_'+id).remove();
                return false;
            });

            $(document).on('click', '.check_required', function(e){
                var id = $(this).attr('id');
                if(e.target.checked == true){
                    $('.'+id+'_input').addClass('show')
                }else{
                    $('.'+id+'_input').removeClass('show')
                }
            })
        </script>
    @endpush
@else
<div class="alert alert-danger">
    No Have Permission
</div>
@endif
@endsection
