@extends('layout.subAdminLayout')
@section('title') {{ucwords(__('cp.product_product'))}}
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
                              style="color: #e02222 !important;">{{__("cp.product_product")}}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form method="post" action="{{url(app()->getLocale().'/subadmin/products')}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form">
                        {{ csrf_field() }}
                        <div class="form-body">



                            @foreach($locales as $locale)
                                <fieldset>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="order">
                                            {{__('cp.name_'.$locale->lang.'_common')}}
                                            <span class="symbol">*</span>
                                        </label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="name_{{$locale->lang}}" value="{{ old('name_'.$locale->lang) }}" id="order"
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
                                            <textarea class="form-control" name="description_{{$locale->lang}}" value="{{ old('description_'.$locale->lang) }}" id="order"
                                                      placeholder=" {{__('cp.description_'.$locale->lang.'_common')}}" 
                                                      {{ old('description_'.$locale->lang) }}>{{ old('description_'.$locale->lang) }}</textarea>
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
                                        <input onkeyup=" if (/\D/g.test(this.value)) this.value = this.value.replace(/[^0-9.]/g,'')"  type="text" class="form-control" name="price" value="{{ old('price') }}"
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
                                        <input onkeyup=" if (/\D/g.test(this.value)) this.value = this.value.replace(/[^0-9.]/g,'')"  type="text" class="form-control" name="offer_price" value="{{ old('offer_price') }}"
                                               placeholder=" {{__('cp.current_price_product')}}" {{ old('offer_price') }}>
                                    </div>
                                </div>
                            </fieldset>


                            <div class="form-group">
                                <label class="control-label col-md-2">
                                {{__('cp.product_product')}} {{__('cp.Availability_common')}}
                                    <span class="symbol">*</span>
                                </label>
                                <div class="col-md-8">
                                    <div class="mt-checkbox-inline">
                                        <label class="mt-checkbox">
                                            <input type="checkbox" name="availability" id="inlineCheckbox1" value="1"> 
                                            {{__('cp.Availability_common')}}
                                            <span></span>
                                        </label>

                                    </div>
                                </div>
                            </div>




                            <div class="form-group">
                                <label class="control-label col-md-2">
                                {{__('cp.product_product')}} {{__('cp.status_product')}}
                                    <span class="symbol">*</span>
                                </label>
                                <div class="col-md-8">
                                    <div class="mt-checkbox-inline">
                                        <label class="mt-checkbox">
                                            <input type="checkbox" name="offer" id="inlineCheckbox1" value="1"> 
                                            {{__('cp.in_offer_bunch')}}
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


                            <div class="form-group">
                                <label class="control-label col-md-3">
                                {{__('cp.images_common')}}  {{__('cp.upload_common')}} </label>
                                <div class="col-md-3">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="input-group input-large">
                                            <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                <span class="fileinput-filename"> </span>
                                            </div>
                                            <span class="input-group-addon btn default btn-file">
                                                                <span class="fileinput-new"> 
                                                                {{__('cp.select_common')}}  {{__('cp.file_common')}}  </span>
                                                                <span class="fileinput-exists"> 
                                                                {{__('cp.change_common')}}  </span>
                                                                <input type="hidden"><input type="file" name="attatchments[]" multiple> </span>
                                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> 
                                            {{__('cp.remove_common')}}  </a>
                                        </div>
                                    </div>
                                </div>
                            </div>












                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">{{__('cp.submit_common')}} </button>
                                        <a href="{{url(getLocal().'/admin/products')}}" class="btn default">
                                        {{__('cp.cancel_common')}} </a>
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

       


    </script>
@endsection
