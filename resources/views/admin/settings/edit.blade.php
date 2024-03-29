@extends('layout.adminLayout')
@section('title')  {{ucwords(__('cp.settings'))}}
@endsection
@section('css')
    <script type="text/javascript"
                src="https://maps.googleapis.com/maps/api/js?key={{env('APIGoogleKey')}}&callback=initMap">
        
    </script>
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
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase"
                              style="color: #e02222 !important;">
                            {{__('cp.settings')}}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form method="post" action="{{url(app()->getLocale().'/admin/settings')}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form">
                        {{ csrf_field() }}
                        <div class="form-body">



                            @foreach($locales as $locale)
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="order">
                                            {{__('cp.sitetitle')}} {{$locale->name}}
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="title_{{$locale->lang}}" value="{{$item->translate($locale->lang)->title}}" id="order"
                                                   placeholder="{{__('cp.sitetitle')}} {{$locale->name}}" 
                                                   {{ old('title_'.$locale->lang) }}>
                                        </div>
                                    </div>
                                </fieldset>
                            @endforeach


                            @foreach($locales as $locale)
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="order">
                                            {{__('cp.key_words')}} {{$locale->name}}
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="key_words_{{$locale->lang}}" value="{{$item->translate($locale->lang)->key_words}}" id="order"
                                                   placeholder="{{__('cp.key_words')}} {{$locale->name}}" 
                                                   {{ old('key_words_'.$locale->lang) }}>
                                        </div>
                                    </div>
                                </fieldset>
                             @endforeach


                            @foreach($locales as $locale)
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="order">
                                            {{__('cp.title')}} {{$locale->name}}
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="address_{{$locale->lang}}" value="{{$item->translate($locale->lang)->address}}" id="order"
                                                   placeholder="{{__('cp.title')}} {{$locale->name}}" {{ old('address_'.$locale->lang) }}>
                                        </div>
                                    </div>
                                </fieldset>
                            @endforeach


                            @foreach($locales as $locale)
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="order">
                                            {{__('cp.description')}} {{$locale->name}}
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="description_{{$locale->lang}}" value="{{$item->translate($locale->lang)->description}}" id="order"
                                                   placeholder="{{__('cp.description')}} {{$locale->name}}" {{ old('description_'.$locale->lang) }}>
                                        </div>
                                    </div>
                                </fieldset>
                            @endforeach

                            <fieldset>
                                <div class="form-group hidden">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('cp.admin_email')}}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="email" class="form-control" name="admin_email" value="{{$item->admin_email}}" id="order"
                                               placeholder="{{__('cp.admin_email.')}}" {{ old('admin_email') }}>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('cp.info_email')}}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="email" class="form-control" name="info_email" value="{{$item->info_email}}" id="order"
                                               placeholder="{{__('cp.info_email')}}" {{ old('info_email') }}>
                                    </div>
                                </div>
                            </fieldset>


                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('cp.app_store_url')}}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="url" class="form-control" name="app_store_url" value="{{$item->app_store_url}}" id="order"
                                               placeholder="{{__('cp.app_store_url')}}" {{ old('app_store_url') }}>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('cp.play_store_url')}}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="url" class="form-control" name="play_store_url" value="{{$item->play_store_url}}" id="order"
                                               placeholder="{{__('cp.play_store_url')}}" {{ old('play_store_url') }}>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('cp.mobile')}}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="mobile" value="{{$item->mobile}}" id="order"
                                               placeholder="{{__('cp.mobile')}}" {{ old('mobile') }}>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('cp.phone')}}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="phone" value="{{$item->phone}}" id="order"
                                               placeholder="{{__('cp.phone')}}" {{ old('phone') }}>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('cp.facebook')}}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="facebook" value="{{$item->facebook}}" id="order"
                                               placeholder="{{__('cp.facebook')}}" {{ old('facebook') }}>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('cp.twitter')}}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="twitter" value="{{$item->twitter}}" id="order"
                                               placeholder="{{__('cp.twitter')}}" {{ old('twitter') }}>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('cp.instagram')}}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="instagram" value="{{$item->instagram}}" id="order"
                                               placeholder="{{__('cp.instagram')}}" {{ old('instagram') }}>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('cp.linked_in')}}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="linked_in" value="{{$item->linked_in}}" id="order"
                                               placeholder="{{__('cp.linked_in')}}" {{ old('linked_in') }}>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('cp.google_plus')}}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="google_plus" value="{{$item->google_plus}}" id="order"
                                               placeholder="{{__('cp.google_plus')}}" {{ old('google_plus') }}>
                                    </div>
                                </div>
                            </fieldset>
                            
                             <fieldset>
                                <div class="form-group" id="gover_option">
                                   <label class="control-label col-md-2">{{__('cp.time_from')}}
                                   </label>
                                   <div class="col-md-6">
                                       <select id="multiple2" class="form-control select2" 
                                            name="time_from">
                                        <option value="">{{__('cp.time')}}</option>
                                        @for($i=00; $i<24 ; $i++)
                                            <option value="{{$i}}" @if($item->time_from == $i) selected @endif>
                                                {{$i}}
                                            </option>
                                        @endfor
                                    </select>
                                   </div>
                               </div>
                            </fieldset>
                            
                             <fieldset>
                                <div class="form-group" id="gover_option">
                                   <label class="control-label col-md-2">{{__('cp.time_to')}}
                                   </label>
                                   <div class="col-md-6">
                                       <select id="multiple2" class="form-control select2" 
                                            name="time_to">
                                        <option value="">{{__('cp.time')}}</option>
                                        @for($i=00; $i<24 ; $i++)
                                            <option value="{{$i}}"  @if($item->time_to == $i) selected @endif>
                                                {{$i}}
                                            </option>
                                        @endfor
                                    </select>
                                   </div>
                               </div>
                            </fieldset>

                            <fieldset>
                                <legend>{{__('cp.logo')}}</legend>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <div class="fileinput-new thumbnail"
                                             onclick="document.getElementById('edit_logo').click()"
                                             style="cursor:pointer">
                                            <img src="{{url($item->logo)}}" id="editlogo">
                                        </div>
                                        <div class="btn red"
                                             onclick="document.getElementById('edit_logo').click()">
                                            <i class="fa fa-pencil"></i>{{__('cp.change_image')}}
                                        </div>
                                        <input type="file" class="form-control" name="logo"
                                               id="edit_logo"
                                               style="display:none">
                                    </div>
                                </div>
                            </fieldset>

                                <fieldset>
                                    <legend>{{__('cp.image')}}</legend>
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-3">
                                            <div class="fileinput-new thumbnail"
                                                 onclick="document.getElementById('edit_image').click()"
                                                 style="cursor:pointer">
                                                <img src="{{url($item->image)}}" id="editImage">
                                            </div>
                                            <div class="btn red"
                                                 onclick="document.getElementById('edit_image').click()">
                                                <i class="fa fa-pencil"></i>{{__('cp.change_image')}}
                                            </div>
                                            <input type="file" class="form-control" name="image"
                                                   id="edit_image"
                                                   style="display:none">
                                        </div>
                                    </div>
                                </fieldset>


                            <fieldset>
                                <legend>{{""}}</legend>
                                <input id="searchInput" class="input-controls" type="text"
                                       placeholder="{{__('cp.search')}}">
                                <div class="map" id="map" style="width: 100%; height: 300px;"></div>
                                <div class="form_area">
                                    <input type="hidden" value="{{$setting->address}}" name="address" id="location">
                                    <input type="hidden" value="{{$setting->latitude}}" name="latitude" id="lat">
                                    <input type="hidden" value="{{$setting->longitude}}" name="longitude" id="lng">
                                </div>

                            </fieldset>


                                <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">{{__('cp.submit')}}</button>
                                        <a href="{{url(getLocal().'/admin/home')}}" class="btn default">
                                        {{__('cp.cancel')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
@section('script')
    <script>
        $('#edit_image').on('change', function (e) {
            readURL(this, $('#editImage'));
        });


        $('#edit_logo').on('change', function (e) {
            readURL(this, $('#editlogo'));
        });

        function format(){
            var e = document.getElementById("type");
            var type = e.options[e.selectedIndex].value;
            //alert(type);

            if(type == 2){

                $('#park').removeClass('hidden');
                $('#edu').prop('required',true);
            }

            if(type == 1){
                $('#park').addClass('hidden');
                $('#edu').prop('required',false);
            }

        }



        /* script */
        function initialize() {
            var latlng = new google.maps.LatLng('{{$setting->latitude}}', '{{$setting->longitude}}');
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
    </script>
@endsection
