@extends('layout.app')

@section('title') {{ucwords(__('cp.title_social'))}}

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

                            <a href="{{url(getLocal().'/admin/social_media/create')}}" style="margin-right: 5px"

                               class="btn sbold green">{{__('cp.add')}}

                                <i class="fa fa-plus"></i>

                            </a>

                            <button class="btn sbold blue btn--filter">{{__('cp.filter')}}

                                <i class="fa fa-search"></i>

                            </button>

                            <button class="btn sbold red event" id="delete">{{__('cp.delete')}}

                                <i class="fa fa-times"></i>

                            </button>

                            <button class="btn sbold green event" id="active">{{__('cp.active')}}

                                <i class="fa fa-check"></i>

                            </button>

                            <button class="btn sbold default event" id="not_active">{{__('cp.not_active')}}

                                <i class="fa fa-minus"></i>

                            </button>

                        </div>

                    </div>



                </div>

                <div class="box-filter-collapse">

                    <form class="form-horizontal" method="get" action="{{url(getLocal().'/admin/social_media')}}">

                        <div class="row">

                            <div class="col-md-4">

                                <div class="form-group row">

                                    <label class="col-md-3 control-label">{{__('cp.title')}}</label>

                                    <div class="col-md-9">

                                        <input type="text" class="form-control" name="title"

                                               placeholder=" ">

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-4">

                                <div class="row">

                                    <div class="col-md-offset-3 col-md-9">

                                        <button type="submit" class="btn sbold blue">{{__('cp.search')}}

                                            <i class="fa fa-search"></i>

                                        </button>

                                        <a href="{{url('admin/social_media')}}" type="submit"

                                           class="btn sbold btn-default ">{{__('cp.reset')}}

                                            <i class="fa fa-refresh"></i>

                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4">

                                <div class="form-group row">

                                    <label class="col-md-3 control-label">{{__('cp.comment')}}</label>

                                    <div class="col-md-9">

                                        <input type="text" class="form-control" name="bio"

                                               placeholder="{{__('cp.comment')}}">

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4">

                                <div class="form-group row">

                                    <label class="col-md-3 control-label"

                                           for="social_category_id">{{__('cp.social_category')}}</label>

                                    <div class="col-md-9">



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

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4">

                                <div class="form-group row">

                                    <label class="col-md-3 control-label" for="status">
                                    {{__('cp.status')}}</label>

                                    <div class="col-md-9">

                                        <select class="form-control select2" name="status" id="status">

                                            <option value="active">{{__('cp.active')}}</option>

                                            <option value="not_active"> {{__('cp.not_active')}}</option>

                                        </select>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

            <input type="hidden" id="url" value="{{url("/en/admin/social_media/changeStatus")}}">

            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="toolsTable">

                <thead>

                <tr>

                    <th></th>

                    <th> {{ucwords(__('cp.title'))}}</th>

                    <th> {{ucwords(('cp.comment'))}}</th>

                    <th> {{ucwords(__('cp.image'))}}</th>

                    <th> {{ucwords(('Social Category'))}}</th>

                    <th> {{ucwords(__('cp.status'))}}</th>

                    <th> {{ucwords(__('cp.created'))}}</th>

                    <th> {{ucwords(__('cp.action'))}}</th>

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

                        <td> {{$item->title}}</td>

                        <td> {{$item->bio}}</td>

                        <td>

                            <img src="{{$item->image}}" width="50px" height="50px">

                        </td>

                        <td>

                            <img src="{{$item->category->image}}" width="50px" height="50px">

                            {{$item->category->title}}

                        </td>

                        <td>

                            <span class="label label-sm <?php echo ($item->status == "Active")

                                ? "label-info" : "label-danger"?>" id="label-{{$item->id}}">

                            {{$item->status}}

                            </span>

                        </td>

                        <td class="center">{{$item->created_at}}</td>

                        <td>

                            <div class="btn-group btn-action">

                                <a href="{{url(getLocal().'/admin/social_media/'.$item->id.'/edit')}}"

                                   class="btn btn-xs blue tooltips" data-container="body" data-placement="top"

                                   data-original-title="{{__('cp.edit_common')}}"><i class="fa fa-edit"></i></a>

                                <a href="#" onclick="delete_adv('{{$item->id}}',event)"

                                   data-placement="top" class="btn btn-xs red tooltips"

                                   data-original-title="{{__('cp.delete_common')}}"><i class="fa fa-times"

                                                                                    aria-hidden="true"></i></a>

                            </div>

                        </td>

                    </tr>



                @empty

                    {{__('cp.no')}}

                @endforelse

                </tbody>

            </table>

            {{$items->links()}}

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

                title: "{{__('cp.confirm_')}}",

                text: "{{__('cp.delete_msg_social')}}",

                icon: "warning",

                buttons: true,

                dangerMode: true

            }).then((willDelete) => {

                if (willDelete) {

                    var url = '{{url(getLocal()."/admin/social_media")}}/' + id;

                    var csrf_token = '{{csrf_token()}}';

                    $.ajax({

                        type: 'DELETE',

                        headers: {'X-CSRF-TOKEN': csrf_token},

                        url: url,

                        success: function (response) {

                            console.log(response);

                            if (response === 'success') {

                                $('#tr-' + id).hide(1000);

                                swal("{{__('cp.delete_done_social')}}", {icon: "success"});

                            } else {

                                swal('Error', {icon: "error"});

                            }

                        },

                        error: function (e) {

                            swal('exception', {icon: "error"});

                        }

                    });

                } else {

                    swal("{{__('cp.delete_cancel_social')}}");

                }

            });

        }

    </script>

@endsection

