@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ $title }}</h5>

                <a href="{{ aurl('products/create') }}" class="btn btn-pill btn-outline-primary btn-air-primary pull-right"><i class="fas fa-plus"></i>
                    {{ trans('admin.Add New Product') }}</a>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover mb-4">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('admin.Image') }}</th>
                                <th>{{ trans('admin.Name') }}</th>
                                <th>{{ trans('admin.Company') }}</th>
                                <th>{{ trans('admin.Category') }}</th>
                                <th>{{ trans('admin.Type') }}</th>
                                <th>{{ trans('admin.Price') }}</th>
                                <th>{{ trans('admin.Stock') }}</th>
                                <th>{{ trans('admin.Views') }}</th>
                                <th>{{ trans('admin.Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td><img src="{{ ($product->image()->exists())?$product->image->url:"" }}" class="img-40 m-r-15 rounded-circle align-top"
                                            style="max-width: 60px; max-height: 60px;" alt=""></td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->user->name }}</td>
                                    <td>{{ ($product->category()->exists())?$product->category->name:"" }}</td>
                                    <td>{{ ($product->type()->exists())?$product->type->name:"" }}</td>
                                    <td>{{ $product->price }}{{ trans('admin.KWD') }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>{{ $product->views }}</td>
                                    <td>
                                        <a href="{{ aurl('products/view/' . $product->id) }}" class="btn btn-pill btn-outline-primary btn-air-primary"><i
                                                class="fas fa-eye"></i>
                                            {{ trans('admin.View') }}</a>

                                        <a href="{{ aurl('products/edit/' . $product->id) }}" class="btn btn-pill btn-outline-warning btn-air-warning"><i
                                                class="fas fa-edit"></i>
                                            {{ trans('admin.Edit') }}</a>

                                        <button data-id="{{ $product->id }}" data-image="{{ ($product->image()->exists())?$product->image->url:"" }}" data-name="{{ $product->name }}"
                                            id="delete" class="btn btn-pill btn-outline-danger btn-air-danger"><i class="fas fa-trash"></i>
                                            {{ trans('admin.Delete') }}</button>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tooltipmodal" aria-hidden="true" id="deleteModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{ trans('admin.Delete') }}</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ aurl('products/delete') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12 text-center">
                            <img src="" style="max-height: 100px;max-width: 100px;" id="productImage" alt="">
                            <p style="margin-top: 10px;font-size: x-large" class="text-info" id="productName"></p>
                        </div>
                        <input type="hidden" id="product_id" name="product_id" value="">
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
                            {{ trans('admin.Close') }}</button>
                        <button type="submit" class="btn btn-pill btn-outline-danger btn-air-danger">{{ trans('admin.Delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            $(document).ready(function() {
                $("#delete ").click(function() {
                    var productName = $(this).attr('data-name');
                    var productId = $(this).attr('data-id');
                    var productImage = $(this).attr('data-image');
                    $("#productName").text(productName);
                    $("#productImage").attr('src',productImage);
                    $("#product_id").val(productId);
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
