@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_payments') == 1)
<div class="col-xl-12 col-md-12">
    <div class="card">
        <div class="card-header">
            <h5><a href="{{ url('admin/payments/create') }}" class="btn btn-pill btn-outline-primary btn-air-primary pull-right"><i
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
                                <th>{{ trans('admin.Icon') }}</th>
                                <th>{{ trans('admin.Token') }}</th>
                                <th>{{ trans('admin.Method Number') }}</th>
                                <th>{{ trans('admin.Status') }}</th>
                                <th>{{ trans('admin.Created At') }}</th>
                                <th>{{ trans('admin.Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>{{ $payment->id }}</td>
                                    <td>{{ $payment->name }}</td>
                                    <td>
                                        @if($payment->icon)
                                            <div class="icon" style="width: 150px;height: 150px; margin: auto">
                                                <img src="{{$payment->icon->url}}" width="100%" height="100%" alt="">
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <p style="max-width: 500px">
                                            {{ $payment->token }}
                                        </p>
                                    </td>
                                    <td>{{ $payment->method_number }}</td>
                                    <td>
                                        @if ($payment->status == 1)
                                            <span class="badge badge-success">
                                                {{trans('admin.Active')}}
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                {{trans('admin.DeActive')}}
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $payment->created_at }}</td>
                                    <td>
                                        {{-- <a href="{{ url('admin/coupons/view/' . $payment->id) }}" class="btn btn-pill btn-outline-primary btn-air-primary">
                                            {{ trans('admin.View') }}</a> --}}
                                            @if (is_permited('edit_payments') == 1)
                                        <a href="{{ url('admin/payments/edit/' . $payment->id) }}" class="btn btn-pill btn-outline-success btn-air-success"><i
                                                class="fas fa-edit"></i>
                                            {{ trans('admin.Edit') }}</a>
                                            @endif
                                            @if (is_permited('delete_payments') == 1)
                                        <button data-id="{{ $payment->id }}" data-name="{{ $payment->name }}" data-url="{{asset('admin/payments/delete/'.$payment->id)}}"
                                            id="delete" class="btn btn-pill btn-outline-danger btn-air-danger"><i class="fas fa-trash"></i>
                                            {{ trans('admin.Delete') }}</button>
                                            @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $payments->links('admin.pagination.index') }}
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
