@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_projects') == 1)
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>
                    {{ $title }}
                    <a href="{{ aurl('projects/create') }}"
                        class="btn btn-pill btn-outline-primary btn-air-primary pull-right"><i class="fas fa-plus"></i>
                        {{ trans('admin.Add New Project') }}</a>
                </h5>
            </div>
            <div class="card-block row">
                <div class="col-sm-12 col-lg-12 col-xl-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('admin.Image') }}</th>
                                    <th>{{ trans('admin.Title') }}</th>
                                    <th>{{ trans('admin.Description') }}</th>
                                    <th>{{ trans('admin.Order') }}</th>
                                    <th>{{ trans('admin.URL') }}</th>
                                    <th>{{ trans('admin.Status') }}</th>
                                    <th>{{ trans('admin.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    <tr>
                                        <td>{{ $project->id }}</td>
                                        <td>
                                            @foreach ($project->image as $img)
                                            <img src="{{ ($img->url)?$img->url:"" }}" style="height:80px" alt="">
                                            @endforeach
                                        </td>
                                        <td>{{ $project->title }}</td>
                                        <td>{{ $project->description }}</td>
                                        <td>{{ $project->order }}</td>
                                        <td>{{ $project->url }}</td>
                                        <td>
                                            @if($project->status == 1)
                                            <span class="badge badge-success">{{trans('admin.Active')}}</span>
                                            @else
                                            <span class="badge badge-danger">{{trans('admin.DeActive')}}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (is_permited('edit_projects') == 1)
                                            <a href="{{ aurl('projects/edit/' . $project->id) }}"
                                                class="btn btn-pill btn-outline-warning btn-air-warning"><i
                                                    class="fas fa-edit"></i>
                                                {{ trans('admin.Edit') }}</a>
                                                @endif

                                                @if (is_permited('delete_projects') == 1)
                                            <button data-id="{{ $project->id }}" data-name="{{ $project->name }}"
                                                data-url="{{ aurl('projects/'.$project->id.'/delete') }}"
                                                id="delete" class="btn btn-pill btn-outline-danger btn-air-danger"><i
                                                    class="fas fa-trash"></i>
                                                {{ trans('admin.Delete') }}</button>
                                                @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $projects->links('admin.pagination.index') }}
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
                <form action="" method="POST">
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
                    var url = $(this).attr('data-url');
                    $("#categoryName").text(categoryName);
                    $("#category_id").val(categoryId);
                    $('#deleteModal form').attr('action', url);
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
