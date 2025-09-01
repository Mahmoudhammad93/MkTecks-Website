@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    @push('styles')
        <style>
            #orderPaymentStatus {
                cursor: pointer;
            }

            #orderStatus {
                cursor: pointer;
            }
        </style>
    @endpush
    <div class="row">
        <div class="col-xl-3 col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5>{{ trans('admin.Board Number') }}</h5>
                </div>
                <div class="card-body text-center">
                    <h1 class="badge badge-danger" style="font-size: 60px">{{ $order->board_id }}</h1>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5>
                        {{ trans('admin.Order Details') }}
                    </h5>
                </div>
                <div class="card-block row">
                    <div class="col-sm-12 col-lg-12 col-xl-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>{{ trans('admin.Order ID') }}</td>
                                    <td>#{{ $order->id }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('admin.Total') }}</th>
                                    <th><span style="font-size: 15px">{{ $order->total }} {{ trans('admin.KWD') }}</span>
                                    </th>
                                </tr>
                                <tr>
                                    <th>{{ trans('admin.Order Status') }}</th>
                                    <th><span id="orderStatus" class="badge badge-success"
                                            style="font-size:15px">{{ trans('admin.' . $order->order_status) }}</span></th>
                                </tr>
                                <tr>
                                    <th>{{ trans('admin.Payment Status') }}</th>
                                    <th><span id="orderPaymentStatus" class="badge badge-primary"
                                            style="font-size:15px">{{ trans('admin.' . $order->payment_status) }}</span>
                                    </th>
                                </tr>
                                <tr>
                                    <th>{{ trans('admin.Payment Method') }}</th>
                                    <th><span class="badge badge-info"
                                            style="font-size:15px">{{ trans('admin.' . $order->payment_method) }}</span>
                                    </th>
                                </tr>
                                <tr>
                                    <th>{{ trans('admin.Order Date') }}</th>
                                    <th>{{ $order->created_at }}</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5>{{ trans('admin.products') }}</h5>
                </div>
                <div class="card-block row">
                    <div class="col-sm-12 col-lg-12 col-xl-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>{{ trans('admin.Image') }}</td>
                                    <td>{{ trans('admin.Product') }}</td>
                                    <td>{{ trans('admin.Status') }}</td>
                                    <td>{{ trans('admin.Price') }}</td>
                                    <td>{{ trans('admin.Quantity') }}</td>
                                    <td>{{ trans('admin.Total') }}</td>
                                </tr>
                                @foreach ($order->products as $product)
                                    <tr>
                                        <td>
                                            <img src="{{ $product->product->image->url }}" style="max-height: 50px"
                                                class="img-thumbnail" alt="">
                                        </td>
                                        <td>{{ $product->product->name }}</td>
                                        <td>
                                            @if ($product->product_status == 'new')
                                                <span
                                                    class="badge badge-danger" style="font-size: 14px">{{ trans('admin.' . $product->product_status) }}</span>
                                            @else
                                                <span
                                                    class="badge badge-success" style="font-size: 14px">{{ trans('admin.' . $product->product_status) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $product->product->new_price }} {{ trans('admin.KWD') }}</td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>{{ $product->total }} {{ trans('admin.KWD') }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tooltipmodal" aria-hidden="true"
        id="paymentStatusModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{ trans('admin.Payment Status') }}</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ aurl('boards/orders/payment_update/' . $order->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <select name="payment_status" class="form-control" id="">
                            <option value="paid">{{ trans('admin.paid') }}</option>
                            <option value="unpaid">{{ trans('admin.unpaid') }}</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
                            {{ trans('admin.Close') }}</button>
                        <button type="submit"
                            class="btn btn-pill btn-outline-primary btn-air-primary">{{ trans('admin.Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tooltipmodal" aria-hidden="true"
        id="orderStatusModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{ trans('admin.Order Status') }}</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ aurl('boards/orders/update/' . $order->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <select name="status" class="form-control" id="">
                            <option value="preparing">{{ trans('admin.Preparing') }}</option>
                            <option value="in_route">{{ trans('admin.in_route') }}</option>
                            <option value="delivered">{{ trans('admin.delivered') }}</option>
                            <option value="completed">{{ trans('admin.Completed') }}</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
                            {{ trans('admin.Close') }}</button>
                        <button type="submit"
                            class="btn btn-pill btn-outline-primary btn-air-primary">{{ trans('admin.Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @push('script')
        <script>
            $(document).ready(function() {
                $("#orderPaymentStatus").click(function() {
                    $("#paymentStatusModal").modal('toggle');
                });
                $("#orderStatus").click(function() {
                    $("#orderStatusModal").modal('toggle');
                });
            })
        </script>
    @endpush
@else
<div class="alert alert-danger">
    No Have Permission
</div>
@endif
@endsection
