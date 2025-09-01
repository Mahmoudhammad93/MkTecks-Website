@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <h5 class="card-header">{{ $title }}</h5>
            <form action="{{ aurl('cities/update/'.$city->id) }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label class="floating-label" for="name_ar">{{ trans('admin.Name Ar') }} <span class="redStar">*</span></label>
                        <input type="text" name="name_ar" value="{{ $city->name_ar }}" class="form-control" id="name_ar">
                    </div>
                    <div class="form-group">
                        <label class="floating-label" for="name_en">{{ trans('admin.Name En') }} <span class="redStar">*</span></label>
                        <input type="text" name="name_en" value="{{ $city->name_en }}" class="form-control" id="name_en">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-pill btn-outline-primary btn-air-primary"><i class="fas fa-save"></i>&nbsp;{{ trans('admin.Save') }}</button>
                </div>
            </form>
        </div>
    </div>
@else
<div class="alert alert-danger">
    No Have Permission
</div>
@endif
@endsection
