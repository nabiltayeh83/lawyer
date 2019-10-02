@extends('layout.subAdminLayout')
@section('title') {{ucwords(__('cp.dashboard_home'))}}
@endsection
@section('css')
  <link href="{{admin_assets('/global/plugins/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet"
                    type="text/css"/>
<style>
.fc-today-button {
    visibility: hidden;
}   
.fc-month-button{
    visibility: hidden;
}
.fc-agendaWeek-button{
   visibility: hidden; 
}
.fc-agendaDay-button{
    visibility: hidden; 
}
.uppercase {
    color: #678098;
}
.list-separated{
    border-bottom: 4px solid wheat;
}


.fc-toolbar{
    margin-top: 34px;
}
</style>
@if(app()->getLocale() == "en")                    
<style>
.fc-button-group{

    margin-top: 59px;
    margin-right: 265px;
}
.fc-right{
    margin-bottom: -60px;
}
</style>   
@else
<style>
.fc-button-group{
    margin-top: 59px;
    margin-right: 0px;
}
.fc .fc-toolbar>*>* {
    margin-left: 4.75em;}
.fc-left{
    margin-bottom: -60px;
}    
@endif
</style>

@endsection
@section('content')

<div class="row widget-row">
        <div class="col-md-3">
            <!-- BEGIN WIDGET THUMB -->
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                <h4 class="widget-thumb-heading">{{__('cp.companies_bunch')}}</h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-green fa fa-th-large"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-subtitle"></span>
                        <span class="widget-thumb-body-stat" data-counter="counterup"
                              data-value="{{$count_companies}}">{{$count_companies}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                <h4 class="widget-thumb-heading">{{__('cp.products_bunch')}}</h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-red icon-layers"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-subtitle"></span>
                        <span class="widget-thumb-body-stat" data-counter="counterup"
                              data-value="{{$count_product}}">{{$count_product}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <!-- BEGIN WIDGET THUMB -->
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                <h4 class="widget-thumb-heading">{{__('cp.orders_bunch')}}</h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-purple icon-screen-desktop"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-subtitle"></span>
                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="{{$count_orders}}">{{$count_orders}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <!-- BEGIN WIDGET THUMB -->
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
                <h4 class="widget-thumb-heading">{{__('cp.users_users')}}</h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-blue icon-bar-chart"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-subtitle"></span>
                        <span class="widget-thumb-body-stat" data-counter="counterup"
                              data-value="{{$count_users}}">{{$count_users}}</span>
                    </div>
                </div>
            </div>
            <!-- END WIDGET THUMB -->
        </div>
    </div>     <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered calendar">
                <div class="portlet-body">
                    <div class="row">
                        
                        <div class="col-md-12 col-sm-12">
                            <div class="row list-separated profile-stat">
                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                            <div class="uppercase profile-stat-title"> @if($company->package) 
                                            {{$company->package}} @endif </div>
                                            <div class="uppercase profile-stat-text"> 
                                            {{__('cp.subscribe_period_bunch')}} {{__('cp.day_bunch')}} </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                            <div class="uppercase profile-stat-title">@if($orders_count) 
                                            {{$orders_count}} @endif</div>
                                            <div class="uppercase profile-stat-text"> 
                                            {{__('cp.order_count_bunch')}} </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-6">
                                            <div class="uppercase profile-stat-title"> @if($company->package ) 
                                            {{$company->package - $orders_count}} @endif</div>
                                            <div class="uppercase profile-stat-text"> 
                                            {{__('cp.remaining_bunch')}} {{__('cp.day_bunch')}}</div>
                                        </div>
                                    </div>
                            <div id="calendar" class="has-toolbar"> </div>
                        </div>
                        <!--<div class="col-md-3 col-sm-9">-->
                        <!--    <div>-->
                                    
                        <!--                <div class="margin-top-20 profile-desc-link">-->
                        <!--                    <i class="fa fa-globe"></i>-->
                        <!--                    <a href="http://www.keenthemes.com">www.keenthemes.com</a>-->
                        <!--                </div>-->
                        <!--                <div class="margin-top-20 profile-desc-link">-->
                        <!--                    <i class="fa fa-twitter"></i>-->
                        <!--                    <a href="http://www.twitter.com/keenthemes/">@keenthemes</a>-->
                        <!--                </div>-->
                        <!--                <div class="margin-top-20 profile-desc-link">-->
                        <!--                    <i class="fa fa-facebook"></i>-->
                        <!--                    <a href="http://www.facebook.com/keenthemes/">keenthemes</a>-->
                        <!--                </div>-->
                        <!--            </div>-->
                        <!--</div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
                                
                                
                                
@endsection
@section('js')
@endsection

@section('script')

<script>


$(document).ready(function() {
 var url = '{{url(getLocal()."/subadmin/homeordersGet")}}';
            $.ajax({
               type: 'GET',
                //headers: {'X-CSRF-TOKEN': csrf_token},
                url: url,
                //data: {section_id:1},
                //data: {_method:'homeordersGet'},
                success: function (response) {
                    console.log(response);
                    var AppCalendar = function() {

    return {
        //main function to initiate the module
        init: function() {
            this.initCalendar();
        },

        initCalendar: function() {

            if (!jQuery().fullCalendar) {
                return;
            }

            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            var h = {};

            if (App.isRTL()) {
                if ($('#calendar').parents(".portlet").width() <= 720) {
                    $('#calendar').addClass("mobile");
                    h = {
                        right: 'title, prev, next',
                        center: '',
                        left: 'agendaDay, agendaWeek, month, today'
                    };
                } else {
                    $('#calendar').removeClass("mobile");
                    h = {
                        right: 'title',
                        center: '',
                        left: 'agendaDay, agendaWeek, month, today, prev,next'
                    };
                }
            } else {
                if ($('#calendar').parents(".portlet").width() <= 720) {
                    $('#calendar').addClass("mobile");
                    h = {
                        left: 'title, prev, next',
                        center: '',
                        right: 'today,month,agendaWeek,agendaDay'
                    };
                } else {
                    $('#calendar').removeClass("mobile");
                    h = {
                        left: 'title',
                        center: '',
                        right: 'prev,next,today,month,agendaWeek,agendaDay'
                    };
                }
            }

            var initDrag = function(el) {
                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim(el.text()) // use the element's text as the event title
                };
                // store the Event Object in the DOM element so we can get to it later
                el.data('eventObject', eventObject);
                // make the event draggable using jQuery UI
                el.draggable({
                    zIndex: 999,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0 //  original position after the drag
                });
            };

            var addEvent = function(title) {
                title = title.length === 0 ? "Untitled Event" : title;
                var html = $('<div class="external-event label label-default">' + title + '</div>');
                jQuery('#event_box').append(html);
                initDrag(html);
            };

            $('#external-events div.external-event').each(function() {
                initDrag($(this));
            });

            $('#event_add').unbind('click').click(function() {
                var title = $('#event_title').val();
                addEvent(title);
            });

            //predefined events
            $('#event_box').html("");
            addEvent("My Event 1");
            addEvent("My Event 2");
            addEvent("My Event 3");
            addEvent("My Event 4");
            addEvent("My Event 5");
            addEvent("My Event 6");

            $('#calendar').fullCalendar('destroy'); // destroy the calendar
            $('#calendar').fullCalendar({ //re-initialize the calendar
                header: h,
                defaultView: 'month', // change default view with available options from http://arshaw.com/fullcalendar/docs/views/Available_Views/ 
                slotMinutes: 15,
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar !!!
                drop: function(date, allDay) { // this function is called when something is dropped

                    // retrieve the dropped element's stored Event Object
                    var originalEventObject = $(this).data('eventObject');
                    // we need to copy it, so that multiple events don't have a reference to the same object
                    var copiedEventObject = $.extend({}, originalEventObject);

                    // assign it the date that was reported
                    copiedEventObject.start = date;
                    copiedEventObject.allDay = allDay;
                    copiedEventObject.className = $(this).attr("data-class");

                    // render the event on the calendar
                    // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                    $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                    // is the "remove after drop" checkbox checked?
                    if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }
                },
                
                  //events:'http://bunch.linekw.com/bunch/public/load.php',
                  events:response,
               
            });

        }

    };

}();

jQuery(document).ready(function() {    
   AppCalendar.init(); 
});
                    
                },
                error: function (e) {
                    // swal('exception', {icon: "error"});
                }
            });
 });

    
</script>
    
            
@endsection
