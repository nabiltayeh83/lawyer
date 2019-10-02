<?php

namespace App\Http\Controllers\WEB\SubAdmin;

use App\Models\Category;
use App\Models\categoryCompanies;
use App\Models\RequestService;
use App\Models\ServiceOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use App\Models\Product;
use App\Models\Catsize;
use App\Models\Features_size;
use App\Models\Features_color;
use App\Models\ProductTranslation;
use App\Models\Attatchments;
use App\User;
use App\Models\Company;
use App\Models\Language;

use App\Models\Setting;
use App\Models\Token;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequestServiceController extends Controller
{
    public function index(Request $request)
    {


        $owner_id = auth()->guard('subadmin')->id();
        //return $owner_id;
       // $compn = Company::query()->where('owner_id',$owner_id);
        $locales = Language::all();


        $company = Company::where('owner_id', $owner_id)->first();
        $items = ServiceOrder::where('company_id',$company->id)->with('requestService');
        $categories = Category::where('id', '>', 0)->get();


        if ($request->has('status') && $request->get('status') != 'no') {
            if ($request->get('status') != null && $request->get('status') != 'no') {
                $items->where('status', $request->get('status'));
            }

        }


        if ($request->has('store') && $request->get('status') != 'no') {
            if ($request->get('store') != null && $request->get('store') != 0) {
                $items->where('company_id', $request->get('store'));
            }

        }


        if ($request->has('categories') && $request->get('categories') != 'no') {
            if ($request->get('categories') != null && $request->get('categories')) {

                $companyArray = categoryCompanies::where('category_id', $request->get('categories'))->pluck('company_id');



                    if ($companyArray)
                    {
                        $items->whereHas('requestService', function ($query) use ($companyArray) {
                            $query
                                ->whereIn('company_id', $companyArray);
                        });

                    }





                // $prodcut_pro=ProductProperty::where('category_id',$request->get('categories'))->pluck('product_id');
                // $prodcut_order=ProductOrder::whereIn('product_id',$prodcut_pro)->pluck('order_id');
                //  $items->whereIn('id', $prodcut_order);
            }

        }

        if ($request->get('from_date') && $request->get('to_date')) {
            $items->whereDate('updated_at', '>=', Carbon::parse($request->get('from_date')));
            $items->whereDate('updated_at', '<=', Carbon::parse($request->get('to_date')));
        }

        $items = $items->orderBy('created_at', 'desc')->get();


        // return $items;

//dd($items->products()->first()->product->first()->store->name);

        return view('subadmin.requestService.home', compact('items', 'locales', 'company', 'categories'));
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        $news_rules = array(

            'status' => 'required',

        );

        if ($request->status > 1) {
            $news_rules = array(
                'driver' => 'required',
            );
        }
        $news_validation = Validator::make($request->all(), $news_rules);

        if ($news_validation->fails()) {
            return redirect()->back()->withErrors($news_validation)->withInput();
        }


        //return $status;

        $order = ServiceOrder::findOrFail($id);
        $order->status = $request->status;
        // $order->driver= $request->driver;
        $order->save();


        $items = ServiceOrder::where('id', $order->id)->with('requestService')->first();


        $user = User::findOrFail($items->user_id);
        //return $items;
        /*  if (count($items) == 0) {
              exit();
          }

          $message = $order->status;
          if($order->status ==0)
              $message2 = "Pending";
          elseif($order->status ==1)
              $message2 = "Confirm";




          $order_obj = $items->id;
          $push_data='';

          if($order->status ==1)
          {
              $push_data = [
                  'title' => $items->name,
                  'body' => __('common.your order has accepted'),
                  'id' => $items->id,
                  'type' => 'rate',
              ];
          }

          else
          {
              $push_data = [
                  'title' => 'done',
                  'body' => __('common.your order has not accepted'),
                  'id' => 0,
                  'type' => 'rate',
              ];
          }


          $note=NotificationMessage::create([
              'user_id'=>$user->id,
              'message'=>$items->name
          ]);





          $note=NotificationMessage::create([
              'customer_id'=>$user->id,
              'message'=>__('common.your order has not accepted')
          ]);

          send_push($user->fcm_token, $push_data,$user->device_type);

          //  $token='es0ZqOPL_3w:APA91bF_uZ2B5pNrdR26_A867vm-wMTlD5cuoF9iozHoVsiKVN66Tz2UNFxrXv1W89gisMXIslja4XNAjdPcj0GxKXUW7tTLlwqFbTM0JWGob9wTrhj2m08W3dg9MPeYv1YrC_Ph3Ccs';
          send_push($user->fcm_token, $push_data,$user->device_type);



          $order_obj = $items->id;


  */

        return redirect()->back()->with('status', __('common.update'));

        //  return back()->with('success','Edit SuccessFully');

    }

    public function edit($id)
    {


        $serviceOrder = ServiceOrder::with(['requestService', 'requestServiceDetails'])->findOrFail($id);

//dd($serviceOrder);
        return view('subadmin.requestService.edit', ['orders' => $serviceOrder]);
    }


    public function destroy($id)
    {
        // return $id;
        $item = ServiceOrder::query()->findOrFail($id);
        if ($item) {
            ServiceOrder::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }

    public function changeStatus(Request $request)
    {
        //return $request->all();
        if ($request->event == 'delete') {
            ServiceOrder::query()->whereIn('id', $request->IDsArray)->delete();
        } else {
            $x = 0;
            if ($request->event == 'active') {
                $x = 1;
            } else {
                $x = 0;
                // not_active
            }
            ServiceOrder::query()->whereIn('id', $request->IDsArray)->update(['status' => $x]);
        }
        return $request->event;
    }
}