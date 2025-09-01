@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_products') == 1)
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ $title }}
                    <a href="{{ aurl('products/create') }}"
                        class="btn btn-pill btn-outline-primary btn-air-primary pull-right"><i class="fas fa-plus"></i>
                        {{ trans('admin.Add New Product') }}</a>
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
                                    <th>{{ trans('admin.Name') }}</th>
                                    <th>{{ trans('admin.Price') }}</th>
                                    <th>{{ trans('admin.Category') }}</th>
                                    {{-- <th>{{ trans('admin.Drinks') }}</th>
                                    <th>{{ trans('admin.Extras') }}</th> --}}
                                    <th>{{ trans('admin.Options') }}</th>
                                    <th>{{ trans('admin.Views') }}</th>
                                    <th>{{ trans('admin.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td><img src="{{ $product->image()->exists() ? $product->image->url : '' }}"
                                                class="img-thumbnail" style="max-width: 60px; max-height: 60px;"
                                                alt="">
                                        </td>
                                        <td> {{ Str::limit($product->name, 30) }} </td>
                                        <td>{{ $product->price }}{{ trans('admin.KWD') }}<br>
                                            {{-- <del>{{ $product->old_price }}{{ trans('admin.KWD') }}</del> --}}
                                        </td>
                                        <td>{{ $product->category->name }}</td>

                                        {{-- <td>
                                            @if(isset($product->drinks) && count($product->drinks) > 0)
                                                @foreach ($product->drinks as $drink)
                                                    @if($drink->drink != null)
                                                        <span class="badge badge-secondary">{{$drink->drink->name}}</span>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>

                                        <td>
                                            @if(isset($product->extras) && count($product->extras) > 0)
                                                @foreach ($product->extras as $extra)
                                                    @if ($extra->extra != null)
                                                        <span class="badge badge-secondary">{{$extra->extra->name}}</span>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td> --}}
                                        <td style="width: 300px">
                                            @if(isset($product->options) && count($product->options) > 0)
                                                @foreach ($product->options as $option)
                                                    @if($option->option != null)
                                                        <span class="badge badge-secondary">{{$option->option->name}}</span>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{ $product->views }}</td>
                                        <td>
                                                @if (is_permited('view_products') == 1)
                                            <a href="{{ aurl('products/view/' . $product->id) }}"
                                                class="btn btn-pill btn-outline-primary btn-air-primary btn-sm"><i
                                                    class="fas fa-eye"></i>
                                                {{ trans('admin.View') }}</a>
                                                @endif
                                                @if (is_permited('edit_products') == 1)
                                            <a href="{{ aurl('products/edit/' . $product->id) }}"
                                                class="btn btn-pill btn-outline-warning btn-air-warning btn-sm"><i
                                                    class="fas fa-edit"></i>
                                                {{ trans('admin.Edit') }}</a>
                                                @endif
                                                @if (is_permited('delete_products') == 1)
                                            <button data-id="{{ $product->id }}"
                                                data-image="{{ $product->image()->exists() ? $product->image->url : '' }}"
                                                data-name="{{ $product->name }}" id="delete"
                                                class="btn btn-pill btn-outline-danger btn-air-danger btn-sm"><i
                                                    class="fas fa-trash"></i>
                                                {{ trans('admin.Delete') }}</button>
                                                @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $products->links('admin.pagination.index') }}
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
                <form action="{{ aurl('products/delete') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12 text-center">
                            <img src="" style="max-height: 100px;max-width: 100px;" id="productImage"
                                alt="">
                            <p style="margin-top: 10px;font-size: x-large" class="text-info" id="productName"></p>
                        </div>
                        <input type="hidden" id="product_id" name="product_id" value="">
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
                    var productName = $(this).attr('data-name');
                    var productId = $(this).attr('data-id');
                    var productImage = $(this).attr('data-image');
                    $("#productName").text(productName);
                    $("#productImage").attr('src', productImage);
                    $("#product_id").val(productId);
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
