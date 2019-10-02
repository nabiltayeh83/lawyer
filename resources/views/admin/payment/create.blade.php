@extends('layout.adminLayout')

@section('title') {{ucwords(__('cp.payment_methods_bunch'))}}

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
                              {{__('cp.add_common')}}{{__('cp.payment_methods_bunch')}}</span>

                    </div>

                </div>

                <div class="portlet-body form">

                    <form method="post" action="{{url(app()->getLocale().'/admin/payment_methods')}}"

                          enctype="multipart/form-data" class="form-horizontal" role="form" id="form">

                        {{ csrf_field() }}

                        <div class="form-body">





                            <fieldset>

                                        <div class="form-group">

                                            <label class="col-sm-2 control-label" for="order">

                                                {{__('cp.title_bunch')}}

                                                <span class="symbol">*</span>

                                            </label>

                                            <div class="col-md-6">

                                                <input type="text" class="form-control" name="title" value="{{ old('title') }}"

                                                       placeholder=" {{__('cp.title_bunch')}}" >

                                            </div>

                                        </div>

                                    </fieldset>





                          

                            <fieldset>

                                <legend>{{__('cp.image_common')}}</legend>

                                <div class="form-group {{ $errors->has('logo') ? ' has-error' : '' }}">

                                    <div class="col-md-6 col-md-offset-3">

                                        @if ($errors->has('logo'))

                                            <span class="help-block">

                                                <strong>{{ $errors->first('image') }}</strong>

                                            </span>

                                        @endif

                                        <div class="fileinput-new thumbnail"

                                             onclick="document.getElementById('edit_image').click()"

                                             style="cursor:pointer">

                                            <img src="{{url(admin_assets('/images/ChoosePhoto.png'))}}" id="editImage">

                                        </div>

                                        <label class="control-label">{{__('cp.image_common')}}</label>

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

                                        <a href="{{url(getLocal().'/admin/payment_methods')}}" class="btn default">
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

    </script>

@endsection

