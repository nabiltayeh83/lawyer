<?php
namespace App\Http\Controllers\API;
use App\Models\Car;
use App\User;
use App\Models\Setting;
use App\Models\Page;
use App\Models\Contact;
use App\Models\Area;
use App\Models\AreaRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppController extends Controller
{

    // --
    public function settings()
    {
        $data = Setting::orderBy('id','desc')->first();
        $data->aboutUs = Page::where('id',1)->first();
        $data->privacy = Page::where('id',2)->first();
        $data->terms = Page::where('id',3)->first();

        $message = __('api.ok');
        return mainResponse(true, $message, $data, 200, 'items', '');

    }
    
        public function workTime()
    {
        $data = Setting::orderBy('id','desc')->first();
        $workingTimes =  array();
        for($i = $data->time_from ;$i<=$data->time_to; $i++){
           $workingTimes[] = $i; 
        }

        $message = __('api.ok');
        return mainResponse(true, $message, $workingTimes, 200, 'items', '');

    }

    // ---
    public function contact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'mobile'=>'required|digits_between:8,12',
            'name' => 'required',
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            return mainResponse(false, '' , null, 200, 'items',$validator);
        }


        $contact = new  Contact();
        $contact->email = $request->get('email');
        $contact->name = $request->get('name');
        $contact->mobile = $request->get('mobile');
        $contact->message = $request->get('message');
        $contact->read = 0 ;
        $contact->save();


        $success =__('api.ok');
        return mainResponse(true, $success, $contact, 200, 'items','');

    }

    public function getCars()
    {
        $data = Car::query()->where('status','active')->get();

        if ($data){
            $msg =__('api.ok');
            return mainResponse(true, $msg, $data, 200, 'items','');
        }
        else{
            $msg =__('api.not_found');
            return mainResponse(false, $msg, [], 200, 'items','');
        }

    }


    public function bookAppointment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'block_id' => 'required',
        ]);
        if ($validator->fails()) {
            return mainResponse(false, '' , null, 200, 'items',$validator);
        }

        $test = Area::where('block_id',$request->block_id)->first();
        if($test)
        {
            $msg =__('api.ok');
            return mainResponse(true, $msg, $test, 200, 'items','');
        }
        else{
            $msg =__('api.not_found');
            return mainResponse(false, $msg, [], 200, 'items','');
        }

    }

    public function requestNewArea(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);
        if ($validator->fails()) {
            return mainResponse(false, '' , null, 200, 'items',$validator);
        }

        $test = Area::where('address',$request->address)->first();
        if($test)
        {
            $msg =__('api.already_area');
            return mainResponse(false, $msg, [], 200, 'items','');
        }
        $test2 = AreaRequest::where('address',$request->address)->first();
        if($test2)
        {
            AreaRequest::where('address',$request->address)->update(['counter' => $test2->counter  +1]) ;
        }
        else{
            $newArea = new AreaRequest();
            $newArea->latitude = $request->latitude;
            $newArea->longitude = $request->longitude;
            $newArea->address = $request->address;
            $newArea->save();
        }

            $msg =__('api.ok');
            return mainResponse(true, $msg, $test, 200, 'items','');
    }



    public function search(){
        
    }


    public function slider(){
        
    }



}
