@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_options') == 1)
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>
                    {{ $title }}
                    <a href="{{ aurl('options/create') }}"
                        class="btn btn-pill btn-outline-primary btn-air-primary pull-right"><i class="fas fa-plus"></i>
                        {{ trans('admin.Add New Option') }}</a>
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
                                    <th>{{ trans('admin.Status') }}</th>
                                    <th>{{ trans('admin.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($options as $option)
                                    <tr>
                                        <td>{{ $option->id }}</td>
                                        <td>{{ $option->name }}</td>
                                        <td>
                                            @if($option->status == 1)
                                            <span class="badge badge-success">{{trans('admin.Active')}}</span>
                                            @else
                                            <span class="badge badge-danger">{{trans('admin.DeActive')}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ aurl('options/view/' . $option->id) }}"
                                                class="btn btn-pill btn-outline-primary btn-air-primary"><i
                                                    class="fas fa-eye"></i>
                                                {{ trans('admin.View') }}</a>
                                            <a href="{{ aurl('options/edit/' . $option->id) }}"
                                                class="btn btn-pill btn-outline-warning btn-air-warning"><i
                                                    class="fas fa-edit"></i>
                                                {{ trans('admin.Edit') }}</a>

                                                <button data-id="{{ $option->id }}" data-name="{{ $option->name }}" data-url="{{asset('admin/options/delete/'.$option->id)}}"
                                                    id="delete" class="btn btn-pill btn-outline-danger btn-air-danger"><i class="fas fa-trash"></i>
                                                    {{ trans('admin.Delete') }}</button>

                                                    <button id="assign" data-id="{{ $option->id }}"
                                                        data-url="{{aurl('options/'.$option->id.'/assign')}}"
                                                        class="btn btn-pill btn-outline-info btn-air-info"><i
                                                            class="fas fa-edit"></i>
                                                        {{ trans('admin.Assign') }}</button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $options->links('admin.pagination.index') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tooltipmodal" aria-hidden="true"
        id="assignModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle"></h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST" id="properity_form">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="floating-label" for="status">{{ trans('admin.Product') }} <span
                                class="redStar">*</span></label>
                            <select name="product_id" class="form-select" id="status">
                                @foreach ($products as $product)
                                    <option value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
                            </select>
                        </div>
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
        id="deleteModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{ trans('admin.Delete') }}</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ aurl('options/delete') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12 text-center">
                            <p style="margin-top: 10px;font-size: x-large" class="text-info" id="categoryName"></p>
                        </div>
                        <input type="hidden" id="category_id" name="category_id" value="">
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
                    var categoryName = $(this).attr('data-name');
                    var categoryId = $(this).attr('data-id');
                    $("#categoryName").text(categoryName);
                    $("#category_id").val(categoryId);
                    $("#deleteModal").modal('show');
                });

                $(document).on("click", "#assign", function() {
                    var status_val = $(this).attr('data-status');
                    var option_id = $(this).attr('data-option-id');
                    var properity_id = $(this).attr('data-id');
                    $("#modalCenterTitle").text($(this).attr('data-name'));
                    $("#name_ar").val($(this).attr('data-name_ar'));
                    $("#name_en").val($(this).attr('data-name_en'));
                    $("#id").val($(this).attr('data-id'));
                    $("#price").val($(this).attr('data-price'));
                    (status_val == 1)? $(`#status option#ac`).prop('selected', true): $(`#status option#dac`).prop('selected', true);
                    $('form#properity_form').attr('action', $(this).attr('data-url'))
                    $("#assignModal").modal('show');

                    // console.log($("#name_ar").val($(this).attr('data-name_ar')))

                    // $('#properity_form input[name=name_ar]').val($("#name_ar").val($(this).attr('data-name_ar')))
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
