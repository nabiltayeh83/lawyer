@extends('layout.adminLayout')

@section('title', ucwords(__('cp.dashboard')))

@section('css')
@endsection


@section('content')

    <div class="row widget-row">
        <div class="col-md-3">
            <!-- BEGIN WIDGET THUMB -->
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                <h4 class="widget-thumb-heading">{{__('cp.employees')}}</h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-green fa fa-male"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-subtitle"></span>
                        <span class="widget-thumb-body-stat" data-counter="counterup"
                              data-value="{{$count_store}}">{{$count_store}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                <h4 class="widget-thumb-heading">{{__('cp.areas')}}</h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-red fa fa-car"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-subtitle"></span>
                        <span class="widget-thumb-body-stat" data-counter="counterup"
                              data-value="{{$areas}}">{{$areas}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <!-- BEGIN WIDGET THUMB -->
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                <h4 class="widget-thumb-heading">{{__('cp.orders')}}</h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-purple icon-screen-desktop"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-subtitle"></span>
                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="{{$orders}}">{{$orders}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <!-- BEGIN WIDGET THUMB -->
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                <h4 class="widget-thumb-heading">{{__('cp.users')}}</h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-blue fa fa-user"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-subtitle"></span>
                        <span class="widget-thumb-body-stat" data-counter="counterup"
                              data-value="{{$count_users}}">{{$count_users}}</span>
                    </div>
                </div>
            </div>
            <!-- END WIDGET THUMB -->
        </div>
    </div>
@endsection



@section('js')
@endsection


@section('script')
@endsection
