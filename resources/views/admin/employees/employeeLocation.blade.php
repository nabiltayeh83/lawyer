@extends('layout.adminLayout')
@section('title') ({{$user->name}}) {{__('cp.location')}}
@endsection
@section('css')
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdjdB1HwQZU5ZBvmWLFli1h89JP2OPKzA&sensor=false&libraries=places"></script>
    <style type="text/css">
        .input-controls {
            margin-top: 10px;
            border: 1px solid transparent;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            height: 32px;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        #searchInput {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 50%;
        }

        #searchInput:focus {
            border-color: #4d90fe;
        }
    </style>
@endsection







@section('content')

    <div class="portlet light bordered">
        <div class="portlet-body">
            <div class="table-toolbar">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="btn-group">
                            <a href="{{url(app()->getLocale().'/admin/employees/create')}}" style="margin-right: 5px"
                               class="btn sbold green">{{__('cp.add')}}
                                <i class="fa fa-plus"></i>
                            </a>
                            <button class="btn sbold blue btn--filter">{{__('cp.filter')}}
                                <i class="fa fa-search"></i>
                            </button>

                            <button class="btn sbold green event" id="active">{{__('cp.active')}}
                                <i class="fa fa-check"></i>
                            </button>
                            <button class="btn sbold default event" id="not_active">{{__('cp.not_active')}}
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>

                </div>
                <div class="box-filter-collapse">
                    <form class="form-horizontal" method="get" action="{{url(getLocal().'/admin/employees')}}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">{{__('cp.email')}}</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="email"
                                               placeholder="{{__('cp.email')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn sbold blue">{{__('cp.search')}}
                                            <i class="fa fa-search"></i>
                                        </button>
                                        <a href="{{url('admin/employees')}}" type="submit"
                                           class="btn sbold btn-default ">{{__('cp.reset')}}
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">{{__('cp.mobile')}}</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="mobile"
                                               placeholder="{{__('cp.mobile')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <input type="hidden" id="url" value="{{url(app()->getLocale()."/admin/ads/changeStatus2")}}">
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="toolsTable">
                <thead>
                <tr>
                    <th>

                    </th>
                    <th> {{ucwords(__('cp.profile_image'))}}</th>
                    <th> {{ucwords(__('cp.full_name'))}}</th>
                    <th> {{ucwords(__('cp.email'))}}</th>
                    <th> {{ucwords(__('cp.mobile'))}}</th>
                    <th> {{ucwords(__('cp.status'))}}</th>
                    <th> {{ucwords(__('cp.created'))}}</th>
                    <th> {{ucwords(__('cp.action'))}}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($items as $item)
                    <tr class="odd gradeX" id="tr-{{$item->id}}">
                        <td>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes chkBox" value="{{$item->id}}" name="chkBox"/>
                                <span></span>
                            </label>
                        </td>
                        <td> <img src="{{@$item->image}}" style="width: 50px;"></td>
                        <td> {{$item->name}}</td>
                        <td><a href="mailto:{{$item->email}}">{{$item->email}}</a></td>
                        <td> {{$item->mobile}}</td>
                        <td> <span class="label label-sm <?php echo ($item->status == "active")
                                ? "label-info" : "label-danger"?>" id="label-{{$item->id}}">
                                @php
                                    $status = $item->status
                                @endphp

                                {{__('cp.'.$status)}}
                            </span></td>
                        <td class="center">{{$item->created_at}}</td>
                        <td>
                            <div class="btn-group btn-action">
                                <a href="{{url(getLocal().'/admin/employees/'.$item->id.'/edit')}}"
                                   class="btn btn-xs blue tooltips" data-container="body" data-placement="top"
                                   data-original-title="{{__('cp.edit')}}"><i class="fa fa-edit"></i></a>

                                <a href="{{url(getLocal().'/admin/employees/'.$item->id.'/edit_password')}}"
                                   class="btn btn-xs blue tooltips" data-container="body" data-placement="top"
                                   data-original-title="{{__('cp.edit_password')}}"><i class="fa fa-expeditedssl"></i></a>

                                <a href="{{url(getLocal().'/admin/employees/'.$item->id.'/lastLocation')}}"
                                   class="btn btn-xs blue tooltips" data-container="body" data-placement="top"
                                   data-original-title="{{__('cp.lastlocation')}}"><i class="fa fa-map-marker"></i></a>
                               
                                <a href="{{url(getLocal().'/admin/employees/'.$item->id.'/employeeLocation')}}"
                                   class="btn btn-xs blue tooltips" data-container="body" data-placement="top"
                                   data-original-title="{{__('cp.location')}}"><i class="fa fa-map-marker"></i></a>

                            </div>
                        </td>
                    </tr>

                @empty
                    {{__('cp.no')}}
                @endforelse
                </tbody>
            </table>
        </div>
    </div>



    <!--<div class="row">-->
    <!--    <div class="col-md-12">-->
            <!-- BEGIN SAMPLE FORM PORTLET-->
    <!--        <div class="portlet light bordered">-->
    <!--            <div class="portlet-body form">-->
    <!--                <div class="form-body">-->
    <!--                    <fieldset>-->
    <!--                        <div class="form-group">-->
    <!--                            <label class="col-sm-2 control-label" for="">-->
    <!--                                {{__('users.last_time')}}-->
    <!--                                <span>:</span>-->
    <!--                            </label>-->
    <!--                            <div class="col-md-6">-->
    <!--                                <label class="col-sm-6 control-label" for="">-->
    <!--                                    {{$location->created_at}}-->
    <!--                                </label>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </fieldset>-->
    <!--                    <br>-->
    <!--                    <fieldset>-->
    <!--                        <legend>{{__('order.place')}}</legend>-->
    <!--                        <input id="searchInput" class="input-controls" type="text"-->
    <!--                               placeholder="{{__('common.search')}}">-->
    <!--                        <div class="map" id="map" style="width: 100%; height: 300px;"></div>-->
    <!--                        <div class="form_area">-->
    <!--                            <input type="hidden" value="{{$location->latitude}}" name="latitude" id="lat">-->
    <!--                            <input type="hidden" value="{{$location->longitude}}" name="longitude" id="lng">-->
    <!--                        </div>-->
    <!--                    </fieldset>-->

    <!--                    <div class="form-actions">-->
    <!--                        <div class="row">-->
    <!--                            <div class="col-md-offset-3 col-md-9">-->
    <!--                                <a href="{{url(getLocal().'/admin/employees')}}" class="btn default">{{__('common.done')}}</a>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
@endsection
@section('js')
@endsection
@section('script')
    <script>
        $('#edit_image').on('change', function (e) {
            readURL(this, $('#editImage'));
        });


        function initialize() {
            var latlng = new google.maps.LatLng('{{$location->latitude}}', '{{$location->longitude}}');
            var map = new google.maps.Map(document.getElementById('map'), {
                center: latlng,
                zoom: 10
            });
            var marker = new google.maps.Marker({
                map: map,
                position: latlng,
                draggable: true,
                anchorPoint: new google.maps.Point(0, -29)
            });
            var input = document.getElementById('searchInput');
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            var geocoder = new google.maps.Geocoder();
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);
            var infowindow = new google.maps.InfoWindow();
            autocomplete.addListener('place_changed', function () {
                infowindow.close();
                marker.setVisible(false);
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    window.alert("Autocomplete's returned place contains no geometry");
                    return;
                }

                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }

                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

                bindDataToForm(place.formatted_address, place.geometry.location.lat(), place.geometry.location.lng());
                infowindow.setContent(place.formatted_address);
                infowindow.open(map, marker);

            });
            // this function will work on marker move event into map
            google.maps.event.addListener(marker, 'dragend', function () {
                geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            bindDataToForm(results[0].formatted_address, marker.getPosition().lat(), marker.getPosition().lng());
                            infowindow.setContent(results[0].formatted_address);
                            infowindow.open(map, marker);
                        }
                    }
                });
            });
        }

        function bindDataToForm(address, lat, lng) {
            document.getElementById('location').value = address;
            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;
//                                                console.log('location = ' + address);
//                                                console.log('lat = ' + lat);
//                                                console.log('lng = ' + lng);
        }

        google.maps.event.addDomListener(window, 'load', initialize);


        jQuery(document).ready(function() {
            FormValidation.init();
        });


    </script>
    <script type="text/javascript">
        setTimeout(function(){
            location.reload();
        },360000);
    </script>
@endsection
