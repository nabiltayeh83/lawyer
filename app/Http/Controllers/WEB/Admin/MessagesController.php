<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Models\CompanyTranslation;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use App\Models\Company;
use App\Models\Messages;
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

class MessagesController extends Controller
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
        $items = Messages::query()->with('user','company');
        if ($request->has('title') && $request->title != '' ) {
            if ($request->get('title') != null)
               $ides_company = CompanyTranslation::where('name','Like','%'.$request->get('title').'%')->where('locale', app()->getLocale())->pluck('company_id')->toArray();
               //return $ides_company;
               
              $items->whereIn('company_id',$ides_company);
        }
        
        $items = $items->orderBy('id','desc')->get();
        //return $items;

        return view('admin.messages.home', [
            'items' => $items,
        ]);

    }

    public function create(Request $request)
    {
        //code
    }

    public function show($id)
    {
        return Messages::query()->with('user','company')->findOrFail($id);
    }

    public function edit(Request $request, $id)
    {
        $item = $this->show($id);


        return view('admin.messages.edit', [
            'item' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {

      //code
    }

    public function destroy($id)
    {
        $item = Messages::query()->findOrFail($id);
        if ($item) {
            Messages::query()->where('id', $id)->delete();
            return "success";
            
        }
        return "fail";
    }

    public function changeStatus(Request $request)
    {
        if ($request->event == 'delete') {
            Messages::query()->whereIn('id', $request->IDsArray)->delete();
        } else {
            Messages::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
    }

  



}
