@extends('admin.layout.admin')
@section('title'){{"Create Course"}}@endsection
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{url('/admin_assets/datepicker/jquery.datetimepicker.css')}}"/>
    <!-- Select2 -->
    <link rel="stylesheet" href="{{url('/admin_assets/plugins/select2/select2.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{url('/admin_assets/plugins/iCheck/all.css')}}">
@endsection
@section('content-header')
    <h1>Create Course</h1>
    <ol class="breadcrumb">
        <li><a href="{{url(app()->getLocale().'/admin/home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url(app()->getLocale().'/admin/courses')}}"><i class="fa fa-th"></i> Courses</a></li>
        <li class="active">Create Course</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Create New Course</h3>
                </div>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>{{'Error'}}!</strong>{{' Wrong data entry'}}<br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form class="form-horizontal" method="post" action="{{url(app()->getLocale().'/admin/courses')}}"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{"Select Type: "}}</label>
                            <div class="col-sm-10">
                                <select name="type" required class="select2 form-control" id="type">
                                    <option value="0">{{"Select Course Type"}}</option>
                                    @foreach($course_types as $type)
                                        <option value="{{$type->id}}">{{$type->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{"Select Category: "}}</label>
                            <div class="col-sm-10">
                                <select name="category_id" required class="select2 form-control" id="category_id">
                                    <option value="0">{{"Select Course Category"}}</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @foreach($locales as $locale)
                        fsdfsdgsd
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Title_{{$locale->lang}} {{$locale->name}}</label>
                                <div class="col-sm-10">
                                    <input type="text" name="title_{{$locale->lang}}" required class="form-control"
                                           placeholder="title {{$locale->name}}">
                                </div>
                            </div>
                        @endforeach
                        @foreach($locales as $locale)
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Course Language_{{$locale->lang}} {{$locale->name}}</label>
                                <div class="col-sm-10">
                                    <input type="text" name="course_language_{{$locale->lang}}" required
                                           class="form-control"
                                           placeholder="course language {{$locale->name}}">
                                </div>
                            </div>
                        @endforeach
                        @foreach($locales as $locale)
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Short Description_{{$locale->lang}} {{$locale->name}}</label>
                                <div class="col-sm-10">
                                    <textarea name="short_description_{{$locale->lang}}" cols="30" rows="2"
                                              required class="form-control"
                                              placeholder="short description {{$locale->name}}"></textarea>
                                </div>
                            </div>
                        @endforeach
                        @foreach($locales as $locale)
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Full Description_{{$locale->lang}} {{$locale->name}}</label>
                                <div class="col-sm-10">
                                    <textarea id="editor_{{$locale->id}}" name="full_description_{{$locale->lang}}"
                                              cols="30" rows="10"
                                              required class="editor1 form-control"
                                              placeholder="full description {{$locale->name}}"></textarea>
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group">
                            <div class="col-md-2" style="float: left;text-align: right">
                                <label>Course Price:</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" name="price" value="0" class="form-control" required
                                       placeholder="course price, 0 if free">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{"Published: "}}</label>
                            <div class="col-sm-10">
                                <input type="checkbox" class="flat-red" value="1" name="is_published" checked>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{"Popular: "}}</label>
                            <div class="col-sm-10">
                                <input type="checkbox" class="flat-red" value="1" name="is_popular">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2" style="float: left;text-align: right">
                                <label>Course Start Time:</label>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" name="start_time"
                                           id="datetimepicker1">
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2" style="float: left;text-align: right">
                                <label>Course End Time:</label>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" name="end_time"
                                           id="datetimepicker2">
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Duration: </label>
                            <div class="col-sm-10">
                                <input type="text" name="duration" class="form-control" required
                                       placeholder="course duration">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Certification Count: </label>
                            <div class="col-sm-10">
                                <input type="number" name="certification_count" class="form-control" required
                                       placeholder="certification count">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Life Time Access Count: </label>
                            <div class="col-sm-10">
                                <input type="number" name="life_time_access_count" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Lectures: </label>
                            <div class="col-sm-10">
                                <input type="number" name="lectures" class="form-control"
                                       placeholder="lectures count">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Quizzes: </label>
                            <div class="col-sm-10">
                                <input type="number" name="quizzes" class="form-control"
                                       placeholder="quizzes count">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Skill Level: </label>
                            <div class="col-sm-10">
                                <input type="text" name="skill_level" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Assessments: </label>
                            <div class="col-sm-10">
                                <input type="text" name="assessments" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Profile Image: </label>
                            <div class="col-sm-10">
                                <input type="file" name="profile_image" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Cover Image: </label>
                            <div class="col-sm-10">
                                <input type="file" name="cover_image" class="form-control">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-default">Cancel</button>
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
        <!--/.col (left) -->
    </div>
@endsection

@section('js-plugins')
    <!-- Select2 -->
    <script src="{{url('/admin_assets/plugins/select2/select2.full.min.js')}}"></script>
    <!-- date-time-picker -->
    <script src="{{url('/admin_assets/datepicker/build/jquery.datetimepicker.full.js')}}"></script>
    <!-- iCheck -->
    <script src="{{url('/admin_assets/plugins/iCheck/icheck.min.js')}}"></script>
    <!-- CK Editor -->
    {{--<script src="{{url('/admin_assets/plugins/ckeditor/ckeditor.js')}}"></script>--}}
    <script src="https://cdn.ckeditor.com/4.7.3/full-all/ckeditor.js"></script>
@endsection
@section('page-script')
    <script>
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2();
        });
        $.datetimepicker.setLocale('en');
        $('#datetimepicker1').datetimepicker({
            timepicker: true,
            dayOfWeekStart: 6,
            format: 'Y-m-d H:i'
        });
        $('#datetimepicker2').datetimepicker({
            timepicker: true,
            dayOfWeekStart: 6,
            format: 'Y-m-d H:i'
        });
        //iCheck for checkbox and radio inputs
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green'
        });

        $(function () {
            @foreach($locales as $locale)
            CKEDITOR.replace('editor_{{$locale->id}}');
            @endforeach
        });
    </script>
@endsection
