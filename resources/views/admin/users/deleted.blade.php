@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ $title }}</h5>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover mb-4">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('admin.Name') }}</th>
                                <th>{{ trans('admin.Email') }}</th>
                                <th>{{ trans('admin.Mobile') }}</th>
                                <th>{{ trans('admin.Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->mobile }}</td>
                                    <td>
                                        <a href="{{ aurl('users/restore/'.$user->id) }}" class="btn btn-pill btn-outline-success btn-air-success"><i class="fas fa-redo-alt"></i> {{ trans('admin.Restore') }}</a>
                                        <button data-name="{{ $user->name }}" data-id="{{ $user->id }}" id="delete" class="btn btn-pill btn-outline-danger btn-air-danger"><i class="fas fa-trash"></i> {{ trans('admin.Delete') }}</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $users->links('admin.pagination.index') }}
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
                <form action="{{ aurl('users/force_delete') }}" method="GET">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12 text-center">
                            <p style="margin-top: 10px;font-size: x-large" class="text-info" id="userName"></p>
                        </div>
                        <input type="hidden" id="user_id" name="user_id" value="">
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
                    var userName = $(this).attr('data-name');
                    var userId = $(this).attr('data-id');
                    $("#userName").text(userName);
                    $("#user_id").val(userId);
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
