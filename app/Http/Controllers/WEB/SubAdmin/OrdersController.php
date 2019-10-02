<?php

namespace App\Http\Controllers\WEB\SubAdmin;

use App\Models\Category;
use App\Models\categoryCompanies;
use App\Models\Company;
use App\Models\Delivery;
use App\Models\Language;
use App\Models\NotificationMessage;
use App\Models\Order;
use App\Models\OrdersTransactions;
use App\Models\OrdersUsers;
use App\Models\Park;
use App\Models\OfferTranslation;
use App\Models\Offers;
use App\Models\ProductOrder;
use App\Models\Setting;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Cookie;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->locales = Language::all();
        $this->settings = Setting::query()->first();
        view()->share([
            'locales' => $this->locales,
            'settings' => $this->settings,

        ]);
    }

    public function index(Request $request)
    {




        $locales = Language::all();

        $owner_id = auth()->guard('subadmin')->id();

        //return $owner_id;
        $company = Company::query()->where('owner_id',$owner_id)->first();


        $items = Order::where('company_id',$company->id)->with('user', 'company', 'products');

        $categories = Category::where('id', '>', 0)->get();
        $deliveryCompany=Delivery::where('id','>',0)->get();

        if ($request->has('status') && $request->get('status') != 'no') {
            if ($request->get('status') != null ) {
                $items->where('status', $request->get('status'));
            }

        }


        if ($request->has('store') && $request->get('store') != 'no') {
            if ($request->get('store') != null ) {
                $items->where('company_id', $request->get('store'));
            }

        }


        if ($request->has('deliveries') && $request->get('deliveries') != 'no') {
            if ($request->get('deliveries') != null ) {
                $items->where('delivery_company_id', $request->get('deliveries'));
            }

        }


        if ($request->has('categories') && $request->get('categories') != 'no') {
            if ($request->get('categories') != null ) {
                $companyArray = categoryCompanies::where('category_id', $request->get('categories'))->pluck('company_id');



                if ($companyArray)
                {
                    $items->whereHas('products', function ($query) use ($companyArray) {
                        $query
                            ->whereIn('company_id', $companyArray);
                    });

                }
            }

        }

        if ($request->get('from_date') && $request->get('to_date')) {
            $items->whereDate('updated_at', '>=', Carbon::parse($request->get('from_date')));
            $items->whereDate('updated_at', '<=', Carbon::parse($request->get('to_date')));
        }

        $items = $items->orderBy('created_at', 'desc')->get();

        //return $items;
        return view('subadmin.orders.home', compact('items', 'locales', 'company', 'categories','deliveryCompany'));


//        $owner_park = auth('subadmin')->id();
//        $park_id = Park::where('admin_id',$owner_park)->pluck('id')->first();
//       // return $park_id;
//        Park::findOrFail($park_id);
//
//
//
//        $name= $request->get('name');
//
//
//        $items = OrdersUsers::query()->with('username');
//
//        if ($request->has('name')) {
//            OrdersUsers::query()->with(['username'=>function($q)use($name){
//                $q->where('name',$name);
//            }])->get();
//        }
//        $items = $items->orderBy('id', 'desc')->get();
//        //return $items;
//        return view('subadmin.orders.home', [
//            'items' => $items,
//        ]);

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



        $order = Order::findOrFail($id);
        $order->status = $request->status;
        // $order->driver= $request->driver;
        $order->save();


        $items = Order::where('id', $order->id)->with('products')->first();


        $user = User::findOrFail($items->user_id);
        //return $items;
        if (count($items) == 0) {
            exit();
        }

        $message = $order->status;
        if ($order->status == 0)
            $message2 = "Pending";
        elseif ($order->status == 1)
            $message2 = "Confirm";


        $order_obj = $items->id;
        $push_data = '';

        if ($order->status == 1) {
            $push_data = [
                'title' => $items->name,
                'body' => __('common.your order has accepted'),
                'id' => $items->id,
                'type' => 'rate',
            ];
        } else {
            $push_data = [
                'title' => 'done',
                'body' => __('common.your order has not accepted'),
                'id' => 0,
                'type' => 'rate',
            ];
        }


        $note = NotificationMessage::create([
            'user_id' => $user->id,
            'message' => $items->name
        ]);






        //  $token='es0ZqOPL_3w:APA91bF_uZ2B5pNrdR26_A867vm-wMTlD5cuoF9iozHoVsiKVN66Tz2UNFxrXv1W89gisMXIslja4XNAjdPcj0GxKXUW7tTLlwqFbTM0JWGob9wTrhj2m08W3dg9MPeYv1YrC_Ph3Ccs';
        //   send_push($user->fcm_token, $push_data, $user->device_type);


        $order_obj = $items->id;


        return redirect()->back()->with('status', __('common.update'));

        //  return back()->with('success','Edit SuccessFully');

    }

    public function edit($id)
    {
        //dd($id

        $orders = Order::with(['user', 'address'])->with('products')->findOrFail($id);



        //return $orders;
        //    $drivers = User::where('admin',1)->get();
        //return $drivers;

        $products = ProductOrder::where('order_id', $id)->with(['product'])->get();


        //return $products;

        return view('subadmin.orders.edit', ['orders' => $orders, 'products' => $products]);
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
