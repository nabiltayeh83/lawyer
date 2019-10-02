<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Admin;
use App\User;
use App\Models\Permission;
use App\Models\Setting;
use App\Models\Area;
use App\Models\AreaRequest;
use App\Models\Car;
use App\Models\PromotionCode;
use App\Models\Order;


use App\Models\Contact;
use App\Models\Booking;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class HomeController extends Controller
{
    
   
    public function index()
    {
        $admin=Admin::findOrFail(auth()->guard('admin')->user()->id);    
        return view('admin.home.dashboard');
    }


    public function changeStatus($model,Request $request)
    {
        $role = "";
        if($model == "admins") $role = 'App\Admin';
        if($model == "areas") $role = 'App\Models\Area';
        if($model == "areaRequests") $role = 'App\Models\AreaRequest';
        if($model == "employees") $role = 'App\User';
        if($model == "users") $role = 'App\User';
        if($model == "role") $role = 'App\Models\Permission';
        if($model == "cars") $role = 'App\Models\Car';
        if($model == "promotions") $role = 'App\Models\PromotionCode';
        if($model == "orders") $role = 'App\Models\Order';
        if($model == "categories") $role = 'App\Models\Category';
        if($model == "countries") $role = 'App\Models\Country';

        if($role !=""){
             if ($request->action == 'delete') {
                $role::query()->whereIn('id', $request->IDsArray)->delete();
            }
            else {
                if($request->action) {
                    $role::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->action]);
                }
            }
            return $request->action;
        }
        return false;
        
  
    }
     
 

 
}
