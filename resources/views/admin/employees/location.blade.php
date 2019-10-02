@extends('layout.adminLayout')
@section('title') ({{$user->name}}) {{__('cp.location')}}
@endsection
@section('css')

 <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
         position: absolute !important; 
    height:400px !important;
    width: 100% !important;
      }
      /* Optional: Makes the sample page fill the window. */

    </style>


@endsection
@section('content')
     <div class="portlet light bordered">
        <div class="portlet-body">
            <div class="table-toolbar">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="btn-group">
                            
                            <button class="btn sbold blue btn--filter">{{__('cp.filter')}}
                                <i class="fa fa-search"></i>
                            </button>

                            
                        </div>
                    </div>

                </div>
                <div class="box-filter-collapse">
                    <form class="form-horizontal" method="get" action="{{url('admin/employees/'.$user->id.'/locations')}}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">{{__('cp.date')}}</label>
                                    <div class="col-md-9">
                                        <input type="date" class="form-control" name="date"
                                               placeholder="{{__('cp.date')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn sbold blue">{{__('cp.search')}}
                                            <i class="fa fa-search"></i>
                                        </button>
                                        <a href="{{url('admin/employees/'.$user->id.'/locations')}}" type="submit"
                                           class="btn sbold btn-default ">{{__('cp.reset')}}
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                 <div id="map"></div>
                 </div>
            </div>
        </div>
        <!--AIzaSyAdjdB1HwQZU5ZBvmWLFli1h89JP2OPKzA-->

    </div>



@endsection
@section('js')

  <script>
      function initMap() {
        var myLatLng = @if(isset($locations[0])) {lat:  {{$locations[0]->latitude}}, lng: {{$locations[0]->longitude}} }
        @else
        {lat:  24.841500, lng: 46.864385 }
        @endif
        ;

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 8,
          center: myLatLng
        });
        @foreach($locations as $one)

        var marker = new google.maps.Marker({
          position: {lat: {{$one->latitude}}, lng: {{$one->longitude}} },
          map: map,
          title: '{{$one->created_at->toDateString()." ".$one->created_at->format('l ')." ".$one->created_at->toTimeString()}}'
        });
        @endforeach
      }
      
        $("#map").css("position","fixed !important");
    </script>

            <script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{env('APIGoogleKey')}}&callback=initMap">
    </script>
@endsection
