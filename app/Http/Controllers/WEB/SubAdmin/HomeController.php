<?php

namespace App\Http\Controllers\WEB\SubAdmin;

use App\Models\Setting;
use App\Models\Order;
use App\Models\Company;
use App\Models\Product;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Carbon\Carbon;

class HomeController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('auth,subadmin');
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
          $auth_now = auth()->guard('subadmin')->id();
        $company = Company::where('owner_id',$auth_now)->first();
        if(!$company && $company == ''){
        Auth::guard('subadmin')->logout();
        return redirect('/subadmin/login')->with('status','You Dont Have Company');
        }
        
        $orders_count = Order::query()->where('company_id',$company->id)->count();
        $count_product = Product::where('company_id',$company->id)->count();
        $count_orders = Order::where('company_id',$company->id)->count();
        $count_users = User::where('admin','!=',1)->count();
        $count_companies = 1;
        return view('subadmin.home',[
            'company'=>$company,
            'orders_count'=>$orders_count,
            'count_product'=>$count_product,
            'count_orders'=>$count_orders,
            'count_users'=>$count_users,
            'count_companies'=>$count_companies
            ]);
    }
    
    
      public function homeordersGet(Request $request)
    {
        $auth_now = auth()->guard('subadmin')->id();
        $company_id = Company::where('owner_id',$auth_now)->pluck('id')->first();
        $orders = Order::query()->where('company_id',$company_id)->get();
        return $orders;
    }
  



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
