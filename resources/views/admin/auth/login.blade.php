@extends('layout.adminLoginLayout')
@section('content')
<body class=" login" style="background-color: #ffffff !important;">
<!-- BEGIN LOGO -->
<div class="logo">
    <div class="page-logo" style="text-align: center; padding: 25px 10px 10px">
        <a href="{{url('/admin/home')}}">
            <img src="{{$setting->logo}}"
                 style="margin: 3px 10px 0 !important; width: 50px;" alt="logo" class="logo-default"/>
        </a>
        <div class="menu-toggler sidebar-toggler">
            <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
        </div>
    </div>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->

        <h3 class="form-title">Login to your admin</h3>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span> Enter any username and password. </span>
        </div>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>{{'Error'}}!</strong>{{' Wrong data entry'}}<br>
                <ul class="list-unstyled">
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
        <form action="{{url(app()->getLocale().'/admin/login')}}" method="post">
            {{csrf_field()}}
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Email</label>
            <div class="input-icon">
                <i class="fa fa-user"></i>
                <input class="form-control placeholder-no-fix" type="email" autocomplete="off" placeholder="Email" name="email" /> </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" /> </div>
        </div>
        <div class="form-actions">

            <button type="submit" class="btn green pull-right" style="width:100%"> Login </button>
        </div>




    </form>

</div>

</body>

@endsection