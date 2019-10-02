@extends('layout.subAdminLayout')
@section('title') {{__('cp.edit_common')}}{{__('cp.order_order')}}
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
                              {{__('cp.edit_common')}}{{__('cp.order_order')}}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form method="post" action="{{route('subadmin.orders.update',$orders->id)}}"
                          enctype="multipart/form-data" class="form-horizontal" role="form">
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{$orders->user_id}}">
                        <input type="hidden" id="order_id" name="order_id" value="{{$orders->id}}">
                        <div class="form-body">


                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('cp.name_common')}}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="name" @if($orders->user) value="{{$orders->user->name}} " @endif id="order"
                                               placeholder=" {{__('cp.name_common')}}" {{ old('name') }} disabled>
                                    </div>
                                </div>
                            </fieldset>




                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('cp.email_common')}}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="name" @if($orders->email) value="{{$orders->user->email}} " @endif id="order"
                                               placeholder=" {{__('cp.email_common')}}" {{ old('email') }} disabled>
                                    </div>
                                </div>
                            </fieldset>



                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('cp.total_bunch')}}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="name" @if($orders->price) value="{{$orders->price}} " @endif id="order"
                                               placeholder=" {{__('cp.price_common')}}" {{ old('email') }} disabled>
                                    </div>
                                </div>
                            </fieldset>


                            <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="order">
                                        {{__('cp.delivery_time_bunch')}}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="name" value="{{$orders->delivery_date}}"
                                               placeholder=" {{__('cp.delivery_time_common')}}"  disabled>
                                    </div>
                                </div>
                            </fieldset>


                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="category_id">
                                    {{__('cp.status_common')}}
                                    <span class="symbol">*</span>
                                </label>
                                <div class="col-md-6">
                                    <select id="status_id" class="form-control select2" name="status"
                                            required>

                                        <option value="0" @if($orders->status == 'Pending' ) selected @endif>
                                            {{__("cp.Pending_common")}}
                                        </option>
                                        <option value="1" @if($orders->status == 'Confirm' ) selected @endif>
                                            {{__("cp.Confirm_common")}}
                                        </option>
                                    </select>
                                </div>
                            </div>







                            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="toolsTable">
                                <thead>
                                <tr>
                                    <th> {{ucwords(__('cp.title_company_bunch'))}}</th>
                                    <th> {{ucwords(__('cp.name_product_bunch'))}}</th>
                                    <th> {{ucwords(__('cp.image_bunch'))}}</th>

                                    <th> {{ucwords(__('cp.quentity_bunch'))}}</th>
                                    <th> {{ucwords(__('cp.price_bunch'))}}</th>
                                    <th> {{ucwords(__('cp.subtotal_bunch'))}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($products)
                                    @forelse($orders->products as $product)
                                        <tr class="odd gradeX" id="tr-{{$product->id}}">

                                            <td>
                                                @if($product->name_company or $product->name_company != '') {{$product->name_company}} @endif

                                            </td>

                                            <td>
                                                @if($product->name_product or $product->name_product != '') {{$product->name_product}} @endif

                                            </td>
                                            <td>
                                                <img src="{{$product->logo}}" width="50px" height="50px">
                                            </td>



                                            <td>{{$product->quantity}}</td>
                                            <td>{{$product->price}}</td>
                                            <td>{{$product->final_price}}</td>


                                        </tr>

                                    @empty
                                        {{__('cp.no_common')}}
                                    @endforelse
                                @endif
                                </tbody>
                            </table>








                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" id="edit" class="btn green">
                                        {{__('cp.submit_common')}}</button>
                                        <a href="{{url(getLocal().'/admin/orders')}}" class="btn default">
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
