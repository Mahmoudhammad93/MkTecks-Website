@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ $title }}</h5>
            </div>
            <div class="card-block row">
                <div class="col-sm-12 col-lg-12 col-xl-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('admin.User') }}</th>
                                    <th>{{ trans('admin.Pay Type') }}</th>
                                    <th>{{ trans('admin.Status') }}</th>
                                    <th>{{ trans('admin.Total') }}</th>
                                    <th>{{ trans('admin.Order Date') }}</th>
                                    <th>{{ trans('admin.Products Count') }}</th>
                                    <th>{{ trans('admin.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->user_id }}</td>
                                        <td>{{ trans('admin.'.$order->payment_method) }}</td>
                                        <td>
                                            @if ($order->status == 'paid')
                                                <span class="badge badge-info">{{ trans('admin.' . $order->status) }}</span>
                                            @else
                                                <span
                                                    class="badge badge-danger">{{ trans('admin.' . $order->status) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($order->total, 3) }} {{ trans('admin.KWD') }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>{{ $order->products_count }}</td>
                                        <td>
                                            <a href="{{ aurl('orders/view/' . $order->id) }}"
                                                class="btn btn-pill btn-outline-info"><i class="fas fa-eye"></i>
                                                {{ trans('admin.View') }}</a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $orders->links('admin.pagination.index') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
<div class="alert alert-danger">
    No Have Permission
</div>
@endif
@endsection
