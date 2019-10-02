@extends('layout.subAdminLayout')
@section('title') {{ucwords(__('cp.edit_common'))}}{{ucwords(__('cp.product_product'))}}
@endsection
@section('css_file_upload')
    <link href="{{admin_assets('/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('css')

        


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
                              {{ucwords(__('cp.edit_common'))}}{{ucwords(__('cp.product_product'))}}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form method="post" action="{{url(app()->getLocale().'/subadmin/products/'.$item->id)}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form">
                        {{ csrf_field() }}
                        {{ method_field('PATCH')}}

                        <div class="form-body">


                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="category_id">
                                    {{__('cp.service_provider_bunch')}}
                                    <span class="symbol">*</span>
                                </label>
                                <div class="col-md-6">
                                    <select class="form-control select2" name="company_id" required  id="category_id">
                                        <option value="" > {{__('cp.select_common')}}</option>
                                        @foreach($companies as $com)
                                            <option value="{{$com->id}}" @if($item->company_id == $com->id) selected @endif>
                                                {{$com->name}}
                                            </option>
                                        @endforeach

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
                                            <textarea class="form-control" name="description_{{$locale->lang}}"  
                                            id="order"
                                                      placeholder=" {{__('cp.description_'.$locale->lang.'_common')}}" 
                                                      {{ old('description_'.$locale->lang) }}>
                                                      {{$item->translate($locale->lang)->description}}</textarea>
                                        </div>
                                    </div>
                                </fieldset>
                            @endforeach



                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('cp.old_price_product')}}
                                        <span class="symbol">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input onkeyup=" if (/\D/g.test(this.value)) this.value = this.value.replace(/[^0-9.]/g,'')"  type="text" class="form-control" name="price" value="{{ $item->price }}"
                                               placeholder=" {{__('cp.old_price_product')}}" {{ old('price') }}>
                                    </div>
                                </div>
                            </fieldset>


                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('cp.current_price_product')}}
                                        <span class="symbol">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input onkeyup=" if (/\D/g.test(this.value)) this.value = this.value.replace(/[^0-9.]/g,'')"  type="text" class="form-control" name="offer_price" value="{{$item->offer_price }}"
                                               placeholder=" {{__('cp.current_price_product')}}" {{ old('offer_price') }} required>
                                    </div>
                                </div>
                            </fieldset>










                            <div class="form-group">
                                <label class="control-label col-md-2">
                                {{__('cp.status_product')}} {{__('cp.product_product')}}
                                    <span class="symbol">*</span>
                                </label>
                                <div class="col-md-8">
                                    <div class="mt-checkbox-inline">
                                        <label class="mt-checkbox">
                                            <input type="checkbox" name="status" id="inlineCheckbox1" 
                                            value="1" @if($item->status == 'active') checked @endif> 
                                            {{__('cp.status_common')}}
                                            <span></span>
                                        </label>

                                    </div>
                                </div>
                            </div>



                            <div class="form-group">
                                <label class="control-label col-md-2">
                                {{__('cp.Availability_common')}} {{__('cp.product_product')}}
                                    <span class="symbol">*</span>
                                </label>
                                <div class="col-md-8">
                                    <div class="mt-checkbox-inline">
                                        <label class="mt-checkbox">
                                            <input type="checkbox" name="availability" id="inlineCheckbox1" value="1" @if($item->availability == 1) checked @endif> 
                                            {{__('cp.Availability_common')}}
                                            <span></span>
                                        </label>

                                    </div>
                                </div>
                            </div>




                            <fieldset>
                                <legend>{{__('cp.logo_common')}}</legend>
                                <div class="form-group {{ $errors->has('logo') ? ' has-error' : '' }}">
                                    <div class="col-md-6 col-md-offset-3">
                                        @if ($errors->has('logo'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('logo') }}</strong>
                                            </span>
                                        @endif
                                        <div class="fileinput-new thumbnail"
                                             onclick="document.getElementById('edit_image').click()"
                                             style="cursor:pointer">
                                            <img src="{{isset($item) && $item->logo ? url($item->logo) : url(admin_assets('/images/ChoosePhoto.png'))}}" id="editImage">
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
                                        <button type="submit" class="btn green">{{__('cp.submit_common')}}</button>
                                        <a href="{{url(getLocal().'/admin/products')}}" class="btn default">
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
@section('js_file_upload')
    <script src="{{admin_assets('/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>

@endsection
@section('js')

    
    <script src="{{admin_assets('/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}" type="text/javascript"></script>
    <script src="{{admin_assets('/global/plugins/jquery-minicolors/jquery.minicolors.min.js')}}" type="text/javascript"></script>
    <script src="{{admin_assets('/pages/scripts/components-color-pickers.min.js')}}" type="text/javascript"></script>
    

    <script src="{{admin_assets('/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js')}}" type="text/javascript"></script>
    <script src="{{admin_assets('/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
    <script src="{{admin_assets('/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}" type="text/javascript"></script>
    <script src="{{admin_assets('/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
    <script src="{{admin_assets('/global/plugins/clockface/js/clockface.js')}}" type="text/javascript"></script>
    <script src="{{admin_assets('/pages/scripts/components-date-time-pickers.min.js')}}" type="text/javascript"></script>


@endsection
@section('script')
    <script>
        $('#edit_image').on('change', function (e) {
            readURL(this, $('#editImage'));
        });
        $('#edit_file').on('change', function (e) {
            readURL(this, $('#edit_file'));
        });

     


        function delete_attatchment(id,iss_id, e) {
            //alert(id);
            e.preventDefault();
            console.log(id);
            console.log(iss_id);
            var url = '{{url(app()->getLocale()."/subadmin/delete_attatchment/")}}/' + id;
            var csrf_token = '{{csrf_token()}}';
            $.ajax({
                type: 'delete',
                headers: {'X-CSRF-TOKEN': csrf_token},
                url: url,
                data: {_method:'delete'},
                success: function (response) {
                    console.log(response);
                    if (response === 'success') {
                        $('#material-' + id).hide(500);
                        $('#myModal' + id).modal('toggle');
                    } else {
                    }
                },
                error: function (e) {
                }
            });

        }
        
        
        
      function delete_featureColor(id,iss_id, e) {
            //alert(id);
            e.preventDefault();
            console.log(id);
            console.log(iss_id);
            var url = '{{url(getLocal()."/subadmin/features_color")}}/' + id;
            var csrf_token = '{{csrf_token()}}';
            $.ajax({
                type: 'delete',
                headers: {'X-CSRF-TOKEN': csrf_token},
                url: url,
                data: {_method:'delete'},
                success: function (response) {
                    console.log(response);
                    if (response === 'success') {
                        $('#tr-' + id).hide(500);
                        $('#myModal' + id).modal('toggle');
                        //swal("القضية حذفت!", {icon: "success"});
                    } else {
                        // swal('Error', {icon: "error"});
                    }
                },
                error: function (e) {
                    // swal('exception', {icon: "error"});
                }
            });

        }
        
        
        function delete_featureSize(id,iss_id, e) {
            //alert(id);
            e.preventDefault();
            console.log(id);
            console.log(iss_id);
            var url = '{{url(getLocal()."/subadmin/features_size")}}/' + id;
            var csrf_token = '{{csrf_token()}}';
            $.ajax({
                type: 'delete',
                headers: {'X-CSRF-TOKEN': csrf_token},
                url: url,
                data: {_method:'delete'},
                success: function (response) {
                    console.log(response);
                    if (response === 'success') {
                        $('#tre-' + id).hide(500);
                        $('#myModal' + id).modal('toggle');
                    } else {
                    }
                },
                error: function (e) {
                    // swal('exception', {icon: "error"});
                }
            });

        }    

    </script>
@endsection
