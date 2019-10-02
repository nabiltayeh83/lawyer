<?php

namespace App\Http\Controllers\WEB\Admin;
use App\Models\Country;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\JobTitle;
use App\Models\Language;
use App\Models\Permission;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class CountryController extends Controller
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



    public function index()
    {
       $items  = Country::latest()->get();       
       return view('admin.country.home', compact('items'));
    }



    public function create()
    {
        return view('admin.country.create');
    }



    public function store(Request $request)
    {
        $locales = Language::all()->pluck('lang');

        $country = new Country();
        $country->code = $request->code;
        
        foreach ($locales as $locale)
        {
            $country->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }
    
        $country->save();
        return redirect()->back()->with('status', __('cp.create'));

    }


    public function show($id)
    {
        $item=Car::all();
    }
    

    public function edit($id)
    {
        $item = Country::findOrFail($id);
        return view('admin.country.edit', compact('item'));
    }



    public function update(Request $request, $id)
    {
        $locales = Language::all()->pluck('lang');
 
        $item = Country::query()->findOrFail($id);
        
        $item->code  = $request->code;

        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }        

        $item->save();

        return redirect()->back()->with('status', __('cp.update'));

    }


    

    public function destroy($id)
    {
        $item = Country::query()->findOrFail($id);
        if ($item) {
            Country::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }

}
