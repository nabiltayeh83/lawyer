@extends('layout.subAdminLayout')
@section('title') {{ucwords(__('cp.my_profile_bunch'))}}
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

                            <button class="btn sbold blue btn--filter">{{__('cp.filter_common')}}
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="box-filter-collapse">
                    <form class="form-horizontal" method="get" action="{{url(getLocal().'/subadmin/owner_user')}}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">{{__('cp.email_common')}}</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="email"
                                               placeholder="{{__('cp.email_common')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn sbold blue">{{__('cp.search_common')}}
                                            <i class="fa fa-search"></i>
                                        </button>
                                        <a href="{{url('subadmin/owner_user')}}" type="submit"
                                           class="btn sbold btn-default ">{{__('cp.reset_common')}}
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">{{__('cp.mobile_common')}}</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="mobile"
                                               placeholder="{{__('cp.mobile_common')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <input type="hidden" id="url" value="">
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="toolsTable">
                <thead>
                <tr>
                    <th>
                        {{--<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">--}}
                        {{--<input type="checkbox" class="group-checkable chkBox" data-set="#sample_1 .checkboxes"/>--}}
                        {{--<span></span>--}}
                        {{--</label>--}}
                    </th>
                    <th> {{ucwords(__('cp.full_name_common'))}}</th>
                    <th> {{ucwords(__('cp.email_common'))}}</th>
                    <th> {{ucwords(__('cp.image_common'))}}</th>
                    <th> {{ucwords(__('cp.mobile_common'))}}</th>
                    <th> {{ucwords(__('cp.action_common'))}}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($items as $item)
                    <tr class="odd gradeX" id="tr-{{$item->id}}">
                        <td>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes chkBox" value="{{$item->id}}" name="chkBox"/>
                                <span></span>
                            </label>
                        </td>
                        <td> {{$item->name}}</td>
                        <td><a href="mailto:{{$item->email}}">{{$item->email}}</a></td>
                        <td>
                            <img src="{{$item->image}}" width="50px" height="50px">
                        </td>
                        <td> {{$item->mobile}}</td>
                        <td>
                            <div class="btn-group btn-action">
                                <a href="{{url(getLocal().'/subadmin/owner_user/'.$item->id.'/edit')}}"
                                   class="btn btn-xs blue tooltips" data-container="body" data-placement="top"
                                   data-original-title="{{__('cp.edit_common')}}"><i class="fa fa-edit"></i></a>
                                <a href="{{url(getLocal().'/subadmin/owner_user/'.$item->id.'/edit_password')}}"
                                   class="btn btn-xs blue tooltips" data-container="body" data-placement="top"
                                   data-original-title="{{__('cp.edit_password_common')}}"><i class="fa fa-user font-red"></i></a>
                                <a href="#" onclick="delete_adv('{{$item->id}}',event)"
                                   data-placement="top" class="btn btn-xs red tooltips"
                                   data-original-title="{{__('cp.delete_common')}}"><i class="fa fa-times"
                                                                                    aria-hidden="true"></i></a>
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
                text: "{{__('cp.delete_msg_users')}}",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then((willDelete) => {
                if (willDelete) {
                    var url = '{{url(getLocal()."/subadmin/users")}}/' + id;
                    var csrf_token = '{{csrf_token()}}';
                    $.ajax({
                        type: 'DELETE',
                        headers: {'X-CSRF-TOKEN': csrf_token},
                        url: url,
                        success: function (response) {
                            console.log(response);
                            if (response === 'success') {
                                $('#tr-' + id).hide(1000);
                                swal("{{__('cp.delete_done_users')}}", {icon: "success"});
                            } else {
                                swal('Error', {icon: "error"});
                            }
                        },
                        error: function (e) {
                            swal('exception', {icon: "error"});
                        }
                    });
                } else {
                    swal("{{__('cp.delete_cancel_users')}}");
                }
            });
        }
    </script>
@endsection
