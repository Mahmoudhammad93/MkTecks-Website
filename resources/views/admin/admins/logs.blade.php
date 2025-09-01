@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ $title }} - {{ $user ? $user->name : '' }}</h5>
            </div>
            <div class="card-block row">
                <div class="col-sm-12 col-lg-12 col-xl-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    @if (!$user)
                                        <th>{{ trans('admin.User') }}</th>
                                    @endif
                                    <th>{{ trans('admin.Operation') }}</th>
                                    <th>{{ trans('admin.Descritpion') }}</th>
                                    <th>{{ trans('admin.Created At') }}</th>
                                    <th>{{ trans('admin.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $log)
                                    <tr>
                                        @if (!$user)
                                            <th>{{ $log->user->name }}</th>
                                        @endif
                                        <td>{{ trans('admin.' . $log->status) }}</td>
                                        <td>{{ $log->description }}</td>
                                        <td>{{ $log->created_at }} - {{ $log->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a class="btn btn-pill btn-outline-primary btn-air-primary"
                                                href="#"><i class="fas fa-eye"></i>
                                                {{ trans('admin.View') }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $logs->links('admin.pagination.index') }}
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
