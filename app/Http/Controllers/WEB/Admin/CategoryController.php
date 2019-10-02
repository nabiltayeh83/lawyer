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


class CategoryController extends Controller
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
       $items  = Category::latest()->get();       
       return view('admin.category.home', compact('items'));
    }



    public function create()
    {
        return view('admin.category.create');
    }



    public function store(Request $request)
    {
        
        $locales = Language::all()->pluck('lang');

        $category = new category();
        
        foreach ($locales as $locale)
        {
            $category->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }
    
        $category->save();
        return redirect()->back()->with('status', __('cp.create'));

    }


    public function show($id)
    {
        $item=Car::all();
    }
    

    public function edit($id)
    {
        $item = category::findOrFail($id);
        return view('admin.category.edit', compact('item'));
    }



    public function update(Request $request, $id)
    {
        $locales = Language::all()->pluck('lang');
 
        $item = category::query()->findOrFail($id);
        
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }        

        $item->save();

        return redirect()->back()->with('status', __('cp.update'));

    }


    

    public function destroy($id)
    {
        $item = category::query()->findOrFail($id);
        if ($item) {
            category::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }

}
