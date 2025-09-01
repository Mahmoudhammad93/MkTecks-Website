@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_banners') == 1)
    @push('styles')
        <link href="https://vjs.zencdn.net/7.17.0/video-js.css" rel="stylesheet" />
        <style>
            .video-js .vjs-big-play-button {
                top: 50px !important;
                right: 10px !important;
                left: 10px !important;
                margin: 0 auto !important;
            }
        </style>
    @endpush
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>
                    {{ $title }}
                    <a href="{{ aurl('sliders/create') }}"
                        class="btn btn-pill btn-outline-primary btn-air-primary pull-right"><i class="fas fa-plus"></i>
                        {{ trans('admin.Add New Slider') }}</a>
                </h5>
            </div>
            <div class="card-block row">
                <div class="col-sm-12 col-lg-12 col-xl-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('admin.Image') }}</th>
                                    <th>{{ trans('admin.Link') }}</th>
                                    <th>{{ trans('admin.Status') }}</th>
                                    <th>{{ trans('admin.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sliders as $slider)
                                    <tr>
                                        <td>{{ $slider->id }}</td>
                                        <td>
                                            @if ($slider->type == 'image')
                                                <img src="{{ $slider->media()->exists() ? $slider->media->url : '' }}"
                                                    class="img-thumbnail" style="height: 100px;" alt="">
                                            @endif

                                            @if ($slider->type == 'video')
                                                <video id="my-video" class="video-js" controls width="200"
                                                    height="150" preload="none" data-setup="{}">
                                                    <source
                                                        src="{{ $slider->media()->exists() ? $slider->media->url : '' }}"
                                                        type="{{ $slider->media()->exists() ? $slider->media->mime : '' }}" />
                                                    <source
                                                        src="{{ $slider->media()->exists() ? $slider->media->url : '' }}"
                                                        type="{{ $slider->media()->exists() ? $slider->media->mime : '' }}" />
                                                    <p class="vjs-no-js">
                                                        To view this video please enable JavaScript, and consider
                                                        upgrading to a
                                                        web browser that
                                                    </p>
                                                </video>
                                            @endif
                                        </td>
                                        <td><a href="{{ $slider->url }}" target="__blank">{{ $slider->url }}</a></td>
                                        <td>
                                            @if($slider->status == 1)
                                            <span class="badge badge-success">{{trans('admin.Active')}}</span>
                                            @else
                                            <span class="badge badge-danger">{{trans('admin.DeActive')}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (is_permited('edit_sliders') == 1)
                                            <a href="{{ aurl('sliders/edit/' . $slider->id) }}"
                                                class="btn btn-pill btn-outline-warning btn-air-warning"><i
                                                    class="fas fa-edit"></i>
                                                {{ trans('admin.Edit') }}</a>
                                            @endif

                                            @if (is_permited('delete_sliders') == 1)
                                            <button data-id="{{ $slider->id }}" data-name="{{ $slider->name }}"
                                                id="delete" class="btn btn-pill btn-outline-danger btn-air-danger"><i
                                                    class="fas fa-trash"></i>
                                                {{ trans('admin.Delete') }}</button>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $sliders->links('admin.pagination.index') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tooltipmodal" aria-hidden="true"
        id="deleteModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{ trans('admin.Delete') }}</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ aurl('sliders/delete') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12 text-center">
                            <p style="margin-top: 10px;font-size: x-large" class="text-info" id="sliderName"></p>
                        </div>
                        <input type="hidden" id="slider_id" name="slider_id" value="">
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
                            {{ trans('admin.Close') }}</button>
                        <button type="submit"
                            class="btn btn-pill btn-outline-danger btn-air-danger">{{ trans('admin.Delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script')
        <script src="https://vjs.zencdn.net/7.17.0/video.min.js"></script>
        <script>
            $(document).ready(function() {
                $("#delete ").click(function() {
                    var sliderName = $(this).attr('data-name');
                    var sliderId = $(this).attr('data-id');
                    $("#sliderName").text(sliderName);
                    $("#slider_id").val(sliderId);
                    $("#deleteModal").modal('show');
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
