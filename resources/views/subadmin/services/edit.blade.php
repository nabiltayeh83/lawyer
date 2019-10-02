@extends('layout.subAdminLayout')
@section('title') {{ucwords(__('cp.services_management_bunch'))}}
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
                              {{ucwords(__('cp.edit_common'))}}{{ucwords(__('cp.service_bunch'))}}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form id="form_category" method="post" action="{{url(app()->getLocale().'/subadmin/services/'.$item->id)}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form">
                        {{ csrf_field() }}
                        {{ method_field('PATCH')}}

                        <div class="form-body">

                          






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
                                                      {{ old('description_'.$locale->lang) }}>{{$item->translate($locale->lang)->description}}</textarea>
                                        </div>
                                    </div>
                                </fieldset>
                            @endforeach



                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('cp.estimated_time_common')}}
                                        <span class="symbol">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input onkeyup=" if (/\D/g.test(this.value)) this.value = this.value.replace(/[^0-9.]/g,'')" type="text" class="form-control" name="estimated_time" value="{{$item->estimated_time }}"
                                               placeholder=" {{__('cp.estimated_time_common')}}" {{ old('estimated_time') }} required>
                                    </div>
                                </div>
                            </fieldset>



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











                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">{{__('cp.submit_common')}}</button>
                                        <a href="{{url(getLocal().'/admin/services')}}" class="btn default">
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






@endsection
@section('script')
    <script>
        $('#edit_image').on('change', function (e) {
            readURL(this, $('#editImage'));
        });
        $('#edit_file').on('change', function (e) {
            readURL(this, $('#edit_file'));
        });



        var FormValidation = function () {

            // basic validation
            var handleValidation1 = function () {
                // for more info visit the official plugin documentation:
                // http://docs.jquery.com/Plugins/Validation

                var form1 = $('#form_category');
                var error1 = $('.alert-danger', form1);
                var success1 = $('.alert-success', form1);

                form1.validate({
                    errorElement: 'span', //default input error message container
                    errorClass: 'help-block help-block-error', // default input error message class
                    focusInvalid: false, // do not focus the last invalid input
                    ignore: "",  // validate all fields including form hidden input
                    messages: {
                        select_multi: {
                            maxlength: jQuery.validator.format("Max {0} items allowed for selection"),
                            minlength: jQuery.validator.format("At least {0} items must be selected"),
                        },
                    },
                    rules: {
                        title_ar: {required: true},
                        title_en: {required: true},

                    },

                    invalidHandler: function (event, validator) { //display error alert on form submit
                        success1.hide();
                        error1.show();
                        App.scrollTo(error1, -200);
                    },


                    highlight: function (element) { // hightlight error inputs

                        $(element)
                            .closest('.form-group').addClass('has-error'); // set error class to the control group
                    },

                    unhighlight: function (element) { // revert the change done by hightlight
                        $(element)
                            .closest('.form-group').removeClass('has-error'); // set error class to the control group
                    },

                    success: function (label) {
                        label
                            .closest('.form-group').removeClass('has-error'); // set success class to the control group
                    },

                    submitHandler: function (form) {
                        success1.show();
                        error1.hide
                        e.submit()
                    }
                });


            };


            return {
                //main function to initiate the module
                init: function () {

                    handleValidation1();

                }

            };

        }();

        jQuery(document).ready(function () {
            FormValidation.init();
        });


    </script>
@endsection
