@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ $title }}</h5>
                <a href="#" class="btn btn-pill btn-outline-info pull-right"><i class="fas fa-plus"></i>
                    {{ trans('admin.Add Products') }}</a>
                <a href="{{ aurl('celebrities/create') }}" class="btn btn-pill btn-outline-primary btn-air-primary pull-right"><i class="fas fa-plus"></i>
                    {{ trans('admin.Add New Celebrity') }}</a>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover mb-4">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('admin.Profile') }}</th>
                                <th>{{ trans('admin.Name') }}</th>
                                <th>{{ trans('admin.Email') }}</th>
                                <th>{{ trans('admin.Mobile') }}</th>
                                <th>{{ trans('admin.Types') }}</th>
                                <th>{{ trans('admin.Limit') }}</th>
                                <th>{{ trans('admin.Percentage') }}</th>
                                <th>{{ trans('admin.Show In Home') }}</th>
                                <th>{{ trans('admin.Views') }}</th>
                                <th>{{ trans('admin.Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                                <tr>
                                    <td>{{ $admin->id }}</td>
                                    <td><img src="{{ ($admin->profile()->exists())?$admin->profile->url:"" }}" class="img-40 m-r-15 rounded-circle align-top" width="60" alt="">
                                    </td>
                                    <td>{{ $admin->celebrity->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->mobile }}</td>
                                    <td>
                                        @foreach ($admin->types as $type)
                                            <span class="badge badge-primary">{{ $type->name }}</span><br>
                                        @endforeach
                                    </td>
                                    <td>{{ $admin->celebrity->products_limit }}</td>
                                    <td>{{ $admin->celebrity->percentage }}</td>
                                    <td>
                                        @if ($admin->celebrity->in_home)
                                            <i class="fas fa-check text-success"></i>
                                        @else
                                            <i class="fas fa-times text-primary"></i>
                                        @endif
                                    </td>
                                    <td>{{ $admin->celebrity->views }}</td>
                                    <td>
                                        <div class="btn-group mb-2 mr-2">
                                            <button class="btn btn-pill btn-outline-primary dropbtn" type="button"
                                                data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">{{ trans('admin.Actions') }}</button>
                                            <div class="dropdown-menu">
                                                <a href="{{ aurl('celebrities/logs/' . $admin->id) }}" class="dropdown-item"><i class="fas fa-chart-line"></i> {{ trans('admin.Activity') }}</a>
                                                <a href="{{ aurl('celebrities/edit/' . $admin->id) }}" class="dropdown-item"><i class="fas fa-edit"></i> {{ trans('admin.Edit') }}</a>
                                                <a href="{{ aurl('celebrities/store/' . $admin->id) }}" class="dropdown-item"><i class="fas fa-store"></i> {{ trans('admin.Store') }}</a>
                                                <a href="{{ aurl('celebrities/products/add/' . $admin->id) }}" class="dropdown-item"><i class="fas fa-boxes"></i> {{ trans('admin.All Products') }}</a>
                                                <div class="dropdown-divider"></div>
                                                <a href="#" data-id="{{ $admin->id }}" data-name="{{ $admin->name }}" id="delete" class="dropdown-item"><i class="fas fa-trash"></i> {{ trans('admin.Delete') }}</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $admins->links('admin.pagination.index') }}
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
                <form action="{{ aurl('admins/delete') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12 text-center">
                            <p style="margin-top: 10px;font-size: x-large" class="text-primary" id="adminName"></p>
                        </div>
                        <input type="hidden" id="admin_id" name="admin_id" value="">
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
                    var adminName = $(this).attr('data-name');
                    var adminId = $(this).attr('data-id');
                    $("#adminName").text(adminName);
                    $("#admin_id").val(adminId);
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
