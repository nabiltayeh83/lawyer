@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.edit_common'))}}{{ucwords(__('cp.password_common'))}}
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
                              {{__('cp.edit_common')}}{{__('cp.password_common')}}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form method="post" action="{{url(app()->getLocale().'/admin/stores/'.$item->id.'/edit_password')}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form" id="form">
                        {{ csrf_field() }}

                        <div class="form-body">

                           
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('cp.password_common')}}
                                        <span class="symbol">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="password"  class="form-control" name="password" value=""
                                               placeholder=" {{__('cp.password_common')}}" required>
                                    </div>
                                </div>
                            </fieldset>
                            
                            
                             <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('cp.confirm_password_common')}}
                                        <span class="symbol">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input type="password"  class="form-control" name="confirm_password" value=""
                                               placeholder=" {{__('cp.confirm_password_common')}}" required>
                                    </div>
                                </div>
                            </fieldset>


                          

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">{{__('cp.submit_common')}}</button>
                                        <a href="{{url(getLocal().'/admin/stores')}}" class="btn default">
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
