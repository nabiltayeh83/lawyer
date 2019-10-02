<?php

namespace App\Http\Controllers\WEB\SubAdmin;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use App\Models\Product;
use App\Models\Catsize;
use App\Models\Features_size;
use App\Models\Features_color;
use App\Models\ProductTranslation;
use App\Models\Attatchments;
use App\User;
use App\SubAdmin;
use App\Models\Company;
use App\Models\Language;
use App\Models\Notify;
use App\Models\Setting;
use App\Models\Token;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
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


    public function image_extensions()
    {

        return array('jpg', 'png', 'jpeg', 'gif', 'bmp');

    }

    public function file_extensions()
    {

        return array('doc', 'docx', 'pdf', 'xls', 'svg');

    }

    public function index(Request $request)
    {
        $owner_id = auth()->guard('subadmin')->id();
        $id_comany = Company::where('owner_id', $owner_id)->pluck('id')->first();


        $items = Product::query()->where('company_id', $id_comany);
        if ($request->has('status')) {
            if ($request->get('status') != null)
                $items->where('status', $request->get('status'));
        }
        $items = $items->orderBy('id', 'desc')->get();
        return view('subadmin.products.home', [
            'items' => $items,
        ]);

    }

    public function create(Request $request)
    {
        $locales = Language::all();

        $owner_id = auth()->guard('subadmin')->id();
        //return $owner_id;
        $companies = Company::query()->where('owner_id', $owner_id);

        return view('subadmin.products.create', ['locales' => $locales, 'companies' => $companies]);
    }

    public function store(Request $request)
    {
        //return $request->all();
        $owner_id = auth()->guard('subadmin')->id();
        $company_id = Company::where('owner_id', $owner_id)->pluck('id')->first();

        $roles = [
            // 'company_id' => 'required|integer',
            'offer_price' => 'required',
            'availability' => 'required',
            'logo' => 'required|mimes:jpeg,bmp,png,gif',
            'attatchments' => 'required',
        ];

        $locales = Language::all()->pluck('lang');

        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
            $roles['description_' . $locale] = 'required';
        }

        $this->validate($request, $roles);


        if (Input::file("logo") && Input::file("logo") != NULL) {
            if (Input::file("logo")->isValid()) {
                $destinationPath = public_path('uploads/products');

                $extension = strtolower(Input::file("logo")->getClientOriginalExtension());
                //dd($extension);
                $array = $this->image_extensions();
                if (in_array($extension, $array)) {
                    $fileName = uniqid() . '.' . $extension;
                    Input::file("logo")->move($destinationPath, $fileName);
                }
            }
        }


        $request->merge([
            'status' => 1,
            'company_id' => $company_id
        ]);


        $product = Product::create($request->only([
            'company_id',
            'price',
            'offer_price',
            'availability',
            'logo',
            'status',


        ]));

        $productDone = Product::find($product->id);
        if ($productDone) {
            if (isset($fileName)) {
                $productDone->logo = 'uploads/products/' . $fileName;
            }

            foreach ($locales as $locale) {
                $productDone->translateOrNew($locale)->name = $request->get('name_' . $locale);
                $productDone->translateOrNew($locale)->description = $request->get('description_' . $locale);
            }

            $productDone->save();
            if ($request->hasFile('attatchments')) {

                $destinationPath = public_path('uploads/products');
                $xy = $request->file('attatchments');
                //return $xy;
                foreach ($xy as $i => $value) {

                    $extension = strtolower($request->attatchments[$i]->getClientOriginalExtension());
                    //return $extension;
                    if (in_array($extension, $this->image_extensions())) {
                        $fileName = uniqid() . '.' . $extension;
                        $request->attatchments[$i]->move($destinationPath, $fileName);
                    }

                    $atta = New Attatchments();
                    $atta->attatchmentable_id = $productDone->id;
                    $atta->attatchmentable_type = 'App\Models\Product';
                    $atta->image = 'uploads/products/' . $fileName;
                    $atta->save();
                }
            }
        }


        return redirect()->back()->with('status', __('common.create'));
    }


    public function show($id)
    {

        return Product::query()->findOrFail($id);
    }

    public function edit(Request $request, $id)
    {
        $owner_id = auth()->guard('subadmin')->id();
        $id_comany = Company::where('owner_id', $owner_id)->pluck('id')->first();

        $locales = Language::all();
        $companies = Company::all();


        $item = Product::with( 'company')->findOrFail($id);
        //return $item;
        return view('subadmin.products.edit', [
            'locales' => $locales,
            'companies' => $companies,
            'item' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {
        // return $request->all();


        $roles = [
            'company_id' => 'required|integer',
            'offer_price' => 'required',

            //'logo' => 'required|mimes:jpeg,bmp,png,gif',
        ];

        $locales = Language::all()->pluck('lang');

        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
            $roles['description_' . $locale] = 'required';
        }

        $this->validate($request, $roles);


        $item = Product::findOrFail($id);
        $updatedDone=   Product::find($item->id)
            ->update($request->only([
                'company_id',
                'price',
                'offer_price',
                'availability',
                'logo',
                'status',

            ]));


        if (Input::file("logo") && Input::file("logo") != NULL) {
            if (Input::file("logo")->isValid()) {
                $destinationPath = public_path('uploads/products');

                $extension = strtolower(Input::file("logo")->getClientOriginalExtension());
                //dd($extension);
                $array = $this->image_extensions();
                if (in_array($extension, $array)) {
                    $fileName = uniqid() . '.' . $extension;
                    Input::file("logo")->move($destinationPath, $fileName);
                }
            }
        }


        foreach ($locales as $locale) {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
            $item->translateOrNew($locale)->description = $request->get('description_' . $locale);
        }



        if (isset($fileName)) {
            $item->logo = 'uploads/products/' . $fileName;
        }
        $item->save();


        if ($request->hasFile('attatchments')) {

            $destinationPath = public_path('uploads/products');
            $xy = $request->file('attatchments');
            //return $xy;
            foreach ($xy as $i => $value) {

                $extension = strtolower($request->attatchments[$i]->getClientOriginalExtension());
                //return $extension;
                if (in_array($extension, $this->image_extensions())) {
                    $fileName = uniqid() . '.' . $extension;
                    $request->attatchments[$i]->move($destinationPath, $fileName);
                }

                $atta = New Attatchments();
                $atta->attatchmentable_id = $item->id;
                $atta->attatchmentable_type = 'App\Models\Product';
                $atta->image = 'uploads/products/' . $fileName;
                $atta->save();
            }
        }


        return redirect()->back()->with('status', __('common.update'));


    }


    public function destroy($id)
    {
        // return $id;
        $item = product::query()->findOrFail($id);
        if ($item) {
            product::query()->where('id', $id)->delete();
            ProductTranslation::query()->where('product_id', $id)->delete();
            //Attatchments::query()->where('foreign_id',$id)->where('type',2)->delete();
            return "success";
        }
        return "fail";
    }


    public function delete_attatchment($id)
    {
        $attatchment_delete = Attatchments::find($id);
        if ($attatchment_delete->delete()) {
            return 'success';
        }
        return 'fail';
    }


    public function changeStatus(Request $request)
    {
        //return $request->all();
        if ($request->event == 'delete') {
            product::query()->whereIn('id', $request->IDsArray)->delete();
        } else {
            product::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }


    function fcmPush($token_android, $token_ios, $object, $message)

    {
//return 'fsdvsfv';
        try {


            $API_ACCESS_KEY = 'AAAAexwIVtg:APA91bH2eC93JQgMZwUvmxp0vaM2oPVI0iuM_StPBXz0_ipO9Bt4oJbypp3-Bz_jmwwXPs8kfH9eOYrtaIjwfHJMfRuEuOa-FSpNwTBbMhNfB4AoHGdrCpWrNlF3eG3lEtunLQ_YBHY2aqAcaSILhPAuQ3zrJneoHA';

            $msg = [
                'body' => $message,
                'type' => "notify",
                'title' => 'Medoz',
                'icon' => 'myicon',//Default Icon
                'sound' => 'mySound'//Default sound
            ];
            //return $msg;
            $fields = [
                'registration_ids' => ["e0nICLJ4RJ4:APA91bHTZpsGARUbSsZsi73urSC4McO6_4cQ1yxTLwEffyRfUXP8Qp5oFO4WxX0_NQCf8hwbFJjc2dB8hpWRRkHRMIPulXlkJb8BuwEk_yLKagWHU98c9yNaqb3OSsE2pOeO20HyOOJt"],
                'data' => $msg
            ];
            $headers = [
                'Authorization: key=' . $API_ACCESS_KEY,
                'Content-Type: application/json'
            ];


            $data = [
                "registration_ids" => $token_android,
                "data" => [
                    'body' => $message,
                    'object' => $object,
                    'type' => "notify",
                    'title' => 'Medoz',
                    'icon' => 'myicon',//Default Icon
                    'sound' => 'mySound'//Default sound
                ]
            ];

            //return $data;
            $notification = [
                "registration_ids" => $token_ios,
                "notification" => [
                    'body' => $message,
                    'object' => $object,
                    'type' => "notify",
                    'title' => 'Medoz',
                    'icon' => 'myicon',//Default Icon
                    'sound' => 'mySound'//Default sound
                ]
            ];
            //return $notification;
            // return json_encode($data);
            if ($token_android) {
//return $token_android;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

            }


            if ($token_ios) {
                //return $token_iphone;

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notification));

            }


            $result = curl_exec($ch);
            //return $result;
            curl_close($ch);
            //return json_decode($result, true);
            //return back()->with('success','Edit SuccessFully');
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }


}
