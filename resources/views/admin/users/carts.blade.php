@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ $title }}
                </h5>
            </div>
            <div class="card-block row">
                <div class="col-sm-12 col-lg-12 col-xl-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>{{ trans('admin.Image') }}</th>
                                    <th>{{ trans('admin.Customer') }}</th>
                                    <th>{{ trans('admin.Store') }}</th>
                                    <th>{{ trans('admin.Name') }}</th>
                                    <th>{{ trans('admin.Quantity') }}</th>
                                    <th>{{ trans('admin.Price') }}</th>
                                    <th>{{ trans('admin.Total') }}</th>
                                    <th>{{ trans('admin.Created At') }}</th>
                                    <th>{{ trans('admin.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td><img src="{{ $product->product->image()->exists() ? $product->product->image->url : '' }}"
                                            class="img-thumbnail" style="height: 80px;" alt="">
                                        </td>
                                        <td>{{ $product->cart->user->name }}</td>
                                        <td>{{ $product->cart->company->store->name }}</td>
                                        <td> {{ $product->product->name }} </td>
                                        <td> {{ $product->quantity }} </td>
                                        <td>{{ number_format($product->price, 3) }} {{ currentCurrency() }}<br></td>
                                        <td>{{ number_format($product->total, 3) }} {{ currentCurrency() }}<br></td>
                                        <td>
                                            {{ $product->created_at }}<br>
                                            {{ $product->created_at->diffforhumans() }}
                                        </td>
                                        <td>
                                            <a href="{{ aurl('carts/notify/' . $product->cart->user->id) }}"
                                                class="btn btn-pill btn-outline-info btn-air-info btn-sm"><i
                                                    class="fas fa-bell"></i>
                                                {{ trans('admin.Send Notification') }}</a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $products->links('admin.pagination.index') }}
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
                <form action="{{ aurl('products/delete') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12 text-center">
                            <img src="" style="max-height: 100px;max-width: 100px;" id="productImage"
                                alt="">
                            <p style="margin-top: 10px;font-size: x-large" class="text-info" id="productName"></p>
                        </div>
                        <input type="hidden" id="product_id" name="product_id" value="">
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
        <script>
            $(document).ready(function() {
                $("#delete ").click(function() {
                    var productName = $(this).attr('data-name');
                    var productId = $(this).attr('data-id');
                    var productImage = $(this).attr('data-image');
                    $("#productName").text(productName);
                    $("#productImage").attr('src', productImage);
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
