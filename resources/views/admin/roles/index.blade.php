@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_roles') == 1)
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ $title }}<a href="{{ aurl('roles/create') }}" class="btn btn-pill btn-outline-primary btn-air-primary pull-right"><i
                            class="fas fa-plus"></i> {{ trans('admin.Add New Role') }}</a></h5>
            </div>
            <div class="card-block row">
                <div class="col-sm-12 col-lg-12 col-xl-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('admin.Role') }}</th>
                                    <th>{{ trans('admin.Name') }}</th>
                                    <th>{{ trans('admin.Admins Count') }}</th>
                                    <th>{{ trans('admin.Description') }}</th>
                                    <th>{{ trans('admin.Created At') }}</th>
                                    <th>{{ trans('admin.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->display_name }}</td>
                                        <td>{{ $role->admins_count }}</td>
                                        <td data-toggle="tooltip" title="{{ $role->description }}">
                                            {{ Str::limit($role->description, 35) }}</td>
                                        <td>{{ $role->created_at }}</td>
                                        <td>
                                            @if (is_permited('edit_roles') == 1)
                                            <a href="{{ aurl('roles/edit/' . $role->id) }}" class="btn btn-pill btn-outline-warning btn-air-warning"><i
                                                    class="fas fa-edit"></i>
                                                {{ trans('admin.Edit') }}</a>
                                            @endif

                                            @if (is_permited('delete_roles') == 1)
                                            <button data-id="{{ $role->id }}" data-name="{{ $role->name }}"
                                                id="delete" class="btn btn-pill btn-outline-danger btn-air-danger"><i class="fas fa-trash"></i>
                                                {{ trans('admin.Delete') }}</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $roles->links('admin.pagination.index') }}
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
                <form action="{{ aurl('roles/delete') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12 text-center">
                            <p style="margin-top: 10px;font-size: x-large" class="text-primary" id="roleName"></p>
                        </div>
                        <input type="hidden" id="role_id" name="role_id" value="">
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
                    var roleName = $(this).attr('data-name');
                    var roleId = $(this).attr('data-id');
                    $("#roleName").text(roleName);
                    $("#role_id").val(roleId);
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
