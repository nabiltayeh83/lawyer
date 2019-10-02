<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Models\Payment;
use App\Models\Setting;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class PaymentController extends Controller
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


    public function index(Request $request)
    {
        
      
        
        $items = Payment::query();

        if ($request->has('title')) {
            if ($request->get('title') != null)
                       $items->where('title', 'like', '%' . $request->get('title') . '%');
        }

        if ($request->has('status')) {
            if ($request->get('status') != null)
                $items->where('status', $request->get('status'));
        }
        $items = $items->orderBy('id', 'desc')->get();
        //return $items;
        return view('admin.payment.home', [
            'items' => $items,
        ]);

    }

    public function create()
    {
        return view('admin.payment.create');
    }

    public function store(Request $request)
    {
        //return $request->all();
        $roles = [
            'title' => 'required|string',
            'logo' => 'required|mimes:jpeg,bmp,png,gif',
        ];
        
        $this->validate($request, $roles);

        $item = New Payment();
        $item->title = $request->title;
        
        if(Input::file("logo")&&Input::file("logo")!=NULL)
        {
            if (Input::file("logo")->isValid())
            {
                $destinationPath=public_path('uploads/payment');

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
        if(isset($fileName)){$item->logo='uploads/payment/'.$fileName;}
        $item->save();
        return redirect()->back()->with('status', __('common.create'));
    }

    public function show($id)
    {
        return Payment::query()->findOrFail($id);
    }

    public function edit($id)
    {
       //code
    }

    public function update(Request $request, $id)
    {
       //code 

    }

    public function destroy($id)
    {
        $item = Payment::query()->findOrFail($id);
        if ($item) {
            Payment::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }

    public function changeStatus(Request $request)
    {
        if ($request->event == 'delete') {
            Payment::query()->whereIn('id', $request->IDsArray)->delete();
        } else {
            Payment::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }
}
