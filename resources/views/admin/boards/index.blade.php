@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_boards') == 1)
    @push('styles')
        <style>
            .qrCodeArea {
                display: none;
            }
        </style>
    @endpush

    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ $title }}
                    <button id="add" class="btn btn-pill btn-outline-primary btn-air-primary pull-right"><i
                            class="fas fa-plus"></i>
                        {{ trans('admin.Add Boards') }}</button>
                </h5>
            </div>
            <div class="card-block row">
                <div class="col-sm-12 col-lg-12 col-xl-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>{{ trans('admin.Board Number') }}</th>
                                    <th>{{ trans('admin.Orders Count') }}</th>
                                    <th>{{ trans('admin.Grand Total') }}</th>
                                    <th>{{ trans('admin.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($boards as $board)
                                    <tr>
                                        <td>{{ $board->number }}</td>
                                        <td>{{ $board->orders_count }}</td>
                                        <td>{{ number_format($board->orders->sum('total') ,3) }} {{ trans('admin.KWD') }}</td>
                                        <td>
                                            <a href="{{ aurl('boards/view/' . $board->id) }}"
                                                class="btn btn-pill btn-outline-primary btn-air-primary"><i
                                                    class="fas fa-eye"></i>
                                                {{ trans('admin.View') }}</a>

                                            <button onclick="printpage({{ $board->number }});"
                                                class="btn btn-pill btn-outline-warning btn-air-warning"><i
                                                    class="fas fa-qrcode"></i> Qr Code</button>

                                            <div class="qrCodeArea" id="qrCodeArea{{ $board->number }}" class="page"
                                                style="width: 100% ;background-color: #fff;text-align: center ; margin: 0 auto">
                                                @for ($i = 0; $i <= 1; $i++)
                                                    <div
                                                        style="width:580px ;display:block ; padding:7px;margin:20px ;border:2px solid #333;text-align:center">
                                                        {!! QrCode::size(550)->generate(url('menu/order/table/' . $board->number)) !!}
                                                    </div>
                                                @endfor
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tooltipmodal" aria-hidden="true" id="addModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{ trans('admin.Delete') }}</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ aurl('boards/create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="floating-label" for="number">{{ trans('admin.Number Of Boards') }} <span
                                    class="redStar">*</span></label>
                            <input required type="number" name="number" class="form-control" id="number">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
                            {{ trans('admin.Close') }}</button>
                        <button type="submit"
                            class="btn btn-pill btn-outline-primary btn-air-primary">{{ trans('admin.Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tooltipmodal" aria-hidden="true"
        id="qrCodeModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{ trans('admin.Delete') }}</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div id="codeArea">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
                        {{ trans('admin.Close') }}</button>
                    <button type="submit"
                        class="btn btn-pill btn-outline-warning btn-air-warning">{{ trans('admin.Print') }}</button>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            $(document).ready(function() {
                $("#add").click(function() {
                    $("#addModal").modal('show');
                });
            });


            function printpage(number) {
                var getpanel = document.getElementById("qrCodeArea" + number);
                var MainWindow = window.open('', '', 'height=1000,width=1280');
                MainWindow.document.write('<html dir="rtl"><head><title></title>');
                MainWindow.document.write(
                    "<link rel=\"stylesheet\" href=\"{{ asset('dashboard') }}/assets/css/print.css\" type=\"text/css\"/>"
                );
                MainWindow.document.write('</head><body onload="window.print();window.close()">');
                MainWindow.document.write(getpanel.innerHTML);
                MainWindow.document.write('</body></html>');
                MainWindow.document.close();
                setTimeout(function() {
                    MainWindow.print();
                }, 500)
                return false;
            }
        </script>
    @endpush
@else
<div class="alert alert-danger">
    No Have Permission
</div>
@endif
@endsection
