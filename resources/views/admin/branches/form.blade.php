@extends('admin.layouts.app')
@section('content')
@if (is_permited('browse_admins') == 1)
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard') }}/assets/css/vendors/select2.css">
        <style>
            /* Always set the map height explicitly to define the size of the div
             * element that contains the map. */
            gmp-map {
              height: 100%;
            }
      
            /* Optional: Makes the sample page fill the window. */
            html,
            body {
              height: 100%;
              margin: 0;
              padding: 0;
            }
            .location{
                display: none
            }
            .location.show{
                display: block;
            }
            .map-row{
                position: relative;
                padding-top: 50px
            }
            .map-search{
                position: absolute;
                top: 0;
                left: 0;
                width: 500px
            }
            .map-search input{
                padding: 10px;
                width: 100%;
                border: none;
                border-radius: 5px;
            }
            #search-btn{
                display: none
            }
          </style>
    @endpush
    <div class="col-md-12 col-xl-12">
        <div class="card">
             
            @if(isset($branch))
            <form action="{{ url('admin/branches/update', $branch->id) }}" enctype="multipart/form-data" method="POST">
            @else
            <form action="{{ url('admin/branches/store') }}" enctype="multipart/form-data" method="POST">
            @endif
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label class="floating-label" for="name_ar">{{ trans('admin.Name Ar') }} <span class="redStar">*</span></label>
                        <input type="text" name="name_ar" class="form-control" id="name_ar" value="{{(isset($branch))?$branch->name_ar:''}}">
                    </div>
                    <div class="form-group">
                        <label class="floating-label" for="name_en">{{ trans('admin.Name En') }} <span class="redStar">*</span></label>
                        <input type="text" name="name_en" class="form-control" id="name_en" value="{{(isset($branch))?$branch->name_en:''}}">
                    </div>
                    <div class="form-group">
                        <label class="floating-label" for="address">{{ trans('admin.Address') }} <span class="redStar">*</span></label>
                        <input type="text" name="address" class="form-control" id="address" value="{{(isset($branch))?$branch->address:''}}">
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="floating-label" for="latitude">{{ trans('admin.Latitude') }} <span class="redStar">*</span></label>
                            <input type="text" name="latitude" class="form-control" id="latitude" value="{{(isset($branch))?$branch->latitude:''}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="floating-label" for="longitude">{{ trans('admin.Longitude') }} <span class="redStar">*</span></label>
                            <input type="text" name="longitude" class="form-control" id="longitude" value="{{(isset($branch))?$branch->longitude:''}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input all" name="all_areas" id="all_areas" {{(isset($city_arr) && isset($city_arr) && count($city_arr) > 0 && $city_arr[0] == 'all')?'checked':''}}>
                                <label class="form-check-label" for="all_areas">Support all areas</label>
                            </div>
                        </div>
                    </div>
                    <div class="row location {{(isset($city_arr) && count($city_arr) > 0 && $city_arr[0] == 'all')?'':'show'}}">
                        <div class="form-group">
                            <label class="floating-label" for="component">{{ trans('admin.Governate') }} <span
                                class="redStar">*</span></label>
                            <select class="js-example-basic-multiple" name="city_id[]" id="city_id" multiple>
                                @foreach ($cities as $city)
                                    <option value="{{$city->id}}" {{(isset($city_arr) && in_array($city->id, $city_arr))?'selected':''}}>{{$city->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row location {{(isset($city_arr) && count($city_arr) > 0 && $city_arr[0] == 'all')?'':'show'}}">
                        <div class="form-group">
                            <label class="floating-label" for="component">{{ trans('admin.Area') }} <span
                                class="redStar">*</span></label>
                            <select class="js-example-basic-multiple" name="areas[]" multiple id="areas">
    
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="floating-label" for="longitude">{{ trans('admin.Status') }} <span class="redStar">*</span></label>
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
        <div class="map-row">
            <div id="map" style="width: 500px; height: 500px;border-radius: 5px;"></div>
            <div class="map-search">
                <input type="text" id="search-input" placeholder="Search for a location">
                <button id="search-btn">Search</button>
            </div>
        </div>
    </div>


    @push('script')
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACaD1BYeXiO63exUnx0DzRid5uSZnUohM&callback=initMap" async defer></script>
        <script src="{{ asset('dashboard') }}/assets/js/select2/select2.full.min.js"></script>
        <script src="{{ asset('dashboard') }}/assets/js/select2/select2-custom.js"></script>
        {{-- <script type="text/javascript" src="http://www.google.com/jsapi?key=AIzaSyACaD1BYeXiO63exUnx0DzRid5uSZnUohM"></script> --}}
        <script>
            let map;
            let marker;

            function initMap() {
                const latitudeInput = document.getElementById('latitude');
                const longitudeInput = document.getElementById('longitude');
                const initialLatitude = parseFloat(latitudeInput.value);
                const initialLongitude = parseFloat(longitudeInput.value);
                const initialLocation = { lat: initialLatitude ?? 0, lng: initialLongitude ?? 0 }; // Initial map center

                map = new google.maps.Map(document.getElementById('map'), {
                    center: initialLocation,
                    zoom: 12
                });

                marker = new google.maps.Marker({
                    position: initialLocation,
                    map: map,
                    draggable: true
                });

                // Update the hidden input fields with the marker's position
                google.maps.event.addListener(marker, 'dragend', function() {
                    const position = marker.getPosition();
                    document.getElementById('latitude').value = position.lat();
                    document.getElementById('longitude').value = position.lng();
                });
                const searchInput = document.getElementById('search-input');
                const searchBtn = document.getElementById('search-btn');

                searchInput.addEventListener('keyup', function () {
                    const geocoder = new google.maps.Geocoder();
                    const address = searchInput.value;

                    geocoder.geocode({ 'address': address }, function (results, status) {
                        if (status === 'OK') {
                            const location = results[0].geometry.location;
                            map.setCenter(location);
                            marker.setPosition(location);
                            document.getElementById('latitude').value = location.lat();
                            document.getElementById('longitude').value = location.lng();
                        } 
                        // else {
                        //     alert('Geocode was not successful for the following reason: ' + status);
                        // }
                    });
                });
            }

            $(document).on('keyup', 'input[name=name]', function(){
                value = $(this).val();
                $('input[name=slug]').val(value.toLowerCase().replace(/\s/g , "-"))
            })

            $(document).on('change', '#city_id', function(){
                var cities = $(this).val();
                $.ajax({
                    url: "{{route('branch.areas')}}",
                    dataType: "json",
                    type: "GET",
                    async: true,
                    data: { cities: cities },
                    success: function (data) {
                        console.log(data.areas)
                        var HTML = '';
                        data.areas[0].forEach(function(element){
                            HTML += `<option value="${element.id}">${element.name}</option>`;
                        })

                        $('#areas').html('')
                        $('#areas').append(HTML)
                    },
                    error: function (xhr, exception) {
                        var msg = "";
                        if (xhr.status === 0) {
                            msg = "Not connect.\n Verify Network." + xhr.responseText;
                        } else if (xhr.status == 404) {
                            msg = "Requested page not found. [404]" + xhr.responseText;
                        } else if (xhr.status == 500) {
                            msg = "Internal Server Error [500]." +  xhr.responseText;
                        } else if (exception === "parsererror") {
                            msg = "Requested JSON parse failed.";
                        } else if (exception === "timeout") {
                            msg = "Time out error." + xhr.responseText;
                        } else if (exception === "abort") {
                            msg = "Ajax request aborted.";
                        } else {
                            msg = "Error:" + xhr.status + " " + xhr.responseText;
                        }
                    
                    }
                }); 
            })

            var branchID = {!! (isset($branch))?json_encode($branch->id):0 !!};
            $(document).ready( function(){
                var cities = $('#city_id').val();
                $.ajax({
                    url: "{{route('branch.areas')}}",
                    dataType: "json",
                    type: "GET",
                    async: true,
                    data: { cities: cities, branch_id: branchID },
                    success: function (data) {
                        var HTML = '';
                        data.areas[0].forEach(function(element){
                            HTML += `<option value="${element.id}" ${(data.areas_arr.findIndex(item => item == element.id) != -1)?'selected':''}>${element.name}</option>`;
                        })


                        $('#areas').html('')
                        $('#areas').append(HTML)
                    },
                    error: function (xhr, exception) {
                        var msg = "";
                        if (xhr.status === 0) {
                            msg = "Not connect.\n Verify Network." + xhr.responseText;
                        } else if (xhr.status == 404) {
                            msg = "Requested page not found. [404]" + xhr.responseText;
                        } else if (xhr.status == 500) {
                            msg = "Internal Server Error [500]." +  xhr.responseText;
                        } else if (exception === "parsererror") {
                            msg = "Requested JSON parse failed.";
                        } else if (exception === "timeout") {
                            msg = "Time out error." + xhr.responseText;
                        } else if (exception === "abort") {
                            msg = "Ajax request aborted.";
                        } else {
                            msg = "Error:" + xhr.status + " " + xhr.responseText;
                        }
                    
                    }
                }); 
            })
            $(document).on('change', '#all_areas', function(e){
                if(e.target.checked == true){
                    $('.location').removeClass('show');
                }else{
                    $('.location').addClass('show');
                }
            })

            // function initMap() {
            //     // Your existing code here

            //     const searchInput = document.getElementById('search-input');
            //     const searchBtn = document.getElementById('search-btn');

            //     searchBtn.addEventListener('click', function () {
            //         const geocoder = new google.maps.Geocoder();
            //         const address = searchInput.value;

            //         geocoder.geocode({ 'address': address }, function (results, status) {
            //             if (status === 'OK') {
            //                 const location = results[0].geometry.location;
            //                 map.setCenter(location);
            //                 marker.setPosition(location);
            //                 document.getElementById('latitude').value = location.lat();
            //                 document.getElementById('longitude').value = location.lng();
            //             } else {
            //                 alert('Geocode was not successful for the following reason: ' + status);
            //             }
            //         });
            //     });
            // }
        </script>
    @endpush
@else
<div class="alert alert-danger">
    No Have Permission
</div>
@endif
@endsection
