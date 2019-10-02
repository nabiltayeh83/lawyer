@extends('layout.subAdminLayout')
@section('title') {{ucwords(__('cp.edit_my_company_bunch'))}}
@endsection
@section('css')
<style type="text/css">
.table-toolbar{
    margin-bottom: 40px;
}
</style>
@endsection
@section('content')
    <div class="portlet light bordered">
        <div class="portlet-body">
            <div class="table-toolbar">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="btn-group">
                           <!--  <a href="{{url(getLocal().'/admin/company/create')}}" style="margin-right: 5px"
                               class="btn sbold green">{{__('cp.add_common')}}
                                <i class="fa fa-plus"></i>
                            </a>
                            <button class="btn sbold blue btn--filter">{{__('cp.filter_common')}}
                                <i class="fa fa-search"></i>
                            </button>
                            <button class="btn sbold red event" id="delete">{{__('cp.delete_common')}}
                                <i class="fa fa-times"></i>
                            </button>
                            <button class="btn sbold green event" id="active">{{__('cp.active_common')}}
                                <i class="fa fa-check"></i>
                            </button>
                            <button class="btn sbold default event" id="not_active">{{__('cp.not_active_common')}}
                                <i class="fa fa-minus"></i>
                            </button> -->
                        </div>
                    </div>
                   </div>
                <div class="box-filter-collapse">
                    <form class="form-horizontal" method="get" action="{{url(getLocal().'/subadmin/company')}}">
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
                                        <a href="{{url('subadmin/company')}}" type="submit" class="btn sbold btn-default ">
                                        {{__('cp.reset_common')}}
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">{{__('cp.status_common')}}</label>
                                    <div class="col-md-9">
                                        <select class="form-control select2" name="status">
                                            <option value="active">{{__('cp.active_common')}}</option>
                                            <option value="not_active"> {{__('cp.not_active_common')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <input type="hidden" id="url" value="{{url(app()->getLocale()."/subadmin/company/changeStatus")}}">
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="toolsTable">
                <thead>
                <tr>
                    <th>
                    </th>
                    <th> {{ucwords(__('cp.title_company_bunch'))}}</th>
                    <th> {{ucwords(__('cp.image_common'))}}</th>
                    <th> {{ucwords(__('cp.status_common'))}}</th>
                    <th> {{ucwords(__('cp.created_common'))}}</th>
                    <th> {{ucwords(__('cp.action_common'))}}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($items as $item)
                    <tr class="odd gradeX" id="tr-{{$item->id}}">
                        <td>
                           #
                        </td>

                        <td>
                            @foreach($locales as $locale)
                            {{$item->translate($locale->lang)->name}}
                            @endforeach
                        </td>
                        <td>
                            <img src="{{$item->logo}}" width="50px" height="50px">
                        </td>
                       
                        <td>
                            <span class="label label-sm <?php echo ($item->status == "Active")
                                ? "label-info" : "label-danger"?>" id="label-{{$item->id}}">
                            @php
                                $status = $item->status
                                @endphp
                               
                                {{__('cp.'.$status.'_common')}}
                            </span>
                        </td>
                        <td class="center">{{$item->created_at}}</td>
                        <td>
                            <div class="btn-group btn-action">
                                <a href="{{url(getLocal().'/subadmin/company/'.$item->id.'/edit')}}"
                                   class="btn btn-xs blue tooltips" data-container="body" data-placement="top"
                                   data-original-title="{{__('cp.edit_common')}}"><i class="fa fa-edit"></i></a>



                                   <a href="{{url(getLocal().'/subadmin/products')}}"
                                   class="btn btn-xs blue tooltips" data-container="body" data-placement="top"
                                   data-original-title="{{__('cp.products_common')}} "><i class="fa fa-list-alt"></i></a>


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
                text: "{{__('cp.delete_msg_company')}}",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then((willDelete) => {
                if (willDelete) {
                    var url = '{{url(getLocal()."/subadmin/company")}}/' + id;
                    var csrf_token = '{{csrf_token()}}';
                    $.ajax({
                        type: 'DELETE',
                        headers: {'X-CSRF-TOKEN': csrf_token},
                        url: url,
                        success: function (response) {
                            console.log(response);
                            if (response === 'success') {
                                $('#tr-' + id).hide(1000);
                                swal("{{__('cp.delete_done_company')}}", {icon: "success"});
                            } else {
                                swal('Error', {icon: "error"});
                            }
                        },
                        error: function (e) {
                            swal('exception', {icon: "error"});
                        }
                    });
                } else {
                    swal("{{__('cp.delete_cancel_company')}}");
                }
            });
        }
        
         function delete_adv(id,iss_id, e) {
            //alert(id);
            e.preventDefault();
            console.log(id);
            console.log(iss_id);
            var url = '{{url(getLocal()."/subadmin/company")}}/' + id;
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
