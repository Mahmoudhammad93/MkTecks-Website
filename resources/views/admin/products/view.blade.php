@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard') }}/assets/css/vendors/photoswipe.css">
        <style>
            .qrCode>svg {
                width: 100% !important
            }

            #qrCodeArea {
                display: none;
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ trans('admin.Images') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row my-gallery gallery" id="aniimated-thumbnials" itemscope="">
                        @foreach ($product->images as $index => $image)
                            <figure class="col-md-3 col-6 img-hover hover-1" itemprop="associatedMedia" itemscope="">
                                <a href="{{ $image->url }}" itemprop="contentUrl" data-size="1600x950">
                                    <div>
                                        <img src="{{ $image->url }}" itemprop="thumbnail"
                                            style="max-height: 180px !important ; width:auto !important"
                                            alt="Image description">
                                    </div>
                                </a>
                                <figcaption itemprop="caption description">{{ $product->name }}</figcaption>
                            </figure>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>
                        {{ trans('admin.Description') }}
                    </h5>
                </div>
                <div class="card-body">
                    <p style="white-space: pre-line">{{ $product->description }}.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5>{{ trans('admin.Details') }}</h5>
                </div>
                <div class="card-block row">
                    <div class="col-sm-12 col-lg-12 col-xl-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <tr>
                                    <th>#</th>
                                    <td>{{ $product->id }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('admin.Name') }}</th>
                                    <td>{{ $product->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('admin.Price') }}</th>
                                    <td>
                                        {{ $product->new_price }}{{ trans('admin.KWD') }}<br>
                                        <del>{{ $product->old_price }}{{ trans('admin.KWD') }}</del>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('admin.Category') }}</th>
                                    <td>{{ $product->category->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('admin.Views') }}</th>
                                    <td>{{ $product->views }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('admin.Created At') }}</th>
                                    <td>{{ $product->created_at }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script src="{{ asset('dashboard') }}/assets/js/photoswipe/photoswipe.min.js"></script>
        <script src="{{ asset('dashboard') }}/assets/js/photoswipe/photoswipe-ui-default.min.js"></script>
        <script src="{{ asset('dashboard') }}/assets/js/photoswipe/photoswipe.js"></script>
    @endpush
@else
<div class="alert alert-danger">
    No Have Permission
</div>
@endif
@endsection
