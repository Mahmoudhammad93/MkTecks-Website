@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    @push('styles')
        <style>
            #map {
                height: 230px;
                width: 100%;
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
                    <div class="information">
                        <h6><span style="display: inline-block ; width: 20px;text-align: center;margin-bottom: 10px"><i
                                    class="fas fa-user"></i> </span>{{ $user->name }}</h6>
                        <h6><span style="display: inline-block ; width: 20px;text-align: center;margin-bottom: 10px"><i
                                    class="fas fa-mobile-alt"></i></span> {{ $user->mobile }}</h6>
                        <h6><span style="display: inline-block ; width: 20px;text-align: center;margin-bottom: 10px"><i
                                    class="far fa-envelope"></i></span> {{ $user->email }}</h6>
                        {{-- <hr>
                        <h6><span style="display: inline-block ; width: 20px;text-align: center;margin-bottom: 10px"><i
                                    class="far fa-clock"></i></span> {{ $user->created_at }}</h6> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5>{{ trans('admin.Addresses') }}</h5>
                </div>
                <div class="card-block row">
                    <div class="col-sm-12 col-lg-12 col-xl-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <th>{{ trans('admin.City') }}</th>
                                    <th>{{ trans('admin.Block') }}</th>
                                    <th>{{ trans('admin.Street') }}</th>
                                    <th>{{ trans('admin.Apartment No') }}</th>
                                    <th>{{ trans('admin.Avenue') }}</th>
                                </thead>
                                <tbody>
                                    @foreach ($user->addresses as $address)
                                        <tr>
                                            <td>{{ $address->area->city->name }} - {{ $address->area->name }}</td>
                                            <td>{{ $address->block }}</td>
                                            <td>{{ $address->street }}</td>
                                            <td>{{ $address->apartment_no }}</td>
                                            <td>{{ $address->avenue }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <h4>{{ trans('admin.Orders') }}</h4>
            @foreach ($orders as $order)
                @foreach ($order->companies as $company)
                    <div class="card">
                        <div class="card-header">
                            <h6>
                                <img src="{{ $company->company->profile->url }}" style="max-width: 60px"
                                    class="img-thumbnail" alt="">
                                <b>{{ $company->company->name }}</b>
                                <span class="pull-right">

                                    <span>{{ trans('admin.Order ID') }} : <a href="{{ aurl('orders/view/' . $order->id) }}" class="badge badge-info">#{{ $order->id }}</a></span>
                                    <span style="margin: 0px 20px">{{ trans('admin.Order Date') }} : <span class="badge badge-primary">{{ $order->created_at }}</span></span>
                                    <span>
                                        {{ trans('admin.Delivery Status') }} : <span class="badge badge-{{ $company->delivery_status == 'pending' ? 'warning' : 'info' }}">{{ trans('admin.' . $company->delivery_status) }}</span>
                                    </span>
                                </span>
                            </h6>

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
                                        @foreach ($company->products as $product)
                                            <tr>
                                                <td>
                                                    <img src="{{ $product->product->product_type == 'item' ? $product->product->image->url : '' }}"
                                                        style="max-width: 70px" class="img-thumbnail" alt="">
                                                </td>
                                                <td>{{ $product->product->display_name }}</td>
                                                <td>{{ $product->price }} {{ currentCurrency() }}</td>
                                                <td>{{ $product->quantity }}</td>
                                                <td>{{ $product->total }} {{ currentCurrency() }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <span>{{ trans('admin.Shipping') }} : {{ $company->delivery }}
                                {{ currentCurrency() }}</span>
                            <span class="pull-right">{{ trans('admin.Total') }} :
                                {{ $company->delivery + $company->price }}
                                {{ currentCurrency() }}</span>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>

    </div>

    @push('script')
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=TRUE"></script>
        <script>
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }

            function showPosition(position) {

                // The location of Uluru
                const uluru = {
                    lat: {{ $order->address->address->latitude }},
                    lng: {{ $order->address->address->longitude }},
                };

                // The map, centered at Uluru
                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 15,
                    center: uluru,
                });

                // The marker, positioned at Uluru
                const marker = new google.maps.Marker({
                    position: uluru,
                    map: map,
                    draggable: false,
                    animation: google.maps.Animation.DROP,
                });

            }
        </script>
    @endpush
@else
<div class="alert alert-danger">
    No Have Permission
</div>
@endif
@endsection
