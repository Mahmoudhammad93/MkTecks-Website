@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard') }}/assets/css/vendors/select2.css">
    @endpush
    <div class="col-md-12 col-xl-12">
        <div class="card">
             
            @if(isset($payment))
            <form action="{{ url('admin/payments/update', $payment->id) }}" enctype="multipart/form-data" method="POST">
            @else
            <form action="{{ url('admin/payments/store') }}" enctype="multipart/form-data" method="POST">
            @endif
                @csrf
                <div class="card-body">
                    @if(isset($payment->icon))
                        <div class="icon" style="width: 150px;height: 150px; margin: auto">
                            <img src="{{$payment->icon->url}}" width="100%" height="100%" alt="">
                        </div>
                    @endif
                    <div class="form-group">
                        <label class="floating-label" for="icon">{{ trans('admin.Icon') }} <span class="redStar">*</span></label>
                        <input type="file" name="icon" class="form-control" id="icon">
                    </div>
                    <div class="form-group">
                        <label class="floating-label" for="name_ar">{{ trans('admin.Name Ar') }} <span class="redStar">*</span></label>
                        <input type="text" name="name_ar" class="form-control" id="name_ar" value="{{(isset($payment))?$payment->name_ar:''}}">
                    </div>
                    <div class="form-group">
                        <label class="floating-label" for="name_en">{{ trans('admin.Name En') }} <span class="redStar">*</span></label>
                        <input type="text" name="name_en" class="form-control" id="name_en" value="{{(isset($payment))?$payment->name_en:''}}">
                    </div>
                    <div class="form-group">
                        <label class="floating-label" for="method_number">{{ trans('admin.Method Number') }} <span class="redStar">*</span></label>
                        <input type="number" name="method_number" class="form-control" id="method_number" value="{{(isset($payment))?$payment->method_number:''}}">
                    </div>
                    <div class="form-group">
                        <label class="floating-label" for="token">{{ trans('admin.Token') }} <span class="redStar">*</span></label>
                        <input type="text" name="token" class="form-control" id="token" value="{{(isset($payment))?$payment->token:''}}">
                    </div>
                    <div class="form-group">
                        <select name="status" class="form-select" id="status">
                            <option value="1">{{trans('admin.Active')}}</option>
                            <option value="0">{{trans('admin.DeActive')}}</option>
                        </select>
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
        <script>
            $(document).on('keyup', 'input[name=name]', function(){
                value = $(this).val();
                $('input[name=slug]').val(value.toLowerCase().replace(/\s/g , "-"))
            })
        </script>
    @endpush
@else
<div class="alert alert-danger">
    No Have Permission
</div>
@endif
@endsection
