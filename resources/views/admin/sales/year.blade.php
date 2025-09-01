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
                                    <th>{{ trans('admin.Order ID') }}</th>
                                    <th>{{ trans('admin.Products Count') }}</th>
                                    <th>{{ trans('admin.Products Price') }}</th>
                                    <th>{{ trans('admin.Shipping') }}</th>
                                    <th>{{ trans('admin.Total') }}</th>
                                    <th>{{ trans('admin.Created At') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                    <tr>
                                        <td><a href="{{ aurl('orders/view/' . $sale->order_id) }}">#{{ $sale->id }}</a></td>
                                        <td>{{ $sale->products_count }}</td>
                                        <td>{{ number_format($sale->products->sum('total'), 3) }} {{ trans('admin.KWD') }}</td>
                                        <td>{{ number_format($sale->delivery, 3) }} {{ trans('admin.KWD') }}</td>
                                        <td>{{ number_format($sale->total, 3) }} {{ trans('admin.KWD') }}</td>
                                        <td>{{ $sale->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $sales->links('admin.pagination.index') }}
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
