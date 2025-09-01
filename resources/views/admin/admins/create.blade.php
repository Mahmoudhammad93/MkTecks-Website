@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard') }}/assets/css/vendors/select2.css">
    @endpush
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <h5 class="card-header">{{ $title }}</h5>
            <form action="{{ aurl('admins/create') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="roles">{{ trans('admin.Roles') }} <span class="redStar">*</span></label>
                        <select class="js-example-placeholder-multiple col-sm-12 {{ lang() == 'ar' ? 'js-example-rtl' : '' }}" multiple="multiple" name="roles[]" id="roles">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->display_name }} - ({{ $role->name }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="floating-label" for="name">{{ trans('admin.Name') }} <span class="redStar">*</span></label>
                        <input type="text" name="name" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                        <label class="floating-label" for="email">{{ trans('admin.Email') }} <span class="redStar">*</span></label>
                        <input type="email" name="email" class="form-control" id="email">
                    </div>
                    <div class="form-group">
                        <label class="floating-label" for="mobile">{{ trans('admin.Mobile') }} <span class="redStar">*</span></label>
                        <input type="number" name="mobile" class="form-control" id="mobile">
                    </div>
                    <div class="form-group">
                        <label class="floating-label" for="password">{{ trans('admin.Password') }} <span class="redStar">*</span></label>
                        <input type="password" name="password" class="form-control" id="password">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-pill btn-outline-primary btn-air-primary"><i class="fas fa-save"></i>&nbsp;{{ trans('admin.Save') }}</button>
                </div>
            </form>
        </div>
    </div>


    @push('script')
        <script src="{{ asset('dashboard') }}/assets/js/select2/select2.full.min.js"></script>
        <script src="{{ asset('dashboard') }}/assets/js/select2/select2-custom.js"></script>
    @endpush
@else
<div class="alert alert-danger">
    No Have Permission
</div>
@endif
@endsection
