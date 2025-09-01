@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
@push('styles')
    <style>
        #orderStatus{
            cursor: pointer;
        }
    </style>
@endpush
    <div class="row">
        <div class="col-xl-3 col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5>{{ trans('admin.Customer') }}</h5>
                </div>
                <div class="card-body">
                    <div class="customerProfile text-center">
                        <img src="{{ asset('dashboard/assets/images/avatar.png') }}" class="rounded-circle align-top"
                            style="max-width: 50%" alt="">
                    </div>
                    <hr>
                    {{-- <div class="information">
                        <h6><span style="display: inline-block ; width: 20px;text-align: center;margin-bottom: 10px"><i
                                    class="fas fa-user"></i> </span>{{ $order->address->name }}</h6>
                        <h6><span style="display: inline-block ; width: 20px;text-align: center;margin-bottom: 10px"><i
                                    class="fas fa-mobile-alt"></i></span> {{ $order->address->phone }}</h6>
                        <h6><span style="display: inline-block ; width: 20px;text-align: center;margin-bottom: 10px"><i
                                    class="far fa-envelope"></i></span> {{ $order->address->email }}</h6>
                    </div> --}}
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
                                    <td>{{ trans('admin.Order Discount') }}</td>
                                    <td>{{ $order->discount }} {{ trans('admin.KWD') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('admin.Shipping') }}</td>
                                    <td>{{ $order->delivery }} {{ trans('admin.KWD') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('admin.Total') }}</th>
                                    <th>{{ $order->total - $order->discount }} {{ trans('admin.KWD') }}</th>
                                </tr>
                                <tr>
                                    <th>{{ trans('admin.Payment Status') }}</th>
                                    @if($order->status == "paid")
                                    <th><span class="badge badge-info">{{ trans('admin.'.$order->status) }}</span></th>
                                    @else
                                    <th><span id="orderStatus" class="badge badge-danger">{{ trans('admin.'.$order->status) }}</span></th>
                                    @endif
                                </tr>
                                <tr>
                                    <th>{{ trans('admin.Order Date') }}</th>
                                    <th>{{ $order->created_at }}</th>
                                </tr>
                                <tr>
                                    <th>{{ trans('admin.Branche') }}</th>
                                    <th>{{ $order->branch->name }}</th>
                                </tr>
                                <tr>
                                    <th>{{ trans('admin.PickUp') }}</th>
                                    <th>{{ ($order->pickup_type == 0)?'PickUp':'PickUp By Car' }}</th>
                                </tr>
                                @if ($order->pickup_type == 1)
                                <tr>
                                    <th>{{ trans('admin.Car Type') }}</th>
                                    <th>{{ $order->car_type }}</th>
                                </tr>
                                <tr>
                                    <th>{{ trans('admin.Car Color') }}</th>
                                    <th>{{ $order->car_color }}</th>
                                </tr>
                                @endif
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
                                    <td>{{ trans('admin.Price') }}</td>
                                    <td>{{ trans('admin.Quantity') }}</td>
                                    <td>{{ trans('admin.Total') }}</td>
                                </tr>
                                @foreach ($order->products as $product)
                                    <tr>
                                        <td>
                                            <img src="{{ (isset($product->product->image))?$product->product->image->url:'' }}" style="max-width: 70px"
                                                class="img-thumbnail" alt="">
                                        </td>
                                        <td>{{ $product->product->name }}</td>
                                        <td>{{ $product->price }} {{ trans('admin.KWD') }}</td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>{{ $product->price * $product->quantity  }} {{ trans('admin.KWD') }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="card">
                <div class="card-header">
                    <h5>{{ trans('admin.Address Information') }}</h5>
                </div>
                <div class="card-block row">
                    <div class="col-sm-12 col-lg-12 col-xl-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>{{ trans('admin.City') }}</td>
                                    <td>{{ $order->address->area->city->name }} -
                                        {{ $order->address->area->name }}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('admin.Block') }}</td>
                                    <td>{{ $order->address->block }}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('admin.Street') }}</td>
                                    <td>{{ $order->address->street }}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('admin.Apartment No') }}</td>
                                    <td>{{ $order->address->apartment_no }}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('admin.Avenue') }}</td>
                                    <td>{{ $order->address->avenue }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

    </div>


    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tooltipmodal" aria-hidden="true"
        id="statusModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{ trans('admin.Payment Status') }}</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ aurl('orders/update/'.$order->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <select name="status" class="form-control" id="">
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


    @push('script')

    <script>
        $(document).ready(function (){
            $("#orderStatus").click( function (){
                $("#statusModal").modal('toggle');
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
