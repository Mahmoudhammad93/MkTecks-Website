@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ $title }}</h5>

                <a href="{{ aurl('categories/create') }}" class="btn btn-pill btn-outline-primary btn-air-primary pull-right"><i class="fas fa-plus"></i>
                    {{ trans('admin.Add New Category') }}</a>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover mb-4">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('admin.Name') }}</th>
                                <th>{{ trans('admin.Company') }}</th>
                                <th>{{ trans('admin.Type') }}</th>
                                <th>{{ trans('admin.Products Count') }}</th>
                                <th>{{ trans('admin.Percentage') }}</th>
                                <th>{{ trans('admin.Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->company->name }}</td>
                                    <td>{{ $category->type->name }}</td>
                                    <td>{{ $category->products_count }}</td>
                                    <td>{{ $category->percentage }}%</td>
                                    <td>
                                        <a href="{{ aurl('categories/edit/' . $category->id) }}" class="btn btn-pill btn-outline-warning btn-air-warning"><i
                                                class="fas fa-edit"></i>
                                            {{ trans('admin.Edit') }}</a>

                                        <button data-id="{{ $category->id }}" data-name="{{ $category->name }}" id="delete"
                                            class="btn btn-pill btn-outline-danger btn-air-danger"><i class="fas fa-trash"></i>
                                            {{ trans('admin.Delete') }}</button>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $categories->links('admin.pagination.index') }}
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
                <form action="{{ aurl('categories/delete') }}" method="POST">
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
                    var categoryName = $(this).attr('data-name');
                    var categoryId = $(this).attr('data-id');
                    $("#categoryName").text(categoryName);
                    $("#category_id").val(categoryId);
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
