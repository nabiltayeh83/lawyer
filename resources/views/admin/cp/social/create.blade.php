@extends('layout.app')

@section('title') {{ucwords(__('cp.title_social'))}}

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
                              {{__('cp.add')}}{{__('cp.social_media')}}</span>

                    </div>

                </div>

                <div class="portlet-body form">

                    <form method="post" action="{{url(app()->getLocale().'/admin/social_media')}}"

                          enctype="multipart/form-data" class="form-horizontal" role="form">

                        {{ csrf_field() }}

                        <div class="form-body">

                            <fieldset>

                                <legend>{{__('cp.social_media')}} {{__('cp.title')}}</legend>



                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="title">

                                        {{__('cp.title')}}

                                        <span class="symbol">*</span>

                                    </label>

                                    <div class="col-md-6">

                                        <input type="text" class="form-control" name="title"

                                               placeholder=" {{__('cp.title')}}" id="title"

                                               value="{{ old('title') }}" required>

                                    </div>

                                </div>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="bio">

                                        {{__('cp.comment')}}

                                        <span class="symbol">*</span>

                                    </label>

                                    <div class="col-md-6">

                                        <input type="text" class="form-control" name="bio"

                                               placeholder=" {{__('cp.comment')}}"

                                               id="bio" value="{{ old('bio') }}" required>

                                    </div>

                                </div>

                            </fieldset>

                            <fieldset>

                                <legend>{{__('cp.social_media')}} {{__('cp.order')}}</legend>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="order">

                                        {{__('cp.order')}}

                                    </label>

                                    <div class="col-md-6">

                                        <input type="text" class="form-control" name="order" value="0" id="order"

                                               placeholder=" {{__('cp.order')}}" {{ old('order') }}>

                                    </div>

                                </div>

                            </fieldset>



                            <fieldset>

                                <legend>{{__('cp.social_category')}}</legend>

                                <div class="form-group">

                                    <label class="col-sm-2 control-label" for="social_category_id">

                                        {{__('cp.social_category_social')}}

                                    </label>

                                    <div class="col-md-6">

                                        <select id="social_category_id" class="form-control select2"

                                                name="social_category_id"

                                                required>

                                            @foreach($social_categories as $social_category)

                                                <option value="{{$social_category->id}}" {{ (old("social_category_id") == $social_category->id ? "selected":"") }}>

                                                    {{$social_category->title}}

                                                </option>

                                            @endforeach

                                        </select>

                                    </div>

                                </div>

                            </fieldset>









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

                                        <a href="{{url(getLocal().'/admin/social_media')}}" class="btn default">
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

