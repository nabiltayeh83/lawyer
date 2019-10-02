@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.store_edit_users'))}}
@endsection
@section('css')
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdjdB1HwQZU5ZBvmWLFli1h89JP2OPKzA&sensor=false&libraries=places"></script>
    <style type="text/css">
        .input-controls {
            margin-top: 10px;
            border: 1px solid transparent;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            height: 32px;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        #searchInput {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 50%;
        }

        #searchInput:focus {
            border-color: #4d90fe;
        }

    </style>
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
                              {{__('cp.edit_common')}}  {{__('cp.store_common')}} </span>
                    </div>
                </div>
                <div class="portlet-body form">


                    <form method="post" action="{{url(app()->getLocale().'/admin/store',$item->id)}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form" id="form" >
                        {{ csrf_field() }}
                        {{ method_field('PATCH')}}


                        @foreach($locales as $locale)
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="name">
                                        {{__('cp.name_'.$locale->lang.'_common')}}
                                        <span class="symbol">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input   type="text" class="form-control" name="name_{{$locale->lang}}"  id="name"
                                                 placeholder=" {{__('cp.name_'.$locale->lang.'_common')}}" {{old('name_'.$locale->lang)}}
                                                 value="{{ $item->translate($locale->lang)->name}}" required>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="description">
                                        {{__('cp.description_'.$locale->lang.'_common')}}
                                        <span class="symbol">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <textarea   type="text" class="form-control" name="description_{{$locale->lang}}" id="description"
                                                 placeholder=" {{__('cp.description_'.$locale->lang.'_common')}}" {{old('description_'.$locale->lang)}}
                                                    required>{{ $item->translate($locale->lang)->descriptions}}</textarea>
                                    </div>
                                </div>
                            </fieldset>
                        @endforeach

                        <fieldset>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="mobile">
                                    {{__('cp.mobile_common')}}
                                    <span class="symbol">*</span>
                                </label>
                                <div class="col-md-6">
                                    <input onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" type="text" class="form-control" name="mobile"
                                           placeholder="{{__('cp.mobile_common')}}" value="{{@$item->user->mobile}}" {{old('mobile')}} required>
                                </div>
                            </div>
                        </fieldset>


                        <div class="form-group" id="cityDiv">
                            <label class="control-label col-md-2" for="country">{{__('cp.country_common')}}
                                <span class="required" aria-required="true"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select  class="form-control" aria-required="true" aria-describedby="select-error" aria-invalid="false" id="country" name="country_id" required>
                                    @foreach($country as $one)
                                        <option value="">{{__('cp.select_common')}} </option>
                                        <option value="{{$one->id}}"@if( $one->id == old('country_id',$item->country_id)) selected @endif>{{$one->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <fieldset>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="delivery_cost">
                                    {{__('cp.delivery_cost_join')}}
                                    <span class="symbol">*</span>
                                </label>
                                <div class="col-md-6">
                                    <input onkeyup=" if (/\D/g.test(this.value)) this.value = this.value.replace(/[^0-9.]/g,'')"
                                           type="text"  class="form-control" name="delivery_cost"
                                           placeholder=" {{__('cp.delivery_cost_join')}}"  required
                                           value="{{$item->delivery_cost}}" {{old('delivery_cost')}}>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="work_from">
                                    {{__('cp.opening_time_common')}}
                                    <span class="symbol">*</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="time" class="form-control" name="work_from" id="work_from" {{old('work_from')}} value="{{$item->work_from}}" required>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="work_to">
                                    {{__('cp.closing_time_common')}}
                                    <span class="symbol">*</span>
                                </label>
                                <div class="col-md-6">
                                    <input type="time" class="form-control" name="work_to" id="work_to" {{old('work_to')}} value="{{$item->work_to}}" required/>
                                </div>
                            </div>
                        </fieldset>

                        <div class="form-group" id="mainCategory">
                            <label class="control-label col-md-2">
                                {{__('cp.Main_Category_common')}}
                                <span class="required" aria-required="true">*</span>
                            </label>
                            <div class="col-md-6">
                                <select class="form-control select2" id= "multiple-checkboxes" multiple required
                                        aria-required="true" aria-describedby="select-error" aria-invalid="false" id="mainCategory" name="mainCategory[]">
                                    @foreach($mincategories as $one)
                                        <option value="">{{__('cp.select_common')}} </option>
                                        @foreach($item->category_user as $onecategory)
                                        <option value="{{$one->id}}" @if($one->id == $onecategory->category_id) selected @endif> {{$one->title}}</option>
                                    @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <fieldset>
                            <legend>{{__('cp.logo_common')}}</legend>
                            <div class="form-group {{ $errors->has('logo1') ? ' has-error' : '' }}">
                                <div class="col-md-6 col-md-offset-3">
                                    @if ($errors->has('logo'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('logo1') }}</strong>
                                            </span>
                                    @endif
                                    <div class="fileinput-new thumbnail"
                                         onclick="document.getElementById('edit_logo1').click()"
                                         style="cursor:pointer">
                                        <img src="{{url(@$item->logo)}}"  id="editLogo1">
                                    </div>

                                    <div class="btn red"
                                         onclick="document.getElementById('edit_logo1').click()">
                                        <i class="fa fa-pencil"></i>
                                    </div>
                                    <input type="file" class="form-control" name="logo1"
                                           id="edit_logo1"
                                           style="display:none">
                                </div>
                            </div>
                        </fieldset>


                        <fieldset>
                            <legend>{{__('cp.image_common')}}</legend>
                            <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}">
                                <div class="col-md-6 col-md-offset-3">
                                    @if ($errors->has('image'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('image') }}</strong>
                                            </span>
                                    @endif
                                    <div class="fileinput-new thumbnail"
                                         onclick="document.getElementById('edit_image').click()"
                                         style="cursor:pointer">
                                        <img src="{{ isset($item) && $item->image ? $item->image :  url(admin_assets('/images/ChoosePhoto.png'))}}"  id="editImage">
                                    </div>

                                    <div class="btn red"
                                         onclick="document.getElementById('edit_image').click()">
                                        <i class="fa fa-pencil"></i>
                                    </div>
                                    <input type="file" class="form-control" name="image[]" multiple
                                           id="edit_image" 
                                           style="display:none">
                                </div>
                            </div>
                        </fieldset>




                        @foreach($item->attachments as $attatchment)
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="dashboard-stat2 ">
                                    <li id="material-{{$attatchment->id}}" style="list-style: none; border-style: outset;">
                                        <a href="#myModal{{$attatchment->id}}" role="button"  data-toggle="modal"><button class="btn btn-outline btn-circle red btn-sm black" data-id="{{$attatchment->id}}"  >
                                                <span class="glyphicon glyphicon-trash"></span> 
                                                {{__('cp.delete_common')}}
                                            </button></a>
                                        {{--<a href="#"--}}
                                        {{--onclick="delete_attatchment('{{$attatchment->id}}','{{$item->id}}',event)" class="btn btn-xs red tooltips">--}}
                                        {{--&nbsp;&nbsp;<i class="fa fa-times" aria-hidden="true"></i>--}}
                                        {{--</a>--}}
                                        <a href="{{url($attatchment->image)}}" target="_blank" >
                                            <img src="{{$attatchment->image}}" height="200" class="img-responsive pic-bordered" />
                                        </a>

                                    </li>
                                </div>
                            </div>
                            <div id="myModal{{$attatchment->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
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
                                            <a href="#" class="btn btn-danger" onclick="delete_attatchment('{{$attatchment->id}}','{{$item->id}}',event)">
                                            {{__('cp.submit_common')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach


                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn green">{{__('cp.submit_common')}}</button>
                                    <a href="{{url(getLocal().'/admin/stores')}}" class="btn default">{{__('cp.cancel_common')}}</a>
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

        function delete_attatchment(id,iss_id, e) {
            //alert(id);
            e.preventDefault();
            console.log(id);
            console.log(iss_id);
            var url = '{{url(app()->getLocale()."/admin/delete_attachment/")}}/' + id;
            var csrf_token = '{{csrf_token()}}';
            $.ajax({
                type: 'delete',
                headers: {'X-CSRF-TOKEN': csrf_token},
                url: url,
                data: {_method:'delete'},
                success: function (response) {
                    console.log(response);
                    if (response === 'success') {
                        $('#material-' + id).hide(500);
                        $('#myModal' + id).modal('toggle');
                    } else {
                    }
                },
                error: function (e) {
                }
            });

        }
    </script>

    <script>


        $(document).on('change','#category_id', function(e){
            var id = $(this).val();
            var url = '{{url(getLocal()."/admin/getCategories")}}/'+id;
            var csrf_token = '{{csrf_token()}}';
            $.ajax({
                type: 'GET',
                headers: {'X-CSRF-TOKEN': csrf_token},
                url: url,
                success: function (response) {
                    if (response.status == 'success') {
                        $('#sub_Category').html("");
                        for(var i = 0 ;  response.categories.length >i; i++){
                            $('#sub_Category').append('<option value="'+response.categories[i]['id']+'" >'+response.categories[i]['title']+'</option>');
                        }
                    } else {
                    }
                },
                error: function (e) {
                }
            });
        });


        @if($item->is_student==0)
        $('#jobDiv').removeClass('hidden');
        $('#jobTitle').prop('required',true);

        @else
        $('#typeStudentDiv').removeClass('hidden');
        $('#typeStudent').prop('required',true);
                @endif


        $('#edit_image').on('change', function (e) {
            readURL(this, $('#editImage'));
        });

        $('#edit_logo1').on('change', function (e) {
            readURL(this, $('#editLogo1'));
        });



        $("#typePostion").change(function() {


            //alert($(this).find(':selected').attr('data-id'));

            //  if ($(this).data('options') === undefined) {

            /*Taking an array of all options-2 and kind of embedding it on the select1*/
            if($(this).find(':selected').attr('data-id')==0)
            {
                $(this).data('options', $('#jobTitle option').clone());
            }
            else
            {
                $(this).data('options', $('#typeStudent option').clone());
            }



            //   }
            var id = $(this).val();


            // alert(id);
            var options = $(this).data('options').filter('[data-id=' + id + ']');


            //  alert(options.length);
            //console.log(options.length);

            //  alert(id);

            if(options.length > 0)
            {


                if($(this).find(':selected').attr('data-id')==0)
                {

                    //    alert('other');
                    $('#jobDiv').removeClass('hidden');
                    $('#jobTitle').prop('required',true);

                    $('#typeStudentDiv').addClass('hidden');
                    $('#typeStudent').prop('required',false);
                }
                else
                {
                    //   alert('student');
                    $('#jobDiv').addClass('hidden');
                    $('#jobTitle').prop('required',false);

                    $('#typeStudentDiv').removeClass('hidden');
                    $('#typeStudent').prop('required',true);
                }





                /////////////////


            }
            else
            {
                $('#typeStudentDiv').addClass('hidden');
                $('#typeStudent').prop('required',false);

                //////

                $('#jobDiv').addClass('hidden');
                $('#jobTitle').prop('required',false);
            }

            if($(this).find(':selected').attr('data-id')==0)
            {
                $('#jobTitle').html(options);
            }
            else
            {
                $('#typeStudent').html(options);
            }


        });




    </script>

@endsection
