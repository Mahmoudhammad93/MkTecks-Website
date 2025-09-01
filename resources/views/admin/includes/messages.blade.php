@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">{{ trans('admin.sorry_some_errors') }}!</h4>
        <hr>
        @foreach ($errors->all() as $error)
            <p>* {{ $error }}</p>
        @endforeach
    </div>
@endif

<div class="col-md-12">
    @if (session()->has('success'))
        <div class="alert alert-primary inverse alert-dismissible fade show" role="alert"><i class="fas fa-thumbs-up"></i>
            <p>{{ trans('admin.' . session('success')) }}</p>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session()->has('faild'))
        <div class="alert alert-danger inverse alert-dismissible fade show" role="alert"><i
                class="fas fa-exclamation-triangle"></i>
            <p>{{ trans('admin.' . session('faild')) }}</p>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>
