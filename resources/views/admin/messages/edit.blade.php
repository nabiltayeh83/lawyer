@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.messages_managments_bunch'))}}
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
                              {{__('cp.view_bunch')}} {{__('cp.message_bunch')}}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form method="post" action="{{url(app()->getLocale().'/admin/messages/'.$item->id)}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form">
                        {{ csrf_field() }}
                        {{ method_field('PATCH')}}
                        <div class="form-body">


                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="category_id">
                                    {{__('cp.user_users')}}
                                    
                                </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" value="{{$item->user->name}}" disabled />
                                </div>
                            </div>
                            
                            
                            
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="category_id">
                                    {{__('cp.company_company')}}
                                    
                                </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" value="{{$item->company->name}}" disabled />
                                </div>
                            </div>
                            
                            
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="category_id">
                                    {{__('cp.message_common')}}
                                    
                                </label>
                                <div class="col-md-6">
                                    <textarea class="form-control"  disabled />{{$item->message}}</textarea>
                                </div>
                            </div>




                          
                           
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        
                                        <a href="{{url(getLocal().'/admin/messages')}}" class="btn default"> 
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
