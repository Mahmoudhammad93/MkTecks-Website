@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_dashboard') == 1)
    <div class="container-fluid">
        <div class="row">
            @if (is_permited('browse_all_team') == 1)
            <div class="col-xl-3 box-col-3 col-lg-3 col-md-3">
                <div class="card o-hidden">
                    <div class="card-body">
                        <div class="ecommerce-widgets media">
                            <div class="media-body">
                                <p class="">{{ trans('admin.Team') }}</p>
                                <h4 class="f-w-500 mb-0 f-20"><span class="counter">{{ $teamCount }}</span></h4>
                            </div>
                            <div class="ecommerce-box light-bg-primary"><i class="fas fa-users fa-lg" style="color:#ee3e36"
                                    aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if (is_permited('browse_all_projects') == 1)
            <div class="col-xl-3 box-col-3 col-lg-3 col-md-3">
                <div class="card o-hidden">
                    <div class="card-body">
                        <div class="ecommerce-widgets media">
                            <div class="media-body">
                                <p class="f-w-500">{{ trans('admin.Projects') }}</p>
                                <h4 class="f-w-500 mb-0 f-20"><span class="counter">{{ $projectsCount }}</span>
                                </h4>
                            </div>
                            <div class="ecommerce-box light-bg-primary"><i class="fas fa-trophy fa-lg"
                                    style="color:#00ff48" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if (is_permited('browse_all_services') == 1)
            <div class="col-xl-3 box-col-3 col-lg-3 col-md-3">
                <div class="card o-hidden">
                    <div class="card-body">
                        <div class="ecommerce-widgets media">
                            <div class="media-body">
                                <p class="f-w-500">{{ trans('admin.Services') }}</p>
                                <h4 class="f-w-500 mb-0 f-20"><span class="counter">{{ $servicesCount }}</span></h4>
                            </div>
                            <div class="ecommerce-box light-bg-primary"><i class="fas fa-star fa-lg"
                                    style="color:#e5ff00" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            {{-- @if (is_permited('browse_all_users') == 1) --}}
            <div class="col-xl-3 box-col-3 col-lg-3 col-md-3">
                <div class="card o-hidden">
                    <div class="card-body">
                        <div class="ecommerce-widgets media">
                            <div class="media-body">
                                <p class="f-w-500">{{ trans('admin.All Users') }}</p>
                                <h4 class="f-w-500 mb-0 f-20"><span class="counter">{{ $allUsers }}</span></h4>
                            </div>
                            <div class="ecommerce-box light-bg-primary"><i class="fas fa-users fa-lg"
                                    style="color:#00ff59" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- @endif --}}
        </div>
        <div class="row">
            <div class="col-xl-6 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ trans('admin.Max Views Products') }}</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="productsChart" style="width: 100%; height: 400px"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ trans('admin.Orders') }}</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="ordersChart" style="width: 100%; height: 400px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <!-- chartjs js -->
        <script src="{{ asset('dashboard') }}/assets/js/plugins/Chart.min.js"></script>
        <!-- highchart chart -->
        <script src="{{ asset('dashboard') }}/assets/js/plugins/highcharts.js"></script>
        <script src="{{ asset('dashboard') }}/assets/js/plugins/highcharts-3d.js"></script>


        <script>
            $(document).ready(function() {

                // [ bar-chart ] start
                var productsChartBar = document.getElementById("productsChart").getContext('2d');
                var data = {
                    labels: [
                        "{{ isset($maxViewsProducts[0]) ? Str::limit($maxViewsProducts[0]->name, 10) : '' }}",
                        "{{ isset($maxViewsProducts[1]) ? Str::limit($maxViewsProducts[1]->name, 10) : '' }}",
                        "{{ isset($maxViewsProducts[2]) ? Str::limit($maxViewsProducts[2]->name, 10) : '' }}",
                        "{{ isset($maxViewsProducts[3]) ? Str::limit($maxViewsProducts[3]->name, 10) : '' }}",
                        "{{ isset($maxViewsProducts[4]) ? Str::limit($maxViewsProducts[4]->name, 10) : '' }}",
                        "{{ isset($maxViewsProducts[5]) ? Str::limit($maxViewsProducts[5]->name, 10) : '' }}",
                    ],
                    datasets: [{
                        label: "{{ trans('admin.Views') }}",
                        data: [
                            "{{ isset($maxViewsProducts[0]) ? $maxViewsProducts[0]->views : '0' }}",
                            "{{ isset($maxViewsProducts[1]) ? $maxViewsProducts[1]->views : '0' }}",
                            "{{ isset($maxViewsProducts[2]) ? $maxViewsProducts[2]->views : '0' }}",
                            "{{ isset($maxViewsProducts[3]) ? $maxViewsProducts[3]->views : '0' }}",
                            "{{ isset($maxViewsProducts[4]) ? $maxViewsProducts[4]->views : '0' }}",
                            "{{ isset($maxViewsProducts[5]) ? $maxViewsProducts[5]->views : '0' }}",
                        ],
                        borderColor: '#ee3e36',
                        backgroundColor: '#ee3e36',
                        hoverborderColor: '#1e9960',
                        hoverBackgroundColor: '#070e1b',
                    }]
                };
                var myproductsChart = new Chart(productsChartBar, {
                    type: 'bar',
                    data: data,
                    options: {
                        barValueSpacing: 20
                    }
                });
                // [ bar-chart ] end

                // [ bar-chart ] start
                var ordermcount = {!! json_encode($ordermcount) !!};
                var orderArr = {!! json_encode($orderArr) !!};
                var bar = document.getElementById("ordersChart").getContext('2d');
                var data = {
                    labels: [
                        "{{ trans('admin.January') }}",
                        "{{ trans('admin.February') }}",
                        "{{ trans('admin.March') }}",
                        "{{ trans('admin.April') }}",
                        "{{ trans('admin.May') }}",
                        "{{ trans('admin.June') }}",
                        "{{ trans('admin.July') }}",
                        "{{ trans('admin.August') }}",
                        "{{ trans('admin.September') }}",
                        "{{ trans('admin.October') }}",
                        "{{ trans('admin.November') }}",
                        "{{ trans('admin.December') }}",
                    ],
                    datasets: [{
                        label: "{{ trans('admin.Orders') }}",
                        data: [
                            orderArr[1],
                            orderArr[2],
                            orderArr[3],
                            orderArr[4],
                            orderArr[5],
                            orderArr[6],
                            orderArr[7],
                            orderArr[8],
                            orderArr[9],
                            orderArr[10],
                            orderArr[11],
                            orderArr[12],
                        ],
                        borderColor: '#ee3e36',
                        backgroundColor: '#ee3e36',
                        hoverborderColor: '#1e9960',
                        hoverBackgroundColor: '#070e1b',
                    }]
                };
                var myBarChart = new Chart(bar, {
                    type: 'bar',
                    data: data,
                    options: {
                        barValueSpacing: 20
                    }
                });
                // [ bar-chart ] end

            })
        </script>
    @endpush
@else
<div class="alert alert-danger">
    No Have Permission
</div>
@endif
@endsection
