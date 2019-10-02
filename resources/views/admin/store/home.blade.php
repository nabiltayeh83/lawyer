@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.all_store_siderbar'))}}
@endsection
@section('css')
@endsection
@section('content')
    <div class="portlet light bordered">
        <div class="portlet-body">
            <div class="table-toolbar">
                <div class="row">
                      <div class="col-sm-9">
                        <div class="btn-group">
                            <a href="{{url(app()->getLocale().'/admin/store/create')}}" style="margin-right: 5px"
                               class="btn sbold green">{{__('cp.add_common')}}
                               <i class="fa fa-plus"></i>
                            </a>
                            <button class="btn sbold blue btn--filter">{{__('cp.filter_common')}}
                                <i class="fa fa-search"></i>
                            </button>
                            <!--<button class="btn sbold red event" id="delete">{{__('cp.delete_common')}}-->
                            <!--    <i class="fa fa-times"></i>-->
                            <!--</button>-->
                            <button class="btn sbold green event" id="active">{{__('cp.active_common')}}
                                <i class="fa fa-check"></i>
                            </button>
                            <button class="btn sbold default event" id="not_active">{{__('cp.not_active_common')}}
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>

                </div>
                <div class="box-filter-collapse">
                    <form class="form-horizontal" method="get" action="{{url(getLocal().'/admin/stores')}}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">{{__('cp.email_common')}}</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="email"
                                               placeholder="{{__('cp.email_common')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">{{__('cp.mobile_common')}}</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="mobile"
                                               placeholder="{{__('cp.mobile_common')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">{{__('cp.country_common')}}</label>
                                    <div class="col-md-9">
                                        <select class="form-control select2" name="country">
                                            <option {{(isset($_GET['country'])&& $_GET['country'] =='no')?'selected':''}} value="no">
                                            {{__('cp.all_common')}}</option>
                                            @foreach($countries as $country)
                                                <option {{(isset($_GET['country'])&& $_GET['country'] == $country->id)?'selected':''}} value="{{$country->id}}">{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">{{__('cp.Main_Category_common')}}</label>
                                    <div class="col-md-9">
                                        <select class="form-control select2" name="category">
                                            <option {{(isset($_GET['category'])&& $_GET['category'] =='no')?'selected':''}} value="no">
                                            {{__('cp.all_common')}}</option>
                                            @foreach($categories as $category)
                                                <option {{(isset($_GET['category'])&& $_GET['category'] == $category->id)?'selected':''}} value="{{$category->id}}">{{$category->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn sbold blue">{{__('cp.search_common')}}
                                            <i class="fa fa-search"></i>
                                        </button>
                                        <a href="{{url('admin/stores')}}" type="submit"
                                           class="btn sbold btn-default ">{{__('cp.reset_common')}}
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
            <input type="hidden" id="url" value="{{url(app()->getLocale()."/admin/stores/changeStatus")}}">
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="toolsTable">
                <thead>
                <tr>
                    <th>
                       
                    </th>
                    <th> {{ucwords(__('cp.full_name_common'))}}</th>
                    <th> {{ucwords(__('cp.email_common'))}}</th>
                    <th> {{ucwords(__('cp.mobile_common'))}}</th>
                    <th> {{ucwords(__('cp.country_common'))}}</th>
                    <th> {{ucwords(__('cp.status_common'))}}</th>
                    <th> {{ucwords(__('cp.action_common'))}}</th>
                </tr>
                </thead>
                <tbody>
                    @forelse($restaurants as $restaurant)
                    <tr class="odd gradeX" id="tr-{{$restaurant->id}}">
                        <td>
                           <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes chkBox" value="{{$restaurant->id}}" name="chkBox"/>
                                <span></span>
                            </label>  
                        </td>
                        <td><a href="{{url(getLocal().'/admin/store/'.$restaurant->id.'/show')}}">{{$restaurant->name}}</a></td>
                        <td>{{@$restaurant->user->email}}</td>
                        <td> {{@$restaurant->user->mobile}}</td>
                        <td> {{@$restaurant->country->name}}</td>
                        <td> <span class="label label-sm <?php echo ($restaurant->status == "active")
                                ? "label-info" : "label-danger"?>" id="label-{{$restaurant->id}}">
                                @php
                                $status = $restaurant->status
                                @endphp
                               
                               {{__('cp.'.$status.'_common')}}
                            </span></td>
                        <td>
                            <div class="btn-group btn-action">
                                <a href="{{url(getLocal().'/admin/store/'.$restaurant->id.'/edit')}}"
                                   class="btn btn-xs blue tooltips" data-container="body" data-placement="top"
                                   data-original-title="{{__('cp.edit_common')}}"><i class="fa fa-edit"></i></a>

                                   <a href="{{url(getLocal().'/admin/stores/'.$restaurant->id.'/edit_password')}}"
                                   class="btn btn-xs blue tooltips" data-container="body" data-placement="top"
                                   data-original-title="{{__('cp.edit_password_common')}}"><i class="fa fa-expeditedssl"></i></a>



                                <a href="#myModal{{$restaurant->id}}" role="button"  data-toggle="modal" class="btn btn-xs red tooltips">
                                    &nbsp;&nbsp;<i class="fa fa-times" aria-hidden="true"></i>
                                </a>

                                <div id="myModal{{$restaurant->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h4 class="modal-title">{{__('cp.delete_common')}}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{__('cp.confirm_common')}} </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn default" data-dismiss="modal" aria-hidden="true">
                                                {{__('cp.cancel_common')}}</button>
                                                <a href="#" onclick="delete_adv('{{$restaurant->id}}','{{$restaurant->id}}',event)"><button class="btn btn-danger">
                                                {{__('cp.delete_common')}}</button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>

                @empty
                    {{__('cp.no_common')}}
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
@endsection
@section('script')
    <script>
        function delete_adv(id, e) {
            e.preventDefault();
            swal({
                title: "{{__('cp.confirm_common')}}",
                text: "{{__('cp.delete_msg_slider')}}",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then((willDelete) => {
                if (willDelete) {
                    var url = '{{url(getLocal()."/admin/stores")}}/' + id;
                    var csrf_token = '{{csrf_token()}}';
                    $.ajax({
                        type: 'DELETE',
                        headers: {'X-CSRF-TOKEN': csrf_token},
                        url: url,
                        success: function (response) {
                            console.log(response);
                            if (response === 'success') {
                                $('#tr-' + id).hide(1000);
                                swal("{{__('cp.delete_done_slider')}}", {icon: "success"});
                            } else {
                                swal('Error', {icon: "error"});
                            }
                        },
                        error: function (e) {
                            swal('exception', {icon: "error"});
                        }
                    });
                }
                else {
                    swal("{{__('cp.delete_cancel_slider')}}");
        }
        });
        }

        function delete_adv(id, iss_id, e) {
            //alert(id);
            e.preventDefault();
            console.log(id);
            console.log(iss_id);
            var url = '{{url(getLocal()."/admin/stores")}}/' + id;
            var csrf_token = '{{csrf_token()}}';
            $.ajax({
                type: 'delete',
                headers: {'X-CSRF-TOKEN': csrf_token},
                url: url,
                data: {_method: 'delete'},
                success: function (response) {
                    console.log(response);
                    if (response === 'success') {
                        $('#tr-' + id).hide(500);
                        $('#myModal' + id).modal('toggle');
                        //swal("القضية حذفت!", {icon: "success"});
                    } else {
                        // swal('Error', {icon: "error"});
                    }
                },
                error: function (e) {
                    // swal('exception', {icon: "error"});
                }
            });

        }


    </script>
@endsection
