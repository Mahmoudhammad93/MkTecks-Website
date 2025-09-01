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
                                    <th>{{ trans('admin.Name') }}</th>
                                    <th>{{ trans('admin.Phone') }}</th>
                                    <th>{{ trans('admin.Email') }}</th>
                                    <th>{{ trans('admin.Seen') }}</th>
                                    <th>{{ trans('admin.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($messages as $message)
                                    <tr>
                                        <td>{{ $message->id }}</td>
                                        <td>{{ $message->name }}</td>
                                        <td>{{ $message->phone }}</td>
                                        <td>{{ $message->email }}</td>
                                        <td style="padding:15px">
                                            @if ($message->seen)
                                                <i class="fas fa-check-circle text-success"></i>
                                            @else
                                                <i class="fas fa-times text-danger"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ aurl('contact_us/view/' . $message->id) }}"
                                                class="btn btn-pill btn-outline-primary btn-air-primary"><i class="fas fa-eye"></i>
                                                {{ trans('admin.View') }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
