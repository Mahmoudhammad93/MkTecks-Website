@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_branches') == 1)
<div class="col-xl-12 col-md-12">
    <div class="card">
        <div class="card-header">
            <h5><a href="{{ url('admin/branches/create') }}" class="btn btn-pill btn-outline-primary btn-air-primary pull-right"><i
                class="fas fa-plus"></i>
            {{ trans('admin.Add New Admin') }}</a></h5>
        </div>
        <div class="card-block row">
            <div class="col-sm-12 col-lg-12 col-xl-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('admin.Name') }}</th>
                                <th>{{ trans('admin.Address') }}</th>
                                <th>{{ trans('admin.Location') }}</th>
                                <th>{{ trans('admin.Status') }}</th>
                                <th>{{ trans('admin.Created At') }}</th>
                                <th>{{ trans('admin.Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($branches as $branch)
                                <tr>
                                    <td>{{ $branch->id }}</td>
                                    <td>{{ $branch->name }}</td>
                                    <td>{{ $branch->address }}</td>
                                    <td>{{ $branch->latitude.','.$branch->longitude }}</td>
                                    <td>
                                        @if ($branch->status == 1)
                                            <span class="badge badge-success">
                                                {{trans('admin.Active')}}
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                {{trans('admin.DeActive')}}
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $branch->created_at }}</td>
                                    <td>
                                        {{-- <a href="{{ url('admin/coupons/view/' . $branch->id) }}" class="btn btn-pill btn-outline-primary btn-air-primary">
                                            {{ trans('admin.View') }}</a> --}}
                                        <a href="{{ url('admin/branches/edit/' . $branch->id) }}" class="btn btn-pill btn-outline-success btn-air-success"><i
                                                class="fas fa-edit"></i>
                                            {{ trans('admin.Edit') }}</a>
                                        <button data-id="{{ $branch->id }}" data-name="{{ $branch->name }}" data-url="{{asset('admin/branches/delete/'.$branch->id)}}"
                                            id="delete" class="btn btn-pill btn-outline-danger btn-air-danger"><i class="fas fa-trash"></i>
                                            {{ trans('admin.Delete') }}</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $branches->links('admin.pagination.index') }}
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
            <form action="{{ url('admins/delete') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12 text-center">
                        <p style="margin-top: 10px;font-size: x-large" class="text-info" id="adminName"></p>
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
                var url = $(this).attr('data-url');
                $("#deleteModal form").attr('action', url);
                $("#adminName").text(adminName);
                $("#admin_id").val(adminId);
                $("#deleteModal").modal('show');
            });

            $("#stop ").click(function() {
                var adminName = $(this).attr('data-name');
                var adminId = $(this).attr('data-id');
                $("#stopAdminName").text(adminName);
                $("#stop_admin_id").val(adminId);
                $("#stopModal").modal('show');
            });

            $("#continue ").click(function() {
                var adminName = $(this).attr('data-name');
                var adminId = $(this).attr('data-id');
                $("#contAdminName").text(adminName);
                $("#cont_admin_id").val(adminId);
                $("#continueModal").modal('show');
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
