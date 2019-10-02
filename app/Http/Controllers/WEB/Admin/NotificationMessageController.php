<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Mockery\Exception;
use Illuminate\Support\Facades\Validator;
use App\Notifications\NewPostNotification;

use App\User;
use App\Models\Notification;
use App\Models\Token;


class NotificationMessageController extends Controller
{


    public function index(Request $request)
    {
        $items = Notification::query()->latest()->get();
        return view('admin.notifications.home', compact('items'));
    }


    public function create()
    {
        $notifications = Notification::all();
        return view('admin.notifications.create', compact('notifications'));
    }


    public function store(Request $request)
    {
        $item = Notification::create($request->all());
        $message = $request->message ;
	        $this->fcmPush($message);
        return redirect()->back()->with('status', __('cp.create'));
    }


    public function destroy($id)
    {
        $notifications = Notification::query()->findOrFail($id);
        if ($notifications->delete()) {
            return 'success';
        }
        return 'fail';
    }


    

  function fcmPush($message)

{ 
//return $type[0];
    
    try {
        $headers = [
            'Authorization: key=AAAAVPf6FBc:APA91bFaClusfFlNlqjkEG1-8KeNwAxXLgVgnE5H1H1oOB78Cuta72I0sgIuQz9bZ4JojGWSEHZllG1Ki79srjU9EqkflMvFY55f0_Wxty0gKlOecqlNAYdZZNzDdf92_JANMVmnKPhr',
            'Content-Type: application/json'
        ];
        $notification= [
            "to"=> '/topics/ezham',
            "notification"=>[
            'body' => $message,
                'type' => "notify",
                'title' => 'Ezham',
                'icon' => 'myicon',//Default Icon
                'sound' => 'mySound'//Default sound
            ]
        ];
        //return $notification;
       // return json_encode($data);
       
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notification));
        
        
        
        $result = curl_exec($ch);
        curl_close($ch);
        //return json_decode($result, true);
      //  return back()->with('success','Edit SuccessFully');
    } catch (\Exception $ex) {
     //   return $ex->getMessage();
}
}

   

}
