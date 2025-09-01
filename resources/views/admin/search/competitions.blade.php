@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ $title }}</h5>
                <a href="{{ aurl('competitions/create') }}" class="btn btn-pill btn-outline-primary btn-air-primary pull-right"><i
                        class="fas fa-plus"></i>
                    {{ trans('admin.Add New Competition') }}</a>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover mb-4">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('admin.Image') }}</th>
                                <th>{{ trans('admin.Spend Title') }}</th>
                                <th>{{ trans('admin.Product Title') }}</th>
                                <th>{{ trans('admin.End At') }}</th>
                                <th>{{ trans('admin.Invoices') }}</th>
                                <th>{{ trans('admin.Views') }}</th>
                                <th>{{ trans('admin.Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($competitions as $competition)
                                <tr>
                                    <td>{{ $competition->id }}</td>
                                    <td><img src="{{ $competition->image()->exists() ? $competition->image->url : '' }}"
                                            class="img-40 m-r-15 rounded-circle align-top" width="60" alt="">
                                    </td>
                                    <td>{{ $competition->spend_title }}</td>
                                    <td>{{ $competition->product_title }}</td>
                                    <td>{{ $competition->end_at }} - {{ $competition->days }}
                                        {{ trans('admin.Days') }}</td>
                                    <td>{{ $competition->invoices_count }}</td>
                                    <td>{{ $competition->views }}</td>
                                    <td>
                                        <a href="{{ aurl('competitions/invoices/' . $competition->id) }}"
                                            class="btn btn-pill btn-outline-success btn-air-success"><i class="fas fa-file-invoice"></i>
                                            {{ trans('admin.Invoices') }}</a>
                                        <a href="{{ aurl('competitions/edit/' . $competition->id) }}"
                                            class="btn btn-pill btn-outline-warning btn-air-warning"><i class="fas fa-edit"></i>
                                            {{ trans('admin.Edit') }}</a>
                                        <button data-id="{{ $competition->id }}" data-name="{{ $competition->name }}"
                                            id="delete" class="btn btn-pill btn-outline-danger btn-air-danger"><i class="fas fa-trash"></i>
                                            {{ trans('admin.Delete') }}</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $competitions->links('admin.pagination.index') }}
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
                <form action="{{ aurl('competitions/delete') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12 text-center">
                            <p style="margin-top: 10px;font-size: x-large" class="text-primary" id="competitionName"></p>
                        </div>
                        <input type="hidden" id="competition_id" name="competition_id" value="">
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
                    var competitionName = $(this).attr('data-name');
                    var competitionId = $(this).attr('data-id');
                    $("#competitionName").text(competitionName);
                    $("#competition_id").val(competitionId);
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
