@extends('layout.adminLayout')
@section('title')
    {{__('cp.add_common')}}  {{__('cp.store_common')}}
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
                              style="color: #e02222 !important;"> 
                              {{__('cp.add_common')}}  {{__('cp.store_common')}} </span>
                    </div>
                </div>
                <div class="portlet-body form">
                 

                    <form method="post" action="{{url(app()->getLocale().'/admin/store')}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form" id="form" >
                        {{ csrf_field() }}

                        @foreach($locales as $locale)
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="name">
                                        {{__('cp.name_'.$locale->lang.'_common')}}
                                        <span class="symbol">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input   type="text" class="form-control" name="name_{{$locale->lang}}"  id="name" {{old('name_'.$locale->lang)}}
                                                 value="{{ old('name_'.$locale->lang) }}"     placeholder=" {{__('cp.name_'.$locale->lang.'_common')}}" required>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="description">
                                        {{__('cp.description_'.$locale->lang.'_common')}}
                                        <span class="symbol">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <textarea   type="text" class="form-control" name="description_{{$locale->lang}}" {{old('description_'.$locale->lang)}}
                                        id="description" value="{{ old('description_'.$locale->lang) }}"
                                        placeholder="{{__('cp.description_'.$locale->lang.'_common')}}" required></textarea>
                                    </div>
                                </div>
                            </fieldset>
                        @endforeach
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="email">
                                        {{__('cp.email_common')}}
                                        <span class="symbol">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="email"  class="form-control" name="email"
                                               {{ old('email') }} placeholder=" {{__('cp.email_common')}}"  required>
                                    </div>
                                </div>
                            </fieldset>


                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="mobile">
                                        {{__('cp.mobile_common')}}
                                        <span class="symbol">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" type="text" class="form-control" name="mobile"
                                               {{ old('mobile') }} placeholder="{{__('cp.mobile_common')}}" required>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="password">
                                        {{__('cp.password_common')}}
                                        <span class="symbol">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="password" class="form-control" name="password"
                                               placeholder=" {{__('cp.password_common')}} "  required>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="confirm_password">
                                        {{__('cp.confirm_password_common')}}
                                        <span class="symbol">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="password" class="form-control" name="confirm_password"
                                               placeholder=" {{__('cp.confirm_password_common')}} " required>
                                    </div>
                                </div>
                            </fieldset>

                        <div class="form-group" id="cityDiv">
                            <label class="control-label col-md-2" for="country">{{__('cp.country_common')}}
                                <span class="required" aria-required="true"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select  class="form-control" aria-required="true" aria-describedby="select-error" aria-invalid="false" id="country" name="country_id" required>
                                    <option value="">{{__('cp.select_common')}} </option>
                                    @foreach($country as $one)
                                    <option value="{{$one->id}}">{{$one->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <fieldset>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="delivery_cost">
                                    {{__('cp.delivery_cost_join')}}
                                    <span class="symbol">*</span>
                                </label>
                                <div class="col-md-6">
                                    <input onkeyup=" if (/\D/g.test(this.value)) this.value = this.value.replace(/[^0-9.]/g,'')"
                                           type="text"  class="form-control" name="delivery_cost"
                                           {{ old('delivery_cost') }} placeholder=" {{__('cp.delivery_cost_join')}}" required>
                                </div>
                            </div>
                        </fieldset>

                        <div class="form-group" id="subscribe">
                            <label class="control-label col-md-2">
                                {{__('cp.subscribe_join')}}
                                <span class="required" aria-required="true">*</span>
                            </label>
                            <div class="col-md-6">
                                <select  class="form-control" aria-required="true" aria-describedby="select-error" aria-invalid="false" id="subscribe" name="subscribe_id" required>
                                    <option value="">{{__('cp.select_common')}} </option>
                                    @foreach($subscribes as $sub)
                                        <option value="{{$sub->id}}"> {{$sub->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <fieldset>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="work_from">
                                    {{__('cp.opening_time_common')}}
                                    <span class="symbol">*</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="time" class="form-control" name="work_from" id="work_from" {{ old('work_from') }} required>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="work_to">
                                    {{__('cp.closing_time_common')}}
                                    <span class="symbol">*</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="time" class="form-control" name="work_to" id="work_to" {{ old('work_to') }} required>
                                </div>
                            </div>
                        </fieldset>

                        <div class="form-group" id="payment">
                            <label class="control-label col-md-2">
                                {{__('cp.payment_join')}}
                                <span class="required" aria-required="true">*</span>
                            </label>
                            <div class="col-md-6">
                                <select class="form-control"
                                         aria-required="true" aria-describedby="select-error" aria-invalid="false" id="payment" name="payment" required>
                                    <option value="">{{__('cp.select_common')}} </option>
                                        <option value ="cash">Cash</option>
                                        <option value ="kent/visa">Kent/visa</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="mainCategory">
                            <label class="control-label col-md-2">
                                {{__('cp.Main_Category_common')}}
                                <span class="required" aria-required="true">*</span>
                            </label>
                            <div class="col-md-6">
                                <select class="form-control select2" id= "multiple-checkboxes" multiple="multiple" name="mainCategory[]" required>
                                    <option value="">{{__('cp.select_common')}} </option>
                                     @foreach($mincategories as $one)
                                        <option value="{{$one->id}}"> {{$one->title}}</option>
                                    @endforeach
                                </select>
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
                                         onclick="document.getElementById('edit_logo').click()"
                                         style="cursor:pointer">
                                        <img src=" {{url(admin_assets('/images/ChoosePhoto.png'))}}"  id="editLogo">
                                    </div>

                                    <div class="btn red"
                                         onclick="document.getElementById('edit_logo').click()">
                                        <i class="fa fa-pencil"></i>
                                    </div>
                                    <input type="file" class="form-control" name="logo"
                                           id="edit_logo"
                                           style="display:none">
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>{{__('cp.image_common')}}</legend>
                            <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}">
                                <div class="col-md-6 col-md-offset-3">
                                    @if ($errors->has('image'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('image') }}</strong>
                                            </span>
                                    @endif
                                    <div class="fileinput-new thumbnail"
                                         onclick="document.getElementById('edit_image').click()"
                                         style="cursor:pointer">
                                        <img src=" {{url(admin_assets('/images/ChoosePhoto.png'))}}"  id="editImage">
                                    </div>

                                    <div class="btn red"
                                         onclick="document.getElementById('edit_image').click()">
                                        <i class="fa fa-pencil"></i>
                                    </div>
                                    <input type="file" class="form-control" name="image[]" multiple
                                           id="edit_image" required
                                           style="display:none">
                                </div>
                            </div>
                        </fieldset>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">{{__('common.submit')}}</button>
                                        <a href="{{url(getLocal().'/admin/stores')}}" class="btn default">{{__('cp.cancel_common')}}</a>
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
            readURL(this, $('#editLogo'));
        });

    </script>

    <script>
        $(document).ready(function() {
            $('#multiple-checkboxes').multiselect({
                includeSelectAllOption: true,
            });
        });</script>


@endsection
