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
                            <tbody>
                                <tr>
                                    <td>{{ trans('admin.Name') }}</td>
                                    <td>{{ $city->name }}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('admin.Areas') }}</td>
                                    <td>{{ $city->areas_count }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ trans('admin.Areas') }}
                    {{-- <button data-id="{{ $city->id }}"
                        class="btn btn-pill btn-outline-primary btn-air-primary pull-right" id="add"><i
                            class="fas fa-plus"></i> {{ trans('admin.Add New Area') }}</button>
                    <button data-id="{{ $city->id }}"
                        class="btn btn-pill btn-outline-info btn-air-info pull-right" style="margin: 0 5px" id="deliveryAdd"><i
                            class="fas fa-plus"></i> {{ trans('admin.Add Delivery Price For All') }}</button> --}}
                </h5>
            </div>
            <div class="card-block row">
                <div class="col-sm-12 col-lg-12 col-xl-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('admin.Name') }}</th>
                                    <th>{{ trans('admin.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($areas as $area)
                                    <tr>
                                        <td>{{ $area->id }}</td>
                                        <td>{{ $area->name }}</td>
                                        <td>
                                            <button data-id="{{ $area->id }}" data-name_ar="{{ $area->name_ar }}"
                                                data-name_en="{{ $area->name_en }}"
                                                data-name="{{ $area->name }}"
                                                data-id="{{ $area->id }}" id="edit"
                                                class="btn btn-pill btn-outline-warning btn-air-warning"><i
                                                    class="fas fa-edit"></i>
                                                {{ trans('admin.Edit') }}</button>

                                            <button data-id="{{ $area->id }}" data-name="{{ $area->name }}"
                                                id="delete" class="btn btn-pill btn-outline-danger btn-air-danger"><i
                                                    class="fas fa-trash"></i>
                                                {{ trans('admin.Delete') }}</button>

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

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tooltipmodal" aria-hidden="true"
        id="deleteModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{ trans('admin.Delete') }}</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ aurl('areas/delete') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12 text-center">
                            <p style="margin-top: 10px;font-size: x-large" class="text-info" id="areaName"></p>
                        </div>
                        <input type="hidden" id="area_id" name="area_id" value="">
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
                            {{ trans('admin.Close') }}</button>
                        <button type="submit"
                            class="btn btn-pill btn-outline-danger btn-air-danger">{{ trans('admin.Delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tooltipmodal" aria-hidden="true"
        id="deliveryAddModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{ trans('admin.Add Delivery Price For All') }}</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ aurl('areas/delivery/create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="city_id" name="city_id" value="{{ $city->id }}">
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
                            {{ trans('admin.Close') }}</button>
                        <button type="submit"
                            class="btn btn-pill btn-outline-info btn-air-info">{{ trans('admin.Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tooltipmodal" aria-hidden="true" id="addModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{ trans('admin.Add New Area') }}</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ aurl('areas/create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="floating-label" for="name_ar">{{ trans('admin.Name Ar') }}</label>
                            <input type="text" name="name_ar" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="floating-label" for="name_en">{{ trans('admin.Name En') }}</label>
                            <input type="text" name="name_en" class="form-control">
                        </div>
                        <input type="hidden" id="city_id" name="city_id" value="{{ $city->id }}">
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
                            {{ trans('admin.Close') }}</button>
                        <button type="submit"
                            class="btn btn-pill btn-outline-primary btn-air-primary">{{ trans('admin.Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tooltipmodal" aria-hidden="true"
        id="editModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle"></h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ aurl('areas/update') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="floating-label" for="name_ar">{{ trans('admin.Name Ar') }}</label>
                            <input type="text" name="name_ar" placeholder="{{ trans('admin.Name Ar') }}"
                                class="form-control" id="name_ar">
                        </div>
                        <div class="form-group">
                            <label class="floating-label" for="name_en">{{ trans('admin.Name En') }}</label>
                            <input type="text" name="name_en" class="form-control" placeholder="trans('admin.Name En')"
                                id="name_en">
                        </div>
                        <input type="hidden" name="area_id" class="form-control" id="id">
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
                            {{ trans('admin.Close') }}</button>
                        <button type="submit"
                            class="btn btn-pill btn-outline-primary btn-air-primary">{{ trans('admin.Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            $(document).ready(function() {
                $("#delete ").click(function() {
                    var areaName = $(this).attr('data-name');
                    var areaId = $(this).attr('data-id');
                    $("#areaName").text(areaName);
                    $("#area_id").val(areaId);
                    $("#deleteModal").modal('show');
                });

                $("#add").click(function() {
                    $("#addModal").modal('show');
                });

                $("#deliveryAdd").click(function() {
                    $("#deliveryAddModal").modal('show');
                });

                $("#edit ").click(function() {
                    $("#modalCenterTitle").text($(this).attr('data-name'));
                    $("#name_ar").val($(this).attr('data-name_ar'));
                    $("#name_en").val($(this).attr('data-name_en'));
                    $("#id").val($(this).attr('data-id'));
                    $("#editModal").modal('show');
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
