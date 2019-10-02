<?php

namespace App\Http\Controllers\WEB\SubAdmin;

use App\Models\categoryCompanies;
use App\Models\CompanyTranslation;
use App\Models\Delivery;
use App\Models\DeliveryCompanies;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use App\Models\Company;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Specialization;
use App\Models\SubcategoryCompanies;
use App\Models\PaymentCompanies;
use App\Models\Projects;
use App\Models\Payment;
use App\Subadmin;
use App\Models\Attatchments;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
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

    public function image_extensions(){

        return array('jpg','png','jpeg','gif','bmp');

    }
    public function file_extensions(){

        return array('doc','docx','pdf','xls','svg');

    }

    public function index(Request $request)
    {
        $owner_id = auth()->guard('subadmin')->id();
        //return $owner_id;
        $items = Company::query()->where('owner_id',$owner_id);
        if ($request->has('title')) {
            if ($request->get('title') != null)
                $items->whereHas('translations', function ($query) use ($request) {
                    $query->where('locale', app()->getLocale())
                        ->where('title', 'like', '%' . $request->get('title') . '%');
                });
        }
        if ($request->has('status')) {
            if ($request->get('status') != null)
                $items->where('status', $request->get('status'));
        }
        $items = $items->orderBy('id','desc')->get();
        //return $items;

        return view('subadmin.company.home', [
            'items' => $items,
        ]);

    }

  
    

    public function show($id)
    {
        $owner_id = auth()->guard('subadmin')->id();
        return Company::query()->where('owner_id',$owner_id)->with('payment_companies')->findOrFail($id);
    }

    public function edit(Request $request, $id)
    {
        $item = $this->show($id);
        $owners = Subadmin::findOrFail($item->owner_id);
        $payments = Payment::query()->get();
        $categories = Category::query()->get();
        $deliveries = Delivery::query()->get();
        //return $item;
        $categoriesCurrent = categoryCompanies::where('company_id',$item->id)->pluck('category_id');


        //  dd($item->images );
        $paymentCurrent = PaymentCompanies::where('company_id',$item->id)->pluck('payment_id');

        $deliveryCompany = DeliveryCompanies::where('company_id',$item->id)->pluck('delivery_id');

        return view('subadmin.company.edit', [
            'item' => $item,
            'owners'=>$owners,
            'payments'=>$payments,
            'categories'=>$categories,
            'categoriesCurrent'=>$categoriesCurrent,
            'paymentCurrent'=>$paymentCurrent,
            'deliveries'=>$deliveries,
            'deliveryCompany'=>$deliveryCompany
        ]);



    }

    public function update(Request $request, $id)
    {
        $roles = [
            //'logo' => 'required|image|mimes:jpeg,jpg,png',
            'owner_id' => 'required',
            'category' => 'required|array',
            'payment_methods' => 'required|array',
            'minimum_fees' => 'required',
            //   'price' => 'required|numeric',
            //   'price_color' => 'required|numeric',
            'delivery_type' => 'required',
        ];


        if($request->delivery_type == 1 || $request->delivery_type == 3 ) {
            $roles = [
                'delivery_option' => 'required',
            ];

        }




        if($request->delivery_option != null || $request->delivery_option == 2 || $request->delivery_option == 3  ) {
            $roles = [

                'delivery_company' => 'required|array',

            ];

        }



        $locales = Language::all()->pluck('lang');

        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
            $roles['description_' . $locale] = 'required';
        }

        $this->validate($request, $roles);
        $item = Company::findOrFail($id);



        if(Input::file("logo")&&Input::file("logo")!=NULL)
        {
            if (Input::file("logo")->isValid())
            {
                $destinationPath=public_path('uploads/company');

                $extension=strtolower(Input::file("logo")->getClientOriginalExtension());
                //dd($extension);
                $array= $this->image_extensions();
                if(in_array($extension,$array))
                {
                    $fileName=uniqid().'.'.$extension;
                    Input::file("logo")->move($destinationPath, $fileName);
                }
            }
        }

        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
            $item->translateOrNew($locale)->description = $request->get('description_' . $locale);
        }


        $item->owner_id = $item->owner_id;
        $item->minimum_fees = $request->minimum_fees;
        // $item->price = $request->price;
        // $item->price_color = $request->price_color;
        $item->delivery_type = $request->delivery_type;
        if($request->delivery_type == 1 || $request->delivery_type == 3){
            $item->delivery_option= $request->delivery_option;
        }else{
            $item->delivery_option= '';
        }

        if(isset($fileName)){$item->logo='uploads/company/'.$fileName;}

        $item->save();



        categoryCompanies::where('company_id',$item->id)->delete();

        if ($request->has('category')) {

            foreach ($request->category as $value) {

                $subcategory_companies = New categoryCompanies();
                $subcategory_companies->company_id = $item->id;
                $subcategory_companies->category_id = $value;
                $subcategory_companies->save();
            }
        }

        PaymentCompanies::where('company_id',$item->id)->delete();
        if ($request->has('payment_methods')) {

            foreach ($request->payment_methods as $value) {

                $payment_companies = New PaymentCompanies();
                $payment_companies->company_id = $item->id;
                $payment_companies->payment_id = $value;
                $payment_companies->save();
            }
        }



        DeliveryCompanies::where('company_id',$item->id)->delete();
        if ($request->has('delivery_company') && $request->delivery_type != 2 && $request->delivery_option != 1 ) {

            foreach ($request->delivery_company as $value) {

                $payment_companies = New DeliveryCompanies();
                $payment_companies->company_id = $item->id;
                $payment_companies->delivery_id = $value;
                $payment_companies->save();
            }
        }


        if($request->hasFile('attatchments'))
        {

            $destinationPath=public_path('uploads/company');
            $xy = $request->file('attatchments');
            //return $xy;
            foreach ($xy as $i => $value)
            {

                $extension =strtolower($request->attatchments[$i]->getClientOriginalExtension());
                //return $extension;
                if(in_array($extension,$this->image_extensions()))
                {
                    $fileName =uniqid().'.'.$extension;
                    $request->attatchments[$i]->move($destinationPath, $fileName);
                }

                $atta = New Attatchments();
                $atta->attatchmentable_id = $item->id;
                $atta->attatchmentable_type= 'App\Models\Company';
                $atta->image = 'uploads/company/'.$fileName;
                $atta->save();
            }
        }

       
        return redirect()->back()->with('status', __('common.update'));


    }

    // public function destroy($id)
    // {
    //     $item = Company::query()->findOrFail($id);
    //     if ($item) {
    //         Company::query()->where('id', $id)->delete();
    //         CompanyTranslation::query()->where('company_id', $id)->delete();
    //         PaymentCompanies::where('company_id',$id)->delete();
    //         SubcategoryCompanies::where('company_id',$id)->delete();
    //         return "success";
            
    //     }
    //     return "fail";
    // }

    public function changeStatus(Request $request)
    {
        if ($request->event == 'delete') {
            Company::query()->whereIn('id', $request->IDsArray)->delete();
        } else {
            Company::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }

  



}
