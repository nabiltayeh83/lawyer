@extends('layout.subAdminLayout')
@section('title') {{ucwords(__('cp.title_company'))}}
@endsection
@section('css')
<link href="{{admin_assets('/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{admin_assets('global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{admin_assets('/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{admin_assets('/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{admin_assets('/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{admin_assets('/global/plugins/clockface/css/clockface.css')}}" rel="stylesheet" type="text/css"/>

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
                              {{__('cp.edit_common')}}{{__('cp.company_common')}}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form method="post" action="{{url(app()->getLocale().'/subadmin/company/'.$item->id)}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form">
                        {{ csrf_field() }}
                        {{ method_field('PATCH')}}
                        <div class="form-body">


                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="category_id">
                                    {{__('cp.owner_users')}}
                                    <span class="symbol">*</span>
                                </label>
                                <div class="col-md-6">
                                    <select id="category_id" class="form-control select2" name="owner_id" disabled
                                            required>
                                        <option value="" >  {{__('cp.select_common')}} {{__('cp.user_users')}}</option>

                                            <option @if($owners->id == $item->owner_id) selected @endif value="{{$owners->id}}">
                                                {{$owners->name}}
                                            </option>

                                    </select>
                                </div>
                            </div>



                            @foreach($locales as $locale)
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="order">
                                            {{__('cp.name_'.$locale->lang.'_common')}}
                                            <span class="symbol">*</span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="name_{{$locale->lang}}" value="{{$item->translate($locale->lang)->name}}" id="order"
                                                   placeholder=" {{__('cp.name_'.$locale->lang.'_common')}}" {{ old('name_'.$locale->lang) }}>
                                        </div>
                                    </div>
                                </fieldset>
                            @endforeach



                            @foreach($locales as $locale)
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="order">
                                            {{__('cp.description_'.$locale->lang.'_common')}}
                                            <span class="symbol">*</span>
                                        </label>
                                        <div class="col-md-6">
                                            <textarea class="form-control" name="description_{{$locale->lang}}" id="order"
                                                      placeholder=" {{__('cp.description_'.$locale->lang.'_common')}}" {{ old('description_'.$locale->lang) }}>{{$item->translate($locale->lang)->description}}</textarea>
                                        </div>
                                    </div>
                                </fieldset>
                            @endforeach


                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="minimum_fees">
                                    {{__('cp.minimum_fees_print')}}
                                    <span class="symbol">*</span>
                                </label>
                                <div class="col-md-6" id="">
                                    <input onkeyup=" if (/\D/g.test(this.value)) this.value = this.value.replace(/[^0-9.]/g,'')"  class="form-control" type="text" value="{{$item->minimum_fees}}" name="minimum_fees">
                                </div>
                            </div>




                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="category_id">
                                    {{__('cp.category_common')}}
                                    <span class="symbol">*</span>
                                </label>
                                <div class="col-md-6" id="goto">
                                    <select id="multiple" class="form-control select2-multiple" multiple name="category[]">
                                        @foreach($categories as $cat)
                                            <option value="{{$cat->id}}" @if(in_array($cat->id,$categoriesCurrent->toArray()))selected @endif  > {{$cat->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>






                            <div class="form-group">
                                <label class="col-sm-2 control-label" >
                                    {{__('cp.payment_methods_bunch')}}
                                    <span class="symbol">*</span>
                                </label>
                                <div class="col-md-6">
                                    <select id="multiple2" class="form-control select2-multiple" multiple name="payment_methods[]">
                                        <option value="" > {{__("cp.select_common")}}</option>

                                        @foreach($payments as $payment)
                                            <option value="{{$payment->id}}" @if(in_array($payment->id,$paymentCurrent->toArray()))selected @endif  >
                                                {{$payment->title}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>



                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="category_id">
                                    {{__('cp.deliveryType_common')}}
                                    <span class="symbol">*</span>
                                </label>
                                <div class="col-md-6">
                                    <select class="form-control select2" name="delivery_type"
                                            required id="delivery_type">
                                        <option value="" > {{__('cp.select_common')}} 
                                        {{__('cp.delivery_type_print')}}</option>

                                        @foreach(typeArrive() as $key=>$value)
                                            <option value="{{$key}}" @if($item->delivery_type==$key)selected @endif >{{$value}}  </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>



                            <div class="form-group hidden" id="options">
                                <label class="col-sm-2 control-label" for="category_id">
                                    {{__('cp.deliveryOption_common')}}
                                    <span class="symbol">*</span>
                                </label>
                                <div class="col-md-6">
                                    <select class="form-control select2" name="delivery_option" id="delivery_option"
                                    >
                                        <option value="" > 
                                        {{__('cp.select_common')}} {{__('cp.delivery_option_print')}}</option>
                                        @foreach(optionArrive() as $key=>$value)
                                            <option value="{{$key}}" @if($item->delivery_option==$key)selected @endif >{{$value}}  </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>




                            <div class="form-group hidden" id="delivery_company">
                                <label class="col-sm-2 control-label" >
                                    {{__('cp.deliveryCompany_common')}}
                                    <span class="symbol">*</span>
                                </label>
                                <div class="col-md-6">
                                    <select id="multiple2" class="form-control select2-multiple" multiple name="delivery_company[]">
                                        <option value="" > {{__("cp.select_common")}}</option>

                                        @foreach($deliveries as $dev)
                                            <option value="{{$dev->id}}" @if(in_array($dev->id,$deliveryCompany->toArray()))selected @endif  >
                                                {{$dev->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>







                            <fieldset>
                                <legend>{{__('cp.logo_common')}}</legend>
                                <div class="form-group {{ $errors->has('logo') ? ' has-error' : '' }}">
                                    <div class="col-md-6 col-md-offset-3">
                                        @if ($errors->has('image'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('logo') }}</strong>
                                            </span>
                                        @endif
                                        <div class="fileinput-new thumbnail"
                                             onclick="document.getElementById('edit_image').click()"
                                             style="cursor:pointer">
                                            <img src="{{url(admin_assets('/images/ChoosePhoto.png'))}}" id="editImage">
                                        </div>
                                        <label class="control-label">{{__('cp.logo_common')}}</label>
                                        <div class="btn red"
                                             onclick="document.getElementById('edit_image').click()">
                                            <i class="fa fa-pencil"></i>{{__('cp.change_image_common')}}
                                        </div>
                                        <input type="file" class="form-control" name="logo"
                                               id="edit_image"
                                               style="display:none">
                                    </div>
                                </div>
                            </fieldset>










                            <fieldset>
                                <legend>{{__('cp.image_common')}}</legend>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <div class="fileinput-new thumbnail"
                                             onclick="document.getElementById('edit_image').click()"
                                             style="cursor:pointer">
                                            <img src="{{url($item->logo)}}" id="editImage">
                                        </div>
                                        <label class="control-label">{{__('cp.image_common')}}</label>
                                        <div class="btn red"
                                             onclick="document.getElementById('edit_image').click()">
                                            <i class="fa fa-pencil"></i>{{__('cp.change_image_common')}}
                                        </div>
                                        <input type="file" class="form-control" name="image"
                                               id="edit_image"
                                               style="display:none">
                                    </div>
                                </div>
                            </fieldset>



                            <div class="form-group">
                                <label class="control-label col-md-3">
                                {{__('cp.images_common')}}  {{__('cp.upload_common')}}</label>
                                <div class="col-md-3">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="input-group input-large">
                                            <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                <span class="fileinput-filename"> </span>
                                            </div>
                                            <span class="input-group-addon btn default btn-file">
                                                                <span class="fileinput-new"> 
                                                                {{__('cp.select_common')}}  {{__('cp.file_common')}} </span>
                                                                <span class="fileinput-exists"> 
                                                                {{__('cp.change_common')}} </span>
                                                                <input type="hidden"><input type="file" name="attatchments[]" multiple> </span>
                                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> 
                                            {{__('cp.remove_common')}} </a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                @foreach($item->images as $attatchment)
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                        <div class="dashboard-stat2 ">
                                            <li id="material-{{$attatchment->id}}" style="list-style: none; border-style: outset;">
                                                <a href="#myModal{{$attatchment->id}}" role="button"  data-toggle="modal"><button class="btn btn-outline btn-circle red btn-sm black" data-id="{{$attatchment->id}}"  >
                                                        <span class="glyphicon glyphicon-trash"></span> 
                                                        {{__('cp.delete_common')}}
                                                    </button></a>
                                                {{--<a href="#"--}}
                                                {{--onclick="delete_attatchment('{{$attatchment->id}}','{{$item->id}}',event)" class="btn btn-xs red tooltips">--}}
                                                {{--&nbsp;&nbsp;<i class="fa fa-times" aria-hidden="true"></i>--}}
                                                {{--</a>--}}
                                                <a href="{{url($attatchment->image)}}" target="_blank" >
                                                    <img src="{{$attatchment->image}}" height="200" class="img-responsive pic-bordered" />
                                                </a>

                                            </li>
                                        </div>
                                    </div>
                                    <div id="myModal{{$attatchment->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">{{__('cp.delete_common')}}</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>{{__('cp.confirm_common')}} </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn default" data-dismiss="modal" aria-hidden="true">
                                                    {{__('cp.cancel_common')}}</button>
                                                    <a href="#" onclick="delete_attatchment('{{$attatchment->id}}','{{$item->id}}',event)"><button class="btn btn-danger">
                                                    {{__('cp.submit_common')}}</button></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            </div>




                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green"> {{__('cp.submit_common')}}</button>
                                        <a href="{{url(getLocal().'/subadmin/company')}}" class="btn default"> 
                                        {{__('cp.cancel_common')}}</a>
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


        $('#section_id').on('change', function() {
            //alert( this.value );
            var section_id = this.value ;
            var url = '{{url(getLocal().'/admin/company/create')}}';

            var csrf_token = '{{csrf_token()}}';
            $.ajax({
                type: 'GET',
                headers: {'X-CSRF-TOKEN': csrf_token},
                url: url,
                data: {section_id:section_id},
                success: function (response) {
                    //console.log(response);
                    if(response){
                        $('#sessions').html("");
                    //console.log(response);
                        var toAppend = '';

                        $.each(response,function(i,o){

                            toAppend += '<option value=""></option>';
                            toAppend += '<option value='+o.id+'>'+o.title+'</option>';
                        });



                        $('#sessions').append(toAppend);
                       // $r = document.getElementById('sessions').value;
                       // alert($r);
                    }
                },
                error: function (e) {

                }
            });
        })



        $('.rando').change(function(){
        var category_id= document.getElementById('sessions').value;
         //alert(category_id);
          var url = '{{url(getLocal().'/admin/company/create')}}';

                   var csrf_token = '{{csrf_token()}}';
                    $.ajax({
                        type: 'GET',
                        headers: {'X-CSRF-TOKEN': csrf_token},
                        url: url,
                        data: {category_id:category_id},
                        success: function (response) {
                            //console.log(response);
                            if(response){
                                //alert('ok');
                                $('#multiple').html("");
                            console.log(response);
                                var toAppend = '';

                                $.each(response,function(i,o){
                                    toAppend += '<option value='+o.id+'>'+o.title+'</option>';
                                });



                                $('#multiple').append(toAppend);
                            }
                        },
                        error: function (e) {

                        }
                    });
        });








        function initialize() {
            var latlng = new google.maps.LatLng('{{$item->lat}}', '{{$item->lan}}');
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
