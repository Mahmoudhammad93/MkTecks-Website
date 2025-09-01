@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ $title }}</h5>

                <a href="{{ aurl('additions/create') }}" class="btn btn-pill btn-outline-primary btn-air-primary pull-right"><i class="fas fa-plus"></i>
                    {{ trans('admin.Add New Addition') }}</a>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover mb-4">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('admin.Name') }}</th>
                                <th>{{ trans('admin.Type') }}</th>
                                <th>{{ trans('admin.Created At') }}</th>
                                <th>{{ trans('admin.Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($additions as $addition)
                                <tr>
                                    <td>{{ $addition->id }}</td>
                                    <td>{{ $addition->name }}</td>
                                    <td>{{ trans('admin.'.$addition->type) }}</td>
                                    <td>{{ $addition->created_at }}</td>
                                    <td>
                                        <a href="{{ aurl('additions/edit/' . $addition->id) }}" class="btn btn-pill btn-outline-warning btn-air-warning"><i
                                                class="fas fa-edit"></i>
                                            {{ trans('admin.Edit') }}</a>

                                        <button data-id="{{ $addition->id }}" data-name="{{ $addition->name }}" id="delete"
                                            class="btn btn-pill btn-outline-danger btn-air-danger"><i class="fas fa-trash"></i>
                                            {{ trans('admin.Delete') }}</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $additions->links('admin.pagination.index') }}
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
                <form action="{{ aurl('additions/delete') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12 text-center">
                            <p style="margin-top: 10px;font-size: x-large" class="text-info" id="additionName"></p>
                        </div>
                        <input type="hidden" id="addition_id" name="addition_id" value="">
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
                    var additionName = $(this).attr('data-name');
                    var additionId = $(this).attr('data-id');
                    $("#additionName").text(additionName);
                    $("#addition_id").val(additionId);
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
