<?php

namespace App\Http\Controllers\WEB\SubAdmin;

use App\Models\Booking;
use App\Models\Messages;
use App\Models\Brands;
use App\Models\BrandsTranslation;
use App\Models\Language;
use App\Models\Company;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class MessageCompanyController extends Controller
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
        $owner_id = auth()->guard('subadmin')->id();
        $ides_comany = Company::where('owner_id',$owner_id)->pluck('id')->toArray();

        $items = Messages::query()->whereIn('company_id',$ides_comany)->with('user','company');
        if ($request->has('status')) {
            if ($request->get('status') != null)
                $items->where('status', $request->get('status'));
        }
        $items = $items->orderBy('id', 'desc')->get();

       // return $items;
        return view('subadmin.messages.home', [
            'items' => $items,
        ]);

    }



    public function show($id)
    {
        $owner_id = auth()->guard('subadmin')->id();
        $ides_comany = Company::where('owner_id',$owner_id)->pluck('id')->toArray();

        return Messages::query()->whereIn('company_id',$ides_comany)->with('user','company')->orderBy('id','DESC')->get();
    }

    public function edit($id)
    {
        $owner_id = auth()->guard('subadmin')->id();
        $ides_comany = Company::where('owner_id',$owner_id)->pluck('id')->toArray();
        //return $id;

        $item =  Messages::query()->where('id',$id)->with('user','company')->orderBy('id','DESC')->first();
        
        return view('subadmin.messages.edit', [
            'item' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {
        //return $request->all();
        $rules=array(
            'status' =>'required',
        );
        $validation=Validator::make($request->all(), $rules);

        if($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $booking = Booking::findOrFail($id);

        $booking->status = $request->status;
        $booking->save();



        return redirect()->back()->with('status', __('common.update'));


    }

    public function destroy($id)
    {
       // return $id;
        $item = Booking::query()->findOrFail($id);
        if ($item) {
            Booking::query()->where('id', $id)->delete();
            return "success";
        }
        return "fail";
    }

    public function changeStatus(Request $request)
    {
        //return $request->all();
        if ($request->event == 'delete') {
            Booking::query()->whereIn('id', $request->IDsArray)->delete();
        } else {
            Booking::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }
}
