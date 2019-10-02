<?php

namespace App\Http\Controllers\API;

use App\Models\Setting;
use App\Models\EmployeeLocation;
use App\Models\Order;
use App\Models\Car;
use App\Models\Code;
use App\Models\Area;
use App\Models\Rate;
use App\Models\PromotionCode;
use App\Notifications\ResetPassword;
use Carbon\Carbon;
use Illuminate\Support\Facades\Password;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Token;
use App\Models\Notification;
use Illuminate\Support\Facades\Validator;
use Image;
use DB;


class UserController extends Controller
{
    public function image_extensions()
    {
        return array('jpg', 'png', 'jpeg', 'gif', 'bmp');
    }

    public function signUp(Request $request)
    {

        $image = $request->get('image');
        $name = $request->get('name');
        $email = $request->get('email');
        $mobile = $request->get('mobile');
        $password = $request->get('password');
        if (!empty($password)) {
            $password = bcrypt($password);
        }


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|digits_between:8,12|unique:users',
            'password' => 'required|min:6',
            //'image' => 'required',

        ]);
        if ($validator->fails()) {
            return mainResponse(false, '', null, 200, 'items', $validator);

        }

        $newUser = new User();
        $newUser->name = $name;
        $newUser->email = $email;
        $newUser->mobile = $mobile;
        $newUser->password = $password;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_name = str_random(15) . "" . rand(1000000, 9999999) . "" . time() . "_" . rand(1000000, 9999999) . ".jpg";
            Image::make($image)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save("uploads/images/users/$file_name");
            $newUser->image = $file_name;
        }

        $newUser->save();

        if ($newUser) {
                        if ($request->has('fcm_token')) {
                Token::updateOrCreate(['device_type' => $request->get('device_type'),'fcm_token' => $request->get('fcm_token')],['user_id' => $newUser->id]);
            }
                    $checkUser = User::where('mobile', $request->mobile)->first();

            $user = User::findOrFail($newUser->id);
            $user['access_token'] = $newUser->createToken('mobile')->accessToken;
              $code = rand(10000, 99999);
            $code = '1111';
            $bodySMS = __('app.ActivationMsg') . " هو : " . $code;
            // sendSMS($mobile,$bodySMS);
            $conf = new Code();
            $conf->code = $code;
            $conf->user_id = $checkUser->id;
            $conf->save();
          

            $masseg =__('api.ok');
            return mainResponse(true, $masseg, $user, 210, 'items', '');
        }
        $masseg =__('api.whoops');
        return mainResponse(false, $masseg, null, 200, 'items', '');

    }


    public function login(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return mainResponse(false, '', null, 200, 'items', $validator);
        }


        if (Auth::once(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            if ($user->status != 'active') {
                $message = (app()->getLocale() == "ar") ? 'الحساب غير مفعل' : 'The account is not active';
                return mainResponse(true, $message, null, 210, 'items', '');
            }
            else {
                if ($request->has('fcm_token')) {
                Token::updateOrCreate(['device_type' => $request->get('device_type'),'fcm_token' => $request->get('fcm_token')],['user_id' => $user->id]);
            }
                $user['access_token'] = $user->createToken('mobile')->accessToken;
                return mainResponse(true, '', $user, 200, 'items', '');
            }
        } else {
            $EmailData = User::query()->where(['email' => $email])->first();
            if ($EmailData) {
                $message = __('api.wrong_password');
                return mainResponse(false, $message, null, 200, 'items', '');
            } else {
                $message = __('api.wrong_email2');

                return mainResponse(false, $message, null, 200, 'items', '');
            }
        }
    }



    public function editUser(Request $request)
    {
        $user_id = auth('api')->id();
        $user = User::query()->findOrFail($user_id);

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'mobile' => 'required',
        ]);
        $name = ($request->has('name')) ? $request->get('name') : $user->name;
        $mobile = ($request->has('mobile')) ? $request->get('mobile') : $user->mobile;

        $user->name = $name;
        $user->mobile = $mobile;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extention = $image->getClientOriginalExtension();
            $file_name = str_random(15) . "" . rand(1000000, 9999999) . "" . time() . "_" . rand(1000000, 9999999) . "." . $extention;
            Image::make($image)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save("uploads/images/users/$file_name");
            $user->image = $file_name;
        }
        $user->save();

        if ($user) {
            $message = __('api.edit');
            return mainResponse(true, $message, $user, 200, 'items', $validator);
        } else {
            $message = __('api.not_edit');
            return mainResponse(false, $message, '', 200, 'items', $validator);
        }
    }

    public function logout()
    {
        $user_id = auth('api')->id();
        Token::where('user_id', $user_id)->delete();
        if (auth('api')->user()->token()->revoke()) {
            $message = 'logged out successfully';
            return mainResponse(true, $message, '', 200, 'items', '');
        } else {
            $message = 'logged out successfully';
            return mainResponse(true, $message, '', 202, 'items', '');
        }
    }


    public function changePassword(Request $request)
    {
        $rules = [
            'old_password' => 'required|min:6',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return mainResponse(false, '', null, 200, 'items', $validator);
        }
        $user = auth('api')->user();

        if (!Hash::check($request->get('old_password'), $user->password)) {
            $message = __('api.old_password'); //wrong old
            return mainResponse(false, $message, null, 200, 'items', $validator);
        }

        $user->password = bcrypt($request->get('password'));
        if ($user->save()) {
            $user->refresh();
            $message = __('api.ok');
            return mainResponse(true, $message, null, 200, 'items', $validator);
        }
        $message = __('api.whoops');
        return mainResponse(false, $message, null, 200, 'items', $validator);
    }


    public function forgotPassword(Request $request)
    {
        $rules = [
            'mobile' => 'required|min:6',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return mainResponse(false, '', null, 200, 'items', $validator);
        }
        $checkUser = User::where('mobile', $request->mobile)->first();
        if ($checkUser) {
            $code = rand(10000, 99999);
            $code = '1111';
            $bodySMS = __('app.ActivationMsg') . " هو : " . $code;
            // sendSMS($mobile,$bodySMS);
            $conf = new Code();
            $conf->code = $code;
            $conf->user_id = $checkUser->id;
            $conf->save();
            $message = __('api.ok');
            return mainResponse(true, $message, null, 200, 'items', $validator);
        }
        $message = __('api.wrongMobile');
        return mainResponse(false, $message, null, 200, 'items', $validator);
    }

    public function resetPassword(Request $request)
    {
        $rules = [
            'code' => 'required|min:4',
            'mobile' => 'required|min:6',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return mainResponse(false, '', null, 200, 'items', $validator);
        }
        $checkUser = User::where('mobile', $request->mobile)->first();
        if ($checkUser) {
            $checkCode = Code::where(['user_id' => $checkUser->id, 'code' => $request->code, 'used' => 0])->orderBy('id', 'desc')->first();
                if ($checkCode) {
                    Code::where('id', $checkCode->id)->update(array('used' => 1));
    
                    $checkUser->password = bcrypt($request->get('password'));
                    if ($checkUser->save()) {
                        $checkUser->refresh();
                        $message = __('api.ok');
                        return mainResponse(true, $message, null, 200, 'items', $validator);
                    }
                
                } else {
            $message = __('api.wrongCode');
                return mainResponse(false, $message, null, 200, 'items', $validator);
                }
            
        }
        $message = __('api.whoops');
        return mainResponse(false, $message, null, 200, 'items', $validator);
    }
    
    public function checkCode(Request $request)
    {
        $rules = [
            'code' => 'required|min:4',
            'mobile' => 'required|min:6',
           // 'password' => 'required|min:6',
           // 'confirm_password' => 'required|min:6|same:password',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return mainResponse(false, '', null, 200, 'items', $validator);
        }
        $checkUser = User::where('mobile', $request->mobile)->first();
        if ($checkUser) {
            $checkCode = Code::where(['user_id' => $checkUser->id, 'code' => $request->code, 'used' => 0])->orderBy('id', 'desc')->first();
                if ($checkCode) {
                    Code::where('id', $checkCode->id)->update(array('used' => 1));
    
                    $checkUser->password = bcrypt($request->get('password'));
                    if ($checkUser->save()) {
                        $checkUser->refresh();
                        $message = __('api.ok');
                        return mainResponse(true, $message, null, 200, 'items', $validator);
                    }
                
                } else {
            $message = __('api.wrongCode');
                return mainResponse(false, $message, null, 200, 'items', $validator);
                }
            
        }
        $message = __('api.wrongMobile');
        return mainResponse(false, $message, null, 200, 'items', $validator);
    }


    public function get_notifications(Request $request)
    {
        $user_id = Auth::guard('api')->id();
        $data = Notification::where('user_id',$user_id)->orderByDesc('created_at')->get();
        $message = __('api.ok');
        return mainResponse(true, $message, $data, 200, 'items', '');

    }


    public function checkPromo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'promo' => 'required',
            'date' => 'required',
        ]);
        if ($validator->fails()) {
            return mainResponse(false, '', null, 200, 'items', $validator);
        }
         $promo = PromotionCode::where('name',$request->get('promo'))->whereDate('end','>=',$request->get('date'))->whereDate('start','<=',$request->get('date'))->where('status','active')->first();
        if ($promo) {
            $message = __('api.ok');
            return mainResponse(true, $message, $promo, 200, 'items', '');
        } else {
            $message = __('api.wrongPromo');
            return mainResponse(false, $message, [], 200, 'items', '');
        }

    }
    
    
    public function checkPoints(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);
        if ($validator->fails()) {
            return mainResponse(false, '', null, 200, 'items', $validator);
        }

        if(strtotime($request->get('date')) > strtotime('+7 days')) {
            $message = __('api.graterThan7Days');
            return mainResponse(false, $message, [], 220, 'items', '');
        }
 
        
        $point = $request->latitude." ".$request->longitude;
        $check = false;
        $area_id =0;
        $areas = Area::all();
        foreach($areas as $one){
            $polygon =[];
            foreach($one->points as $o){
                $polygon[] = $o->latitude." ".$o->longitude;
            }
           $polygon[] = $one->points[0]['latitude']." ".$one->points[0]['longitude'];
            
            
            
           $check =  pointInPolygon($point, $polygon);
           if($check){
               $area_id = $one->id;
               break;
           }
        }
        if($check && $area_id>0){
           
        $area = Area::findOrFail($area_id);
        $employees = $area->employees->pluck('user_id')->toArray();
        
       // $today = Carbon::today();
           $ordersInDate = Order::where('area_id',$area_id)->whereDate('date', $request->date)->select('*', \DB::raw('count(*) as total'))->groupBy('time')->get();
           
           $data = Setting::orderBy('id','desc')->first();
        $workingTimes =  array();
        $j =0;
        for($i = $data->time_from ;$i<=$data->time_to; $i++){
            
           $workingTimes[$j]['time'] = (string)$i;
           $is_free = 0; // 0 free  ; 1 not free
           foreach($ordersInDate as $one){
             if($one->time == $i){
                 if($one->total == $area->employees->count()){
                     $is_free = 1;
                 }
                 break;
             }
           }
           $workingTimes[$j]['is_free'] = $is_free; 
           $j++;
        }
           

                $message = __('common.ok');
                return mainResponse(true, $message, $workingTimes, 200, 'items', '');
            
        }else{
            $message = __('api.notCoverd');
                return mainResponse(false, $message, [], 210, 'items', '');
        }
    }
 

    public function bookRequest(Request $request)
    {
        $user_id = auth('api')->id();
        $validator = Validator::make($request->all(), [
            'car_id' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);
        if ($validator->fails()) {
            return mainResponse(false, '', null, 200, 'items', $validator);
        }
        
        $promo_id = null;
        $promo = null;
        
        if(strtotime($request->get('date')) > strtotime('+7 days')) {
            $message = __('api.graterThan7Days');
            return mainResponse(false, $message, [], 220, 'items', '');
        }
        
        if($request->has('promotion_code')){
            $promo = PromotionCode::where('name',$request->get('promotion_code'))->whereDate('end','>=',$request->get('date'))->whereDate('start','<=',$request->get('date'))->where('status','active')->first();
        }
        if ($promo){
            $promo_id = $promo->id;
            $discount = $promo->discount;
            $car_price = Car::query()->where('id',$request->get('car_id'))->pluck('price')->first();
            $price = $car_price - ($car_price * $discount/100);
        }
        else{
            $price = Car::query()->where('id',$request->get('car_id'))->pluck('price')->first();
            $promo_id = null;
        }
        
        $point = $request->latitude." ".$request->longitude;
        $check = false;
        $area_id =0;
        $areas = Area::all();
        foreach($areas as $one){
            $polygon =[];
            foreach($one->points as $o){
                $polygon[] = $o->latitude." ".$o->longitude;
            }
           $polygon[] = $one->points[0]['latitude']." ".$one->points[0]['longitude'];
            
            
            
           $check =  pointInPolygon($point, $polygon);
           if($check){
               $area_id = $one->id;
               break;
           }
        }
        if($check && $area_id>0){
           
        $area = Area::findOrFail($area_id);
        $employees = $area->employees->pluck('user_id')->toArray();
        
       // $today = Carbon::today();
           $busyEmployeeIDs = Order::where('area_id',$area_id)->whereDate('date', $request->date)->where('time',$request->time)->pluck('employee_id')->toArray();
           
         $freeEmployee =   array_diff($employees,$busyEmployeeIDs);
         if(empty($freeEmployee)){
            $message = __('api.noFreeEmployee');
            return mainResponse(false, $message, [], 220, 'items', '');
         }
         $employee = $freeEmployee[0];

   $todayEmployeeRequests = Order::whereIn('employee_id',$freeEmployee)->where('area_id',$area_id)->whereDate('date', $request->date)->select('*', \DB::raw('count(*) as total'))->groupBy('employee_id')->orderBy('total','asc')->first();
   if($todayEmployeeRequests){
       $employee = $todayEmployeeRequests->employee_id;
   }

            $newOrder = new Order();
            $newOrder->area_id = $area_id;
            $newOrder->user_id = $user_id;
            $newOrder->employee_id = $employee;
            $newOrder->date = $request->get('date');
            $newOrder->time = $request->get('time');
            $newOrder->car_id = $request->get('car_id');
            $newOrder->price = $price;
            $newOrder->promotion_code_id = $promo_id;
            $newOrder->latitude = 	$request->get('latitude');
            $newOrder->longitude = 	$request->get('longitude');
            $newOrder->save();
    
            if ($newOrder) {
                $message =  __('api.newOrder');
                $order_id = $newOrder->id;
                $tokens_android = [];
                $tokens_ios = Token::where('user_id',$employee)->where('device_type','ios')->pluck('fcm_token')->toArray();
                sendNotificationToUsers( $tokens_android, $tokens_ios,  $order_id, $message );
                $data = Order::query()->where('id',$newOrder->id)->first();
                $message = __('common.book');
                return mainResponse(true, $message, $data, 200, 'items', '');
            } else {
                $message = __('api.whoops');
                return mainResponse(false, $message, [], 200, 'items', '');
            }
        }else{
            $message = __('api.notCoverd');
                return mainResponse(false, $message, [], 210, 'items', '');
        }
    }
    

    public function rate(Request $request)
    {
        $user_id = auth('api')->id();
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
            'rate' => 'required',
        ]);
        if ($validator->fails()) {
            return mainResponse(false, '', null, 200, 'items', $validator);
        }
        
        $order = Order::findOrFail($request->order_id);
        if($order->user_id == $user_id){
            $rate = new Rate();
            $rate->user_id = $user_id;
            $rate->order_id = $order->id;
            $rate->rate = $request->rate;
            if ($request->hasFile('image')) {
                    $image = $request->file('image');
                  
                    $file_name = str_random(15) . "" . rand(1000000, 9999999) . "" . time() . "_" . rand(1000000, 9999999) . ".jpg";
                    Image::make($image)->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save("uploads/images/rates/$file_name");
                   $rate->image = $file_name;
                }
            $rate->save();
            if($rate){
                $message = __('api.ok');
                return mainResponse(true, $message, $rate, 200, 'items', '');
            }
            $message = __('api.whoops');
            return mainResponse(false, $message, [], 200, 'items', '');
        }
        $message = __('api.whoops');
        return mainResponse(false, $message, [], 200, 'items', '');
    }

    public function myBooking(Request $request)
    {
        $user_id = auth('api')->id();
        $data = Order::query()->where('user_id',$user_id);
        if ($request->has('status') && $request->get('status') != null){
            $data = $data->where('status',$request->get('status'));
        }
        $data = $data->get();
        if (count($data)>0) {
            $message = __('api.ok');
            return mainResponse(true, $message, $data, 200, 'items', '');
        }
        else {
            $message = __('api.not_found');
            return mainResponse(false, $message, [], 200, 'items', '');
        }
    }

    public function myScheduleBooking()
    {
        $user_id = auth('api')->id();
        $data = Order::query()->where('user_id',$user_id)->where('date','>',Carbon::now())->get();
        if (count($data)>0) {
            $message = __('api.ok');
            return mainResponse(true, $message, $data, 200, 'items', '');
        }
        else {
            $message = __('api.not_found');
            return mainResponse(false, $message, [], 200, 'items', '');
        }
    }

    public function employeeHome(Request $request)
    {
        $user = Auth::guard('api')->user();
        if ($user->type == 2)
        {
            //where status 0 = new order , 1 => accpt ,, 2 => in_progress ,, 3 => start , 4 => completed
            $data = Order::where('employee_id',$user->id);
            if ($request->has('status') && $request->get('status') != null){
                    $data->where('status',$request->get('status'));
            }

            $data = $data->orderBy('date','asc')->orderBy('time','asc')->with('user')->get();
            if (count($data)>0) {
                $message = __('api.ok');
                return mainResponse(true, $message, $data, 200, 'items', '');
            }
            else {
                $message = __('api.not_found');
                return mainResponse(false, $message, [], 200, 'items', '');
            }
        }
        $message = __('api.whoops');
        return mainResponse(false, $message, [], 200, 'items', '');
    }

    public function acceptOrder($id)
    {
        $user = Auth::guard('api')->user();
        if ($user->type == 2)

        {
            $order = Order::where('id',$id)->where('status',0)->where('employee_id',$user->id)->with('user')->first();
                //    return $order;
            if ($order){
                $order->status=1;
                $order->save();

                $message =  __('api.acceptOrder');
                $order_id = $id;
                $tokens_android = [];
                $tokens_ios = Token::where('user_id',$order->user_id)->where('device_type','ios')->pluck('fcm_token')->toArray();
                sendNotificationToUsers( $tokens_android, $tokens_ios,  $order_id, $message );
                
                $message = __('api.ok');
                return mainResponse(true, $message, $order, 200, 'items', '');
            }else {
                $message = __('api.not_found');
                return mainResponse(false, $message, [], 200, 'items', '');
            }
        }
        $message = __('api.whoops');
        return mainResponse(false, $message, [], 200, 'items', '');
    }

    public function in_progressOrder($id)
    {
        $user = Auth::guard('api')->user();
        if ($user->type == 2)
        {
            $order = Order::query()->where('id',$id)->where('status',1)->where('employee_id',$user->id)->with('user')->first();
            if ($order){
              //  $order->update(['status' => 2]);
                $order->status=2;
                $order->save();

                $message =  __('api.in_progressOrder');
                $order_id = $id;
                $tokens_android = [];
                $tokens_ios = Token::where('user_id',$order->user_id)->where('device_type','ios')->pluck('fcm_token')->toArray();
                sendNotificationToUsers( $tokens_android, $tokens_ios,  $order_id, $message );
                
                $message = __('api.ok');
                return mainResponse(true, $message, $order, 200, 'items', '');
            }else {
                $message = __('api.not_found');
                return mainResponse(false, $message, [], 200, 'items', '');
            }
        }
        $message = __('api.whoops');
        return mainResponse(false, $message, [], 200, 'items', '');
    }

    public function startOrder($id, Request $request)
    {
        $user = Auth::guard('api')->user();

        $validator = Validator::make($request->all(), [
            'image_before' => 'required|image|mimes:jpeg,jpg,png',
        ]);
        if ($validator->fails()) {
            return mainResponse(false, '', null, 200, 'items', $validator);
        }

        if ($user->type == 2)
        {
            $order = Order::query()->where('id',$id)->where('status',2)->where('employee_id',$user->id)->with('user')->first();
            if ($order){
                if ($request->hasFile('image_before')) {
                    $image = $request->file('image_before');
                  
                    $file_name = str_random(15) . "" . rand(1000000, 9999999) . "" . time() . "_" . rand(1000000, 9999999) . ".jpg";
                    Image::make($image)->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save("uploads/images/before/$file_name");
                }
             //  $order->update(['status' => 3 ,'image_before' => $file_name]);
                $order->status=3;
                $order->image_before=$file_name;
                $order->save();
               
               $message =  __('api.startOrder');
                $order_id = $id;
                $tokens_android = [];
                $tokens_ios = Token::where('user_id',$order->user_id)->where('device_type','ios')->pluck('fcm_token')->toArray();
                sendNotificationToUsers( $tokens_android, $tokens_ios,  $order_id, $message );
                $message = __('api.ok');
                return mainResponse(true, $message, $order, 200, 'items', '');
            }else {
                $message = __('api.not_found');
                return mainResponse(false, $message, [], 200, 'items', '');
            }
        }
        $message = __('api.whoops');
        return mainResponse(false, $message, [], 200, 'items', '');
    }

    public function completeOrder($id,Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image_after' => 'required|image|mimes:jpeg,jpg,png',
        ]);
        if ($validator->fails()) {
            return mainResponse(false, '', null, 200, 'items', $validator);
        }
        $user = Auth::guard('api')->user();
        if ($user->type == 2)
        {
            $order = Order::query()->where('id',$id)->where('status',3)->where('employee_id',$user->id)->with('user')->first();
            if ($order){
                if ($request->hasFile('image_after')) {
                    $image = $request->file('image_after');
                    $extention = $image->getClientOriginalExtension();
                    $file_name = str_random(15) . "" . rand(1000000, 9999999) . "" . time() . "_" . rand(1000000, 9999999) . "." . $extention;
                    Image::make($image)->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save("uploads/images/after/$file_name");
                }
              //  $order->update(['status' => 4,'image_after' => $file_name]);
                 $order->status=4;
              $order->image_after=$file_name;

                $order->save();
                $message =  __('api.completeOrder');
                $order_id = $id;
                $tokens_android = [];
                $tokens_ios = Token::where('user_id',$order->user_id)->where('device_type','ios')->pluck('fcm_token')->toArray();
                sendNotificationToUsers( $tokens_android, $tokens_ios,  $order_id, $message,"202" );
                $message = __('api.ok');
                return mainResponse(true, $message, $order, 200, 'items', '');
            }else {
                $message = __('api.not_found');
                return mainResponse(false, $message, [], 200, 'items', '');
            }
        }
        $message = __('api.whoops');
        return mainResponse(false, $message, [], 200, 'items', '');
    }

    public function employeeLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required',
            'longitude' => 'required',
        ]);
        if ($validator->fails()) {
            return mainResponse(false, '', null, 200, 'items', $validator);
        }

        $user = Auth::guard('api')->user();
        if ($user->type == 2) {
            $newLocation = new EmployeeLocation();
            $newLocation->employee_id = $user->id;
            $newLocation->latitude = $request->latitude;
            $newLocation->longitude = $request->longitude;
            $newLocation->save();
            if ($newLocation) {
                $message = __('api.ok');
                return mainResponse(true, $message, $newLocation, 200, 'items', '');
            }
            else {
                $message = __('api.not_found');
                return mainResponse(false, $message, [], 200, 'items', '');
            }
        }
        $message = __('api.whoops');
        return mainResponse(false, $message, [], 200, 'items', '');
    }


    public function changeStatus2 (Request $request)
    {
        dd($request->IDsArray) ;
        if ($request->event == 'delete') {
            User::query()->whereIn('id', $request->IDsArray)->delete();
        } else {
            User::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }

}