@extends('layout.adminLayout')
@section('title') {{__('cp.settings')}} @endsection
@section('page-style')
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjOp2BjQx-ruFkTnb4mB_2m3eFtcCyPbU&sensor=false&libraries=places"></script>
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
@section('content-header')
    <h1>Edit Setting</h1>
    <ol class="breadcrumb">
        <li><a href="{{url(app()->getLocale().'/admin/home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit Setting</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{"Site Settings"}}</h3>
                </div>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>{{'Error'}}!</strong>{{' Wrong data entry'}}<br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form class="form-horizontal" method="post"
                      action="{{url(app()->getLocale().'/admin/settings')}}"
                      enctype="multipart/form-data">
                    {{csrf_field()}}


                    <div class="box-body">





                        @foreach($locales as $locale)
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Title_{{$locale->lang}} {{$locale->name}}</label>
                                <div class="col-sm-10">
                                    <input type="text" name="title_{{$locale->lang}}"
                                           value="{{$setting->translate($locale->lang)->title}}" required
                                           class="form-control"
                                           placeholder="title {{$locale->name}}">
                                </div>
                            </div>
                        @endforeach


                        @foreach($locales as $locale)
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Key words_{{$locale->lang}} {{$locale->name}}</label>
                                <div class="col-sm-10">
                                    <input type="text" name="key_words_{{$locale->lang}}" required
                                           value="{{$setting->translate($locale->lang)->key_words}}"
                                           class="form-control"
                                           placeholder="key words {{$locale->name}}">
                                </div>
                            </div>
                        @endforeach
                        @foreach($locales as $locale)
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Address_{{$locale->lang}} {{$locale->name}}</label>
                                <div class="col-sm-10">
                                    <input type="text" name="address_{{$locale->lang}}"
                                           value="{{$setting->translate($locale->lang)->address}}" required
                                           class="form-control"
                                           placeholder="address {{$locale->name}}">
                                </div>
                            </div>
                        @endforeach
                        @foreach($locales as $locale)
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Description_{{$locale->lang}}</label>
                                <div class="col-sm-10">
                                    <textarea name="description_{{$locale->lang}}" cols="30" rows="2"
                                              required class="form-control"
                                              placeholder="description">{{$setting->translate($locale->lang)->description}}</textarea>
                                </div>
                            </div>
                        @endforeach



                        <div class="form-group">
                            <div class="col-md-2" style="float: left;text-align: right">
                                <label>Url:</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="url" name="url" value="{{$setting->url}}" class="form-control"
                                       placeholder="site url">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2" style="float: left;text-align: right">
                                <label>Admin Email:</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="email" name="admin_email" value="{{$setting->admin_email}}"
                                       class="form-control" placeholder="admin email">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2" style="float: left;text-align: right">
                                <label>Info Email:</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="email" name="info_email" value="{{$setting->info_email}}"
                                       class="form-control" placeholder="info email">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2" style="float: left;text-align: right">
                                <label>App Store Url:</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="url" name="app_store_url" value="{{$setting->app_store_url}}"
                                       class="form-control" placeholder="app store url">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2" style="float: left;text-align: right">
                                <label>Play Store Url:</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="url" name="play_store_url" value="{{$setting->play_store_url}}"
                                       class="form-control" placeholder="play store url">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2" style="float: left;text-align: right">
                                <label>Mobile:</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" name="mobile" value="{{$setting->mobile}}"
                                       class="form-control" placeholder="mobile">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2" style="float: left;text-align: right">
                                <label>Phone:</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" name="phone" value="{{$setting->phone}}"
                                       class="form-control" placeholder="phone">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2" style="float: left;text-align: right">
                                <label>Facebook:</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" name="facebook" value="{{$setting->facebook}}"
                                       class="form-control" placeholder="facebook">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2" style="float: left;text-align: right">
                                <label>Twitter:</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" name="twitter" value="{{$setting->twitter}}"
                                       class="form-control" placeholder="twitter">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2" style="float: left;text-align: right">
                                <label>Google Plus:</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" name="google_plus" value="{{$setting->google_plus}}"
                                       class="form-control" placeholder="google plus">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2" style="float: left;text-align: right">
                                <label>Linked In:</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" name="linked_in" value="{{$setting->linked_in}}"
                                       class="form-control" placeholder="linked in">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2" style="float: left;text-align: right">
                                <label>Instagram:</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" name="instagram" value="{{$setting->instagram}}"
                                       class="form-control" placeholder="Instagram">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2" style="float: left;text-align: right">
                                <label>Message Chat:</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" name="pinterest" value="{{$setting->pinterest}}"
                                       class="form-control" placeholder="Message Chat">
                            </div>
                        </div>
                        {{--   @foreach($locales as $locale)
                         <div class="form-group">
                             <div class="col-md-2" style="float: left;text-align: right">
                                 <label>Description_{{$locale->lang}}</label>
                             </div>
                             <div class="col-sm-10">
                                 <input type="text" name="description_{{$locale->lang}}" value=""
                                        class="form-control" placeholder="note">
                             </div>
                         </div>
                         @endforeach --}}

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Logo: </label>
                            <div class="col-md-4">
                                <div class="fileinput-new thumbnail"
                                     onclick="document.getElementById('logo').click()" style="cursor:pointer">
                                    <img src="{{$setting->logo}}" id="Logo"></div>
                                <div class="btn fileinput-exists btn-azure"
                                     onclick="document.getElementById('logo').click()"><i
                                            class="fa fa-pencil"></i>{{' Select Image'}}
                                </div>
                                <input type="file" class="form-control" name="logo" value="{{$setting->logo}}" id="logo" style="display:none">
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="col-sm-2 control-label">Image: </label>
                            <div class="col-md-4">
                                <div class="fileinput-new thumbnail"
                                     onclick="document.getElementById('logo2').click()" style="cursor:pointer">
                                    <img src="{{$setting->image}}" id="Logo2"></div>
                                <div class="btn fileinput-exists btn-azure"
                                     onclick="document.getElementById('logo2').click()"><i
                                            class="fa fa-pencil"></i>{{' Select Image'}}
                                </div>
                                <input type="file" class="form-control" name="image" value="" id="logo2" style="display:none">
                            </div>
                        </div>

                        <fieldset>
                            <legend>{{"Event Coordinates"}}</legend>
                            <input id="searchInput" class="input-controls" type="text"
                                   placeholder="Enter a location">
                            <div class="map" id="map" style="width: 100%; height: 300px;"></div>
                            <div class="form_area">
                                <input type="text" disabled value="{{$setting->address}}" name="address" id="location">
                                <input type="text" value="{{$setting->latitude}}" name="latitude" id="lat">
                                <input type="text" value="{{$setting->longitude}}" name="longitude" id="lng">
                            </div>

                        </fieldset>



                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-default">Cancel</button>
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
        <!--/.col (left) -->
    </div>
@endsection

@section('js-plugins')
    <!-- Select2 -->
    <script src="{{url('/admin_assets/plugins/select2/select2.full.min.js')}}"></script>
    <!-- date-time-picker -->
    <script src="{{url('/admin_assets/datepicker/build/jquery.datetimepicker.full.js')}}"></script>
    <!-- iCheck -->
    <script src="{{url('/admin_assets/plugins/iCheck/icheck.min.js')}}"></script>
    <!-- CK Editor -->
    {{--<script src="{{url('/admin_assets/plugins/ckeditor/ckeditor.js')}}"></script>--}}
    <script src="https://cdn.ckeditor.com/4.7.3/full-all/ckeditor.js"></script>
@endsection
@section('page-script')
    <script>
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2();
        });
        $.datetimepicker.setLocale('en');
        $('#datetimepicker1').datetimepicker({
            timepicker: true,
            dayOfWeekStart: 6,
            format: 'Y-m-d H:i:s'
        });
        $('#datetimepicker2').datetimepicker({
            timepicker: true,
            dayOfWeekStart: 6,
            format: 'Y-m-d H:i:s'
        });
        //iCheck for checkbox and radio inputs
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green'
        });

        $(function () {
            @foreach($locales as $locale)
            CKEDITOR.replace('editor_{{$locale->id}}');
            @endforeach
        });

        function readURL(input, target) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    target.attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        var imagesPreview = function (input, placeToInsertImagePreview) {

            if (input.files) {
                var filesAmount = input.files.length;
                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        $($.parseHTML('<i class="fa fa-times-circle-o deleteImage" aria-hidden="true"></i>')).appendTo(placeToInsertImagePreview);
                        $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                        $($.parseHTML('<input type="hidden" name="images[]">')).attr('value', event.target.result).appendTo(placeToInsertImagePreview);
                    };
                    reader.readAsDataURL(input.files[i]);
                }
            }
        };

        $('#profile_image').on('change', function (e) {
            readURL(this, $('#profileImage'));
        });
        $('#logo').on('change', function (e) {
            readURL(this, $('#Logo'));
        });

        $('#logo2').on('change', function (e) {
            readURL(this, $('#Logo2'));
        });



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
