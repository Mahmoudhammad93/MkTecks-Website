@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard') }}/assets/css/vendors/select2.css">
    @endpush
    <div class="col-md-12 col-xl-12">
        <div class="card">
             
            @if(isset($coupon))
            <form action="{{ url('admin/coupons/update', $coupon->id) }}" enctype="multipart/form-data" method="POST">
            @else
            <form action="{{ url('admin/coupons/store') }}" enctype="multipart/form-data" method="POST">
            @endif
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label class="floating-label" for="code">{{ trans('admin.Code') }} <span class="redStar">*</span></label>
                        <input type="text" name="code" class="form-control" id="code" value="{{(isset($coupon))?$coupon->code:''}}">
                    </div>
                    <div class="form-group">
                        <label class="floating-label" for="value">{{ trans('admin.Value') }} <span class="redStar">*</span></label>
                        <input type="number" name="value" class="form-control" id="value" value="{{(isset($coupon))?$coupon->value:''}}">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="discount_type" id="coupo_type1" value="0" {{(isset($coupon) && $coupon->discount_type == 0)?'checked':''}}>
                        <label class="form-check-label" for="coupo_type1">
                          Amount
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="discount_type" id="coupo_type2" value="1" {{(isset($coupon) && $coupon->discount_type == 1)?'checked':''}}>
                        <label class="form-check-label" for="coupo_type2">
                            Percentage
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="floating-label" for="min_total">{{ trans('admin.Mini Total') }} <span class="redStar">*</span></label>
                        <input type="number" name="min_total" class="form-control" id="min_total" value="{{(isset($coupon))?$coupon->min_total:''}}">
                    </div>
                    <div class="form-group">
                        <label class="floating-label" for="usage_count">{{ trans('admin.Usage Count') }} <span class="redStar">*</span></label>
                        <input type="number" name="usage_count" class="form-control" id="usage_count" value="{{(isset($coupon))?$coupon->usage_count:''}}">
                    </div>
                    <div class="form-group">
                        <label class="floating-label" for="usage_per_user">{{ trans('admin.Usage Per User') }} <span class="redStar">*</span></label>
                        <input type="number" name="usage_per_user" class="form-control" id="usage_per_user" value="{{(isset($coupon))?$coupon->usage_per_user:''}}">
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
