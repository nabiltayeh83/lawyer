@extends('layout.adminLayout')

@section('title') {{$data->name}}

@endsection

@section('css')

@endsection

@section('content')

    <div class="row">

        <div class="col-md-12">

            <!-- BEGIN SAMPLE FORM PORTLET-->

            <div class="portlet light bordered">

                <div class="portlet-body form">

                        <div class="form-body">

                            <fieldset>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="">

                                        {{__('cp.logo_join')}}

                                        <span>:</span>

                                    </label>

                                    <div class="col-md-6">

                                        <label class="col-sm-6 control-label" for="">

                                            <img src="{{$data->logo}}" width="50px" height="50px">

                                        </label>

                                    </div>

                                </div>

                            </fieldset><br>

                            <fieldset>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="">

                                        {{__('cp.name_common')}}

                                        <span>:</span>

                                    </label>

                                    <div class="col-md-6">

                                        <label class="col-sm-6 control-label" for="">

                                            {{$data->name}}

                                        </label>

                                    </div>

                                </div>

                            </fieldset><br>

                            <fieldset>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="">

                                        {{__('cp.description_join')}}

                                        <span>:</span>

                                    </label>

                                    <div class="col-md-6">

                                        <label class="col-sm-6 control-label" for="">

                                            {{$data->descriptions}}

                                        </label>

                                    </div>

                                </div>

                            </fieldset><br>

                            <fieldset>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="">

                                        {{__('cp.email_join')}}

                                        <span>:</span>

                                    </label>

                                    <div class="col-md-6">

                                        <label class="col-sm-6 control-label" for="">

                                            {{@$data->user->email}}

                                        </label>

                                    </div>

                                </div>

                            </fieldset><br>

                            <fieldset>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="">

                                        {{__('cp.mobile_join')}}

                                        <span>:</span>

                                    </label>

                                    <div class="col-md-6">

                                        <label class="col-sm-6 control-label" for="">

                                            {{@$data->user->mobile}}

                                        </label>

                                    </div>

                                </div>

                            </fieldset><br>

                            <fieldset>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="">

                                        {{__('cp.country_join')}}

                                        <span>:</span>

                                    </label>

                                    <div class="col-md-6">

                                        <label class="col-sm-6 control-label" for="">

                                            {{@$data->country->name}}

                                        </label>

                                    </div>

                                </div>

                            </fieldset><br>

                            <fieldset>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="">

                                        {{__('cp.delivery_cost_join')}}

                                        <span>:</span>

                                    </label>

                                    <div class="col-md-6">

                                        <label class="col-sm-6 control-label" for="">

                                            {{$data->delivery_cost}}

                                        </label>

                                    </div>

                                </div>

                            </fieldset><br>

                            <fieldset>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="">

                                        {{__('cp.work_from_join')}}

                                        <span>:</span>

                                    </label>

                                    <div class="col-md-6">

                                        <label class="col-sm-6 control-label" for="">

                                            {{$data->work_from}}

                                        </label>

                                    </div>

                                </div>

                            </fieldset><br>

                            <fieldset>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="">

                                        {{__('cp.work_to_join')}}

                                        <span>:</span>

                                    </label>

                                    <div class="col-md-6">

                                        <label class="col-sm-6 control-label" for="">

                                            {{$data->work_to}}

                                        </label>

                                    </div>

                                </div>

                            </fieldset><br>

                            <fieldset>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="">

                                        {{__('cp.image_common')}}

                                        <span>:</span>

                                    </label>

                                    <div class="col-md-6">

                                        <label class="col-sm-6 control-label" for="">

                                            @foreach ($data->attachments as $one)

                                            <img src="{{$one->image}}" width="100px" height="100px">

                                            @endforeach

                                        </label>

                                    </div>

                                </div>

                            </fieldset>



                            <div class="form-actions">

                                <div class="row">

                                    <div class="col-md-offset-3 col-md-9">

                                        <a href="{{url(getLocal().'/admin/stores')}}" class="btn default">
                                        {{__('cp.done_common')}}</a>

                                    </div>

                                </div>

                            </div>

                        </div>

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









        var FormValidation = function () {



            // basic validation

            var handleValidation1 = function() {

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

                        logo: {required: true},

                        mainCat: {required: true}

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

                        e.submit()                }

                });





            };







            return {

                //main function to initiate the module

                init: function () {



                    handleValidation1();



                }



            };



        }();



        jQuery(document).ready(function() {

            FormValidation.init();

        });





    </script>

@endsection

