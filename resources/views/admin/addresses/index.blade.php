@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_addresses') == 1)
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>
                    <a href="{{ aurl('Addresses/create') }}"
                        class="btn btn-pill btn-outline-primary btn-air-primary pull-right"><i class="fas fa-plus"></i>
                        {{ trans('admin.Add New Address') }}</a>
                </h5>
            </div>
            <div class="card-block row">
                <div class="col-sm-12 col-lg-12 col-xl-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('admin.User') }}</th>
                                    <th>{{ trans('admin.Title') }}</th>
                                    <th>{{ trans('admin.Street') }}</th>
                                    <th>{{ trans('admin.Block') }}</th>
                                    <th>{{ trans('admin.Building') }}</th>
                                    <th>{{ trans('admin.Avenue') }}</th>
                                    <th>{{ trans('admin.Flat') }}</th>
                                    <th>{{ trans('admin.Role') }}</th>
                                    <th>{{ trans('admin.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($addresses as $address)
                                    <tr>
                                        <td>{{ $address->id }}</td>
                                        <td> {{ $address->user->name }} </td>
                                        <td> {{ $address->title_name }} </td>
                                        <td> {{ $address->street }} </td>
                                        <td> {{ $address->block }} </td>
                                        <td> {{ $address->building }} </td>
                                        <td> {{ $address->avenue }} </td>
                                        <td> {{ $address->flat }} </td>
                                        <td> {{ $address->role }} </td>
                                        <td>
                                            <a href="{{ aurl('cities/view/' . $address->id) }}"
                                                class="btn btn-pill btn-outline-primary btn-air-primary"><i
                                                    class="fas fa-eye"></i>
                                                {{ trans('admin.View') }}</a>

                                            <a href="{{ aurl('cities/edit/' . $address->id) }}"
                                                class="btn btn-pill btn-outline-warning btn-air-warning"><i
                                                    class="fas fa-edit"></i>
                                                {{ trans('admin.Edit') }}</a>

                                            <button data-id="{{ $address->id }}" data-name="{{ $address->name }}"
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
                <form action="{{ aurl('cities/delete') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12 text-center">
                            <p style="margin-top: 10px;font-size: x-large" class="text-info" id="cityName"></p>
                        </div>
                        <input type="hidden" id="city_id" name="city_id" value="">
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

    @push('script')
        <script>
            $(document).ready(function() {
                $("#delete ").click(function() {
                    var cityName = $(this).attr('data-name');
                    var cityId = $(this).attr('data-id');
                    $("#cityName").text(cityName);
                    $("#city_id").val(cityId);
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
