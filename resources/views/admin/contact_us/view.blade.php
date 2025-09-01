@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ $title }}</h5>
            </div>
            <div class="card-block row">
                <div class="col-sm-12 col-lg-12 col-xl-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <tr>
                                <td>#</td>
                                <td>{{ $message->id }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin.Name') }}</td>
                                <td>{{ $message->name }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin.Phone') }}</td>
                                <td>{{ $message->phone }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin.Email') }}</td>
                                <td>{{ $message->email }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <small>{{ trans('admin.Message') }}:</small><br><br>
                                    <p style="font-size: 20px;font-weight: bold">
                                        {{ $message->message }}
                                    </p>
                                </td>
                            </tr>
                            {{-- @if ($message->reply()->exists())
                                <tr>
                                    <td colspan="2">
                                        <h6>{{ trans('admin.Reply') }} {{ trans('admin.By') }} :
                                            {{ $message->reply->user->name }}</h6>

                                        <br><br>
                                        <p style="font-size: 20px;font-weight: bold">
                                            {!! $message->reply->message !!}
                                        </p>
                                    </td>
                                </tr>
                            @endif --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <form action="{{ aurl('contact_us/replay') }}" method="POST">

        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ trans('admin.Replay') }}</h5>
                </div>
                <div class="card-body">
                    @csrf
                    <input type="hidden" name="contact_id" value="{{ $message->id }}">

                    <div class="form-group">
                        <label class="floating-label" for="title">{{ trans('admin.Title') }}</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="form-control"
                            id="title">
                    </div>

                    <div class="form-group">
                        <textarea name="message" id="message" class="form-control" rows="5">{{ old('description_ar') }}</textarea>
                    </div>

                </div>
                <div class="card-footer">
                    <button class="btn btn-pill btn-outline-info" type="submit"><i class="fas fa-reply"></i>
                        {{ trans('admin.Send') }}</button>
                </div>
            </div>
        </div>
    </form> --}}
    @push('script')
        <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
        <script>
            CKEDITOR.replace('message');
        </script>
    @endpush
@else
<div class="alert alert-danger">
    No Have Permission
</div>
@endif
@endsection
