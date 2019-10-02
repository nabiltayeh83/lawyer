<?php

namespace App\Http\Controllers\WEB\SubAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;
use Mockery\Exception;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Models\Language;
use App\Models\Order;
use App\Models\Company;
use App\Models\ProductOrder;
use App\Models\Token;

class CartController extends Controller
{
   


    public function image_extensions(){

        return array('jpg','png','jpeg','gif','bmp','pdf');

    }


    public function index(Request $request)
    {
        $owner_id = auth()->guard('subadmin')->id();
        $ides_comany = Company::where('owner_id',$owner_id)->pluck('id')->toArray();
        
        $locales = Language::all();
        $items = Order::whereIn('company_id',$ides_comany)->with('username')->orderBy('orders.created_at', 'desc')->get();
         //return $orders;

        return view('subadmin.orders.home', [
            'items' => $items,
            'locales' => $locales
        ]);
    }

    


    public function edit($id)
    {
        //dd($id);
        $owner_id = auth()->guard('subadmin')->id();
        $ides_comany = Company::where('owner_id',$owner_id)->pluck('id')->toArray();
        
        $orders = Order::whereIn('company_id',$ides_comany)->with('username')->findOrFail($id);
         //return $orders;

        $products = ProductOrder::where('order_id',$id)->with('product')->get();
        //return $products;

        return view('subadmin.orders.edit',['orders'=>$orders,'products'=>$products]);
    }

       public function update(Request $request, $id)
    {
        //dd($request->all());
        $news_rules=array(
           
            'status' =>'required',
        );
        $news_validation=Validator::make($request->all(), $news_rules);

        if($news_validation->fails())
        {
            return redirect()->back()->withErrors($news_validation)->withInput();
        }
        
        if($request->status == 'delivered'){
        $status = 0;
        
        }else{
        
        $status = 1;
        }
        
        //return $status;

        $order= Order::findOrFail($id);
        $order->status= $status;

        $order->save();


        return back()->with('success','Edit SuccessFully');
    
        
        //$token = Token::where('user_id',$request->user_id)->pluck('tokens');
        //$type = Token::where('user_id',$request->user_id)->pluck('type');
        //$token = explode(':', $tokens, 1);
        //return $token;
        //if ($token == '') {
         //   exit();
        //}

        //$items = Order::where('id',$order->id)->with('products')->first();
        //return $items;
        //if (count($items) == 0) {
         //   exit();
       // }
    
        //$message = $order->status;
         //if($order->status ==0)
        //$message2 = "Waitting";
        //elseif($order->status ==2)
         //$message2 = "Acceptable";
         //elseif($order->status ==3)
         // $message2 = "Un Acceptable";
         // elseif($order->status ==4)
         //  $message2 = "Delivered";
        
        
        
        //$order_obj = $items;

        //return $this->fcmPush( $token , $message , $order_obj,$type,$message2);
    

        //return back()->with('success','Edit SuccessFully');
              
    }
    
    


//  function fcmPush($token,$message,$order_obj, $type,$message2)
//
//{
////return $type;
////return json_encode($order_obj);
//
//    try {
//
//
//        $API_ACCESS_KEY = 'AAAAvUMfvqA:APA91bHXK9fkItg7ikFHwaFugWh_FbANDvXVT605g_dfnIl9YcVAJyzBUkRCxUJRRxgkfmlAG-cJQeDqrxoQWVBoIndmy75q7dVfq9J4za-CmGA02FmrRchQTffa2R6nc9evXxix68Bw';
//
//        $headers = [
//            'Authorization: key=' . $API_ACCESS_KEY,
//            'Content-Type: application/json'
//        ];
//        $data= [
//        	"to"=> $token[0],
//        	"data"=>[
//        	'body' => $message,
//	            'order' => $order_obj,
//	            'title' => 'Craftat',
//	            'icon' => 'myicon',//Default Icon
//	            'sound' => 'mySound'//Default sound
//        	]
//        ];
//
//
//
//        $notification= [
//        	"to"=> $token[0],
//        	"notification"=>[
//        	'body' => $message2,
//	            'order' => $order_obj,
//	            'title' => 'Craftat',
//	            'icon' => 'myicon',//Default Icon
//	            'sound' => 'mySound'//Default sound
//        	],
//        	'priority' => 'high',
//        ];
//
//        //return json_encode($notification);
//
//        if($type[0] == 1){
////return 'jhjhjh';
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
//
//
//         }else{
//         //return 'jhjjjjjjjhjjhjhjhjhjhjhj';
//         	$ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notification));
//
//         }
//
//        $result = curl_exec($ch);
//        curl_close($ch);
//        //return json_decode($result, true);
//        return back()->with('success','Edit SuccessFully');
//    } catch (\Exception $ex) {
//        return $ex->getMessage();
//}
//}



    public function destroy($id)
    {
        // return $id;
        $item = Order::query()->findOrFail($id);
        if ($item) {
            Order::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }

    public function changeStatus(Request $request)
    {
        //return $request->all();
        if ($request->event == 'delete') {
            Order::query()->whereIn('id', $request->IDsArray)->delete();
        } else {
            Order::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }
   

}


