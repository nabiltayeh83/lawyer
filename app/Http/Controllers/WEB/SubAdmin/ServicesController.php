<?php

namespace App\Http\Controllers\WEB\SubAdmin;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use App\Models\Service;
use App\Models\ServiceTranslation;
use App\Models\Attatchments;
use App\User;
use App\Models\Company;
use App\Models\Language;
use App\Models\Notify;
use App\Models\Setting;
use App\Models\Token;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServicesController extends Controller
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
        $company = Company::query()->where('owner_id',$owner_id)->first();
        $items = Service::query()->where('company_id',$company->id);
        if ($request->has('status')) {
            if ($request->get('status') != null)
                $items->where('status', $request->get('status'));
        }

        $items = $items->orderBy('id', 'desc')->get();



        return view('subadmin.services.home', [
            'items' => $items,
        ]);

    }

    public function create(Request $request)
    {
           $locales = Language::all();


        return view('subadmin.services.create',['locales'=>$locales]);
    }

    public function store(Request $request)
    {
        //return $request->all();

        $roles = [
          //  'company_id' => 'required|integer',
            'logo' => 'required|mimes:jpeg,bmp,png,gif',
            'estimated_time'=>'required|integer',
        ];

        $locales = Language::all()->pluck('lang');

        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
            $roles['description_' . $locale] = 'required';
        }

        $this->validate($request, $roles);



        if(Input::file("logo")&&Input::file("logo")!=NULL)
        {
            if (Input::file("logo")->isValid())
            {
                $destinationPath=public_path('uploads/services');

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

        $owner_id = auth()->guard('subadmin')->id();
        //return $owner_id;
        $company = Company::query()->where('owner_id',$owner_id)->first();
        $request->merge([
            'company_id'=>$company->id,
        ]);


        $service = Service::create($request->only([
            'company_id',
            'estimated_time',
            'logo',
            'status',


        ]));

        $serviceDone = Service::find($service->id);



        foreach ($locales as $locale)
        {
            $serviceDone->translateOrNew($locale)->name = $request->get('name_' . $locale);
            $serviceDone->translateOrNew($locale)->description = $request->get('description_' . $locale);
        }


        if(isset($fileName)){
            $serviceDone->logo='uploads/services/'.$fileName;
        }
        $serviceDone->save();








        return redirect()->route('subadmin.services.index')->with('status', __('common.create'));
    }



    public function show($id)
    {
        return Service::query()->findOrFail($id);
    }

    public function edit(Request $request,$id)
    {
        $locales = Language::all();


        $item= Service::with('company')->findOrFail($id);
        //return $item;
        return view('subadmin.services.edit',['locales'=>$locales,'item'=>$item]);
    }

    public function update(Request $request, $id)
    {
       // return $request->all();


  $roles = [
      //'company_id' => 'required|integer',
    //  'logo' => 'required|mimes:jpeg,bmp,png,gif',
      'estimated_time'=>'required|integer',
        ];

        $locales = Language::all()->pluck('lang');

        foreach ($locales as $locale) {
            $roles['name_' . $locale] = 'required';
            $roles['description_' . $locale] = 'required';
        }

        $this->validate($request, $roles);
        $owner_id = auth()->guard('subadmin')->id();
        //return $owner_id;
        $company = Company::query()->where('owner_id',$owner_id)->first();
        $request->merge([
            'company_id'=>$company->id,
        ]);

        $item= Service::findOrFail($id);
        $updatedDone=   Service::find($item->id)
            ->update($request->only([
                'company_id',
                'estimated_time',
                'logo',
                'status',
            ]));

        if(Input::file("logo")&&Input::file("logo")!=NULL)
        {
            if (Input::file("logo")->isValid())
            {
                $destinationPath=public_path('uploads/services');

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



        if(isset($fileName)){$item->logo='uploads/services/'.$fileName;}
        $item->save();




      
        
        return redirect()->route('subadmin.services.index')->with('status', __('common.update'));


    }
    
    



    public function destroy($id)
    {
        // return $id;
        $item = Service::query()->findOrFail($id);
        if ($item) {
            Service::query()->where('id', $id)->delete();
            ServiceTranslation::query()->where('service_id', $id)->delete();
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
            Service::query()->whereIn('id', $request->IDsArray)->delete();
        } else {
            Service::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }


















}
