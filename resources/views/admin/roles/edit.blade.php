@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard') }}/assets/css/vendors/select2.css">
    @endpush
    <form action="{{ aurl('roles/update/' . $role->id) }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <h5 class="card-header">{{ $title }}</h5>
                <div class="card-body">

                    <div class="form-group">
                        <label class="floating-label" for="name">{{ trans('admin.Role Name') }}</label>
                        <input type="text" value="{{ $role->name }}" name="name" class="form-control" id="name">
                        <small
                            class="text-danger">{{ trans('admin.The name must be lowercase and without spaces') }}</small>
                    </div>

                    <div class="form-group">
                        <label class="floating-label" for="display_name_ar">{{ trans('admin.Name Ar') }}</label>
                        <input type="text" value="{{ $role->display_name_ar }}" name="display_name_ar"
                            class="form-control" id="display_name_ar">
                    </div>

                    <div class="form-group">
                        <label class="floating-label" for="display_name_en">{{ trans('admin.Name En') }}</label>
                        <input type="text" value="{{ $role->display_name_en }}" name="display_name_en"
                            class="form-control" id="display_name_en">
                    </div>

                    <div class="form-group">
                        <label class="floating-label" for="description_ar">{{ trans('admin.Description Ar') }}</label>
                        <input type="text" value="{{ $role->description_ar }}" name="description_ar"
                            class="form-control" id="description_ar">
                    </div>

                    <div class="form-group">
                        <label class="floating-label" for="description_en">{{ trans('admin.Description En') }}</label>
                        <input type="text" value="{{ $role->description_en }}" name="description_en"
                            class="form-control" id="description_en">
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-pill btn-outline-primary btn-air-primary"><i
                            class="fas fa-save"></i>&nbsp;{{ trans('admin.Save') }}</button>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <h5 style="display: flex;
            align-items: center;
            justify-content: space-between;">
                <span>
                    {{ trans('admin.Permissions') }}
                </span>
                <span>
                    <div class="media-body text-end switch-outline" style="display: flex;
                    align-items: center;">
                        <label style="margin: 0 5px">Select All</label>
                        <label class="switch" for="check_all">
                            <input type="checkbox" name=""
                                id="check_all"><span
                                class="switch-state bg-primary"></span>
                        </label>
                    </div>
                </span>
            </h5>
            <hr>
            <div class="row">
                @foreach ($tables as $table)
                    <div class="col-md-6 col-xl-6">
                        <div class="card">
                            <div class="card-header" style="padding: 20px 20px 0px 20px !important;">
                                <h5 style="margin-top: 10px ; margin-bottom: -10px">
                                    {{ $table->display_name }}
                                    <div id="table-{{ $table->id }}" class="pull-right">
                                        <div class="media mb-2">
                                            <label class="m-r-10">{{ trans('admin.Select All') }}</label>
                                            <div class="media-body text-end switch-outline">
                                                <label class="switch" for="table{{ $table->id }}">
                                                    <input type="checkbox" name="table[]"
                                                        id="table{{ $table->id }}" {{ in_array($table->id, $tableIds->toArray()) ? 'checked' : '' }}><span
                                                        class="switch-state bg-primary"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </h5>
                            </div>
                            <div class="card-body row switch-showcase">
                                <div class="row">
                                    @foreach ($table->permissions as $permission)
                                        <div class="col-md-6 col-xl-6">
                                            <div class="media mb-2">
                                                <div class="media-body text-end icon-state switch-outline" style="flex: 0 !important">
                                                    <label for="permission{{ $permission->id }}" class="switch">
                                                        <input name="permissions[]" value="{{ $permission->id }}"
                                                        {{ in_array($permission->id, $permissionsId->toArray()) ? 'checked' : '' }}
                                                            data-parentid="table{{ $table->id }}"
                                                            data-id="{{ $permission->id }}"
                                                            data-name="{{ $permission->name }}" type="checkbox"
                                                            id="permission{{ $permission->id }}">
                                                        <span class="switch-state bg-primary"></span>
                                                    </label>
                                                </div>
                                                <label style="margin-top: 9px;" class="m-r-10">{{ $permission->display_name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </form>

    @push('script')
        <script>
            $(document).ready(function() {
                $('[name="table[]"]').on('click', function() {
                    var attr = $(this).attr('id');
                    if ($(this).prop('checked')) {
                        $('*[data-parentid="' + attr + '"]').prop('checked', true);
                    } else {
                        $('*[data-parentid="' + attr + '"]').prop('checked', false);
                    }
                })
                $('[name="permissions[]"]').on('click', function() {
                    var per_attr = $(this).attr('data-parentid');
                    if ($("input:checkbox[data-parentid='" + per_attr + "']").is(":checked")) {
                        $('#' + per_attr).prop('checked', true);
                    } else {
                        $('#' + per_attr).prop('checked', false);
                    }
                })

                $('#check_all').on('change', function(e){
                    if(e.target.checked == true){
                        $('input[type=checkbox]').prop("checked", true)
                    }else{
                        $('input[type=checkbox]').prop("checked", false)
                    }
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
