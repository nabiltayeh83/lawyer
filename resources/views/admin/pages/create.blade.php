@extends('layout.adminLayout')

@section('title')

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
                              {{__('cp.add')}}</span>

                    </div>

                </div>

                <div class="portlet-body form">

                    <form method="post" action="{{url(app()->getLocale().'/admin/pages')}}"

                          enctype="multipart/form-data" class="form-horizontal" role="form">

                        {{ csrf_field() }}

                        <div class="form-body">







                            @foreach($locales as $locale)

                                <fieldset>

                                    <div class="form-group">

                                        <label class="col-sm-2 control-label" for="order">

                                            {{__('cp.title_'.$locale->lang.'')}}

                                        </label>

                                        <div class="col-md-6">

                                            <input type="text" class="form-control" name="title_{{$locale->lang}}" value="" id="order"

                                                   placeholder=" {{__('cp.title_'.$locale->lang.'')}}" {{ old('title_'.$locale->lang) }}>

                                            <span class="help-inline"> * required </span>

                                        </div>

                                    </div>

                                </fieldset>

                            @endforeach





                                @foreach($locales as $locale)

                                    <fieldset>

                                        <div class="form-group">

                                            <label class="col-sm-2 control-label" for="order">

                                                {{__('cp.description_'.$locale->lang.'')}}

                                            </label>

                                            <div class="col-md-6">

                                                <textarea class="ckeditor form-control" name="description_{{$locale->lang}}" value="" id="order"

                                                          placeholder=" {{__('cp.description_'.$locale->lang.'')}}" {{ old('description_'.$locale->lang) }}></textarea>

                                                <span class="help-inline"> * required </span>

                                            </div>

                                        </div>

                                    </fieldset>

                                @endforeach





                                @foreach($locales as $locale)

                                    <fieldset>

                                        <div class="form-group">

                                            <label class="col-sm-2 control-label" for="order">

                                                {{__('cp.key_words_'.$locale->lang.'')}}

                                            </label>

                                            <div class="col-md-6">

                                                <input type="text" class="form-control" name="key_words_{{$locale->lang}}" value="" id="order"

                                                       placeholder=" {{__('cp.key_words_'.$locale->lang.'')}}" {{ old('key_words_'.$locale->lang) }}>

                                                <span class="help-inline"> * required </span>

                                            </div>

                                        </div>

                                    </fieldset>

                                @endforeach







                                <fieldset>

                                    <legend>{{__('cp.image')}}</legend>

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

                                                <img src="{{url(admin_assets('/images/ChoosePhoto.png'))}}" id="editImage">

                                            </div>

                                            <label class="control-label">{{__('cp.image')}}</label>

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













                            <div class="form-actions">

                                <div class="row">

                                    <div class="col-md-offset-3 col-md-9">

                                        <button type="submit" class="btn green">{{__('cp.submit')}}</button>

                                        <a href="{{url(getLocal().'/admin/pages')}}" class="btn default">
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



    </script>

@endsection

