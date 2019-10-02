@extends('layout.adminLayout')
@section('title') {{__('cp.categories')}}
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
                            <a href="{{url(getLocal().'/admin/categories/create')}}" style="margin-right: 5px"
                               class="btn sbold green">{{__('cp.add')}}
                                <i class="fa fa-plus"></i>
                            </a>

                            <button class="btn sbold red event" data-action="delete" href="#deleteAll" role="button"  data-toggle="modal">
                            {{__('cp.delete')}}
                                <i class="fa fa-times"></i>
                            </button>


                                    <button class="btn sbold green event"  data-action="active" href="#activation" role="button"  data-toggle="modal">
                            {{__('cp.active')}}
                                <i class="fa fa-check"></i>
                            </button>
                            <button class="btn sbold default event"  href="#cancel_activation" role="button"  data-toggle="modal" data-action="not_active">
                            {{__('cp.not_active')}}
                                <i class="fa fa-minus"></i>
                            </button>

                        </div>
                    </div>

                </div>
                <div class="box-filter-collapse">
                    <form class="form-horizontal" method="get" action="{{url(getLocal().'/admin/categories')}}">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn sbold blue">{{__('cp.search')}}
                                            <i class="fa fa-search"></i>
                                        </button>
                                        <a href="{{url('admin/jobTitle')}}" type="submit" class="btn sbold btn-default ">
                                        {{__('cp.reset')}}
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
            <input type="hidden" id="url" value="{{url(app()->getLocale()."/admin/changeStatus/roles")}}">
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="toolsTable">
                <thead>
                <tr>
                    <th>
                        {{--<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">--}}
                        {{--<input type="checkbox" class="group-checkable chkBox" data-set="#sample_1 .checkboxes"/>--}}
                        {{--<span></span>--}}
                        {{--</label>--}}
                    </th>
                    <th> {{ucwords(__('cp.title'))}}</th>
                    <th>
                     {{ucwords(__('cp.status'))}}</th>



                    <th> {{ucwords(__('cp.created'))}}</th>
                    <th> {{ucwords(__('cp.actions'))}}</th>
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
                        <td> {{$item->name}}  </td>

                        <td>
                        <span class="label label-sm <?php echo ($item->status == "active")
                                ? "label-info" : "label-danger"?>" id="label-{{$item->id}}"> 
                                {{__('cp.' .$item->status)}}  
                                </span></td>

                        <td class="center">{{$item->created_at}}
                        
                        </td>
                        <td>
                            <div class="btn-group btn-action">
                                <a href="{{url(getLocal().'/admin/categories/'.$item->id.'/edit')}}"
                                   class="btn btn-xs blue tooltips" data-container="body" data-placement="top"
                                   data-original-title="{{__('cp.edit')}}"><i class="fa fa-edit"></i></a>


                               <a href="#myModal{{$item->id}}" role="button"  data-toggle="modal" class="btn btn-xs red tooltips">
                                &nbsp;&nbsp;<i class="fa fa-times" aria-hidden="true"></i>
                                </a>

                            </div>
                        </td>
                    </tr>
<div id="myModal{{$item->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">{{__('cp.delete')}}</h4> 
            </div>
            <div class="modal-body">
                <p>{{__('cp.confirm')}} </p> 
            </div>
            <div class="modal-footer">
                <button class="btn default" data-dismiss="modal" aria-hidden="true">{{__('cp.cancel')}}</button>
                <a href="#" onclick="delete_adv('{{$item->id}}','{{$item->id}}',event)"><button class="btn btn-danger">
                {{__('cp.delete')}}</button></a>
            </div>
        </div>
    </div>
</div>
                @empty
                    {{__('cp.no')}}
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
            var url = '{{url(getLocal()."/admin/categories")}}/' + id;
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
