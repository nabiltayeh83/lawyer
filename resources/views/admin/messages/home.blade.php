@extends('layout.adminLayout')

@section('title') {{ucwords(__('cp.messages_managments_bunch'))}}

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

                            <button class="btn sbold red event" id="delete">{{__('cp.delete_common')}}

                                <i class="fa fa-times"></i>

                            </button>



                        </div>

                    </div>

                   </div>

                <div class="box-filter-collapse">

                    <form class="form-horizontal" method="get" action="{{url(getLocal().'/admin/messages')}}">

                        <div class="row">

                            <div class="col-md-4">

                                <div class="form-group row">

                                    <label class="col-md-3 control-label">{{__('cp.title_common')}}</label>

                                    <div class="col-md-9">

                                        <input type="text" class="form-control" name="title"

                                               placeholder="">

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="row">

                                    <div class="col-md-offset-3 col-md-9">

                                        <button type="submit" class="btn sbold blue">{{__('cp.search_common')}}

                                            <i class="fa fa-search"></i>

                                        </button>

                                        <a href="{{url('admin/company')}}" type="submit" class="btn sbold btn-default ">
                                        {{__('cp.reset_common')}}

                                            <i class="fa fa-refresh"></i>

                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

            <input type="hidden" id="url" value="{{url(app()->getLocale()."/admin/messages/changeStatus")}}">

            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="toolsTable">

                <thead>

                <tr>

                    <th>

                    </th>

                    <th> {{ucwords(__('cp.username_bunch'))}}</th>

                    <th> {{ucwords(__('cp.title_company_bunch'))}}</th>

                    <th> {{ucwords(__('cp.created_common'))}}</th>

                    <th> {{ucwords(__('cp.action_common'))}}</th>

                </tr>

                </thead>

                <tbody>

                @forelse($items as $item)

                @if($item->user && $item->company)

                    <tr class="odd gradeX" id="tr-{{$item->id}}">

                        <td>

                           <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">

                                <input type="checkbox" class="checkboxes chkBox" value="{{$item->id}}" name="chkBox"/>

                                <span></span>

                            </label>

                        </td>



                         <td>

                            @if($item->user)

                            {{$item->user->name}}

                            @endif

                        </td>



                        <td>

                            @if($item->company)

                            {{$item->company->name}}

                            @endif

                        </td>







                        <td class="center">{{$item->created_at}}</td>

                        <td>

                            <div class="btn-group btn-action">

                                <a href="{{url(getLocal().'/admin/messages/'.$item->id.'/edit')}}"

                                   class="btn btn-xs blue tooltips" data-container="body" data-placement="top"

                                   data-original-title="{{__('cp.edit_common')}}"><i class="fa fa-edit"></i></a>

                                 <a href="#myModal{{$item->id}}" role="button"  data-toggle="modal" class="btn btn-xs red tooltips">

                                                    &nbsp;&nbsp;<i class="fa fa-times" aria-hidden="true"></i>

                                                </a>



                                                                                     <div id="myModal{{$item->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">

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

                                                    <a href="#" onclick="delete_adv('{{$item->id}}','{{$item->id}}',event)"><button class="btn btn-danger">
                                                    {{__('cp.delete_common')}}</button></a>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                            </div>

                        </td>

                    </tr>

                @endif

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





         function delete_adv(id,iss_id, e) {

            //alert(id);

            e.preventDefault();

            console.log(id);

            console.log(iss_id);

            var url = '{{url(getLocal()."/admin/messages")}}/' + id;

            var csrf_token = '{{csrf_token()}}';

            $.ajax({

                type: 'delete',

                headers: {'X-CSRF-TOKEN': csrf_token},

                url: url,

                data: {_method:'delete'},

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

