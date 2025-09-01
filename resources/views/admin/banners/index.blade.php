@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_banners') == 1)
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>
                    {{ $title }}
                    <a href="{{ aurl('banners/create') }}"
                        class="btn btn-pill btn-outline-primary btn-air-primary pull-right"><i class="fas fa-plus"></i>
                        {{ trans('admin.Add New Banner') }}</a>
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
                                    <th>{{ trans('admin.Title') }}</th>
                                    <th>{{ trans('admin.Description') }}</th>
                                    <th>{{ trans('admin.Link') }}</th>
                                    <th>{{ trans('admin.Clicks') }}</th>
                                    <th>{{ trans('admin.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($banners as $banner)
                                    <tr>
                                        <td>{{ $banner->id }}</td>
                                        <td>
                                            <img src="{{ $banner->media()->exists() ? $banner->media->url : '' }}"
                                                class="img-thumbnail" style="height: 100px;" alt="">
                                        </td>
                                        <td>{{ $banner->title }}</td>
                                        <td>{{ $banner->description }}</td>
                                        <td><a href="{{ $banner->link }}" target="__blank">{{ $banner->link }}</a></td>
                                        <td>{{ $banner->clicks }}</td>
                                        <td>
                                            <a href="{{ aurl('banners/edit/' . $banner->id) }}"
                                                class="btn btn-pill btn-outline-warning btn-air-warning"><i
                                                    class="fas fa-edit"></i>
                                                {{ trans('admin.Edit') }}</a>

                                            <button data-id="{{ $banner->id }}" data-name="{{ $banner->name }}"
                                                id="delete" class="btn btn-pill btn-outline-danger btn-air-danger"><i
                                                    class="fas fa-trash"></i>
                                                {{ trans('admin.Delete') }}</button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $banners->links('admin.pagination.index') }}
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
                <form action="{{ aurl('banners/delete') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12 text-center">
                            <p style="margin-top: 10px;font-size: x-large" class="text-info" id="bannerName"></p>
                        </div>
                        <input type="hidden" id="banner_id" name="banner_id" value="">
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
@else
<div class="alert alert-danger">
    No Have Permission
</div>
@endif

    @push('script')
        <script>
            $(document).ready(function() {
                $("#delete ").click(function() {
                    var bannerName = $(this).attr('data-name');
                    var bannerId = $(this).attr('data-id');
                    $("#bannerName").text(bannerName);
                    $("#banner_id").val(bannerId);
                    $("#deleteModal").modal('show');
                });

            });
        </script>
    @endpush
@endsection
