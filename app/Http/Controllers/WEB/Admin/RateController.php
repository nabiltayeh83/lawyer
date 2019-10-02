<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\Models\Language;
use App\Models\Order;
use App\Models\Rate;
use App\Models\Token;

class RateController extends Controller
{


    public function image_extensions()
    {

        return array('jpg', 'png', 'jpeg', 'gif', 'bmp', 'pdf');

    }

    public function index(Request $request)
    {
        $locales = Language::all();
        $items = Rate::query()->orderBy('created_at', 'desc')->get();
        return view('admin.rate.home', compact('items', 'locales'));
    }




    public function edit($id)
    {
        $order = Rate::findOrFail($id);
        $employees = User::where('type',2)->where('id','<>',$order->employee_id)->get();
        
        return view('admin.order.edit', ['order' => $order,'employees'=>$employees]);
    }



    public function update(Request $request, $id)
    {

        $order = Order::findOrFail($id);
        $order->employee_id = $request->employee_id;
        $order->save();
        
        $message =  __('api.newOrder');
                $order_id = $id;
                $tokens_android = [];
                $tokens_ios = Token::where('user_id',$request->employee_id)->where('device_type','ios')->pluck('fcm_token')->toArray();
                sendNotificationToUsers( $tokens_android, $tokens_ios,  $order_id, $message );
        return redirect()->back()->with('status', __('common.update'));
    }





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




}


