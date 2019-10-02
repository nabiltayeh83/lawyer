@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.edit'))}} {{ucwords(__('cp.employee'))}}
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
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase"
                              style="color: #e02222 !important;">{{__('cp.edit')}} {{__('cp.employee')}}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form method="post" action="{{route('admin.users.update',$item->id)}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form" id="form_company">
                        {{ csrf_field() }}
                        {{ method_field('PATCH')}}

                        <fieldset>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="order">
                                    {{__('cp.full_name')}}
                                    <span class="symbol">*</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name"
                                           placeholder="{{__('cp.full_name')}}"  value="{{$item->name}}" required>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="order">
                                    {{__('cp.mobile')}}
                                    <span class="symbol">*</span>
                                </label>
                                <div class="col-md-6">
                                    <input onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" type="text" class="form-control" name="mobile" value="{{$item->mobile}}"
                                           placeholder="{{__('cp.mobile')}}" {{ old('mobile') }} required>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="order">
                                    {{__('cp.email')}}
                                    <span class="symbol">*</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name"
                                           placeholder="{{__('cp.email')}}"  value="{{$item->email}}" disabled>
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
                                        <i class="fa fa-pencil"></i>
                                    </div>
                                    <input type="file" class="form-control" name="image"
                                           id="edit_image"
                                           style="display:none">
                                </div>
                            </div>
                        </fieldset>

                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn green">{{__('cp.submit')}}</button>
                                    <a href="{{url(getLocal().'/admin/employees')}}" class="btn default">
                                    {{__('cp.cancel')}}</a>
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


        @if($item->is_student==0)
        $('#jobDiv').removeClass('hidden');
        $('#jobTitle').prop('required',true);

        @else
        $('#typeStudentDiv').removeClass('hidden');
        $('#typeStudent').prop('required',true);
        @endif
        $('#edit_image').on('change', function (e) {
            readURL(this, $('#editImage'));
        });





        $("#typePostion").change(function() {


            //alert($(this).find(':selected').attr('data-id'));

            //  if ($(this).data('options') === undefined) {

            /*Taking an array of all options-2 and kind of embedding it on the select1*/
            if($(this).find(':selected').attr('data-id')==0)
            {
                $(this).data('options', $('#jobTitle option').clone());
            }
            else
            {
                $(this).data('options', $('#typeStudent option').clone());
            }



            //   }
            var id = $(this).val();


            // alert(id);
            var options = $(this).data('options').filter('[data-id=' + id + ']');


            //  alert(options.length);
            //console.log(options.length);

            //  alert(id);

            if(options.length > 0)
            {


                if($(this).find(':selected').attr('data-id')==0)
                {

                    //    alert('other');
                    $('#jobDiv').removeClass('hidden');
                    $('#jobTitle').prop('required',true);

                    $('#typeStudentDiv').addClass('hidden');
                    $('#typeStudent').prop('required',false);
                }
                else
                {
                    //   alert('student');
                    $('#jobDiv').addClass('hidden');
                    $('#jobTitle').prop('required',false);

                    $('#typeStudentDiv').removeClass('hidden');
                    $('#typeStudent').prop('required',true);
                }





                /////////////////


            }
            else
            {
                $('#typeStudentDiv').addClass('hidden');
                $('#typeStudent').prop('required',false);

                //////

                $('#jobDiv').addClass('hidden');
                $('#jobTitle').prop('required',false);
            }

            if($(this).find(':selected').attr('data-id')==0)
            {
                $('#jobTitle').html(options);
            }
            else
            {
                $('#typeStudent').html(options);
            }


        });


        function initialize() {
            var latlng = new google.maps.LatLng('{{$item->lat}}', '{{$item->lng}}');
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
            document.getElementById('address').value = address;
            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;
        }

        google.maps.event.addDomListener(window, 'load', initialize);



    </script>

@endsection
